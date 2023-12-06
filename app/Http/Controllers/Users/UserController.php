<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Interfaces\Users\UserRepositoryInterface;

class UserController extends Controller
{


    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:المستخدمين');
        $this->middleware('permission:قائمة المستخدمين',  ['only' => ['index']]);
        $this->middleware('permission:اضافة مستخدم', ['only' => ['cretae' , 'store']]);
        $this->middleware('permission:تعديل مستخدم', ['only' => ['edit' , 'update']]);
        $this->middleware('permission:حذف مستخدم', ['only' => ['destroy']]);

        $this->userRepository = $userRepository;

    }


    public function index(Request $request)
    {
        return $this->userRepository->index($request);
    }


    public function create()
    {
        return $this->userRepository->create();
    }


    public function store(UserRequest $request)
    {    
        return $this->userRepository->store($request);
    }


    public function show($id)
    {
        return $this->userRepository->show($id);
    }


    public function edit($id)
    {
        return $this->userRepository->edit($id);
    }


    public function update(UserRequest $request, $id)
    {
        return $this->userRepository->update($request, $id);
    }


    public function destroy(Request $request)
    {
        return $this->userRepository->destroy($request);
    }
}
