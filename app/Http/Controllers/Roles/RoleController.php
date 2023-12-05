<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    
    function __construct()
    {
    $this->middleware(['auth' , 'check.user.status'] );
    $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
    $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);

    }





    public function index(Request $request)
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





    public function store(RoleRequest $request)
    {
        $validatedData = $request->validated();
        
        $role = $this->createRole($validatedData['name']);
        $this->syncPermissionsToRole($role, $validatedData['permission']);
    
        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }
    
    private function createRole($name)
    {
        return Role::create(['name' => $name]);
    }
    
    private function syncPermissionsToRole($role, $permissions)
    {
        $role->syncPermissions($permissions);
    }
    





    public function show($id)
    {
        $role = $this->findRoleById($id);
        $rolePermissions = $this->getRolePermissions($id);
    
        return view('roles.show', compact('role', 'rolePermissions'));
    }
    
    private function findRoleById($id)
    {
        return Role::findOrFail($id);
    }
    
    private function getRolePermissions($id)
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
    

    private function getAllPermissions()
    {
        return Permission::get();
    }

    
    private function getAllRolePermissions($id)
    {
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
    }


    public function update(RoleRequest $request, $id)
    {
        $validatedData = $request->validated();
        
        $role = $this->findRoleById($id);
        $this->updateRoleDetails($role, $validatedData['name']);
        $this->syncPermissionsToRole($role, $validatedData['permission']);
    
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }
    
    private function updateRoleDetails($role, $name)
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
