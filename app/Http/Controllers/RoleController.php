<?php

namespace App\Http\Controllers;

use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Repositories\RolePermissionRepository;
use App\Enum\Paginate;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Enum\Permission;

class RoleController extends Controller
{
    /**
     * Function constructor
     *
     * @param RoleRepository $role
     * @param UserRepository $user
     * @param PermissionRepository $permission
     */
    public function __construct (UserRepository $user, RoleRepository $role, PermissionRepository $permission, RolePermissionRepository $rolePermission)
    {
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
        $this->rolePermission = $rolePermission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->checkPermission(Permission::SHOWROLE)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for show role']);
        }
        $page = $request->get('page',1);
        $roles = $this->role->getAll();
        return view('layouts.roles.index',compact('roles','page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->checkPermission(Permission::CREATEROLE)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for create role']);
        }
        $permissions = $this->permission->all();
        return view('layouts.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        if (!$this->checkPermission(Permission::CREATEROLE)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for create role']);
        }
        DB::beginTransaction();
        $data = [
            'name'=>$request->name,
            'slug'=>Str::slug($request->name)
        ];
        $result = $this->role->create($data);

        $permissionIdArr = $request->permission;
        foreach($permissionIdArr as $permission_id)
        {
            $dataRP = [
                'role_id' => $result->id,
                'permission_id' => $permission_id
            ];
            $resultAddPivot = $this->rolePermission->create($dataRP);
        }

        if (!$result || !$resultAddPivot) {
            DB::rollBack();
            return redirect()->route('roles.index')->with(['msgF'=>'Add role failed']);
        }
        DB::commit();
        return redirect()->route('roles.index')->with(['msgS'=>'Add role successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = $this->role->findById($id);
        if (!$role) {
            return redirect()->route('roles.index')->with(['msgF'=>'Role not found']);
        }

        $permissions = $this->role->permissions($id);
        return view('layouts.roles.show',compact('role','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$this->checkPermission(Permission::EDITROLE)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for edit role']);
        }
        $role = $this->role->findById($id);
        if (!$role) {
            return redirect()->route('roles.index')->with(['msgF'=>'Role not found']);
        }
        $permissionsRole = $this->role->permissions($id);
        $permissions = $this->permission->all();
        return view('layouts.roles.edit',compact('role','permissionsRole','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        if (!$this->checkPermission(Permission::EDITROLE)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for edit role']);
        }
        DB::beginTransaction();
        $data = [
            'name'=>$request->name,
            'slug'=>Str::slug($request->name)
        ];
        $result = $this->role->update($data,$id);

        //array per_id old with role
        $perOldArray = $this->rolePermission->findByField('role_id',$id);
        //array new per_id
        $perIdArray = $request->permission;
        $resultRoleP = true;

        foreach($perOldArray as $perOld)
        {
            $rolePermissionId = $this->rolePermission->findRolePermission($id,$perOld->permission_id)->id;
            //old is delete
            if (!in_array($perOld->permission_id, $perIdArray)) {
                $resultRoleP = $this->rolePermission->delete($rolePermissionId);
            }
        }

        //check if role_id is exists in array old role_id
        foreach($perIdArray as $permission_id)
        {
            $resultCheck = true;
            foreach($perOldArray as $item)
            {
                if ($permission_id == $item->permission_id) {
                    $resultCheck = false;
                    break;
                }
            }
            //insert new role_id
            if ($resultCheck) {
                $resultRoleP = $this->rolePermission->create(['role_id'=>$id,'permission_id'=>$permission_id]);
            }
        }
        if (!$result || !$resultRoleP) {
            DB::rollBack();
            return redirect()->route('roles.index')->with(['msgF'=>'Update role failed']);
        }
        DB::commit();
        return redirect()->route('roles.index')->with(['msgS'=>'Update role successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->checkPermission(Permission::DELETEROLE)) {
            return redirect()->route('home.index')->with(['msgF'=>'You do not have permission for delete role']);
        }
        if (!$this->role->findById($id)) {
            return redirect()->route('roles.index')->with(['mdgF'=>'Role not found']);
        }

        DB::beginTransaction();
        $roleIdArray = $this->rolePermission->findByField('role_id',$id);
        foreach($roleIdArray as $alo)
        {
            $resultDeleteInRolePermission = $this->rolePermission->delete($alo->id);
        }
        $result = $this->role->delete($id);
        if (!$resultDeleteInRolePermission || !$result) {
            DB::rollBack();
            return redirect()->route('roles.index')->with(['msgF'=>'Delete role failed']);
        }
        DB::commit();
        return redirect()->route('roles.index')->with(['msgS'=>'Delete role successfully']);
    }
}
