<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(){

        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:المنتجات',   ['only' => ['index']]);
        $this->middleware('permission:حذف منتج',   ['only' => ['destroy']]);
        $this->middleware('permission:اضافة منتج', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['edit','update']]);
    
    }

    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('products.index',compact('products','sections'));
    }





    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();

        Product::create($validatedData);

        session()->flash('add_product');
        return redirect()->back();

    }





    public function update(ProductRequest $request)
    {

        $productId = $request->id;

        $validatedData = $request->validated();
        
        $product = Product::findorFail($productId);

        $product->update($validatedData);

        session()->flash('edit');
        return back();

    }




    public function destroy(Request $request)
    {

        $id = $request->id;

        $product = Product::findOrFail($id);
        $product = $product->destroy($id);
        session()->flash('delete');
        return redirect()->back();
    }


}
