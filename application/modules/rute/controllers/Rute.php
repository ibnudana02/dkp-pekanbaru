<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Rute controller
 */
class Rute extends Front_Controller
{
    protected $permissionCreate = 'Rute.Rute.Create';
    protected $permissionDelete = 'Rute.Rute.Delete';
    protected $permissionEdit   = 'Rute.Rute.Edit';
    protected $permissionView   = 'Rute.Rute.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('rute/rute_model');
        $this->lang->load('rute');
        
        

        Assets::add_module_js('rute', 'rute.js');
    }

    /**
     * Display a list of Rute data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        $records = $this->rute_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}