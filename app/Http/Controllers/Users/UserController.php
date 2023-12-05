<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function __construct(){
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:المستخدمين');
        $this->middleware('permission:قائمة المستخدمين',  ['only' => ['index']]);
        $this->middleware('permission:اضافة مستخدم', ['only' => ['cretae' , 'store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit' , 'update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);
    }




    public function index(Request $request)
    {
        $data = User::latest()->paginate(5);
        return view('users.index',compact('data'));
    }





    public function create()
    {
        
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }





    public function store(UserRequest $request)
    {    
        $validatedData = $this->validateAndHashPassword($request->validated());
        $user = $this->createUser($validatedData);
        $this->assignRolesToUser($user, $validatedData['roles_name']);
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    

    //This method handles the validation and hashing of the user's password:
    private function validateAndHashPassword($data)
    {
        $data['password'] = Hash::make($data['password']);
        return $data;
    }
    
    private function createUser($data)
    {
        return User::create($data);
    }
    
    private function assignRolesToUser($user, $roles)
    {
        $user->assignRole($roles);
    }
    
    




    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }




    
    public function edit($id)
    {
        $user = $this->findUserById($id);
        $roles = $this->getAllRoles();
        $userRole = $this->getUserRoles($user);

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    private function findUserById($id)
    {
        return User::findOrFail($id);
    }

    private function getAllRoles()
    {
        return Role::pluck('name', 'name')->all();
    }


    /**
     * $user->roles refers to a relationship between the User model and the Role model, assuming a many-to-many relationship
     *  where a user can have multiple roles.
     *  pluck('name', 'name') is a Laravel Eloquent method that retrieves specific columns from the result. In this case,
     *  it selects the 'name' column from the roles associated with the user.
     *  The first 'name' specifies the column to be retrieved, and the second 'name' specifies the key for the resulting array.
     *  all() converts the result into an associative array, where the role names serve as both keys and values.
     */
    private function getUserRoles($user)
    {
        return $user->roles->pluck('name', 'name')->all();
    }






    public function update(UserRequest $request, $id)
    {
        $validatedData = $this->validateUserData($request->validated());
        $this->updateUser($id, $validatedData);
        $this->updateUserRoles($id, $validatedData['roles_name']);
    
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
    

    /*
        It checks if the password is present in the data.
        If the password is present, it hashes it using Hash::make().
        If no password is present, it removes the password field from the data.
        Returns the validated and manipulated user data. 
    */
    private function validateUserData($data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, ['password']);
        }
        return $data;
    }
    
    private function updateUser($id, $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
    }
    

        private function deleteExistingUserRoles($id)
        {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
        }


    private function updateUserRoles($id, $roles)
    {
        $this->deleteExistingUserRoles($id);
        $user = User::findOrFail($id);
        $user->assignRole($roles);
    }
    


    


    
    public function destroy(Request $request)
    {
        User::findOrFail($request->user_id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
