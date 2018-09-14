<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Pengangkutan_sampah controller
 */
class Pengangkutan_sampah extends Front_Controller
{
    protected $permissionCreate = 'Pengangkutan_sampah.Pengangkutan_sampah.Create';
    protected $permissionDelete = 'Pengangkutan_sampah.Pengangkutan_sampah.Delete';
    protected $permissionEdit   = 'Pengangkutan_sampah.Pengangkutan_sampah.Edit';
    protected $permissionView   = 'Pengangkutan_sampah.Pengangkutan_sampah.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('pengangkutan_sampah/pengangkutan_sampah_model');
        $this->lang->load('pengangkutan_sampah');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
        

        Assets::add_module_js('pengangkutan_sampah', 'pengangkutan_sampah.js');
    }

    /**
     * Display a list of Pengangkutan Sampah data.
     *
     * @return void
     */
    public function index($offset = 0)
    {
        
        $pagerUriSegment = 3;
        $pagerBaseUrl = site_url('pengangkutan_sampah/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->pengangkutan_sampah_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->pengangkutan_sampah_model->limit($limit, $offset);
        
        $records = $this->pengangkutan_sampah_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}