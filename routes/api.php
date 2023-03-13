<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\TagController;
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
Route::apiResource('categories', CategoryController::class);
Route::apiResource('tags', TagController::class);
Route::apiResource('books', BookController::class);
Route::apiResource('bookrequests', BookRequestController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('downloads', DownloadController::class);

Route::post('/downloadbook', [BookController::class, 'download']);

Route::post('/bycategory', [BookController::class, 'byCategory']);

Route::post('/bytag', [BookController::class, 'byTag']);