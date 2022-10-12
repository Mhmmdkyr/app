<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public $guarded = [];

    public function getValueAttribute($value){
        if(is_json($value)){
            return json_decode($value);
        } else {
            return $value;
        }
    }
}
