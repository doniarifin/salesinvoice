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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('salesorder', App\Http\Controllers\SalesOrderController::class);
Route::resource('saleslines', App\Http\Controllers\SalesLineController::class);
Route::get('api/saleslines', [App\Http\Controllers\SalesLineController::class, 'api']);

Route::get('export-chart', [App\Http\Controllers\SalesLineController::class, 'chart']);

Route::post('printout', [App\Http\Controllers\PrintOutController::class, 'printOut']);

Route::get('export', [App\Http\Controllers\SalesLineController::class, 'export']);
