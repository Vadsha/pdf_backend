<?php

namespace App\Http\Controllers\client;

use App\Models\Tag;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

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

    public function getBook($book)
    {
        $data = Book::where('slug' , $book)->with('comments')->first();
        if ($data) {
            $data->load('comments');
            $comments = CommentResource::collection($data->comments);
            $data->comments = $comments;
        }
        return $this->success(new BookResource($data));
    }

    public function getTags ()
    {
        return $this->success(TagResource::collection(Tag::all()));
    }
    public function storeComment(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'comment' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
       $comment = new Comment();
       $comment->comment = $request->comment;
       $comment->user_id = $request->user_id;
       $comment->book_id = $request->book_id;
       $comment->save();
       return $this->success(new CommentResource($comment));
    }

}
