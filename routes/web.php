<?php

use App\Models\Tag;
use App\Models\Book;
use App\Models\User;
use App\Models\BookTag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
    // $name = "abc,def,ghi,jkl";
    // if (str_contains($name , "abc") != false) {
    //     return 'found';
    // }
    // else{
    //     return "not found";
    // }
    // return Category::where(str_contains());
    // $search = "Crime";
    // return Book::where("tags" , "LIKE" , "%".$search."%")->get();
});
// Route::get('/book_tags', function () {
//     $booktags =Tag::where('id',1)->first()->booktags;
//     return $booktags;
//     return BookTag::create([
//         'book_id' => 3,
//         'tag_id' => 1,
//     ]);
// });

// Route::get('/users', function () {
//     return User::create([
//         'name' => 'Zwe Zar Ni',
//         'email' => 'zwe@gmail.com',
//         'password' => Hash::make('internet'),
//     ]);
// });
