<?php

namespace App\Interfaces\Users;

interface UserRepositoryInterface {


    public function index($request);


    public function create();


    public function store($request);


    public function validateAndHashPassword($data);


    public function createUser($data);


    public function assignRolesToUser($user, $roles);


    public function show($id);


    public function edit($id);


    public function findUserById($id);


    public function getAllRoles();


    public function getUserRoles($user);


    public function update($request, $id);


    public function validateUserData($data);

    
    public function updateUser($id, $data);


    public function deleteExistingUserRoles($id);


    public function updateUserRoles($id, $roles);

    
    public function destroy($request);

}