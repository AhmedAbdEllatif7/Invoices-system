<?php

namespace App\Http\Controllers;

use App\Models\Invoice;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth' , 'check.user.status'] );


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(Invoice::count() == 0)
        {
            return view('home2');
        }
        else {
            $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#FF1E1E'],
                    'data' => [number_format(Invoice::where('value_status', 0)->count()/Invoice::count()*100,2)]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#06FF00'],
                    'data' => [number_format(Invoice::where('value_status', 1)->count()/Invoice::count()*100,2)]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#FFED00'],
                    'data' => [number_format(Invoice::where('value_status', 2)->count()/Invoice::count()*100,2)]
                ],
                    ])
                    ->options([]);

            //boll
            $chartjs2 = app()->chartjs
            ->name('barChartTest2')
            ->type('pie')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF1E1E','#06FF00','#FFED00'],
                    'data' => [number_format(Invoice::where('value_status', 0)->count()/Invoice::count()*100,2), number_format(Invoice::where('value_status', 1)->count()/Invoice::count()*100,2) , number_format(Invoice::where('value_status', 2)->count()/Invoice::count()*100,2)]
                ]
            ])
            ->options([]);
                }
                    return view('home',compact('chartjs','chartjs2'));
            }


}
