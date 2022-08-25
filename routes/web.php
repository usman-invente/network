<?php

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

Route::get('/', 'IndexController@index');
Route::post('/submit', 'IndexController@submit')->name('submit');
Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('export', [App\Http\Controllers\IndexController::class, 'export'])->name('export');
Route::get('exportHistory', [App\Http\Controllers\IndexController::class, 'historExport'])->name('historyexport');
Auth::routes();

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin_dashboard');
    // optouts route
    Route::get('optouts', [App\Http\Controllers\AdminController::class, 'optouts'])->name('admin_optouts');
    Route::get('history', [App\Http\Controllers\AdminController::class, 'history'])->name('admin_history');
    Route::post('get-optouts', [App\Http\Controllers\AdminController::class, 'getoptouts'])->name('admin_getoptouts');
    Route::post('delete-optouts', [App\Http\Controllers\AdminController::class, 'delete_optouts'])->name('admin_delete_optouts');
    Route::post('get-history', [App\Http\Controllers\AdminController::class, 'gethistory'])->name('admin_gethistory');

    Route::get('get-optout', [App\Http\Controllers\AdminController::class, 'getOptout'])->name('getOptout');
    Route::post('updateoptout', [App\Http\Controllers\AdminController::class, 'updateOptout'])->name('admin_update_optouts');
    Route::get('getuser', [App\Http\Controllers\AdminController::class, 'getUser'])->name('admin_get_user');
    Route::get('cases', [App\Http\Controllers\AdminController::class, 'cases'])->name('admin_cases');
    
    Route::post('admin/case', [App\Http\Controllers\AdminController::class, 'getCases'])->name('admin_case');
    Route::post('send/email', [App\Http\Controllers\AdminController::class, 'adminsendemail'])->name('admin_sendemail');
    Route::post('deletecase', [App\Http\Controllers\AdminController::class, 'deletecase'])->name('deletecase');
    Route::get('case/edit/{id}', [App\Http\Controllers\AdminController::class, 'caseedit'])->name('case.edit');
    Route::post('assigntouser', [App\Http\Controllers\AdminController::class, 'assigntouser'])->name('assigntouser');
    
    Route::post('updateCase', [App\Http\Controllers\AdminController::class, 'updateCase'])->name('updateCase');
    Route::get('add/case', [App\Http\Controllers\AdminController::class, 'addCase'])->name('add-case');
    Route::post('saveCase', [App\Http\Controllers\AdminController::class, 'saveCase'])->name('saveCase');
    Route::post('assignhimself', [App\Http\Controllers\AdminController::class, 'assignhimself'])->name('assignhimself');
    Route::post('updatecomment', [App\Http\Controllers\AdminController::class, 'updatecomment'])->name('updatecomment');
    Route::get('my/case', [App\Http\Controllers\AdminController::class, 'MyCase'])->name('my_case');
    Route::post('myallcases', [App\Http\Controllers\AdminController::class, 'MyAllCases'])->name('myallcases');
    Route::get('case/{id}', [App\Http\Controllers\AdminController::class, 'CaseDetail'])->name('case.show');
    Route::post('markseen', [App\Http\Controllers\AdminController::class, 'markseen'])->name('markseen');
    
    Route::post('updateUser', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('admin_update_user');
    Route::post('admin_delete_history', [App\Http\Controllers\AdminController::class, 'DeleteHistory'])->name('admin_delete_history');
    Route::post('chnage-password', [App\Http\Controllers\HomeController::class, 'chnage_password'])->name('chnage_password');
    Route::post('chnage-profile', [App\Http\Controllers\HomeController::class, 'chnage_profile'])->name('chnage_profile');
    Route::get('account', [App\Http\Controllers\HomeController::class, 'account'])->name('account');
    // user route
    Route::get('users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin_users');
    Route::post('get-users', [App\Http\Controllers\AdminController::class, 'getusers'])->name('admin_getusers');
    Route::post('delete-users', [App\Http\Controllers\AdminController::class, 'delete_users'])->name('admin_delete_users');
    Route::post('users/status', [App\Http\Controllers\AdminController::class, 'user_status'])->name('user_status');
});
