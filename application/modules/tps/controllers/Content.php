<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class Content extends Admin_Controller
{
    protected $permissionCreate = 'Tps.Content.Create';
    protected $permissionDelete = 'Tps.Content.Delete';
    protected $permissionEdit   = 'Tps.Content.Edit';
    protected $permissionView   = 'Tps.Content.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('tps/tps_model');
        $this->lang->load('tps');
        
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_module_js('tps', 'tps.js');
    }

    /**
     * Display a list of tps data.
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
                    $deleted = $this->tps_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('tps_delete_success'), 'success');
                } else {
                    Template::set_message(lang('tps_delete_failure') . $this->tps_model->error, 'error');
                }
            }
        }
        
        
        
        $records = $this->tps_model->find_all();
		Assets::add_js('$(document).ready(function() {$("#tablekita").DataTable();});', 'inline');
		Assets::add_js(array('datatables/jquery.dataTables.js'));
        Template::set('records', $records);
        
    Template::set('toolbar_title', lang('tps_manage'));

        Template::render();
    }
	
	 public function downloadPdf(){
     $row = $this->tps_model->find_all();
     $this->load->view('content/pdf',array('hasil'=>$row));
    }
    
    /**
     * Create a tps object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_tps()) {
                log_activity($this->auth->user_id(), lang('tps_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'tps');
                Template::set_message(lang('tps_create_success'), 'success');

                redirect(SITE_AREA . '/content/tps');
            }

            // Not validation error
            if ( ! empty($this->tps_model->error)) {
                Template::set_message(lang('tps_create_failure') . $this->tps_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('tps_action_create'));

        Template::render();
    }
    /**
     * Allows editing of tps data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('tps_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/tps');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_tps('update', $id)) {
                log_activity($this->auth->user_id(), lang('tps_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'tps');
                Template::set_message(lang('tps_edit_success'), 'success');
                redirect(SITE_AREA . '/content/tps');
            }

            // Not validation error
            if ( ! empty($this->tps_model->error)) {
                Template::set_message(lang('tps_edit_failure') . $this->tps_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->tps_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('tps_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'tps');
                Template::set_message(lang('tps_delete_success'), 'success');

                redirect(SITE_AREA . '/content/tps');
            }

            Template::set_message(lang('tps_delete_failure') . $this->tps_model->error, 'error');
        }
        
        Template::set('tps', $this->tps_model->find($id));

        Template::set('toolbar_title', lang('tps_edit_heading'));
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
    private function save_tps($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->tps_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->tps_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
        $return = false;
        if ($type == 'insert') {
            $data['file_foto']='';
            $id = $this->tps_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $old_data = $this->tps_model->find($id);
            $return = $this->tps_model->update($id, $data);
        }
        if($type == 'insert'){
         $id=$this->db->insert_id();
        }
        $data = array();
        $config['upload_path']   = 'data/images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = 10240;
        $config['file_name']     = "TPS-".$id;
        $this->load->library('upload', $config);
        if($this->upload->data() !== null) {
         if ( ! $this->upload->do_upload('images') && ! $this->upload->data('is_image') ){
           $error = array('error' => $this->upload->display_errors());
           if($error['error'] == "You did not select a file to upload."){
            $this->flashMsg($this->upload->display_errors(),"","");
            //echo $this->upload->display_errors();
           }
           if($type != 'update'){
            $data['file_foto'] = '';
           }
         } else {
           $data['file_foto'] = $this->upload->data('file_name');
           if($type == 'update'){
            unlink($config['upload_path'].$old_data->file_foto);
           }
           $return = $this->tps_model->update($id,$data);
         }
        } 
        //$return = $this->tps_model->update($id,$data);
        

        return $return;
    }
}