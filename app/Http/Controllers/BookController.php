<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Category;
use App\Models\Download;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class BookController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'author' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'file' =>'required',
            'tags' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(),403);
        }
        // image setup
        $imagename =$request->file('image')->getClientOriginalName();
        $filename = $request->file('file')->getClientOriginalName();

        Storage::putFileAs(
            '/public/photos',
            $request->file('image'),
            $imagename
        );
        Storage::putFileAs(
            '/public/files',
            $request->file('file'),
            $filename
        );
        // image setup end
        $book = new Book();
        $book->category_id =$request->category_id;
        $book->name = $request->name;
        $book->author = $request->author;
        $slug = Str::of($request->name)->slug('-');
        $book->slug = $slug;
        $book->tags = $request->tags;
        $book->description = $request->description;
        $book->image = $imagename;
        $book->file = $filename;
        $book->save();

        if ($book) {
            $download = new Download();
            $download->book_id = $book->id;
            $download->downloads = 0;
            $download->save();
        }
        return $this->success(new BookResource($book));
    }
    public function index()
    {
        return $this->success(BookResource::collection(Book::all()));
    }
    public function show($slug)
    {
        try {
            Book::where('slug', $slug)->firstOrFail();
        } catch (Exception $e ) {
            return $this->fail(["message" => $e->getMessage()], 404);
        }
        $book = new BookResource(Book::where('slug', $slug)->first());
        return $this->success($book);
    }
    public function update(Request $request,$slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'author' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg',
            'file' =>'required|mimes:pdf'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(), 403);
        }
        $book = Book::where('slug',$slug)->first();
        if($book){
            // file and image unlink
            $imagename = Book::where('slug',$slug)->first()->image;
            $imagepath = storage_path('app/public/photos/'.$imagename);
            $filename = Book::where('slug',$slug)->first()->file;
            $filepath = storage_path('app/public/files/'.$filename);
            unlink($imagepath);
            unlink($filepath);
            // file and image unlink end

            $imagename = $request->file('image')->getClientOriginalName();
            $filename = $request->file('file')->getClientOriginalName();

            Storage::putFileAs(
                'public/photos',
                $request->file('image'),
                $imagename
            );
            Storage::putFileAs(
                'public/files',
                $request->file('file'),
                $filename
            );
            $book->slug = Str::of($request->name)->slug('-');
            $book->update($request->all());
            $book->image = $imagename;
            $book->file = $filename;
            return $this->success(new BookResource($book));
        }else{
           return $this->fail(['message'=> "Not found"],404);
        }
    }
    public function destroy($slug)
    {
        try {
            $book = Book::where('slug' , $slug)->firstOrFail();
          } catch (Exception $e) {
              return $this->fail(["message"=> $e->getMessage()], 404);
          }
          $imagename = Book::where('slug',$slug)->first()->image;
          $imagepath = storage_path('app/public/photos/'.$imagename);
          $filename = Book::where('slug',$slug)->first()->file;
          $filepath = storage_path('app/public/files/'.$filename);
          unlink($imagepath);
          unlink($filepath);

          $download = Download::where('book_id' , $book->id)->get();
          $download->delete();
          $book->delete();

          return $this->response(["message" => "Successfully Deleted"],[],200,true);
      }
      public function download(Request $request)
      {
        $path = public_path('storage/files/' . $request->book);
        return response()->download($path);
      }

      public function byCategory(Request $request)
      {
        $books = Book::where('category_id' , $request->id)->get();
        return $this->success(BookResource::collection($books));
      }

      public function byTag(Request $request)
      {
        $books = Book::where("tags" , "LIKE" , "%".$request->tag."%")->get();
        return $this->success(BookResource::collection($books));
      }

    }
