<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_tps extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'tps';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'nama' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'status' => array(
            'type'       => 'ENUM',
            'constraint' => '\'Pinggir Jalan\',\'Lahan Kosong\'',
            'null'       => true,
        ),
        'kelurahan' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => true,
        ),
        'kecamatan' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => true,
        ),
        'volume' => array(
            'type'       => 'INTEGER',
            'null'       => true,
        ),
        'luas' => array(
            'type'       => 'BIGINT',
            'null'       => true,
        ),
        'keterangan' => array(
            'type'       => 'TEXT',
            'null'       => true,
        ),
        'lat' => array(
            'type'       => 'FLOAT',
            'constraint' => '15',
            'null'       => true,
        ),
        'long' => array(
            'type'       => 'FLOAT',
            'constraint' => '15',
            'null'       => true,
        ),
        'zoom' => array(
            'type'       => 'INTEGER',
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
		$this->dbforge->add_key('id', true);
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