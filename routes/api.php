<?php

use App\Http\Controllers\API\AdminAuthorizationController;
use App\Http\Controllers\API\AuditoriumsController;
use App\Http\Controllers\API\CoursesController;
use App\Http\Controllers\API\DisciplinesController;
use App\Http\Controllers\API\FloorsController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\MetaInfoController;
use App\Http\Controllers\API\PairInfosController;
use App\Http\Controllers\API\PairsController;
use App\Http\Controllers\API\ScienceRanksController;
use App\Http\Controllers\API\SecondaryObjectsController;
use App\Http\Controllers\API\SecondaryObjectTypesController;
use App\Http\Controllers\API\TeachersController;
use App\Http\Controllers\API\TeachersDisciplinesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('teachers', TeachersController::class);
Route::resource('floors', FloorsController::class);
Route::resource('auditoriums', AuditoriumsController::class);
Route::resource('disciplines', DisciplinesController::class);
Route::resource('secondary-objects', SecondaryObjectsController::class);
Route::resource('pair-infos', PairInfosController::class);
Route::resource('science-ranks', ScienceRanksController::class);
Route::resource('pairs', PairsController::class);
Route::resource('teachers-disciplines', TeachersDisciplinesController::class);
Route::resource('secondary-object-types', SecondaryObjectTypesController::class);
Route::resource('groups', GroupsController::class);
Route::resource('courses', CoursesController::class);

Route::post('/createAdmin', [AdminAuthorizationController::class, "createAdmin"])->name('register');

Route::get('/pairs-repeatings', [MetaInfoController::class, "loadAllPairsRepeatings"]);
Route::get('/days-of-week', [MetaInfoController::class, "loadAllDaysOfWeek"]);
