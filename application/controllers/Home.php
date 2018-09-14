<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Bonfire
 *
 * An open source project to allow developers to jumpstart their development of
 * CodeIgniter applications.
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2014, Bonfire Dev Team
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

/**
 * Home controller
 *
 * The base controller which displays the homepage of the Bonfire site.
 *
 * @package    Bonfire
 * @subpackage Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Home extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('application');
		$this->load->library('Template');
		$this->load->library('Assets');
		$this->lang->load('application');
		$this->load->library('events');
  $this->load->model('profil/profil_model');

        $this->load->library('installer_lib');
        if (! $this->installer_lib->is_installed()) {
            $ci =& get_instance();
            $ci->hooks->enabled = false;
            redirect('install');
        }

        // Make the requested page var available, since
        // we're not extending from a Bonfire controller
        // and it's not done for us.
        $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
	}

	//--------------------------------------------------------------------

	/**
	 * Displays the homepage of the Bonfire app
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->library('users/auth');
		$this->set_current_user();
  Assets::js(array('jquery.min.js','bootstrap.min.js'));
  Template::set('hal','home');
		Template::render();
	}//end index()
 
 public function gis(){
  $this->load->library('users/auth');
  $this->set_current_user();
  Assets::add_css(array('leaflet.css','MarkerCluster.css','MarkerCluster.Default','L.Control.Locate.css','leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.css','app.css','leaflet.draw.css'));
  Assets::js(array('jquery.min.js','bootstrap.min.js','typeahead.bundle.min.js','handlebars.min.js','list.min.js','leaflet.js','leaflet.markercluster.js','L.Control.Locate.min.js','leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js','MovingMarker.js',
  'leaflet.geometryutil.js', 'app.js'));
  Template::set('hal','GIS');
  Template::render();
 }
 
 public function profil($id){
  $this->load->library('users/auth');
  $this->set_current_user();
  Assets::js(array('jquery.min.js','bootstrap.min.js'));
  $profil=$this->profil_model->find($id);
  $prolist=$this->profil_model->find_all_by('kategori_informasi','Profil DKP');
  //echo var_dump($profil);
  Template::set('profil',$profil);
  Template::set('prolist',$prolist);
  Template::render();
 }
 
 public function informasi(){
  $this->load->library('users/auth');
  $this->set_current_user();
  if($this->input->post('cari') !== null){
   $this->profil_model->where('kategori_informasi','Informasi Publik');
   $this->profil_model->like('judul_informasi',$this->input->post('query'));
   $prolist=$this->profil_model->find_all();
  } else {
   $prolist=$this->profil_model->find_all_by('kategori_informasi','Informasi Publik');
  }
  Assets::js(array('jquery.min.js','bootstrap.min.js'));
  
  //echo var_dump($prolist);
  Template::set('artikel',$prolist);
  Template::render();
 }
 
 public function aksi_lapor(){
  $this->load->model('laporan_masyarakat/laporan_masyarakat_model');
  $data = $this->laporan_masyarakat_model->prep_data($this->input->post());
  $config['upload_path']   = 'data/images/';
  $config['allowed_types'] = 'gif|jpg|png|jpeg';
  $config['max_size']      = 10240;
  $config['file_name']     = $data['nama_pe_laporanmas']."-".date('ymdhis');
  $this->load->library('upload', $config);
  if($this->upload->data() != null){
   if ( ! $this->upload->do_upload('foto_laporanmas') && ! $this->upload->data('is_image') ){
     $error = array('error' => $this->upload->display_errors());
     if($error['error'] == "You did not select a file to upload."){
      $this->flashMsg($this->upload->display_errors(),"","");
      //echo $this->upload->display_errors();
     }
     
   } else {
     $data['foto_laporanmas'] = $this->upload->data('file_name');
   }
  } else {
   $data['foto_laporanmas'] = '';
  }
  $data['tgl_laporanmas'] = date('Y-m-d h:i:s');
  $data['status_laporan'] = 0;
  
  if($this->laporan_masyarakat_model->insert($data)){
   $this->load->model('tps/tps_model');
   Template::set('success',true);
   Template::set('datalapor',$data);
   Template::set('tps',$this->tps_model->find($data['id_tps']));
   Template::set('judul','Laporan Telah Diterima!');
  } else {
   Template::set('success',false);
   Template::set('judul','Gagal Mengirim Laporan! '.$this->laporan_masyarakat_model->error);
  }
  //echo var_dump($data);
  
  Template::set_view('home/message');
  Template::render();
 }
 
 public function apicamat(){
  $k_lat = $this->input->get('lat');
  $k_long = $this->input->get('long');
  $jsonlurah = file_get_contents('data/kelurahan.php');
  
  
 }

	//--------------------------------------------------------------------

	/**
	 * If the Auth lib is loaded, it will set the current user, since users
	 * will never be needed if the Auth library is not loaded. By not requiring
	 * this to be executed and loaded for every command, we can speed up calls
	 * that don't need users at all, or rely on a different type of auth, like
	 * an API or cronjob.
	 *
	 * Copied from Base_Controller
	 */
	protected function set_current_user()
	{
        if (class_exists('Auth')) {
			// Load our current logged in user for convenience
            if ($this->auth->is_logged_in()) {
				$this->current_user = clone $this->auth->user();

				$this->current_user->user_img = gravatar_link($this->current_user->email, 22, $this->current_user->email, "{$this->current_user->email} Profile");

				// if the user has a language setting then use it
                if (isset($this->current_user->language)) {
					$this->config->set_item('language', $this->current_user->language);
				}
            } else {
				$this->current_user = null;
			}

			// Make the current user available in the views
            if (! class_exists('Template')) {
				$this->load->library('Template');
			}
			Template::set('current_user', $this->current_user);
		}
	}
}
/* end ./application/controllers/home.php */
