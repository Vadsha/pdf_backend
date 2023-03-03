<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookRequestResource;
use App\Models\BookRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookRequestController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bookrequest' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(),403);
        }
        $bookrequest = new BookRequest();
        $bookrequest->bookrequest = $request->bookrequest;
        $bookrequest->user_id = rand(1, 5);
        $bookrequest->save();
        return $this->success( new BookRequestResource($bookrequest));
    }
    public function index()
    {
        return $this->success(BookRequestResource::collection(BookRequest::all()));
    }
    public function show($id)
    {
        try {
            BookRequest::where('id',$id)->firstOrFail();
        } catch (Exception $e) {
            return $this->fail(["message" => $e->getMessage()],404);
        }
       $bookrequest = new BookRequestResource(BookRequest::where('id',$id)->first());
        return $this->success($bookrequest);
    }
    public function destroy($id)
    {
        try {
            $bookrequest  = BookRequest::where('id',$id)->firstOrFail();
        } catch (Exception $e) {
            return $this->fail(["message" => $e->getMessage()],404);
        }
        $bookrequest->delete();
        return $this->response(["message" => "Successfully Deleted"],[],200,true);
    }
}
