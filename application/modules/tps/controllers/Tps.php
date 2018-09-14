<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Tps controller
 */
class Tps extends Front_Controller
{
    protected $permissionCreate = 'Tps.Tps.Create';
    protected $permissionDelete = 'Tps.Tps.Delete';
    protected $permissionEdit   = 'Tps.Tps.Edit';
    protected $permissionView   = 'Tps.Tps.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('tps/tps_model');
        $this->lang->load('tps');
        
        

        Assets::add_module_js('tps', 'tps.js');
    }

    /**
     * Display a list of tps data.
     *
     * @return void
     */
    public function index()
    {
     $records = $this->tps_model->find_all();
     $this->load->view('index', ['records'=>$records]);
        //Template::set('records', $records);
        //Template::render();
    }
    
	public function geoJSON(){
        $records = $this->tps_model->find_all();
        $this->load->view('geojson', ['records'=>$records]);		
	}
    
}