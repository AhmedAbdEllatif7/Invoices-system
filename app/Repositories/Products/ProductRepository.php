<?php

namespace App\Repositories\Products;

use App\Interfaces\Products\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Section;

class ProductRepository implements ProductRepositoryInterface {

    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('products.index',compact('products','sections'));
    }





    public function store($request)
    {
        $validatedData = $request->validated();

        Product::create($validatedData);

        session()->flash('add_product');
        return redirect()->back();

    }





    public function update($request)
    {

        $productId = $request->id;

        $validatedData = $request->validated();
        
        $product = Product::findorFail($productId);

        $product->update($validatedData);

        session()->flash('edit');
        return back();

    }




    public function destroy($request)
    {
        $id = $request->id;

        $product = Product::findOrFail($id);
        $product = $product->destroy($id);
        session()->flash('delete');
        return redirect()->back();
    }

}