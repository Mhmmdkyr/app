<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $appends = ['meta'];


    public function getMetaAttribute($value)
    {
        $metas = json_decode($value);
        return $metas;
    }

    public function getShownAttribute($value)
    {
        $metas = json_decode($value);
        return $metas;
    }
}
