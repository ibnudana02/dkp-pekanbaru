<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Settings controller
 */
class Settings extends Admin_Controller
{
    protected $permissionCreate = 'Rute.Settings.Create';
    protected $permissionDelete = 'Rute.Settings.Delete';
    protected $permissionEdit   = 'Rute.Settings.Edit';
    protected $permissionView   = 'Rute.Settings.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('rute/rute_model');
        $this->lang->load('rute');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'settings/_sub_nav');

        Assets::add_module_js('rute', 'rute.js');
    }

    /**
     * Display a list of Rute data.
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
                    $deleted = $this->rute_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('rute_delete_success'), 'success');
                } else {
                    Template::set_message(lang('rute_delete_failure') . $this->rute_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->rute_model->find_all();

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('rute_manage'));

        Template::render();
    }
    
    /**
     * Create a Rute object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_rute()) {
                log_activity($this->auth->user_id(), lang('rute_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'rute');
                Template::set_message(lang('rute_create_success'), 'success');

                redirect(SITE_AREA . '/settings/rute');
            }

            // Not validation error
            if ( ! empty($this->rute_model->error)) {
                Template::set_message(lang('rute_create_failure') . $this->rute_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('rute_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Rute data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('rute_invalid_id'), 'error');

            redirect(SITE_AREA . '/settings/rute');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_rute('update', $id)) {
                log_activity($this->auth->user_id(), lang('rute_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'rute');
                Template::set_message(lang('rute_edit_success'), 'success');
                redirect(SITE_AREA . '/settings/rute');
            }

            // Not validation error
            if ( ! empty($this->rute_model->error)) {
                Template::set_message(lang('rute_edit_failure') . $this->rute_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->rute_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('rute_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'rute');
                Template::set_message(lang('rute_delete_success'), 'success');

                redirect(SITE_AREA . '/settings/rute');
            }

            Template::set_message(lang('rute_delete_failure') . $this->rute_model->error, 'error');
        }
        
        Template::set('rute', $this->rute_model->find($id));

        Template::set('toolbar_title', lang('rute_edit_heading'));
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
    private function save_rute($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->rute_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->rute_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->rute_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->rute_model->update($id, $data);
        }

        return $return;
    }
}