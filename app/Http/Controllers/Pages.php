<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PostCategory;

class Pages extends Controller
{

    public function detail($slug){
        $page = Page::where('slug', $slug)->where('language_id', config('app.active_lang.id'))->first();
        if(!$page){
            return $this->render("404");
        }
        if($page->visibility == 'only_members' && !auth()->user()){
            return redirect()->route('frontend.login', ['redirect_url' => url()->current()]);
        }
        $meta = ['title' => $page->meta->meta_title, 'description' => $page->meta->meta_description, 'keywords' => $page->meta->meta_keywords];
        return $this->render("page", ['page' => $page, 'meta' => $meta]);
    }

 

   
}
