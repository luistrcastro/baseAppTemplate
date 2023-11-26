<?php

use App\Http\Controllers\AccountAPIController;
use App\Http\Controllers\CategoryAPIController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonthBudgetAPIController;
use App\Http\Controllers\TransactionAPIController;
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

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->get('user', [LoginController::class, 'me'])->name('me');

Route::apiResource('categories', CategoryAPIController::class);
Route::post('categories/restore/{categoryId}', [CategoryAPIController::class, 'restore']);
Route::get('base_categories', [CategoryAPIController::class, 'baseCategories']);

Route::apiResource('month_budgets', MonthBudgetAPIController::class);
Route::get('base_month_budgets', [MonthBudgetAPIController::class, 'baseMonthBudgets']);

Route::apiResource('transactions', TransactionAPIController::class);
Route::post('transactions/per_period', [TransactionAPIController::class, 'perPeriod']);
Route::post('transactions/bulk', [TransactionAPIController::class, 'bulk']);

Route::apiResource('accounts', AccountAPIController::class);

Route::get('test', function () {
  return 'test successful';
});
