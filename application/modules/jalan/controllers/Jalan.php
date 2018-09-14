<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Jalan controller
 */
class Jalan extends Front_Controller
{
    protected $permissionCreate = 'Jalan.Jalan.Create';
    protected $permissionDelete = 'Jalan.Jalan.Delete';
    protected $permissionEdit   = 'Jalan.Jalan.Edit';
    protected $permissionView   = 'Jalan.Jalan.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('jalan/jalan_model');
        $this->lang->load('jalan');
        
        

        Assets::add_module_js('jalan', 'jalan.js');
    }

    /**
     * Display a list of jalan data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        echo "<h1>eka WK WK WK</h1>";
        $records = $this->jalan_model->find_all();
		$this->load->view('index', ['records'=>$records]);
		//die(var_dump($records));
		
		//karena kita sudah edit template, jangan lagi pake yang ini
        //Template::set('records', $records);
        //Template::render();
    }
	
	public function geoJSON(){
        $records = $this->jalan_model->find_all();
		$this->load->view('geojson', ['records'=>$records]);		
	}
    
}
