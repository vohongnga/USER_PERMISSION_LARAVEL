<?php
namespace App\Repositories;
use App\Repositories\RepositoryAbstract;
use App\Models\RolePermission;

class RolePermissionRepository extends RepositoryAbstract
{
    /**
     * @return model
     */
    public function getModel()
    {

        return RolePermission::class;

    }

    /**
     * Find record with role_id, permission_id
     *
     * @param int $role_id, $permission_id
     * @return mixed
     */
    public function findRolePermission($role_id,$permission_id)
    {
        return $this->model->where('role_id',$role_id)->where('permission_id',$permission_id)->first();
    }

    /**
     * Delete records with permission
     *
     * @param array
     * @return mixed
     */
    public function deleteMultiple($permissionIdArray)
    {
        return $this->model->where('permission_id', $permissionIdArray)->get();
    }

}
