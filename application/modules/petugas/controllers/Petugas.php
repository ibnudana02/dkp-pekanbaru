<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Petugas controller
 */
class Petugas extends Front_Controller
{
    protected $permissionCreate = 'Petugas.Petugas.Create';
    protected $permissionDelete = 'Petugas.Petugas.Delete';
    protected $permissionEdit   = 'Petugas.Petugas.Edit';
    protected $permissionView   = 'Petugas.Petugas.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('petugas/petugas_model');
        $this->lang->load('petugas');
        
        

        Assets::add_module_js('petugas', 'petugas.js');
    }

    /**
     * Display a list of Petugas data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        $records = $this->petugas_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}