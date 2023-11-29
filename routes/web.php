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

############################################ Begin Invoices #################################################

Route::resource('invoices', InvoicesController::class);
Route::controller(InvoicesController::class)->group(function(){
    Route::get('show_print/{id}', 'showPrint')->name('show.print.invoice'); //Print Invoice
    Route::post('invoice_update_status/{id}', 'updateStatus')->name('update.status.invoice'); //Update Invoice Status
    Route::get('sections/{id}', 'getproducts'); //Get Product
    Route::get('invoices/paid',  'viewPaidInvoices'); //Show paid Invoices
    Route::get('invoices/unpaid', 'viewUnPaidInvoices');  //Show Unpaid Invoices
    Route::get('invoices/partial-paid',  'viewPartialPaid');   //Show Partial paid Invoices

});
############################################ End Invoices ####################################################




############################################ Begin Archive Invoice ###########################################

Route::get('archives' , [ArchiveInvoiceController::class , 'index']);
Route::post('archive-invoice' , [ArchiveInvoiceController::class , 'archive'])->name('archive.invoice');
Route::post('restore' , [ArchiveInvoiceController::class , 'restoreInvoice'])->name('restore');
Route::post('delete-from-archive' , [ArchiveInvoiceController::class , 'deleteFromArchive']);
############################################ End Archive Invoice #############################################





############################################ Begin Report Invoice #############################################

Route::controller(InvoiceReportController::class)->group(function(){
    Route::get('clients_reports', 'searchClients'); //Show Clients Reports Page
    Route::get('clients_reports', 'showClients'); //Show Clients Reports Page
    Route::post('search_clients_reports',  'searchClients'); //Searching For Clients
    Route::post('search_invoice_reports',  'search'); //Searching For Invoice

});
############################################ End Report Invoice ################################################





############################################ Begin Details Invoice #############################################

Route::controller(InvoicesDetailsController::class)->group(function(){
    Route::get("view_file/{invoice_number}/{file_name}",  'openFile'); //View The Attachments
    Route::get("download_file/{invoice_number}/{file_name}", 'downloadFile'); //Download The Attachments
    Route::post("delete_file", 'destroy')->name('delete.file'); //Delete The Attachments
    Route::get('invoice/details/{id}',  'showDetails')->name('show.details');

});
############################################ End Details Invoice #############################################





//Invoice Reports
Route::resource('invoice_reports', InvoiceReportController::class);

//Sections
Route::resource('sections', SectionController::class);

//Products
Route::resource('products', ProductController::class);

//Save The Attachment
Route::post("invoices_attachment",[InvoicesAttachmentsController::class, 'store'])->name('store.attachment');


// Route::get('/{page}', [AdminController::class , 'index']);


