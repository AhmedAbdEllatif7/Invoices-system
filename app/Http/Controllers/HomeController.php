<?php

namespace App\Http\Controllers;

use App\Models\Invoice;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth' , 'check.user.status'] );
    }


    public function index()
    {
        $chartData = $this->calculateInvoicePercentages();
    
        $labels = ['الفواتير الغير المدفوعة', 'الفواتير المدفوعة', 'الفواتير المدفوعة جزئيا'];
    
        $chartjs = $this->generateBarChart($chartData, $labels);
        $chartjs2 = $this->generatePieChart($chartData, $labels);
    
        return view('home', compact('chartjs', 'chartjs2', 'labels'));
    }
    
    private function calculateInvoicePercentages()
    {
        $invoiceCount = Invoice::count();
        $unpaidCount = Invoice::where('value_status', 0)->count();
        $paidCount = Invoice::where('value_status', 1)->count();
        $partiallyPaidCount = Invoice::where('value_status', 2)->count();
    
        $unpaidPercentage = $invoiceCount > 0 ? number_format($unpaidCount / $invoiceCount * 100, 2) : 0;
        $paidPercentage = $invoiceCount > 0 ? number_format($paidCount / $invoiceCount * 100, 2) : 0;
        $partiallyPaidPercentage = $invoiceCount > 0 ? number_format($partiallyPaidCount / $invoiceCount * 100, 2) : 0;
    
        return [
            'unpaidPercentage' => $unpaidPercentage,
            'paidPercentage' => $paidPercentage,
            'partiallyPaidPercentage' => $partiallyPaidPercentage,
        ];
    }
    
    private function generateBarChart($chartData, $labels)
    {
        if ($labels && is_array($labels) && count($labels) >= 3) {
            return app()->chartjs
                ->name('barChartTest')
                ->type('bar')
                ->size(['width' => 350, 'height' => 200])
                ->labels($labels)
                ->datasets([
                    [
                        "label" => "الفواتير الغير المدفوعة",
                        'backgroundColor' => ['#FF1E1E'],
                        'data' => [$chartData['unpaidPercentage']],
                    ],
                    [
                        "label" => "الفواتير المدفوعة",
                        'backgroundColor' => ['#06FF00'],
                        'data' => [$chartData['paidPercentage']],
                    ],
                    [
                        "label" => "الفواتير المدفوعة جزئيا",
                        'backgroundColor' => ['#FFED00'],
                        'data' => [$chartData['partiallyPaidPercentage']],
                    ],
                ])
                ->options([]);
        } 
    }
    
    private function generatePieChart($chartData, $labels)
    {
        if ($labels && is_array($labels) && count($labels) >= 3) {
            return app()->chartjs
                ->name('barChartTest2')
                ->type('pie')
                ->size(['width' => 350, 'height' => 200])
                ->labels($labels)
                ->datasets([
                    [
                        'backgroundColor' => ['#FF1E1E', '#06FF00', '#FFED00'],
                        'data' => [
                            $chartData['unpaidPercentage'],
                            $chartData['paidPercentage'],
                            $chartData['partiallyPaidPercentage'],
                        ],
                    ],
                ])
                ->options([]);
        }
    }
    


}
