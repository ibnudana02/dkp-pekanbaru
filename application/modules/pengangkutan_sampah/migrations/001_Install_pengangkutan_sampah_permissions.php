<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_pengangkutan_sampah_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Pengangkutan_sampah.Content.View',
			'description' => 'View Pengangkutan_sampah Content',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Content.Create',
			'description' => 'Create Pengangkutan_sampah Content',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Content.Edit',
			'description' => 'Edit Pengangkutan_sampah Content',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Content.Delete',
			'description' => 'Delete Pengangkutan_sampah Content',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Reports.View',
			'description' => 'View Pengangkutan_sampah Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Reports.Create',
			'description' => 'Create Pengangkutan_sampah Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Reports.Edit',
			'description' => 'Edit Pengangkutan_sampah Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Reports.Delete',
			'description' => 'Delete Pengangkutan_sampah Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Settings.View',
			'description' => 'View Pengangkutan_sampah Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Settings.Create',
			'description' => 'Create Pengangkutan_sampah Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Settings.Edit',
			'description' => 'Edit Pengangkutan_sampah Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Settings.Delete',
			'description' => 'Delete Pengangkutan_sampah Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Developer.View',
			'description' => 'View Pengangkutan_sampah Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Developer.Create',
			'description' => 'Create Pengangkutan_sampah Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Developer.Edit',
			'description' => 'Edit Pengangkutan_sampah Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Pengangkutan_sampah.Developer.Delete',
			'description' => 'Delete Pengangkutan_sampah Developer',
			'status' => 'active',
		),
    );

    /**
     * @var string The name of the permission key in the role_permissions table
     */
    private $permissionKey = 'permission_id';

    /**
     * @var string The name of the permission name field in the permissions table
     */
    private $permissionNameField = 'name';

	/**
	 * @var string The name of the role/permissions ref table
	 */
	private $rolePermissionsTable = 'role_permissions';

    /**
     * @var numeric The role id to which the permissions will be applied
     */
    private $roleId = '1';

    /**
     * @var string The name of the role key in the role_permissions table
     */
    private $roleKey = 'role_id';

	/**
	 * @var string The name of the permissions table
	 */
	private $tableName = 'permissions';

	//--------------------------------------------------------------------

	/**
	 * Install this version
	 *
	 * @return void
	 */
	public function up()
	{
		$rolePermissionsData = array();
		foreach ($this->permissionValues as $permissionValue) {
			$this->db->insert($this->tableName, $permissionValue);

			$rolePermissionsData[] = array(
                $this->roleKey       => $this->roleId,
                $this->permissionKey => $this->db->insert_id(),
			);
		}

		$this->db->insert_batch($this->rolePermissionsTable, $rolePermissionsData);
	}

	/**
	 * Uninstall this version
	 *
	 * @return void
	 */
	public function down()
	{
        $permissionNames = array();
		foreach ($this->permissionValues as $permissionValue) {
            $permissionNames[] = $permissionValue[$this->permissionNameField];
        }

        $query = $this->db->select($this->permissionKey)
                          ->where_in($this->permissionNameField, $permissionNames)
                          ->get($this->tableName);

        if ( ! $query->num_rows()) {
            return;
        }

        $permissionIds = array();
        foreach ($query->result() as $row) {
            $permissionIds[] = $row->{$this->permissionKey};
        }

        $this->db->where_in($this->permissionKey, $permissionIds)
                 ->delete($this->rolePermissionsTable);

        $this->db->where_in($this->permissionNameField, $permissionNames)
                 ->delete($this->tableName);
	}
}