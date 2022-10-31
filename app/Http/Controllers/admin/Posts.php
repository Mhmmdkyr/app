<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post as ModelsPost;
use App\Models\PostCategory;
use App\Models\ContentMeta;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class Posts extends AdminController
{
    public function index(Request $request)
    {
        $posts = ModelsPost::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $posts = $posts->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->has('lang')) {
            $lang = $request->lang;
        } else {
            $lang = config('app.active_lang')->id;
        }
        $posts = $posts->where('language_id',  $lang);
        $publish_count = ModelsPost::where('publish_date', '<=', Carbon::now())->where('status', 'published')->count();
        $drafted_count = ModelsPost::where('status', 'drafted')->count();
        $trashed_count = ModelsPost::whereNotNull('deleted_at')->count();
        if ($request->has('status') && $request->status != "all" && $request->status != "trashed") {
            $posts = $posts->withoutTrashed()->where('status', $request->status)->paginate(50);
        } elseif ($request->status == 'trashed') {
            $posts = $posts->onlyTrashed()->paginate(50);
        } else {
            $posts = $posts->withoutTrashed()->paginate(50);
        }
        $posts = PostResource::collection($posts);
        return $this->render("posts.list", ["posts" => $posts, "lang" => $lang, "all_count" => ($publish_count + $drafted_count + $trashed_count), "publish_count" => $publish_count, "drafted_count" => $drafted_count, "trashed_count" => $trashed_count, "status" => $request->has('status') ? $request->status : 'all']);
    }

    public function selectType()
    {
        return $this->render("posts.types");
    }

    public function create(Request $request, $post_id = false)
    {
        if (!$post_id && (!$request->has('lang') || !$request->has('type'))) {
            return redirect()->route('admin.posts.types');
        }
        $categories = $this->category_tree(NULL, "json");
        $selected_categories = "";
        $form_title = __('Add New');
        $post = false;
        $type = $request->has('type') ? $request->type : 'article';
        if (old('categories')) {
            $selected_categories = json_encode(old('categories'));
        }
        if ($post_id) {
            $post = ModelsPost::where("id", $post_id)->firstOrFail();
            $type = $post->type;
        }
        session()->flash('status', __('Your changes have been saved'));
        return $this->render("posts.form", ["categories" => $categories, "selected_categories" => $selected_categories, "post" => $post, "form_title" => $form_title, "imager" => true, 'type' => $type]);
    }
    public function save(Request $request, $post_id = false)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $validated = $request->validate(
            [
                'title' => 'required|max:255',
                'content' => 'required',
                'publish_date' => 'required',
                'categories' => 'required',
                'language_id' => 'required'
            ],
            [
                'title.required' => __('"Title" is required. Please check and try again.'),
                'content.required' => __('"Content" is required. Please check and try again.'),
                'publish_date.required' => __('"Publish Date" is required. Please check and try again.'),
                'categories.required' => __('"Categories" is required. Please check and try again.'),
                'language_id.required' => __('"Language" is required. Please check and try again.'),
            ]
        );
        try {
            $images = [];

            if ($request->has('featured_image')) {
                $images['featured_image'] = $request->featured_image;
            }

            if ($request->has('slider_image')) {
                $images['slider_image'] = $request->slider_image;
            }
            $meta_fields = [
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords
            ];
            $content = $request->content;
            if (is_array($request->content)) {
                $contents = $request->content;
                if ($request->type == 'list') {
                    $contents = [];
                    $contents["content"] = $request->content["content"];
                    for ($i = 0; $i < count($request->content["items"]["title"]); $i++) {
                        $cont["title"] = $request->content["items"]["title"][$i];
                        $cont["content"] = $request->content["items"]["content"][$i];
                        $cont["image"] = $request->content["items"]["image"][$i];
                        $contents["items"][] = $cont;
                    }
                }
                $content = json_encode($contents);
            }
            if ($request->has('slug') && $request->slug) {
                $slug = slugify($request->slug);
            } else {
                $slug = slugify($request->title);
            }
            $already_slug = ModelsPost::where('slug', $slug)->where('language_id', $request->language_id);
            if ($post_id) {
                $already_slug = $already_slug->where('id', '!=', $post_id);
            }
            if ($already_slug->count()) {
                $slug = $slug . "-" . ($already_slug->count() + 1);
            }
            $fields = [
                'title' => $request->title,
                'description' =>  $request->spotlight,
                'content' =>  $content,
                'features' =>  json_encode($request->features),
                'images' =>  json_encode($images),
                'tags' =>  $request->meta_keywords,
                'categories' => implode(',', $request->categories),
                'publish_date' =>  $request->publish_date,
                'language_id' => $request->language_id,
                'slug' => $slug,
                'visibility' => $request->visibility,
                'status' => $request->status,
                'user_id' => auth()->user()->id,
                'type' => $request->type,
                'meta' => json_encode($meta_fields)
            ];
            if ($post_id) {
                ModelsPost::where('id', $post_id)->update($fields);
            } else {
                $post = ModelsPost::create($fields);
                $post_id = $post->id;
            }
            PostCategory::where('post_id', $post_id)->delete();
            foreach ($request->categories as $category) {
                PostCategory::create([
                    'post_id' => $post_id,
                    'category_id' => $category
                ]);
            }
            session()->flash('status', __('Your changes have been saved'));
            return redirect()->route('admin.posts.index');
        } catch (Exception $e) {
            $request->session()->flash('error', __('A problem occurred while saving.'));
            return redirect()->route('admin.posts.index');
        }
    }

    public function getVideoInformation(Request $request)
    {
        $request->validate([
            'url' => 'required'
        ]);
        $url = $request->url;
        $output = false;
        if (getYoutubeID($url)) {
            $output['id'] = getYoutubeID($url);
            $output['thumb'] = getYoutubeThumb($url);
            $output['embed'] = getYoutubeEmbed($url);
            $output['source'] = 'youtube';
        } elseif (getVimeoID($url)) {
            $output['id'] = getVimeoID($url);
            $output['thumb'] = getVimeoThumb($url);
            $output['embed'] = getVimeoEmbed($url);
            $output['source'] = 'vimeo';
        }
        return response()->json($output);
    }
    public function trash(Request $request)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $request->validate([
            'id' => 'required'
        ]);
        if (is_array($request->id)) {
            foreach ($request->id as $post_id) {
                ModelsPost::where('id', $post_id)->delete();
            }
        } else {
            ModelsPost::where('id', $request->id)->delete();
        }
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }

    public function revert(Request $request)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $request->validate([
            'post_id' => 'required'
        ]);
        ModelsPost::where('id', $request->post_id)->restore();
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'reverted']);
    }

    public function delete(Request $request)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $request->validate([
            'post_id' => 'required'
        ]);
        ModelsPost::where('id', $request->post_id)->forceDelete();
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'deleted']);
    }
}
