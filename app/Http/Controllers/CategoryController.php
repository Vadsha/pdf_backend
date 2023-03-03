<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(),403);
        }
        $category = new Category();
        $category->name = $request->name;
        $slug = Str::of($request->name)->slug('-');
        $category->slug = $slug;
        $category->save();
        return $this->success(new CategoryResource($category));
    }
    public function index()
    {
        return $this->success(CategoryResource::collection(Category::all()));
    }
    public function show($slug)
    {
        try {
            Category::where('slug', $slug)->firstOrFail();
        } catch (Exception $e ) {
            return $this->fail(["message" => $e->getMessage()], 404);
        }
        $category = new CategoryResource(Category::where('slug', $slug)->first());
        return $this->success($category);
    }
    public function update(Request $request,$slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors(), 403);
        }
        $category = Category::where('slug',$slug)->first();

        if($category){
            $category->slug = Str::of($request->name)->slug('-');
            $category->update($request->all());
            return $this->success(new CategoryResource($category));
        }else{
           return $this->fail(['message'=> "Not found"],404);
        }
    }
    public function destroy($slug)
    {
        try {
          $category = Category::where('slug' , $slug)->firstOrFail();
        } catch (Exception $e) {
            return $this->fail(["message"=> $e->getMessage()], 404);
        }
        $category->delete();
        return $this->response(["message" => "successfully deleted"],[],200,true);
    }
}
