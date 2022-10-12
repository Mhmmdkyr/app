<?php

namespace App\Http\Controllers\admin;

use App\Http\Resources\PostResource;
use App\Models\Page;
use App\Models\ContentMeta;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Pages extends AdminController
{
    public function index(Request $request)
    {
        $pages = Page::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $pages = $pages->where('title', 'like', '%' . $request->search . '%');
        }
        $lang = 0;
        if ($request->has('lang') && $request->lang) {
            $lang = $request->lang;
            $pages = $pages->where('language_id',  $request->lang);
        }

        $pages = $pages->paginate(50);
        $pages = PostResource::collection($pages);
        return $this->render("pages.list", ["pages" => $pages, "lang" => $lang]);
    }
    public function create(Request $request, $page_id = false)
    {
        $form_title = __('Add New');
        $page = false;
        if ($page_id) {
          $form_title = __('Edit Page');
            $page = Page::where("id", $page_id)->first();
            if(!$page){
            return redirect()->route('admin.pages.index');
            }
        }
        session()->flash('status', __('Your changes have been saved'));
        return $this->render("pages.form", ["page" => $page, "form_title" => $form_title, "imager" => true]);
    }
    public function save(Request $request, $page_id = false)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
        try {
            $meta_fields = [
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords
            ];
            if($request->has('slug') && $request->slug){
                $slug = slugify($request->slug);
            } else {
                $slug = slugify($request->title);
            }
            $already_slug = Page::where('slug', $slug)->where('language_id', $request->language_id);
            if($page_id){
                $already_slug = $already_slug->where('id', '!=', $page_id);
            }
            if($already_slug->count()){
                $slug = $slug."-".($already_slug->count() + 1);
            }
            $fields = [
                'title' => $request->title,
                'slug' => $slug,
                'description' =>  $request->spotlight,
                'content' =>  $request->content,
                'visibility' =>  $request->visibility,
                'language_id' => $request->language_id,
                'shown' => json_encode($request->shown),
                'meta' => json_encode($meta_fields)
            ];
            if ($page_id) {
                Page::where('id', $page_id)->update($fields);
            } else {
                $page = Page::create($fields);
                $page_id = $page->id;
            }
            session()->flash('status', __('Your changes have been saved'));
            return redirect()->route('admin.pages.index');
        } catch (Exception $e) {
            Log::alert($e);
            session()->flash('status', __('Your changes could not be saved!'));
            return redirect()->route('admin.pages.index');
        }
    }

    public function trash(Request $request) {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $request->validate([
            'id' => 'required'
        ]);
        if(is_array($request->id)){
            foreach($request->id as $page_id){
                Page::where('id', $page_id)->delete();
            }
        } else {
            Page::where('id', $request->id)->delete();
        }
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }

    public function revert(Request $request) {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $request->validate([
            'page_id' => 'required'
        ]);
        Page::where('id', $request->page_id)->restore();
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'reverted']);
    }

    public function delete(Request $request) {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $request->validate([
            'page_id' => 'required'
        ]);
        Page::where('id', $request->page_id)->forceDelete();
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'deleted']);
    }
}
