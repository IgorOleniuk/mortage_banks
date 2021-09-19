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
    return view('banks');
})->name('banks');

Route::get('/mortgage-calculator', function () {
    return view('mortgage-calc');
})->name('calculator');

Route::get('/{id}/loan-history', function (int $id) {
    return view('bank-history', compact('id'));
})->name('bank-history');
