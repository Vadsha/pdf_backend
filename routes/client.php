<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\HomeController;


Route::get('/get-books' , [HomeController::class , 'getBooks']);
Route::get('/get-categories' , [HomeController::class , 'getCategories']);
Route::get('/get-books-by-download' , [HomeController::class , 'BooksByDownload']);
Route::get('/get-books-by-categories/{categories}' , [HomeController::class , 'booksByCategories']);
