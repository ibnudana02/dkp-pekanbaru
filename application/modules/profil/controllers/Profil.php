<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Profil controller
 */
class Profil extends Front_Controller
{
    protected $permissionCreate = 'Profil.Profil.Create';
    protected $permissionDelete = 'Profil.Profil.Delete';
    protected $permissionEdit   = 'Profil.Profil.Edit';
    protected $permissionView   = 'Profil.Profil.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('profil/profil_model');
        $this->lang->load('profil');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            Assets::add_css('jquery-ui-timepicker.css');
            Assets::add_js('jquery-ui-timepicker-addon.js');
        

        Assets::add_module_js('profil', 'profil.js');
    }

    /**
     * Display a list of Profil data.
     *
     * @return void
     */
    public function index()
    {
        
        
        
        
        $records = $this->profil_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}