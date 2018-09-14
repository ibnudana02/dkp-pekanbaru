<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_tps_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Tps.Content.View',
			'description' => 'View Tps Content',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Content.Create',
			'description' => 'Create Tps Content',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Content.Edit',
			'description' => 'Edit Tps Content',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Content.Delete',
			'description' => 'Delete Tps Content',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Reports.View',
			'description' => 'View Tps Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Reports.Create',
			'description' => 'Create Tps Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Reports.Edit',
			'description' => 'Edit Tps Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Reports.Delete',
			'description' => 'Delete Tps Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Settings.View',
			'description' => 'View Tps Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Settings.Create',
			'description' => 'Create Tps Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Settings.Edit',
			'description' => 'Edit Tps Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Settings.Delete',
			'description' => 'Delete Tps Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Developer.View',
			'description' => 'View Tps Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Developer.Create',
			'description' => 'Create Tps Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Developer.Edit',
			'description' => 'Edit Tps Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Tps.Developer.Delete',
			'description' => 'Delete Tps Developer',
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