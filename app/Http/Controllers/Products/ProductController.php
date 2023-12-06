<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Interfaces\Products\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository) {

        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:المنتجات',   ['only' => ['index']]);
        $this->middleware('permission:حذف منتج',   ['only' => ['destroy']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);

        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return $this->productRepository->index();
    }


    public function store(ProductRequest $request)
    {
        return $this->productRepository->store($request);
    }


    public function update(ProductRequest $request)
    {
        return $this->productRepository->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->productRepository->destroy($request);
    }


}
