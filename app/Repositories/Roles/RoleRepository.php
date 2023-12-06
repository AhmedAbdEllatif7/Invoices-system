<?php

namespace App\Repositories\Roles;

use App\Interfaces\Roles\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleRepository implements RoleRepositoryInterface {


    public function index($request)
    {
    $roles = Role::orderBy('id','DESC')->paginate(5);
    return view('roles.index',compact('roles'))
    ->with('i', ($request->input('page', 1) - 1) * 5);
    }



    public function create()
    {
    $permission = Permission::all();
    return view('roles.create',compact('permission'));
    }



    public function store($request)
    {
        $validatedData = $request->validated();
        
        $role = $this->createRole($validatedData['name']);
        $this->syncPermissionsToRole($role, $validatedData['permission']);
    
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }
    
    public function createRole($name)
    {
        return Role::create(['name' => $name]);
    }
    
    public function syncPermissionsToRole($role, $permissions)
    {
        $role->syncPermissions($permissions);
    }
    





    public function show($id)
    {
        $role = $this->findRoleById($id);
        $rolePermissions = $this->getRolePermissions($id);
    
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    
    public function findRoleById($id)
    {
        return Role::findOrFail($id);
    }
    
    public function getRolePermissions($id)
    {
        return Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
            ->where("role_has_permissions.role_id", $id)
            ->get();
    }
    




    public function edit($id)
    {
        $role = $this->findRoleById($id);
        $permission = $this->getAllPermissions();
        $rolePermissions = $this->getAllRolePermissions($id);
    
        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }
    

    public function getAllPermissions()
    {
        return Permission::get();
    }

    
    public function getAllRolePermissions($id)
    {
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
    }


    public function update($request, $id)
    {
        $validatedData = $request->validated();
        
        $role = $this->findRoleById($id);
        $this->updateRoleDetails($role, $validatedData['name']);
        $this->syncPermissionsToRole($role, $validatedData['permission']);
    
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }
    
    public function updateRoleDetails($role, $name)
    {
        $role->name = $name;
        $role->save();
    }




    
    public function destroy($id)
    {
        $role = DB::table("roles")->find($id);
        if ($role) {
            DB::table("roles")->where('id', $id)->delete();
                return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
        } else {
            return redirect()->route('roles.index')->with('error', 'Role not found');
        }
    }
}