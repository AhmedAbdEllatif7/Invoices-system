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
        $this->middleware('returnRedirectIfNotAuth');
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
        $sectionId = Section::where('section_name',$request->section_name)->first()->id;

        $productId = $request->id;

        $validatedData = $request->validated();
        
        $validatedData['section_id'] = $sectionId;

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
