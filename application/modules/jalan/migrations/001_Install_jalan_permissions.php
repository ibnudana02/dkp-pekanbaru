<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_jalan_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Jalan.Content.View',
			'description' => 'View Jalan Content',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Content.Create',
			'description' => 'Create Jalan Content',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Content.Edit',
			'description' => 'Edit Jalan Content',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Content.Delete',
			'description' => 'Delete Jalan Content',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Reports.View',
			'description' => 'View Jalan Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Reports.Create',
			'description' => 'Create Jalan Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Reports.Edit',
			'description' => 'Edit Jalan Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Reports.Delete',
			'description' => 'Delete Jalan Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Settings.View',
			'description' => 'View Jalan Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Settings.Create',
			'description' => 'Create Jalan Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Settings.Edit',
			'description' => 'Edit Jalan Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Settings.Delete',
			'description' => 'Delete Jalan Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Developer.View',
			'description' => 'View Jalan Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Developer.Create',
			'description' => 'Create Jalan Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Developer.Edit',
			'description' => 'Edit Jalan Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Jalan.Developer.Delete',
			'description' => 'Delete Jalan Developer',
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