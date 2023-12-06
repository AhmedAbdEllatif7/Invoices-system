<?php

namespace App\Interfaces\Products;

interface ProductRepositoryInterface {

    public function index();

    public function store($request);

    public function update($request);

    public function destroy($request);


}