<?php

use App\Http\Controllers\API\AdminAuthorizationController;
use App\Http\Controllers\PagesController;
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
    return view('welcome');
});

Route::get('/adminPanel', [PagesController::class, "openAdminPage"])->name('openAdminPage');
Route::get('/adminAuthorization', [PagesController::class, "openAdminAuthPage"])->name('openAdminAuthPage');
Route::post('/authorizeToAdminPanel', [AdminAuthorizationController::class, "loginAsAdministrator"])->name('login');
Route::get('/logout', [AdminAuthorizationController::class, "logout"])->name('logout');
