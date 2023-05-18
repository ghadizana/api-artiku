<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthenticationController::class, 'logout']);   
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::patch('/articles/{id}', [ArticleController::class, 'update'])->middleware('article-owner');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->middleware('article-owner');
}); 

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::post('/login', [AuthenticationController::class, 'login']);
