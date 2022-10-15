<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $data = [];
    public $languages = [];
    public $left_menu = [];
    public $default_lang = [];
    public function __construct()
    {
        $this->languages = Language::get();
        foreach($this->languages as $lang){
            if($lang->default){
                $this->default_lang = $lang->id;
            }
        }
        // Dashboard
        $this->left_menu[] = [
            'icon'       => 'tachometer-alt',
            'label'      => __('Dashboard'),
            'href'       => 'admin.dashboard',
            'group'      => 'global'
        ];

        // News Managament
        $this->left_menu[] = [
            'header'     => __('Contents'),
            'icon'       => 'paperclip',
            'label'      => __('Posts'),
            'href'       => 'admin.posts.index',
            'group'      => 'posts',
            'sub'        => [
                [
                    'label'      => __('All Posts'),
                    'href'       => 'admin.posts.index',
                ],
                [
                    'label'      => __('Add Post'),
                    'href'       => 'admin.posts.types',
                ],
                [
                    'label'      => __('Categories'),
                    'href'       => 'admin.categories.index',
                ],
            ]
        ];

        // Comments
        $this->left_menu[] = [
            'icon'       => 'comments',
            'label'      => __('Comments'),
            'href'       => 'admin.comments.index',
            'group'      => 'comments',
            'sub'        => [
                [
                    'label'      => __('All Comments'),
                    'href'       => 'admin.comments.index',
                ],
                [
                    'label'      => __('Pending Comments'),
                    'href'       => 'admin.comments.index',
                    'params'     => ['filter' => 'pending']
                ]
            ]
        ];

        // Users
        $this->left_menu[] = [
            'icon'       => 'users',
            'label'      => __('Users'),
            'href'       => 'admin.users.index',
            'group'      => 'users',
            'sub'        => [
                [
                    'label'      => __('All Users'),
                    'href'       => 'admin.users.index',
                ],
                [
                    'label'      => __('Add User'),
                    'href'       => 'admin.users.create',
                ],
                [
                    'label'      => __('Roles'),
                    'href'       => 'admin.roles.index',
                ]
            ]
        ];

        // Users
        // $this->left_menu[] = [
        //     'icon'       => 'bookmark',
        //     'label'      => 'Columnists',
        //     'href'       => 'columnists',
        //     'sub'        => [
        //         [
        //             'label'      => 'All Columnists',
        //             'href'       => 'columnists',
        //         ],
        //         [
        //             'label'      => 'Articles',
        //             'href'       => 'articles',
        //         ]
        //     ]
        // ];

        // Static Pages
         $this->left_menu[] = [
            'icon'       => 'file-alt',
            'label'      => __('Pages'),
            'href'       => 'admin.pages.index',
            'group'      => 'pages',
            'sub'        => [
                [
                    'label'      => __('All Pages'),
                    'href'       => 'admin.pages.index',
                ],
                [
                    'label'      => __('Add Page'),
                    'href'       => 'admin.pages.create',
                ]
            ]
        ];

        // Contact Messages
        $this->left_menu[] = [
            'icon'       => 'envelope',
            'label'      => __('Messages'),
            'href'       => 'admin.messages.index',
            'group'      => 'messages'
        ];


        // Static Pages
        $this->left_menu[] = [
            'icon'       => 'inbox',
            'label'      => __('Newsletter'),
            'href'       => 'admin.newsletters.index',
            'group'      => 'newsletters'
        ];

        // Static Pages
        $this->left_menu[] = [
            'header'     => __('Configurations'),
            'icon'       => 'palette',
            'label'      => __('Apperance'),
            'href'       => false,
            'group'      => 'settings',
            'sub'        => [
                [
                    'label'      => __('Themes'),
                    'href'       => 'admin.themes.index',
                ],
                [
                    'label'      => __('Ad Spaces'),
                    'href'       => 'admin.settings.adspaces',
                ]
                // [
                //     'label'      => __('apperance.navigations'),
                //     'href'       => 'admin.navigations.index',
                // ]
            ]
        ];
        $this->left_menu[] = [
            'icon'       => 'cogs',
            'label'      => __('Settings'),
            'href'       => false,
            'group'      => 'settings',
            'sub'        => [
                [
                    'label'      => __('General Settings'),
                    'href'       => 'admin.settings.index',
                ],
                [
                    'label'      => __('Localizations'),
                    'href'       => 'admin.settings.localizations',
                ],
                [
                    'label'      => __('Backup Database'),
                    'href'       => 'admin.settings.dbbackups',
                ]
            ]
        ];


    }
    public function datas()
    {
        if ($this->data) {
            return $this->data;
        }
    }
    public function render($view, $view_data=[])
    {
        if(!auth()->user()->role->panel_login){
            return redirect()->route('frontend.index.show');
        }
        
        $menus = [];
        foreach($this->left_menu as $left){
            foreach(auth()->user()->role->access as $k => $access){
                if($k == $left["group"] || $k == "all"){
                    $menus[] = $left;
                }
            }
        }
        $logged_user = auth()->user();
        $logged_user->ip = request()->ip();
        return view('admin.layouts.app', $view_data)
            ->with('view', 'admin.'.$view)
            ->with('left_menu', $menus)
            ->with('languages', $this->languages)
            ->with('default_lang', $this->default_lang);
    }
    public function category_tree($parent = 0, $output = false){
        $category_list = [];
        foreach($this->languages as $lang){
            $categories = Category::where('parent', $parent)->where('language_id', $lang->id)->get();
            $category_list[$lang->id] = [];
            if($categories){
                foreach($categories as $category){
                    $step = 0;
                    $category_list[$lang->id][] = ['category_title' => $category->category_title, 'language_id' => $category->language_id, 'uniq_id' => $category->uniq_id, 'subs' => $category->subs, 'id' => $category->uniq_id];
                }
            }
        }


        if($output == 'json'){
            return json_encode($category_list);
        }

       return $category_list;
    }
    public function permissionDenied(){
        return $this->render('errors.permission');
    }
}
