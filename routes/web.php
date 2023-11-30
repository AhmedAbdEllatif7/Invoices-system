<?php

use App\Http\Controllers\Invoices\Reports\InvoiceReportController;
use App\Http\Controllers\Invoices\Archives\ArchiveInvoiceController;
use App\Http\Controllers\Invoices\Attachments\InvoicesAttachmentsController;
use App\Http\Controllers\Invoices\InvoicesController;
use App\Http\Controllers\Invoices\Details\InvoicesDetailsController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Sections\SectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


############################################ Begin Invoices ###############################################

Route::resource('invoices', InvoicesController::class);

Route::controller(InvoicesController::class)->group(function(){
    Route::get('show-print/{id}', 'showPrint')->name('show.print.invoice'); 
    Route::post('invoice-update-status/{id}', 'updateStatus')->name('update.status.invoice'); 
    Route::get('sections/{id}', 'getproducts'); //Get Product
    Route::get('paid-invoices',  'viewPaidInvoices'); 
    Route::get('unpaid-invoices', 'viewUnPaidInvoices');  
    Route::get('partial-paid-invoices',  'viewPartialPaid');   

});
############################################ End Invoices ##################################################




############################################ Begin Details Invoice ##########################################

Route::resource('details' , InvoicesDetailsController::class);

############################################ End Details Invoice ############################################





############################################ Begin Attachments Invoice ######################################

Route::controller(InvoicesAttachmentsController::class)->group(function(){
Route::post("attachments/store", 'store')->name('attachments.store');
Route::delete("attachments/destroy" , 'destroy')->name('attachments.destroy');
Route::get("attachments/view/{invoice_number}/{file_name}" , 'openFile')->name('attachments.view');
Route::get("attachments/download/{invoice_number}/{file_name}" , 'downloadFile')->name('attachments.download');
});

############################################ End Attachments Invoice #########################################







############################################ Begin Archive Invoice ###########################################

Route::get('archives' , [ArchiveInvoiceController::class , 'index'])->name('archives.index');
Route::post('archive-invoice' , [ArchiveInvoiceController::class , 'archive'])->name('archive.invoice');
Route::post('restore' , [ArchiveInvoiceController::class , 'restoreInvoice'])->name('restore');
Route::post('delete-from-archive' , [ArchiveInvoiceController::class , 'deleteFromArchive']);

############################################ End Archive Invoice ##############################################





############################################ Begin Report Invoice #############################################

Route::controller(InvoiceReportController::class)->group(function(){
    Route::get('reports', 'index'); 
    Route::get('clients-reports', 'searchClients'); 
    Route::get('clients', 'indexClients'); 
    Route::post('search-clients-reports',  'searchClientReports'); 
    Route::post('search-reports',  'searchReports')->name('search.reports'); 

});

############################################ End Report Invoice ###############################################
















//Invoice Reports

//Sections
Route::resource('sections', SectionController::class);

//Products
Route::resource('products', ProductController::class);






