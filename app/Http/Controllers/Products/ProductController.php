<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
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
        $products = Product::get();
        $sections = Section::get();
        return view('products.products',compact('products','sections'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {

         //Validation
            $validated = $request->validate([
                'product_name' => 'required|max:50|unique:products',
                'section_id' => 'required',
            ],
            [
                'product_name.required' => ' عفوا يجب إدخال أسم المنتج',
                'product_name.unique' => ' عفوا هذا المنتج موجود بالفعل',
                'product_name.max' => 'عفوا لقد تخطيت الحد الأقصي من الحروف',
                'section_id.required' => ' عفوا يجب اختيار اسم القسم',
            ]

            );

            Product::create([
                'product_name' => $request->product_name,
                'description' => $request->description,
                'section_id' => $request->section_id,
            ]);
        session()->flash('add_product');
        return redirect()->back();
    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request)
    {
        $id = Section::where('section_name',$request->section_name)->first()->id;
        $id2 = $request->id;
        $validated = $request->validate([
            'product_name' => 'required|max:50|unique:products,product_name,'.$id2,
        ],
        [
            'product_name.required' => ' عفوا يجب إدخال أسم المنتج',
            'product_name.unique' => ' عفوا هذا المنتج موجود بالفعل',
            'product_name.max' => 'عفوا لقد تخطيت الحد الأقصي من الحروف',
        ]

        );
        $product = Product::findorFail($request->id);

        $product = $product->update([
            'product_name' => $request->product_name,
            'description'  => $request->description,
            'section_id'   => $id,
        ]);
        session()->flash('edit');
        return back();

    }


    public function destroy(Request $request)
    {

        $id = $request->id;

        $product = Product::find($id);
        $product = $product->destroy($id);
        session()->flash('delete');
        return redirect()->back();
    }
}
