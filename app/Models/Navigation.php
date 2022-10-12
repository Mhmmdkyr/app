<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    public $guarded = [];
    protected $appends = array('subs');

    public function getSubsAttribute()
    {
        return NavigationItem::where("parent", $this->uniq_id)->where('language_id', 1)->get();
    }
}
