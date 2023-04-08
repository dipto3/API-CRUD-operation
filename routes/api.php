<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/products', [HomeController::class, 'store']);
Route::get('/products', [HomeController::class, 'index']);
Route::get('products/{id}', [HomeController::class, 'show']);
Route::put('products/{id}', [HomeController::class, 'update']);
Route::delete('products/{id}', [HomeController::class, 'destroy']);
