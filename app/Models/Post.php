<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'date', 'image', 'description', 'text', 'posted', 'type', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->morphedByMany(Tag::class, 'taggables');
    }

    public function getImageURL()
    {
        return URL::asset('images/posts/' . $this->image);
    }
}
