<?php defined('BASEPATH') || exit('No direct script access allowed');

class Pengangkutan_sampah_model extends BF_Model
{
    protected $table_name	= 'bf_laporangkut';
	protected $key			= 'id_laporan';
	protected $date_format	= 'datetime';

	protected $log_user 	= true;
	protected $set_created	= false;
	protected $set_modified = false;
	protected $soft_deletes	= false;


	// Customize the operations of the model without recreating the insert,
    // update, etc. methods by adding the method names to act as callbacks here.
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 	    = array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	// For performance reasons, you may require your model to NOT return the id
	// of the last inserted row as it is a bit of a slow method. This is
    // primarily helpful when running big loops over data.
	protected $return_insert_id = true;

	// The default type for returned row data.
	protected $return_type = 'object';

	// Items that are always removed from data prior to inserts or updates.
	protected $protected_attributes = array();

	// You may need to move certain rules (like required) into the
	// $insert_validation_rules array and out of the standard validation array.
	// That way it is only required during inserts, not updates which may only
	// be updating a portion of the data.
	protected $validation_rules 		= array(
		array(
			'field' => 'id_user',
			'label' => 'lang:pengangkutan_sampah_field_id_user',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'id_tps',
			'label' => 'lang:pengangkutan_sampah_field_id_tps',
			'rules' => 'max_length[11]',
		),
		array(
			'field' => 'tanggal_angkut',
			'label' => 'lang:pengangkutan_sampah_field_tanggal_angkut',
			'rules' => '',
		),
		array(
			'field' => 'waktu_angkut',
			'label' => 'lang:pengangkutan_sampah_field_waktu_angkut',
			'rules' => '',
		),
	);
	protected $insert_validation_rules  = array();
	protected $skip_validation 			= false;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function find_all_joined($user=''){
     $this->db->select('id_laporan, id_user, bf_users.display_name, bf_tps.nama, tanggal_angkut, waktu_angkut');
     $this->db->where('bf_laporangkut.id_user = bf_users.id and bf_laporangkut.id_tps = bf_tps.id');
	 if($user!==''){
	  $this->db->where('bf_laporangkut.id_user',$user);
	 }
     return $this->db->get('bf_laporangkut, bf_users, bf_tps')->result();
    }
}