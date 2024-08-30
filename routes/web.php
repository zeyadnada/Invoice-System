<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customer_ReportController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionsController::class);
Route::resource('product', ProductsController::class);
Route::get('section/{id}', [InvoicesController::class, 'getproducts']);
Route::get('InvoicesDetails/{id}', [InvoicesDetailsController::class, 'edit']);
Route::get('View_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'open_file']);
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'get_file']);
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy'])->name('delete_file');
Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);
Route::get('edit_invoice/{id}', [InvoicesController::class, 'edit']);
Route::get('Status_show/{id}', [InvoicesController::class, 'show'])->name('Status_show');
Route::post('Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');
Route::get('/Invoice_Paid', [InvoicesController::class, 'Invoice_Paid']);
Route::get('/Invoice_UnPaid', [InvoicesController::class, 'Invoice_UnPaid']);
Route::get('/Invoice_Partial', [InvoicesController::class, 'Invoice_Partial']);
Route::resource('Archive', InvoiceArchiveController::class);
Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice']);
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
Route::get('invoices_report',[Invoices_Report::class,'index']);
Route::post('Search_invoices',[Invoices_Report::class,'search_invoices']);
Route::get('customers_report', [Customer_ReportController::class, 'index']);
Route::post('Search_customers', [Customer_ReportController::class, 'search_customers']);

Route::get('markAsReadAll',[InvoicesController::class, 'markAsReadAll'])->name('markAsReadAll');
Route::get('/{page}', [AdminController::class, 'index']);
