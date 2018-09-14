<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Reports controller
 */
class Reports extends Admin_Controller
{
    protected $permissionCreate = 'Laporan_masyarakat.Reports.Create';
    protected $permissionDelete = 'Laporan_masyarakat.Reports.Delete';
    protected $permissionEdit   = 'Laporan_masyarakat.Reports.Edit';
    protected $permissionView   = 'Laporan_masyarakat.Reports.View';

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
        
        Template::set_block('sub_nav', 'reports/_sub_nav');

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
        
        
        $this->load->model('tps/tps_model');
        $tps_raw = $this->tps_model->find_all();
        $tps = array();
        foreach($tps_raw as $tp){
         $tps[$tp->id]['nama'] = $tp->nama;
         $tps[$tp->id]['coord'] = $tp->lat." , ".$tp->long;
        }
        $records = $this->laporan_masyarakat_model->find_all();

        Template::set('records', $records);
        Template::set('tpskita', $tps);
        
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

                redirect(SITE_AREA . '/reports/laporan_masyarakat');
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

            redirect(SITE_AREA . '/reports/laporan_masyarakat');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_laporan_masyarakat('update', $id)) {
                log_activity($this->auth->user_id(), lang('laporan_masyarakat_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'laporan_masyarakat');
                Template::set_message(lang('laporan_masyarakat_edit_success'), 'success');
                redirect(SITE_AREA . '/reports/laporan_masyarakat');
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

                redirect(SITE_AREA . '/reports/laporan_masyarakat');
            }

            Template::set_message(lang('laporan_masyarakat_delete_failure') . $this->laporan_masyarakat_model->error, 'error');
        }
        
        Template::set('laporan_masyarakat', $this->laporan_masyarakat_model->find($id));

        Template::set('toolbar_title', lang('laporan_masyarakat_edit_heading'));
        Template::render();
    }
	
	public function view($id) {
		$this->load->model('tps/tps_model');
  $tps_raw = $this->tps_model->find_all();
  $tps = array();
  foreach($tps_raw as $tp){
   $tps[$tp->id]['nama'] = $tp->nama;
   $tps[$tp->id]['coord'] = $tp->lat." , ".$tp->long;
  }
  Template::set('laporan_masyarakat', $this->laporan_masyarakat_model->find($id));
  Template::set('tpskita', $tps);
  Template::set('toolbar_title', 'Lihat Laporan Masyarakat');
		Template::render();
	}
 
 public function balas($id){
  // if a save posted
  if(isset($_POST['save'])){
   $this->load->library('emailer/Emailer');
   $email = array(
    'to' => $this->input->post('email_to'),
    'subject' => $this->input->post('email_subject'),
    'message' => $this->input->post('email_content')
   );
   $result = $this->emailer->send($email, true);
   if($result){
    $data = array(
     'balasan' => json_encode($email),
     'tanggal_balasan' => date('Y-m-d'),
     'status_laporan' => 1
    );
    $this->db->where('id_laporanmas',$id);
    $hasil = $this->db->update('bf_laporan_masyarakat', $data);
    Template::set_message("Email Balasan Telah Diantrikan.", 'success');
   } else {
    Template::set_message("Terdapat Kesalahan! Email Balasan Gagal Terkirim.", 'error');
   }
   redirect(SITE_AREA . '/reports/laporan_masyarakat/view/'.$id);
   //echo var_dump($this->laporan_masyarakat_model->error);
   //echo var_dump($hasil);
  }
  // view 
  $this->load->model('tps/tps_model');
  $tps_raw = $this->tps_model->find_all();
  $tps = array();
  foreach($tps_raw as $tp){
   $tps[$tp->id]['nama'] = $tp->nama;
   $tps[$tp->id]['coord'] = $tp->lat." , ".$tp->long;
  }
  $lapmas = $this->laporan_masyarakat_model->find($id);
  $subj = "Terima Kasih telah melapor, ".$lapmas->nama_pe_laporanmas."!";
  $cont = "<h1>Halo, ".$lapmas->nama_pe_laporanmas."</h1>  <h3 align='justify'>Terima Kasih atas kontribusi Anda dengan melaporkan masalah mengenai persampahan kepada Kami. Laporan Anda pada tanggal ".tanggal($lapmas->tgl_laporanmas)." akan kami tanggulangi secepatnya. Kami akan berusaha menciptakan Kota Pekanbaru yang bersih dan nyaman untuk Anda tinggali. Kami berharap Anda juga tidak bosan melaporkan masalah persampahan di lingkungan sekitar Anda.</h3> <h3>Salam,</h3>  <h3>DKP Kota Pekanbaru</h3>";
  Template::set('email_content', $cont);
  Template::set('email_subject', $subj);
  Template::set('laporan_masyarakat', $lapmas);
  Template::set('tpskita', $tps);
  Template::set('toolbar_title', 'Lihat Laporan Masyarakat');
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