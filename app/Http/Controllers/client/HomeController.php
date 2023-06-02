<?php

namespace App\Http\Controllers\client;

use App\Models\Tag;
use App\Models\Book;
use App\Models\Comment;
use App\Models\Category;
use App\Models\BookRequest;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Resources\BookResource;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BookRequestResource;
use App\Models\Download;

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

    public function booksByCategory($category)
    {
        $books = Book::where('category_id' , $category)->get();
        return $this->success(BookResource::collection($books));
    }

    public function booksByTag($tag)
    {
        $books = Book::where('tags' , 'LIKE' , '%'.$tag.'%')->get();
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

    public function downloadPdf($filename)
    {
        $file = storage_path('app/public/files/' . $filename);
        $book = Book::where('file' , $filename)->first();
        $download = Download::where('book_id' , $book->id)->first();
        $download->downloads++;
        $download->save();
        return response()->download($file);
    }

    public function bookRequest(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bookrequest' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(),403);
        }
        $bookrequest = new BookRequest();
        $bookrequest->bookrequest = $request->bookrequest;
        $bookrequest->user_id = $request->user_id;
        $bookrequest->save();
        return $this->success( new BookRequestResource($bookrequest));
    }

}
