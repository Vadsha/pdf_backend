<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Category;
use App\Models\Download;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function download()
    {
        return $this->hasOne(Download::class);
    }
}
