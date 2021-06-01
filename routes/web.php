<?php

namespace App\Http\Controllers;

use ArielMejiaDev\LarapexCharts\LarapexChart;
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

Route::get('/btc_chart', [MainController::class, 'showBtcGraph']);

Route::get('/btc_data', [MainController::class, 'getBtcData']);

Route::get('/test', [MainController::class, 'getSimpleLinearRegressionArray']);
