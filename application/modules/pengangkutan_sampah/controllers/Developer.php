<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Developer controller
 */
class Developer extends Admin_Controller
{
    protected $permissionCreate = 'Pengangkutan_sampah.Developer.Create';
    protected $permissionDelete = 'Pengangkutan_sampah.Developer.Delete';
    protected $permissionEdit   = 'Pengangkutan_sampah.Developer.Edit';
    protected $permissionView   = 'Pengangkutan_sampah.Developer.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('pengangkutan_sampah/pengangkutan_sampah_model');
        $this->lang->load('pengangkutan_sampah');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'developer/_sub_nav');

        Assets::add_module_js('pengangkutan_sampah', 'pengangkutan_sampah.js');
    }

    /**
     * Display a list of Pengangkutan Sampah data.
     *
     * @return void
     */
    public function index($offset = 0)
    {
        // Deleting anything?
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->pengangkutan_sampah_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('pengangkutan_sampah_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pengangkutan_sampah_delete_failure') . $this->pengangkutan_sampah_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/developer/pengangkutan_sampah/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->pengangkutan_sampah_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->pengangkutan_sampah_model->limit($limit, $offset);
        
        $records = $this->pengangkutan_sampah_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('pengangkutan_sampah_manage'));

        Template::render();
    }
    
    /**
     * Create a Pengangkutan Sampah object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_pengangkutan_sampah()) {
                log_activity($this->auth->user_id(), lang('pengangkutan_sampah_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'pengangkutan_sampah');
                Template::set_message(lang('pengangkutan_sampah_create_success'), 'success');

                redirect(SITE_AREA . '/developer/pengangkutan_sampah');
            }

            // Not validation error
            if ( ! empty($this->pengangkutan_sampah_model->error)) {
                Template::set_message(lang('pengangkutan_sampah_create_failure') . $this->pengangkutan_sampah_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('pengangkutan_sampah_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Pengangkutan Sampah data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('pengangkutan_sampah_invalid_id'), 'error');

            redirect(SITE_AREA . '/developer/pengangkutan_sampah');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_pengangkutan_sampah('update', $id)) {
                log_activity($this->auth->user_id(), lang('pengangkutan_sampah_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'pengangkutan_sampah');
                Template::set_message(lang('pengangkutan_sampah_edit_success'), 'success');
                redirect(SITE_AREA . '/developer/pengangkutan_sampah');
            }

            // Not validation error
            if ( ! empty($this->pengangkutan_sampah_model->error)) {
                Template::set_message(lang('pengangkutan_sampah_edit_failure') . $this->pengangkutan_sampah_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->pengangkutan_sampah_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('pengangkutan_sampah_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'pengangkutan_sampah');
                Template::set_message(lang('pengangkutan_sampah_delete_success'), 'success');

                redirect(SITE_AREA . '/developer/pengangkutan_sampah');
            }

            Template::set_message(lang('pengangkutan_sampah_delete_failure') . $this->pengangkutan_sampah_model->error, 'error');
        }
        
        Template::set('pengangkutan_sampah', $this->pengangkutan_sampah_model->find($id));

        Template::set('toolbar_title', lang('pengangkutan_sampah_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_pengangkutan_sampah($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id_laporan'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->pengangkutan_sampah_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->pengangkutan_sampah_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['tanggal_angkut']	= $this->input->post('tanggal_angkut') ? $this->input->post('tanggal_angkut') : '0000-00-00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->pengangkutan_sampah_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->pengangkutan_sampah_model->update($id, $data);
        }

        return $return;
    }
}