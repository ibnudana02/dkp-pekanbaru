<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Developer controller
 */
class Developer extends Admin_Controller
{
    protected $permissionCreate = 'Profil.Developer.Create';
    protected $permissionDelete = 'Profil.Developer.Delete';
    protected $permissionEdit   = 'Profil.Developer.Edit';
    protected $permissionView   = 'Profil.Developer.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('profil/profil_model');
        $this->lang->load('profil');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            Assets::add_css('jquery-ui-timepicker.css');
            Assets::add_js('jquery-ui-timepicker-addon.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'developer/_sub_nav');

        Assets::add_module_js('profil', 'profil.js');
    }

    /**
     * Display a list of Profil data.
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
                    $deleted = $this->profil_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('profil_delete_success'), 'success');
                } else {
                    Template::set_message(lang('profil_delete_failure') . $this->profil_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->profil_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('profil_manage'));

        Template::render();
    }
    
    /**
     * Create a Profil object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_profil()) {
                log_activity($this->auth->user_id(), lang('profil_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'profil');
                Template::set_message(lang('profil_create_success'), 'success');

                redirect(SITE_AREA . '/developer/profil');
            }

            // Not validation error
            if ( ! empty($this->profil_model->error)) {
                Template::set_message(lang('profil_create_failure') . $this->profil_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('profil_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Profil data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('profil_invalid_id'), 'error');

            redirect(SITE_AREA . '/developer/profil');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_profil('update', $id)) {
                log_activity($this->auth->user_id(), lang('profil_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'profil');
                Template::set_message(lang('profil_edit_success'), 'success');
                redirect(SITE_AREA . '/developer/profil');
            }

            // Not validation error
            if ( ! empty($this->profil_model->error)) {
                Template::set_message(lang('profil_edit_failure') . $this->profil_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->profil_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('profil_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'profil');
                Template::set_message(lang('profil_delete_success'), 'success');

                redirect(SITE_AREA . '/developer/profil');
            }

            Template::set_message(lang('profil_delete_failure') . $this->profil_model->error, 'error');
        }
        
        Template::set('profil', $this->profil_model->find($id));

        Template::set('toolbar_title', lang('profil_edit_heading'));
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
    private function save_profil($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id_profil'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->profil_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->profil_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['tgl_terbit_profil']	= $this->input->post('tgl_terbit_profil') ? $this->input->post('tgl_terbit_profil') : '0000-00-00 00:00:00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->profil_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->profil_model->update($id, $data);
        }

        return $return;
    }
}