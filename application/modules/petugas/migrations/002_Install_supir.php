<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_supir extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'supir';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id_petugas' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'nama_petugas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'no_hp_petugas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 14,
            'null'       => true,
        ),
        'shift_petugas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 10,
            'null'       => true,
        ),
        'id_rute' => array(
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => true,
        ),
        'kecamatan' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => true,
        ),
	);

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id_petugas', true);
		$this->dbforge->create_table($this->table_name);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}
}