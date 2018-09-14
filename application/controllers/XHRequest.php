<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Content controller
 */
class XHRequest extends Base_Controller{

    public function __construct(){
        $this->load->model('pengangkutan_sampah/pengangkutan_sampah_model');
        $this->load->model('tps/tps_model');
        
    }
    
    public function lapor(){
        $data = array(
         'id_tps' => $this->input->post('id_tps'),
         'id_user' => $this->input->post('id_user'),
         'tanggal_angkut' => date('Y-m-d'),
         'waktu_angkut' => date('H:i:s'),
        );
        $id = $this->pengangkutan_sampah_model->insert($data);
        if (is_numeric($id)) {
         $return = json_encode($data);
        } else {
         $return = false;
        }
        echo $return;
    }
    
    public function coba(){
     $data = array(
      'tanggal_angkut' => date('d-m-Y'),
      'waktu_angkut' => date('H:i:s'),
      'session_id' => session_id()
     );
     echo json_encode($data);
     
    }
}