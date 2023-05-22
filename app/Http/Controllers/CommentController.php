<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends BaseController
{
    public function store(Request $request)
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
    public function index()
    {
        return $this->success(CommentResource::collection(Comment::orderBy('id' , 'desc')->paginate(4)));
    }
    public function show($id)
    {
        try {
            $comments = Comment::where('book_id', $id)->paginate(3);
            return $this->success(CommentResource::collection($comments));
        } catch (Exception $e ) {
            return $this->fail(["message" => $e->getMessage()],404);
        }
    }
    public function destroy($id)
    {
        try {
            $comment = Comment::where('id', $id)->firstOrFail();
        } catch (Exception $e ) {
            return $this->fail(["message" => $e->getMessage()],404);
        }
        $comment->delete();
        return $this->response(["message" => "successfully Deleted"],[],200,true);
    }

    public function commentByBook(Request $request)
    {
        $comment = Comment::all();
        // $comment = Comment::where('book_id' , $request->book_id)->get();
        return $comment;
        return $this->success(CommentResource::collection($comment));
    }
}

