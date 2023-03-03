<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(),403);
        }
        $tag = new Tag();
        $tag->name = $request->name;
        $slug = Str::of($request->name)->slug('-');
        $tag->slug = $slug;
        $tag->save();
        return $this->success(new TagResource($tag));
    }
    public function index()
    {
        return $this->success(TagResource::collection(Tag::all()));
    }
    public function show($slug)
    {
        try {
            Tag::where('slug', $slug)->firstOrFail();
        } catch (Exception $e ) {
            return $this->fail(["message" => $e->getMessage()], 404);
        }
        $tag = new TagResource(Tag::where('slug', $slug)->first());
        return $this->success($tag);
    }
    public function update(Request $request,$slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(), 403);
        }
        $tag = Tag::where('slug',$slug)->first();

        if($tag){
            $tag->slug = Str::of($request->name)->slug('-');
            $tag->update($request->all());
            return $this->success(new TagResource($tag));
        }else{
           return $this->fail(['message'=> "Not found"],404);
        }
    }
    public function destroy($slug)
    {
        try {
          $tag = Tag::where('slug' , $slug)->firstOrFail();
        } catch (Exception $e) {
            return $this->fail(["message"=> $e->getMessage()], 404);
        }
        $tag->delete();
        return $this->response(["message" => "successfully deleted"],[],200,true);
    }
}
