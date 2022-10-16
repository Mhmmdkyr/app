<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $table = 'categories';
    public $guarded = [];
    protected $appends = array('meta', 'home_block');

    public function subs()
    {
        return $this->hasMany(Category::class, 'parent', 'uniq_id')->where('language_id', $this->language_id);
    }
    public function getShownAttribute($value)
    {
        $metas = json_decode($value);
        return $metas;
    }
    public function getHomeBlockAttribute($value){
        if($this->shown && $this->shown->home_enable == '1'){
            return (object) ['type' => $this->shown->home_type];
        }
    }
    public function getMetaAttribute($value)
    {
        $metas = json_decode($value);
        return $metas;
    }
}
