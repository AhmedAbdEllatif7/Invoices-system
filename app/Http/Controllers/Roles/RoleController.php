<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Interfaces\Roles\RoleRepositoryInterface;

class RoleController extends Controller
{
    
    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository) {
    $this->middleware(['auth' , 'check.user.status'] );
    $this->middleware('permission:عرض صلاحية', ['only' => ['index']]);
    $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
    $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
    $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);

    $this->roleRepository = $roleRepository;

    }


    public function index(Request $request)
    {
        return $this->roleRepository->index($request);
    }


    public function create()
    {
        return $this->roleRepository->create();
    }


    public function store(RoleRequest $request)
    {
        return $this->roleRepository->store($request);
    }    


    public function show($id)
    {
        return $this->roleRepository->show($id);
    }


    public function edit($id)
    {
        return $this->roleRepository->edit($id);
    }


    public function update(RoleRequest $request, $id)
    {        
        return $this->roleRepository->update($request, $id);
    }


    public function destroy($id)
    {
        return $this->roleRepository->destroy($id);
    }

}
