<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_jalan extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'jalan';

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
            'constraint' => 50,
            'null'       => true,
        ),
        'html' => array(
            'type'       => 'TEXT',
            'null'       => true,
        ),
        'geom' => array(
            'type'       => 'TEXT',
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