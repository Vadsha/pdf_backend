<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\HomeController;


Route::get('/get-books' , [HomeController::class , 'getBooks']);
Route::get('/get-all-books' , [HomeController::class , 'getAllBooks']);
Route::get('/get-book/{book}' , [HomeController::class , 'getBook']);
Route::get('/get-categories' , [HomeController::class , 'getCategories']);
Route::get('/get-tags' , [HomeController::class , 'getTags']);
Route::get('/get-books-by-download' , [HomeController::class , 'BooksByDownload']);
Route::get('/get-books-by-categories/{categories}' , [HomeController::class , 'booksByCategory']);
Route::get('/get-books-by-tags/{tag}' , [HomeController::class , 'booksByTag']);
Route::post('/comment' , [HomeController::class , 'storeComment']);
