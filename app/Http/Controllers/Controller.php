<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Function constructor
     * @param UserRepository $user
     * @param RoleRepository $role
     */
    public function __construct (UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    /**
     * Check user have permission for action
     *
     * @param model $user
     * @param string $permission
     * @return boolean
     */
    public function checkPermission($permission)
    {
        $role_id = Auth::user()->role->id;
        $permissionsUser = $this->role->permissions($role_id);
        foreach($permissionsUser as $permissionU)
        {
            if ($permissionU->slug == $permission) {
                return true;
            }
        }
        return false;
    }
}
