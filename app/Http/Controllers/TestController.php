<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Models\Permission;
use App\Models\Role;

class TestController extends Controller
{
    /**
     * Function constructor
     *
     * @param UserRepository $user
     * @param RoleRepository $role
     */
    public function __construct (UserRepository $user, RoleRepository $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function index()
    {
        $users = $this->user->all();

        foreach($users as $user)
        {
            echo $user->role->name;
        }

        $users = $this->role->findById(1)->users;
        foreach($users as $user)
        {
            echo $user->display_name;
        }

        $permissions = Role::find(1)->permissions;
        foreach($permissions as $per)
        {
            echo $per->name;
        }

        $roles = Permission::find(1)->roles;
        foreach($roles as $role)
        {
            echo $role->name;
        }
    }
}
