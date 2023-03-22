<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\DownloadResource;

class DownloadController extends BaseController
{
    public function index()
    {
        return $this->success(DownloadResource::collection(Download::all()));
    }
    public function show($book_id)
    {
        $download = Download::where('book_id',  $book_id)->first();
        return response()->json($download);
    }
    public function update(Request $request, $book_id)
    {
        $download = Download::where('book_id', $book_id)->first();
        $download->downloads = $download->downloads + 1;
        $download->update();
        return response()->json($download);
    }
}