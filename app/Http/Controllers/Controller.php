<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;


class Controller extends BaseController
{
    public $user = false;
    public $socials = false;
    public $active_theme = 'octomag';
    public $meta = [];
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $active_theme = Theme::where('active', 1)->first();
        if ($active_theme) {
            $this->active_theme = $active_theme;
        }
        
    }
    public function render($view, $view_data = [])
    {
        $this->meta['title'] = config('settings.title');
        $this->meta['description'] = config('settings.description');
        $this->meta['keywords'] = config('settings.keywords');
        $categories = Category::where('language_id', config('app.active_lang.id'))->get();
        $parent_categories = $categories->filter(function ($q) {
            if (!$q->parent) {
                return true;
            }
        });
        $menu = $categories->filter(function ($q) {
            if (isset($q->shown) && $q->shown->menu) {
                return true;
            }
        });
        $footer = $categories->filter(function ($q) {
            if (isset($q->shown) && $q->shown->footer) {
                return true;
            }
        });
        $pages = Page::where('language_id', config('app.active_lang.id'))->get();
        $top_pages = $pages->filter(function ($q) {
            if (isset($q->shown) && $q->shown->menu) {
                return true;
            }
        });
        $footer_pages = $pages->filter(function ($q) {
            if (isset($q->shown) && $q->shown->footer) {
                return true;
            }
        });
        $all_posts = new Posts();
        $breakings = $all_posts->all_posts();
        $breakings = $breakings->where('features', 'LIKE','breaking')->limit(10)->orderBy('publish_date', 'desc')->get();

        $popular_posts = $all_posts->all_posts();
        $popular_posts = $popular_posts->limit(5)->orderBy('hit', 'DESC')->get();

        $random_posts = $all_posts->all_posts();
        $random_posts = $random_posts->limit(5)->inRandomOrder()->get();

        if (isset($view_data['meta']) && is_array($view_data['meta'])) {
            $view_data['meta']['title'] = $view_data['meta']['title'] . " - " . config('settings.short_title');
            $this->meta = array_merge($this->meta, $view_data['meta']);
        }
        return view('themes.' . $this->active_theme->path . '.layouts.app', $view_data)
            ->with('view', 'themes.' . $this->active_theme->path . '.' . $view)
            ->with('categoriesForColours', $categories)
            ->with('parent_categories', $parent_categories)
            ->with('menu', $menu)
            ->with('footer', $footer)
            ->with('top_pages', $top_pages)
            ->with('footer_pages', $footer_pages)
            ->with('breakings', $breakings)
            ->with('popular_posts', $popular_posts)
            ->with('random_posts', $random_posts)
            ->with('meta', $this->meta)
            ->with('settings', config('settings'))
            ->with('languages', config('app.languages'))
            ->with('theme', $this->active_theme);
    }
}
