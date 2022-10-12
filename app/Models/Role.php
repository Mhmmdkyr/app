<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    public $guarded = [];

    public function users(){
        $this->belongsToMany(Roles::class);
    }

    public function getAccessAttribute($value){
        if($value){
            return json_decode($value, true);
        }
    }
}
