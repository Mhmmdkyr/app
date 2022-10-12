<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Category;

class Categories extends AdminController
{
    public function index(Request $request)
    {
        $categories = Category::where('parent', NULL);
        $lang = 0;
        if ($request->has('lang') && $request->lang) {
            $lang = $request->lang;
            $categories->where('language_id', $request->lang);
        }
        $categories = $categories->get();
        return $this->render("categories.list", ["categories" => $categories, "columns" => ["Category Title"], "lang" => $lang]);
    }

    public function edit(Request $request, $uniq)
    {
        $category = Category::where('id', $uniq)->first();
        if ($category) {
            $categories = Category::where('parent', NULL)->where('language_id', $category->language_id)->get();
            $lang = $category->language_id;
            if ($request->has('lang')) {
                $lang = $request->lang;
                $categories = Category::where('parent', NULL)->where('language_id', $lang)->get();
            }
        } else {
            session()->flash('error', __('Category not found'));
            return redirect()->route('admin.categories.index')->withErrors(__('categories.created'));
        }
        return $this->render("categories.list", ["categories" => $categories, "category" => $category, "lang" => $lang]);
    }

    public function store(Request $request, $uniq_id = false)
    {

        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'category_title' => 'required',
                'language_id' => 'required|integer'
            ],
            [
                'category_title.required' => __('"Category Title" is required. Please check and try again.'),
                'language_id.required' => __('"Language" is required. Please check and try again.'),
            ]
        );
        try {
            if ($request->has('slug') && $request->slug) {
                $slug = slugify($request->slug);
            } else {
                $slug = slugify($request->category_title);
            }
            $already_slug = Category::where('slug', $slug)->where('language_id', $request->language_id);
            if ($uniq_id) {
                $already_slug = $already_slug->where('id', '!=', $uniq_id);
            } else {
                $uniq_id = uniq_id('c.');
            }
            if ($already_slug->count()) {
                $slug = $slug . "-" . ($already_slug->count() + 1);
            }

            $field['category_title'] = $request->category_title;
            $field['parent'] = $request->parent;
            $field['color'] = ltrim($request->color, '#');
            $field['category_description'] = $request->category_description;
            $field['uniq_id'] = $uniq_id;
            $field['language_id'] = $request->language_id;
            $field['shown'] = json_encode($request->shown);
            $field['slug'] = $slug;
            $meta_data = [
                "meta_title" => $request->meta_title ? $request->meta_title : $request->category_title,
                "meta_description" => $request->meta_description ? $request->meta_description : $request->category_description,
                "meta_keywords" =>  $request->meta_keywords ? $request->meta_keywords : $request->category_title,
            ];
            $field['meta'] = json_encode($meta_data);
            $categories = Category::updateOrInsert(['uniq_id' => $uniq_id, 'language_id' => $request->language_id], $field);
            $request->session()->flash('status', __('Your changes have been saved'));
            return redirect()->route('admin.categories.index')->withSuccess(__('categories.created'));
        } catch (\Throwable $th) {
            $request->session()->flash('error', __('A problem occurred while saving.'));
            return redirect()->route('admin.categories.index')->withErrors(__('categories.created'));
        }
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
            Category::whereIn('id', $request->id)->delete();
        } else {
            Category::where('id', $request->id)->delete();
        }
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }
}
