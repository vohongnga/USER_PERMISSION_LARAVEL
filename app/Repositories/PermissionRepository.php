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

    /**
     * Search permissions by name or slug
     *
     * @param string $name
     * @return mixed
     */
    public function search($name)
    {
        return $this->model->where('name','LIKE',"%$name%")->orWhere('slug','LIKE',"%name%")->with('roles')->paginate(Paginate::PAGINATE);
    }

    /**
     * Check slug permission is exists
     *
     * @param string $slug
     *@return boolean
     */
    public function checkSlug($slug)
    {
        $result = $this->model->where('slug',$slug)->first();
        if (!$result) {
            return true;
        }
        return false;
    }
}
