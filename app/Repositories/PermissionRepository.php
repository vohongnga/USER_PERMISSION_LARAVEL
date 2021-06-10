<?php
namespace App\Repositories;

use App\Enum\Paginate;
use App\Repositories\RepositoryAbstract;
use App\Models\Permission;

class PermissionRepository extends RepositoryAbstract
{
    /**
     * @return model
     */
    public function getModel()
    {

        return Permission::class;

    }

    /**
     * Get permission role and paginate
     *
     * @return mixed
     */
    public function getAll()
    {
        $model = $this->model;
        return $model->with('roles')->paginate(Paginate::PAGINATE);
    }

    /**
     *Get roles of permission
    *
     *@param int $id
     *@return mixed
     */
    public function getRolesOfPermission($id)
    {
        $model = $this->model;
       return $model->find($id)->roles_permisison;
    }

    /**
     * Get roles of permission
     *
     * @param int permission_id
     * @return array
     */
    public function roles($permission_id)
    {
        return $this->model->find($permission_id)->roles;
    }
}
