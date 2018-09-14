<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller
{
    protected $permissionCreate = 'Jalan.Content.Create';
    protected $permissionDelete = 'Jalan.Content.Delete';
    protected $permissionEdit   = 'Jalan.Content.Edit';
    protected $permissionView   = 'Jalan.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('jalan/jalan_model');
        $this->lang->load('jalan');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_module_js('jalan', 'jalan.js');
    }

    /**
     * Display a list of jalan data.
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
                    $deleted = $this->jalan_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('jalan_delete_success'), 'success');
                } else {
                    Template::set_message(lang('jalan_delete_failure') . $this->jalan_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->jalan_model->find_all();
		Assets::add_js('$(document).ready(function() {$("#tablekita").DataTable();});', 'inline');
		Assets::add_js(array('datatables/jquery.dataTables.js'));

        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('jalan_manage'));

        Template::render();
    }
    
    /**
     * Create a jalan object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_jalan()) {
                log_activity($this->auth->user_id(), lang('jalan_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'jalan');
                Template::set_message(lang('jalan_create_success'), 'success');

                redirect(SITE_AREA . '/content/jalan');
            }

            // Not validation error
            if ( ! empty($this->jalan_model->error)) {
                Template::set_message(lang('jalan_create_failure') . $this->jalan_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('jalan_action_create'));

        Template::render();
    }
	 public function downloadPdf(){
     $row = $this->jalan_model->find_all();
     $this->load->view('content/pdf',array('hasil'=>$row));
    }
    /**
     * Allows editing of jalan data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('jalan_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/jalan');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_jalan('update', $id)) {
                log_activity($this->auth->user_id(), lang('jalan_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'jalan');
                Template::set_message(lang('jalan_edit_success'), 'success');
                redirect(SITE_AREA . '/content/jalan');
            }

            // Not validation error
            if ( ! empty($this->jalan_model->error)) {
                Template::set_message(lang('jalan_edit_failure') . $this->jalan_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->jalan_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('jalan_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'jalan');
                Template::set_message(lang('jalan_delete_success'), 'success');

                redirect(SITE_AREA . '/content/jalan');
            }

            Template::set_message(lang('jalan_delete_failure') . $this->jalan_model->error, 'error');
        }
        
        Template::set('jalan', $this->jalan_model->find($id));

        Template::set('toolbar_title', lang('jalan_edit_heading'));
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
    private function save_jalan($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->jalan_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->jalan_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        

        $return = false;
        if ($type == 'insert') {
            $id = $this->jalan_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->jalan_model->update($id, $data);
        }

        return $return;
    }
}