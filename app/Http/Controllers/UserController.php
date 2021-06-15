<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;
use App\Enum\RoleUser;
use App\Enum\Paginate;
use App\Enum\Permission;
use App\Http\Requests\ChangePassRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use DB;
class UserController extends Controller
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

    /**
     * Show the table user.
     *
     * @param \Illuminate\Http\UserRequest  $request
     * @return view
     */
    public function index(Request $request)
    {
        if (!$this->checkPermission('show-user')) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for show-user']);
        }
        $role = $this->user->isAdmin();
        $page = $request->get('page', 1);
        $users = $this->user->getAll();
        $members = $this->user->getMembers(Auth::user()->role_id);
        return view('layouts.users.index',compact('users','page','role','members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->checkPermission(Permission::CREATEUSER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for create user']);
        }
        $roles = $this->role->all();
        return view('layouts.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!$this->checkPermission(Permission::CREATEUSER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for create user']);
        }
        $data = $request->only('display_name', 'email', 'role_id');
        $data['password'] = Hash::make($request->password);
        $result = $this->user->create($data);
        if (!$result) {
            return redirect()->route('users.index')->with(['msgF'=>'Add user failed']);
        }
        return redirect()->route('users.index')->with(['msgS'=>'Add user successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if (!$this->checkPermission(Permission::EDITUSER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for edit user']);
        }
        $page = $request->get('page',1);
        $user = $this->user->findById($id);
        if(!$user || $user->role->id == RoleUser::ADMIN)
        {
            return redirect()->route('users.index')->with(['msgF'=>'User not found or You can not edit this user']);
        }
        // if ($user->role->id == RoleUser::ADMIN) {
        //     return redirect()->route('users.index')->with(['msgF'=>'You can not edit this user']);
        // }
        $roles = $this->role->all();
        return view('layouts.users.edit',compact('user','roles','page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserEditRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        if (!$this->checkPermission(Permission::EDITUSER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for edit user']);
        }
        $page = $request->get('page');
        $data = $request->only('display_name','email','role_id');
        if ($this->user->isAdmin($id)) {
            $data['role_id']= RoleUser::ADMIN;
        }
        $result = $this->user->update($data,$id);
        if (!$result) {
            return redirect()->route('users.index',['page'=>$page])->with(['msgF'=>'Update user failed']);
        }
        return redirect()->route('users.index',['page'=>$page])->with(['msgS'=>'Update user successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->checkPermission(Permission::DELETEUSER) || !$this->user->isAdmin()) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for delete user']);
        }

        $userDelete = $this->user->findById($id);
        if (Auth::user()->id == $id || $userDelete->role->id == RoleUser::ADMIN) {
            return redirect()->route('users.index')->with(['msgF'=>'You can not delete this user']);
        }

        if (!$userDelete) {
            return redirect()->route('users.index')->with(['msgF'=>'User not found']);
        }
        $result = $this->user->delete($id);
        return redirect()->route('users.index')->with(['msgS'=>'Delete user successfully!']);
    }

    /**
     * Show form for change password
     *
     * @param int $id
     * @return view
     */
    public function showPassword($id)
    {
        if (!$this->checkPermission(Permission::CHANGEPASS)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for change password']);
        }
        $user = $this->user->findById($id);
        if (!$user) {
            return redirect()->route('users.index')->with(['msgF'=>'User not found']);
        }
        return view('layouts.users.changePass',compact('user'));
    }

    /**
     *Change password
     *
     * @param  \Illuminate\Http\ChangePassRequest  $request
     * @param int $id
     * @return mixed
     */
    public function updatePassword(ChangePassRequest $request,$id)
    {
        if (!$this->checkPermission(Permission::CHANGEPASS)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for change password']);
        }
        $data = ['password'=>Hash::make($request->password)];
        $result = $this->user->update($data,$id);
        if (!$result) {
             return redirect()->route('users.index')->with(['msgF'=>'Change password failed']);
        }
        return redirect()->route('users.index')->with(['msgS'=>'Change password successfully']);
    }

    /**
     * Search
     *
     * @param \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $name = $request->search;
        $users = $this->user->search($name);
        $members = $this->user->searchMember($name,Auth::user()->role_id);
        $role = $this->user->isAdmin();
        $page = $request->get('page', 1);
        return view('layouts.users.index',compact('users','page','members','role','name'));
    }


}

