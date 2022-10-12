<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $appends = ['meta'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getMetaAttribute($value)
    {
        $metas = json_decode($value);
        return $metas;
    }

    public function getCategoriesAttribute($value)
    {
        return Category::whereIn('uniq_id', explode(',', $value))->where('language_id', config('app.active_lang.id'))->get();
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'content_id', 'id')->where('status', 1);
    }
    public function getImagesAttribute($value)
    {
        $images = json_decode($value);
        if(!$images->featured_image){
          $images->featured_image = 'placeholders/lg.jpg';
        }
        return $images;
    }

    public function getContentAttribute($value)
    {
        if (is_json($value)) {
            return json_decode($value);
        } else {
            return $value;
        }
    }

    public function getFeaturesAttribute($value)
    {
        return json_decode($value);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format("d/m/Y H:i");
    }

    public function getReactionsAttribute($value)
    {
        if ($value) {
            return json_decode($value);
        }
    }
}
