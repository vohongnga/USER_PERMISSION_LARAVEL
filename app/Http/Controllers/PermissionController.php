<?php

namespace App\Http\Controllers;

use App\Enum\Permission;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PermissionRequest;
use Illuminate\Support\Str;
use App\Repositories\RolePermissionRepository;
use App\Enum\RoleUser;
use App\Models\Role;

class PermissionController extends Controller
{
    /**
     * Function constructor
     *
     * @param UserRepository $user
     * @param RoleRepository $role
     * @param PermissionRepository $permission
     * @param RolePermissionRepository $rolePermission
     */
    public function __construct (UserRepository $user, RoleRepository $role, PermissionRepository $permission,RolePermissionRepository $rolePermission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
        $this->rolePermission = $rolePermission;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->checkPermission(Permission::SHOWPER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for show permission']);
        }
        $permissions = $this->permission->getAll();
        $page = $request->get('page');
        if (!$page) {
            $page = 1;
        }
        return view('layouts.permissions.index',compact('permissions','page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->checkPermission(Permission::CREATEPER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for create permission']);
        }
        $roles = $this->role->all();
        $member = RoleUser::MEMBER;
        return view('layouts.permissions.create',compact('roles','member'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        if (!$this->checkPermission(Permission::CREATEPER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for create permission']);
        }
        // DB::beginTransaction();
        $permisisonData = [
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
        ];
        $slug = Str::slug($request->name);

        if (!$this->isFormatted($slug)) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Name permission is unformatted']);
        }

        if(!$this->permission->checkSlug($slug)) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Permission is exist']);
        }

        $result = $this->permission->create($permisisonData);

        if (!$result) {
            // DB::rollBack();
            return redirect()->route('permissions.index')->with(['msgF'=>'Add permission failed']);
        }
        // DB::commit();
        return redirect()->route('permissions.index')->with(['msgS'=>'Add permission successfully']);
    }

    /**
     * Show the form for editing the specified resource
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$this->checkPermission(Permission::EDITPER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for edit permission']);
        }
        $permission = $this->permission->findById($id);

        if (!$permission) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Permission not found']);
        }

        $rolesOfPermission = $this->permission->roles($id);
        return view('layouts.permissions.edit',compact('permission','rolesOfPermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        if (!$this->checkPermission(Permission::EDITPER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for edit permission']);
        }
        $data = [
            'name'=>$request->name,
            'slug'=>Str::slug($request->name)
        ];

        $slug = Str::slug($request->name);

        if (!$this->isFormatted($slug)) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Name permission is unformatted']);
        }

        if(!$this->permission->checkSlug($slug)) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Permission is exist']);
        }

        $result = $this->permission->update($data,$id);

        if (!$result) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Update permission failed']);
        }
        return redirect()->route('permissions.index')->with(['msgS'=>'Update permission successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->checkPermission(Permission::DELETEPER)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for delete permission']);
        }
        if (!$this->permission->findById($id)) {
            return redirect()->route('permissions.index')->with(['mdgF'=>'Permission not found']);
        }

        $permissionIdArray = $this->rolePermission->findByField('permission_id',$id);

        foreach($permissionIdArray as $alo) {
            $resultDeleteInRolePermission = $this->rolePermission->delete($alo->id);
        }
        $result = $this->permission->delete($id);
        if (!$resultDeleteInRolePermission || !$result) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Delete permission failed']);
        }
        return redirect()->route('permissions.index')->with(['msgS'=>'Delete permission successfully']);
    }

    /**
     * Check name permission is possible
     *
     * @param string $slug
     * @return boolean
     */
    public function isFormatted($slug)
    {
        if ($slug != Permission::CREATEUSER && $slug != Permission::EDITUSER && $slug != Permission::DELETEUSER && $slug != Permission::CREATEROLE && $slug != Permission::EDITROLE && $slug != Permission::DELETEROLE && $slug != Permission::CREATEPER && $slug != Permission::EDITPER && $slug != Permission::DELETEPER && $slug != Permission::SHOWUSERS && $slug != Permission::SHOWROLE && $slug != Permission::SHOWPER) {
            return false;
        }
        return true;
    }

}
