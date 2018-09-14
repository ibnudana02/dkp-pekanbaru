<?php defined('BASEPATH') || exit('No direct script access allowed');

class Migration_Install_profil_permissions extends Migration
{
	/**
	 * @var array Permissions to Migrate
	 */
	private $permissionValues = array(
		array(
			'name' => 'Profil.Content.View',
			'description' => 'View Profil Content',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Content.Create',
			'description' => 'Create Profil Content',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Content.Edit',
			'description' => 'Edit Profil Content',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Content.Delete',
			'description' => 'Delete Profil Content',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Reports.View',
			'description' => 'View Profil Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Reports.Create',
			'description' => 'Create Profil Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Reports.Edit',
			'description' => 'Edit Profil Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Reports.Delete',
			'description' => 'Delete Profil Reports',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Settings.View',
			'description' => 'View Profil Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Settings.Create',
			'description' => 'Create Profil Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Settings.Edit',
			'description' => 'Edit Profil Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Settings.Delete',
			'description' => 'Delete Profil Settings',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Developer.View',
			'description' => 'View Profil Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Developer.Create',
			'description' => 'Create Profil Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Developer.Edit',
			'description' => 'Edit Profil Developer',
			'status' => 'active',
		),
		array(
			'name' => 'Profil.Developer.Delete',
			'description' => 'Delete Profil Developer',
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