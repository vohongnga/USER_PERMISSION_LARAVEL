<?php
namespace App\Repositories;
use App\Repositories\RepositoryAbstract;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enum\RoleUser;
use App\Enum\Paginate;
class UserRepository extends RepositoryAbstract
{
    /**
     * @return model
     */
    public function getModel()
    {

        return User::class;

    }

    /**
     * Check user login is admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if(Auth::user()->role->id != RoleUser::ADMIN){
            return false;
        }
        return true;
    }

    /**
     * Get users with role and paginate
     *
     * @return mixed
     */
    public function getAll()
    {
        $model = $this->model;
        return $model->with('role')->paginate(Paginate::PAGINATE);
    }

    /**
     * Search users by name or email
     *
     * @param string $name
     * @return mixed
     */
    public function search($name)
    {
        return $this->model->where('display_name','LIKE',"%$name%")->orWhere('email','LIKE',"%name%")->with('role')->paginate(Paginate::PAGINATE);
    }

     /**
     * Search users by name or email
     *
     * @param int $role
     * @param string $name
     * @return mixed
     */
    public function searchMember($name,$role)
    {
        return $this->model->where('role_id',$role)->where('display_name','LIKE',"%$name%")->orWhere('email','LIKE',"%name%")->with('role')->paginate(Paginate::PAGINATE);
    }

    /**
     * Get users with role isnot admin and paginate
     *
     * @param int $role
     * @return mixed
     */
    public function getMembers($role)
    {
        return $this->model->with('role')->where('role_id',$role)->paginate(Paginate::PAGINATE);
    }
}
