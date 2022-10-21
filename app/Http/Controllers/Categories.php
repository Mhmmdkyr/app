<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostCategory;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Categories extends Controller
{

    public function detail($slug){
        $category = Category::where('slug', $slug)->where('language_id', config('app.default_lang.id'))->first();
        if(!$category){
            return $this->render("404");
        }
        $posts = Post::whereRaw("FIND_IN_SET('".$category->uniq_id."', categories)")->where('publish_date', '<=', Carbon::now())->where('status', 'published')->where('language_id', config('app.active_lang.id'))->orderBy('publish_date', 'desc')->paginate(15);
        $meta = ['title' => $category->meta->meta_title, 'description' => $category->meta->meta_description, 'keywords' => $category->meta->meta_keywords];
        return $this->render("category", ['category' => $category, 'posts' => $posts, 'meta' => $meta]);
    }

    public function filteredPosts(Request $request, $type=false){
        $all_posts = new Posts();
        $posts = $all_posts->all_posts();
        if($type) {
            $posts = $posts->where('type', $type)->orderBy('publish_date', 'desc')->paginate(15);
        } else {
            $posts = $posts->orderBy('publish_date', 'desc')->paginate(15);
        }
        $meta = ['title' => __("Type:".$type)];
        return $this->render("type", ['type' => $type, 'posts' => $posts, 'meta' => $meta]);
    }
 

   
}
