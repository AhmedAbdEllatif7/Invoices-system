<?php

use App\Http\Controllers\Invoices\Reports\InvoiceReportController;
use App\Http\Controllers\Invoices\Archives\ArchiveInvoiceController;
use App\Http\Controllers\Invoices\Attachments\InvoicesAttachmentsController;
use App\Http\Controllers\Invoices\InvoicesController;
use App\Http\Controllers\Invoices\Details\InvoicesDetailsController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\Users\UserController;
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
    Route::get('users/export/',  'export');
    Route::delete('delete-selected-invoices',  'deleteSelectedInvoices')->name('delete.selected.invoices');
    Route::post('change-status-selected',  'changeGroupStatus')->name('change.group.status');

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
Route::delete('archive-selected-invoices',  [ArchiveInvoiceController::class , 'archiveSelectedInvoices'])->name('archive.selected.invoices');
Route::delete('restore-selected-invoices',  [ArchiveInvoiceController::class , 'restoreSelectedInvoices'])->name('restore.selected.invoices');
Route::post('restore' , [ArchiveInvoiceController::class , 'restoreInvoice'])->name('restore');
Route::post('delete-from-archive' , [ArchiveInvoiceController::class , 'deleteFromArchive']);
Route::delete('force-delete-selected-invoices',  [ArchiveInvoiceController::class , 'forceDeleteSelectedInvoices'])->name('forceDelete.selected.invoices');


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









############################################ Begin Notifications #############################################

Route::controller(NotificationController::class)->group(function(){
    Route::get('/read-all-notification', 'readAllNotification')->name('read.all.notification');
    Route::get('/view-notification-invoice',  'viewNotificationInvoice')->name('view.notification.invoice');
    Route::get('/view-read-notification-invoice', 'viewReadNotificationInvoice')->name('view.read.notification.invoice');
    Route::delete('/delete-slected-notifications',  'deleteSelectedNotifications')->name('delete.selected.notifications');

});

############################################ End Notifications #############################################







############################################ Begin Section #############################################

Route::resource('sections', SectionController::class);

############################################ End Section #############################################







############################################ Begin Products #############################################

Route::resource('products', ProductController::class);

############################################ End Products #############################################








############################################ Begin Roles #############################################

Route::resource('roles', RoleController::class);

############################################ End Roles #############################################






############################################ Begin Users #############################################

    Route::resource('users', UserController::class);

############################################ End Users #############################################






