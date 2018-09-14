<?php defined('BASEPATH') || exit('No direct script access allowed');
class Pengangkut extends MX_Controller{
 public function _construct(){
  parent::__construct();

		$this->load->helper('application');
		$this->load->library('Template');
		$this->load->library('Assets');
		$this->lang->load('application');
		$this->load->library('events');

  // Make the requested page var available, since
  // we're not extending from a Bonfire controller
  // and it's not done for us.
  $this->requested_page = isset($_SESSION['requested_page']) ? $_SESSION['requested_page'] : null;
 }
 
 public function index(){
  $this->load->view('pengangkut/main');
 }
}