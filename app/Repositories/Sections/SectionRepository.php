<?php

namespace App\Repositories\Sections;

use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;

class SectionRepository implements SectionRepositoryInterface {
    public function index()
    {
        $sections = Section::all();
        return view('sections.index',compact('sections'));
    }





    public function store($request)
    {
        $validatedData = $request->validated();

        $validatedData['created_by'] = Auth::user()->name;

        Section::create($validatedData);

        return redirect()->route('sections.index')->with('Add', 'Section added successfully.');
    }



    public function update($request)
    {
    
        $id = $request->id;

        $section = Section::findOrFail($id);

        $validatedData = $request->validated();
        
        $section->update($validatedData);

        session()->flash('edit');
        return redirect()->back();
    }


    public function destroy($request)
    {
        $section  = Section::findOrFail($request->id);
        $section->products()->delete();
        $section->delete();
        session()->flash('delete', 'تم الحذف بنجاح');
        return redirect()->back();
    }
}