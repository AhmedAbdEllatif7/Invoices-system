<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{

    public function __construct(){
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:الاقسام',    ['only' => ['index']]);
        $this->middleware('permission:حذف قسم',   ['only' => ['destroy']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);
    }

    public function index()
    {
        $sections = Section::all();
        return view('sections.index',compact('sections'));
    }





    public function store(SectionRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['created_by'] = Auth::user()->name;

        Section::create($validatedData);

        return redirect()->route('sections.index')->with('Add', 'Section added successfully.');
    }



    public function update(SectionRequest $request)
    {
    
        $id = $request->id;

        $section = Section::findOrFail($id);

        $validatedData = $request->validated();
        
        $section->update($validatedData);

        session()->flash('edit');
        return redirect()->back();
    }


    public function destroy(Request $request)
    {
        $section  = Section::findOrFail($request->id);
        $section->products()->delete();
        $section->delete();
        session()->flash('delete', 'تم الحذف بنجاح');
        return redirect()->back();
    }
}
