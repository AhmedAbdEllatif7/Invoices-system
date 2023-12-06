<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Interfaces\Sections\SectionRepositoryInterface;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    private $sectionRepository;

    public function __construct(SectionRepositoryInterface $sectionRepository) {
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:الاقسام',    ['only' => ['index']]);
        $this->middleware('permission:حذف قسم',   ['only' => ['destroy']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit','update']]);

        $this->sectionRepository = $sectionRepository;
    }


    public function index()
    {
        return $this->sectionRepository->index();
    }


    public function store(SectionRequest $request)
    {
        return $this->sectionRepository->store($request);
    }


    public function update(SectionRequest $request)
    {
        return $this->sectionRepository->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->sectionRepository->destroy($request);
    }
}
