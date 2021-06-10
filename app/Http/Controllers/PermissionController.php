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
        DB::beginTransaction();
        $permisisonData = [
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
        ];
        $slug = Str::slug($request->name);

        if (!$this->isFormatted($slug)) {
            return redirect()->route('permissions.index')->with(['msgF'=>'Name permission is unformatted']);
        }
        $result = $this->permission->create($permisisonData);

        $roleIdArr = $request->role_id;
        foreach($roleIdArr as $role_id)
        {
            $rolePermissionData = [
                'role_id' => $role_id,
                'permission_id' => $result->id
            ];
            $resultRolePer = $this->rolePermission->create($rolePermissionData);
        }


        if (!$result || !$resultRolePer) {
            DB::rollBack();
            return redirect()->route('permissions.index')->with(['msgF'=>'Add permission failed']);
        }
        DB::commit();
        return redirect()->route('permissions.index')->with(['msgS'=>'Add permission successfully']);
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
        return redirect()->route('permissions.index')->with(['msgF'=>'You do not have permission for edit rolex']);

        $roles = $this->role->all();
        $rolesOfPermission = $this->permission->roles($id);
        return view('layouts.permissions.edit',compact('permission','roles','rolesOfPermission'));
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
        DB::beginTransaction();
        $data = [
            'name'=>$request->name,
            'slug'=>Str::slug($request->name)
        ];
        $result = $this->permission->update($data,$id);

        //array role_id old with permission
        $roleOldArr = $this->rolePermission->findByField('permission_id',$id);
        //array new role_id
        $roleIdArray = $request->role_id;
        $resultRoleP = true;

        foreach($roleOldArr as $roleOld)
        {
            $rolePermissionId = $this->rolePermission->findRolePermission($roleOld->role_id,$id)->id;
            //old is delete
            if (!in_array($roleOld->role_id, $roleIdArray)) {
                $resultRoleP = $this->rolePermission->delete($rolePermissionId);
            }
        }

        //check if role_id is exists in array old role_id
        foreach($roleIdArray as $role_id)
        {
            $resultCheck = true;
            foreach($roleOldArr as $item)
            {
                if ($role_id == $item->role_id) {
                    $resultCheck = false;
                    break;
                }
            }
            //insert new role_id
            if ($resultCheck) {
                $resultRoleP = $this->rolePermission->create(['role_id'=>$role_id,'permission_id'=>$id]);
            }
        }
        if (!$result || !$resultRoleP) {
            DB::rollBack();
            return redirect()->route('permissions.index')->with(['msgF'=>'Update permission failed']);
        }
        DB::commit();
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
        DB::beginTransaction();
        $permissionIdArray = $this->rolePermission->findByField('permission_id',$id);

        foreach($permissionIdArray as $alo)
        {
            $resultDeleteInRolePermission = $this->rolePermission->delete($alo->id);
        }
        $result = $this->permission->delete($id);
        if (!$resultDeleteInRolePermission || !$result) {
            DB::rollBack();
            return redirect()->route('permissions.index')->with(['msgF'=>'Delete permission failed']);
        }
        DB::commit();
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
