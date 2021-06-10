<?php
namespace App\Repositories;
use App\Repositories\RepositoryAbstract;
use App\Models\Role;
use App\Enum\Paginate;
use Illuminate\Contracts\Pagination\Paginator;

class RoleRepository extends RepositoryAbstract
{
    /**
     * @return model
     */
    public function getModel()
    {

        return Role::class;

    }

    /**
     * Get permissions of role
     *
     * @return mixed
     */
    public function permissions($role_id)
    {
        return $this->model->find($role_id)->permissions;
    }

    /**
     * Get roles with permissions and paginate
     *
     * @return mixed
     */
    public function getAll()
    {
        $model = $this->model;
        return $model->with('permissions')->paginate(Paginate::PAGINATE);
    }
}
