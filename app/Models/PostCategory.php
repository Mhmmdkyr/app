<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function post(){
        return $this->hasOne(Post::class, 'id', 'post_id')->where('language_id', config('app.active_lang.id'))->orderBy('publish_date', 'desc');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'uniq_id');
    }
}
