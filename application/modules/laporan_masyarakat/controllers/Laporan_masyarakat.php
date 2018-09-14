<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Laporan_masyarakat controller
 */
class Laporan_masyarakat extends Front_Controller
{
    protected $permissionCreate = 'Laporan_masyarakat.Laporan_masyarakat.Create';
    protected $permissionDelete = 'Laporan_masyarakat.Laporan_masyarakat.Delete';
    protected $permissionEdit   = 'Laporan_masyarakat.Laporan_masyarakat.Edit';
    protected $permissionView   = 'Laporan_masyarakat.Laporan_masyarakat.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('laporan_masyarakat/laporan_masyarakat_model');
        $this->lang->load('laporan_masyarakat');
        
        

        Assets::add_module_js('laporan_masyarakat', 'laporan_masyarakat.js');
    }

    /**
     * Display a list of Laporan Masyarakat data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        $records = $this->laporan_masyarakat_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}