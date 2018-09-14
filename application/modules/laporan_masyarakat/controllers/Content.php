<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller
{
    protected $permissionCreate = 'Laporan_masyarakat.Content.Create';
    protected $permissionDelete = 'Laporan_masyarakat.Content.Delete';
    protected $permissionEdit   = 'Laporan_masyarakat.Content.Edit';
    protected $permissionView   = 'Laporan_masyarakat.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('laporan_masyarakat/laporan_masyarakat_model');
        $this->lang->load('laporan_masyarakat');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_module_js('laporan_masyarakat', 'laporan_masyarakat.js');
    }

    /**
     * Display a list of Laporan Masyarakat data.
     *
     * @return void
     */
    public function index()
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
                    $deleted = $this->laporan_masyarakat_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('laporan_masyarakat_delete_success'), 'success');
                } else {
                    Template::set_message(lang('laporan_masyarakat_delete_failure') . $this->laporan_masyarakat_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->laporan_masyarakat_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('laporan_masyarakat_manage'));

        Template::render();
    }
    
    /**
     * Create a Laporan Masyarakat object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_laporan_masyarakat()) {
                log_activity($this->auth->user_id(), lang('laporan_masyarakat_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'laporan_masyarakat');
                Template::set_message(lang('laporan_masyarakat_create_success'), 'success');

                redirect(SITE_AREA . '/content/laporan_masyarakat');
            }

            // Not validation error
            if ( ! empty($this->laporan_masyarakat_model->error)) {
                Template::set_message(lang('laporan_masyarakat_create_failure') . $this->laporan_masyarakat_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('laporan_masyarakat_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Laporan Masyarakat data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('laporan_masyarakat_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/laporan_masyarakat');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_laporan_masyarakat('update', $id)) {
                log_activity($this->auth->user_id(), lang('laporan_masyarakat_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'laporan_masyarakat');
                Template::set_message(lang('laporan_masyarakat_edit_success'), 'success');
                redirect(SITE_AREA . '/content/laporan_masyarakat');
            }

            // Not validation error
            if ( ! empty($this->laporan_masyarakat_model->error)) {
                Template::set_message(lang('laporan_masyarakat_edit_failure') . $this->laporan_masyarakat_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->laporan_masyarakat_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('laporan_masyarakat_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'laporan_masyarakat');
                Template::set_message(lang('laporan_masyarakat_delete_success'), 'success');

                redirect(SITE_AREA . '/content/laporan_masyarakat');
            }

            Template::set_message(lang('laporan_masyarakat_delete_failure') . $this->laporan_masyarakat_model->error, 'error');
        }
        
        Template::set('laporan_masyarakat', $this->laporan_masyarakat_model->find($id));

        Template::set('toolbar_title', lang('laporan_masyarakat_edit_heading'));
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
    private function save_laporan_masyarakat($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id_laporanmas'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->laporan_masyarakat_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->laporan_masyarakat_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->laporan_masyarakat_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->laporan_masyarakat_model->update($id, $data);
        }

        return $return;
    }
}