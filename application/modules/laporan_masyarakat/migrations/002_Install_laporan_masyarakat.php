<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_laporan_masyarakat extends Migration
{
	/**
	 * @var string The name of the database table
	 */
	private $table_name = 'laporan_masyarakat';

	/**
	 * @var array The table's fields
	 */
	private $fields = array(
		'id_laporanmas' => array(
			'type'       => 'INT',
			'constraint' => 11,
			'auto_increment' => true,
		),
        'nama_pe_laporanmas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 25,
            'null'       => false,
        ),
        'notel_laporanmas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 14,
            'null'       => false,
        ),
        'email_laporanmas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 30,
            'null'       => true,
        ),
        'kelurahan_laporanmas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 25,
            'null'       => false,
        ),
        'kecamatan_laporanmas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 25,
            'null'       => false,
        ),
        'isi_laporanmas' => array(
            'type'       => 'TEXT',
            'null'       => false,
        ),
        'foto_laporanmas' => array(
            'type'       => 'VARCHAR',
            'constraint' => 15,
            'null'       => true,
        ),
        'id_tps' => array(
            'type'       => 'INT',
            'constraint' => 5,
            'null'       => false,
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
		$this->dbforge->add_key('id_laporanmas', true);
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