<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_profil extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'profil';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id_profil' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'judul_profil' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => false,
        ),
        'tgl_terbit_profil' => array(
            'type'       => 'DATETIME',
            'null'       => false,
            'default'    => '0000-00-00 00:00:00',
        ),
        'isi_profil' => array(
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
		$this->dbforge->add_key('id_profil', true);
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