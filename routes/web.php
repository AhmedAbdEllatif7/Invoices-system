<?php

use App\Http\Controllers\Invoices\InvoiceReportController;
use App\Http\Controllers\Invoices\InvoicesArchiefController;
use App\Http\Controllers\Invoices\InvoicesAttachmentsController;
use App\Http\Controllers\Invoices\InvoicesController;
use App\Http\Controllers\Invoices\InvoicesDetailsController;
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
})->middleware('guest')->name('login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(InvoicesController::class)->group(function(){
    Route::post('restore_invoice',  'restoreInvoice')->name('restore.invoice');  //Restore Invoice
    Route::get('show_print/{id}', 'showPrint')->name('show.print.invoice'); //Print Invoice
    Route::post('invoice_update_status/{id}', 'updateStatus')->name('update.status.invoice'); //Update Invoice Status
    Route::get('sections/{id}', 'getproducts'); //Get Product
    Route::get('payed_invoices',  'showPayedInvoices'); //Show Payed Invoices
    Route::get('unpayed_invoices', 'showUnPayedInvoices');  //Show Unpayed Invoices
    Route::get('partial_payed_invoices',  'showPartialPayedInvoices');   //Show Partial Payed Invoices

});

#########################################################################################################################################

Route::controller(InvoicesArchiefController::class)->group(function(){
    Route::post('invoice_archiev',  'destroy')->name('archiev.invoice'); //Archiev Invoice
    Route::post('invoice_delete_from_archiev',  'deleteFromArchiev')->name('delete.archiev.invoice'); //Deleting From Archiev
    Route::resource('invoice_archievs', InvoicesArchiefController::class);//Show Archeif Invoices
});

#########################################################################################################################################

Route::controller(InvoiceReportController::class)->group(function(){
    Route::get('clients_reports', 'searchClients'); //Show Clients Reports Page
    Route::get('clients_reports', 'showClients'); //Show Clients Reports Page
    Route::post('search_clients_reports',  'searchClients'); //Searching For Clients
    Route::post('search_invoice_reports',  'search'); //Searching For Invoice

});


#########################################################################################################################################

Route::controller(InvoicesDetailsController::class)->group(function(){
    Route::get("view_file/{invoice_number}/{file_name}",  'openFile'); //View The Attachments
    Route::get("download_file/{invoice_number}/{file_name}", 'downloadFile'); //Download The Attachments
    Route::post("delete_file", 'destroy')->name('delete.file'); //Delete The Attachments
    Route::get('invoice/details/{id}',  'showDetails')->name('show.details');

});



//Invoices
Route::resource('invoices', InvoicesController::class);

//Invoice Reports
Route::resource('invoice_reports', InvoiceReportController::class);

//Sections
Route::resource('sections', SectionController::class);

//Products
Route::resource('products', ProductController::class);

//Save The Attachment
Route::post("invoices_attachment",[InvoicesAttachmentsController::class, 'store'])->name('store.attachment');


// Route::get('/{page}', [AdminController::class , 'index']);


