<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_petugas_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Petugas.Content.View',
			'description' => 'View Petugas Content',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Content.Create',
			'description' => 'Create Petugas Content',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Content.Edit',
			'description' => 'Edit Petugas Content',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Content.Delete',
			'description' => 'Delete Petugas Content',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Reports.View',
			'description' => 'View Petugas Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Reports.Create',
			'description' => 'Create Petugas Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Reports.Edit',
			'description' => 'Edit Petugas Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Reports.Delete',
			'description' => 'Delete Petugas Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Settings.View',
			'description' => 'View Petugas Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Settings.Create',
			'description' => 'Create Petugas Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Settings.Edit',
			'description' => 'Edit Petugas Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Settings.Delete',
			'description' => 'Delete Petugas Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Developer.View',
			'description' => 'View Petugas Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Developer.Create',
			'description' => 'Create Petugas Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Developer.Edit',
			'description' => 'Edit Petugas Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Petugas.Developer.Delete',
			'description' => 'Delete Petugas Developer',
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