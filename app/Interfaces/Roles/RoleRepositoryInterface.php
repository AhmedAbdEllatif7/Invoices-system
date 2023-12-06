<?php

namespace App\Interfaces\Roles;


interface RoleRepositoryInterface {

    public function index($request);

    public function create();

    public function store($request);

    public function createRole($name);

    public function syncPermissionsToRole($role, $permissions);

    public function show($id);
    
    public function findRoleById($id);

    public function getRolePermissions($id);

    public function edit($id);

    public function getAllPermissions();

    public function getAllRolePermissions($id);

    public function update($request, $id);

    public function updateRoleDetails($role, $name);

    public function destroy($id);


}