<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\BaseController;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Http\Resources\CategoryResource;
use GrahamCampbell\ResultType\Success;

class HomeController extends BaseController
{
    public function getBooks()
    {
        return $this->success(BookResource::collection(Book::latest()->paginate(6)));
    }

    public function getCategories()
    {
        $categories = CategoryResource::collection(Category::with('books')->get());
        return $this->success($categories);
    }

    public function booksByDownload(){
        $books = BookResource::collection(Book::all());
        return $this->success($books);
    }

    public function booksByCategories($category)
    {
        $books = Book::where('category_id' , $category)->get();
        return $this->success(BookResource::collection($books));
    }

    public function getAllBooks()
    {
        return $this->success(BookResource::collection(Book::latest()->paginate(6)));
    }

}
