<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('returnRedirectIfNotAuth');
    }

    public function index()
    {
        $sections = Section::get();
        return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_name' => 'required|unique:sections|max:50',
        ],
        [
            'section_name.required' => ' عفوا يجب إدخال أسم ألقسم',
            'section_name.unique' => ' عفوا هذا القسم موجود بالفعل',
            'section_name.max' => 'عفوا لقد تخطيت الحد الأقصي من الحروف',
        ]

    );

            Section::create(
                [
                    'section_name' => $request->section_name,
                    'created_by'   => Auth::user()->name,
                    'description'  => $request->description,
                ]
                );
                session()->flash('Add');
                return redirect('/sections');

            // return $request;

    }


    public function show(Section $section)
    {
        //
    }


    public function edit(Section $section)
    {
        //
    }

    public function update(Request $request)
    {
        //Validation
        $id = $request->id;
        $validated = $request->validate([
            'section_name' => 'required|max:50|unique:sections,section_name,'.$id,
        ],
        [
            'section_name.required' => ' عفوا يجب إدخال أسم ألقسم',
            'section_name.unique' => ' عفوا هذا القسم موجود بالفعل',
            'section_name.max' => 'عفوا لقد تخطيت الحد الأقصي من الحروف',
        ]

        );

        //Update
        $section = Section::find($id);
        $section->update([
            'section_name'  => $request->section_name,
            'description'   => $request->description,
        ]);
        session()->flash('edit');
        return redirect()->back();



    }


    public function destroy(Request $request)
    {
        $section  = Section::find($request->id);
        $section->products()->delete();
        $section->delete();
        session()->flash('delete', 'تم الحذف بنجاح');
        return redirect()->back();
    }
}
