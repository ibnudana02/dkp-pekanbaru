<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_rute_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Rute.Content.View',
			'description' => 'View Rute Content',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Content.Create',
			'description' => 'Create Rute Content',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Content.Edit',
			'description' => 'Edit Rute Content',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Content.Delete',
			'description' => 'Delete Rute Content',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Reports.View',
			'description' => 'View Rute Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Reports.Create',
			'description' => 'Create Rute Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Reports.Edit',
			'description' => 'Edit Rute Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Reports.Delete',
			'description' => 'Delete Rute Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Settings.View',
			'description' => 'View Rute Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Settings.Create',
			'description' => 'Create Rute Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Settings.Edit',
			'description' => 'Edit Rute Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Settings.Delete',
			'description' => 'Delete Rute Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Developer.View',
			'description' => 'View Rute Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Developer.Create',
			'description' => 'Create Rute Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Developer.Edit',
			'description' => 'Edit Rute Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Rute.Developer.Delete',
			'description' => 'Delete Rute Developer',
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