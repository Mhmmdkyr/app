<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\PostCategory;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Posts extends Controller
{

    public function detail($slug)
    {
        try {
            $post = Post::where('slug', $slug)->where('language_id', config('app.active_lang.id'))->where('deleted_at', null)->first();
            if (!$post) {
                return $this->render("404");
            }
            $prev_post = Post::where('publish_date', '<', $post->publish_date)->orderBy('publish_date', 'desc')->first();
            $next_post = Post::where('publish_date', '>', $post->publish_date)->orderBy('publish_date', 'asc')->first();
            if (!$post) {
                return view('error.404');
            }
            if ($post->visibility == 'only_members' && !auth()->user()) {
                return redirect()->route('frontend.login', ['redirect_url' => url()->current()]);
            }
            if (session()->has('post_views')) {
                if (!in_array($post->id, session()->get('post_views'))) {
                    $post->hit = $post->hit + 1;
                    $post->save();
                    session()->push('post_views', $post->id);
                }
            } else {
                $post->hit = $post->hit + 1;
                $post->save();
                session()->push('post_views', $post->id);
            }
            $favorites = false;
            if (auth()->user()) {
                $favorites = Favorite::where('user_id', auth()->user()->id)->get()->filter(function ($q) use ($post) {
                    if ($q->post_id == $post->id) {
                        return true;
                    }
                })->count();
            }
            $meta = ['title' => $post->meta->meta_title, 'description' => $post->meta->meta_description, 'keywords' => $post->meta->meta_keywords];
            $releated_posts  = [];
            if ($post->categories && isset($post->categories[0])) {
                $releated_posts = Post::whereRaw("FIND_IN_SET('" . $post->categories[0]->uniq_id . "', categories)")->paginate(3);
            }
            return $this->render("post", ['post' => $post, 'prev' => $prev_post, 'next' => $next_post, 'meta' => $meta, 'releated_posts' => $releated_posts, 'post_favorites' => $favorites]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->render("404");
        }
    }

    public function search(Request $request)
    {
        if (!$request->has('q') || $request->q == '') {
            return $this->render("404");
        }
        $search = $request->q;
        $posts = Post::where('title', 'LIKE', '%' . $search . '%')->where('language_id', config('app.active_lang.id'))->paginate(20);
        $meta = ['title' => __('Search result for ":q"', ['q' => $request->q]), 'description' => __('Search result for :q', ['q' => $request->q])];
        return $this->render("search", ['posts' => $posts, 'meta' => $meta]);
    }
    public function add_comment(Request $request, Post $post)
    {
        try {
            if (!auth()->user()) {
                $valid_area = [
                    'name' => ['required', 'string'],
                    'email' => ['required', 'string', 'email'],
                    'comment' => ['required', 'string'],
                ];
            } else {
                $valid_area = [
                    'comment' => ['required', 'string'],
                ];
            }
            if (config('settings.recaptcha') && isset(config('settings.recaptcha')->secret)) {
                $valid_area['g-recaptcha-response'] = ['required', new ReCaptcha];
            }
            $request->validate($valid_area);
            $arr = [
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'fullname' => $request->has('name') ? strip_tags($request->name) : null,
                'comment' => strip_tags($request->comment),
                'email' => $request->has('email') ? $request->email : null,
                'user_ip' => $request->ip(),
                'status' => 0,
                'content_id' => $post->id
            ];
            Comment::create($arr);
            $output['status'] = 200;
            $output['message'] = __('Your comment has been saved. Your comment will appear here after it has been reviewed and approved by our editors.');
        } catch (\Throwable $th) {
            $output['status'] = 403;
            $output['message'] = __('Something went wrong');
        }
        return response()->json($output);
    }

    public function all_posts()
    {

        $auth = true;
        $posts = Post::where('publish_date', '<=', Carbon::now())->where('status', 'published')->where('language_id', config('app.active_lang.id'));
        if (!$auth) {
            $posts->where('visibility', 'all');
        }
        return $posts;
    }

    public function rssList()
    {
        $category = Category::where('language_id', config('app.default_lang.id'))->get();
        $meta = ['title' => __('RSS Lists'), 'description' => __('RSS Lists')];
        return $this->render("rss-list", ['categories' => $category, 'meta' => $meta]);
    }

    public function rssFeeds($category)
    {
        $category = Category::where('slug', $category)->where('language_id', config('app.active_lang.id'))->first();
        if (!$category) {
            return view('error.404');
        }
        $posts = Post::whereRaw("FIND_IN_SET('" . $category->uniq_id . "', categories)")->paginate(1000);
        $meta = ['title' => $category->meta->meta_title, 'description' => $category->meta->meta_description, 'keywords' => $category->meta->meta_keywords];
        return response()->view("rss-feed", ['category' => $category, 'posts' => $posts, 'meta' => $meta])->header('Content-Type', 'application/xml');
    }
}
