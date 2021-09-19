<?php

use App\Http\Controllers\BankController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('banks')->group(function () {
    Route::get('/', [BankController::class, 'getAllBanks']);
    Route::get('/{id}/loan-history', [BankController::class, 'getBankLoanHistory']);
    Route::post('/create/bank', [BankController::class, 'createBank']);
    Route::post('/update/bank/{id}', [BankController::class, 'updateBank']);
    Route::post('/{id}/create/bank-loan-history', [BankController::class, 'addBankLoanHistory']);
    Route::delete('/delete/bank/{id}', [BankController::class, 'deleteBank']);
});
