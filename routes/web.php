<?php
use Vijaysoftware\Ginsights\Http\Controllers\ConversionController;
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

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

//Route::post('/cacheconversion', 'ConversionController@index')->name('cc');
Route::post('/ginsights/cacheconversion',[ConversionController::class, 'index'])->name('cc');
Route::post('/ginsights/disconnect',[ConversionController::class, 'disconnect'])->name('disconnect');
