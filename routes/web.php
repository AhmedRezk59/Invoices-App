<?php

use App\User;
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
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/invoices', 'InvoiceController');

Route::resource('/sections', 'SectionController');

Route::resource('/products', 'ProductController');

Route::resource('/products', 'ProductController');

Route::resource('/invoiceattachments', 'InvoicesAttachmentsController');

Route::get('/section/{id}', 'InvoiceController@getProducts');

Route::get('/invoicedetails/{id}', 'InvoicesDetailsController@edit');



Route::get('StatusShow/{id}', 'InvoiceController@show')->name('StatusShow');

Route::post('/Status_Update/{id}', 'InvoiceController@Status_Update')->name('Status_Update');

Route::get('/deleteinvoice/{id}', 'InvoiceController@destroy');

Route::get('/editinvoice/{id}', 'InvoiceController@edit');

Route::post('delete_file', 'InvoicesDetailsController@destroy')->name('delete_file');

Route::get('download/{invoice_id}/{file_name}', 'InvoicesDetailsController@download_file');

Route::get('/paidinvoices', 'InvoiceController@show_paid_invoices');

Route::get('/unpaidinvoices', 'InvoiceController@show_unpaid_invoices');

Route::get('/partiallypaidinvoices', 'InvoiceController@show_partially_paid_invoices');

Route::get('/ArchivedInvoices', 'InvoiceController@show_archived_invoices');

Route::delete('/Archive', 'InvoiceController@archive')->name('Archive');

Route::get('/restoreArchivedInvoices/{id}', 'InvoiceController@restore_archived')->name('restore');

Route::get('/printInvoice/{id}', 'InvoiceController@print_invoice');

Route::get('/export_invoice', "InvoiceController@export");

Route::group(['middleware' => ['auth']], function () {

    Route::resource('roles', 'RoleController');

    Route::resource('users', 'UserController');
});

Route::get('/invoices_report', 'InvoicesReport@index');

Route::post('/Search_invoices', 'InvoicesReport@search');


Route::get('/customers_report', 'CustomersReport@index');

Route::post('/search_customers', 'CustomersReport@search');

Route::get('/readAll', 'NotificationController@markReadAll');

Route::get('/read/{id}', 'NotificationController@markRead');

Route::get('/{page}', 'AdminController@index');
