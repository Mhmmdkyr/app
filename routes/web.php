<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\Dashboard;
use App\Http\Controllers\admin\Imager;

use App\Http\Controllers\admin\Login;
use App\Http\Controllers\Categories;
use App\Http\Controllers\Contact;
use App\Http\Controllers\DynamicProcess;
use App\Http\Controllers\Index;
use App\Http\Controllers\Pages;
use App\Http\Controllers\Posts;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Sitemap;
use App\Models\Language;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::localized(function () {
    Route::get('/', [Index::class, 'index'])->name('frontend.index.show');
    Route::get('/post/{slug}', [Posts::class, 'detail'])->name('frontend.posts.detail');
    Route::get('/search', [Posts::class, 'search'])->name('frontend.posts.search');
    Route::get('/trends', [Posts::class, 'all_trends'])->name('frontend.posts.trends');
    Route::get('/category/{slug}', [Categories::class, 'detail'])->name('frontend.categories.detail');
    Route::get('/page/{slug}', [Pages::class, 'detail'])->name('frontend.categories.detail');
    Route::get('/all', [Categories::class, 'filteredPosts'])->name('frontend.filter.all');
    Route::get('/all/{type}', [Categories::class, 'filteredPosts'])->name('frontend.filter.type');
    Route::get('/login', [Index::class, 'login'])->name('frontend.login');
    Route::post('/login', [Index::class, 'authenticate'])->name('frontend.login.authenticate');
    Route::post('/register', [Index::class, 'register'])->name('frontend.login.register');
    Route::get('/confirm-account/{token}', [Index::class, 'confirm'])->name('frontend.login.confirm');
    Route::post('/get-token', [Index::class, 'getRememberToken'])->name('frontend.login.reset');
    Route::get('/reset-password/{token}', [Index::class, 'resetPasswordForm'])->name('frontend.login.reset_form');
    Route::post('/reset-password', [Index::class, 'resetPassword'])->name('frontend.login.reset_password');
    Route::get('/logout', [Index::class, 'logout'])->name('frontend.login.logout');
    Route::get('/rss-feeds', [Posts::class, 'rssList'])->name('frontend.rss.feeds');
    Route::get('/rss/{category}', [Posts::class, 'rssFeeds'])->name('frontend.rss.detail');
    Route::get('/contact-us', [Contact::class, 'index'])->name('frontend.contact.index');
    Route::post('/send-message', [Contact::class, 'sendMessage'])->name('frontend.contact.send');

});
Route::post('/add-comment/{post}', [Posts::class, 'add_comment'])->name('frontend.posts.add_comment');
Route::post('/add-newsletter', [Index::class, 'addNewsletter'])->name('frontend.newsletter');

Route::group(['prefix' => 'user', 'middleware' => ['user:sanctum']], function () {
    Route::get('/profile', [UserController::class, 'profileForm'])->name('frontend.user.profile');
    Route::post('/profile', [UserController::class, 'profileStore'])->name('frontend.user.profile_store');
    Route::get('/favorites', [UserController::class, 'favorites'])->name('frontend.user.favorites');
    Route::get('/add-favorite/{post_id}', [UserController::class, 'addFavorites'])->name('frontend.user.add_favorite');
    Route::get('/remove-favorite/{post_id}', [UserController::class, 'removeFavorite'])->name('frontend.user.remove_fav');
    Route::get('/comments', [UserController::class, 'comments'])->name('frontend.user.comments');
    Route::get('/remove_comment/{comment_id}', [UserController::class, 'removeComment'])->name('frontend.user.remove_comment');
    Route::get('/posts/list', [UserController::class, 'addPost'])->name('frontend.user.post_list');
    Route::get('/posts/add', [UserController::class, 'addPost'])->name('frontend.user.post_add');
});
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', [Login::class, 'index'])->name('login');
    Route::post('/login', [Login::class, 'authenticate'])->name('admin.login.login');
});

Route::fallback(function ($val) {
    $short = Post::where('short_link', $val)->first();
    if($short){
        return redirect(uri('post', $short->slug));
    } else {
        return view('errors.404');
    }
});
Route::post('/dynamic/reaction', [DynamicProcess::class, 'reaction'])->name('dynamic.reaction');
Route::get('/dynamic/category-post/{category_id}', [DynamicProcess::class, 'getCategoryPosts'])->name('dynamic.category_posts');
Route::get('/switch-mode', [DynamicProcess::class, 'darkMode'])->name('dynamic.dark_mode');
Route::get('/accept-cookie', [DynamicProcess::class, 'acceptCookie'])->name('dynamic.cookie_alert');
Route::get('/close-newsletter', [DynamicProcess::class, 'closeNewsletter'])->name('dynamic.close_newsletter');
Route::get('/sitemap.xml', [Sitemap::class, 'index'])->name('frontend.sitemap');
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum']], function () {

    Route::get('/permission-denied', [AdminController::class, 'permissionDenied'])->name('admin.errors.permission');

    // Imager Route
    Route::get('/imager', [Imager::class, 'show'])->name('admin.imager');
    Route::post('/imager/files', [Imager::class, 'files'])->name('admin.imager.files');
    Route::post('/imager/upload', [Imager::class, 'upload'])->name('admin.imager.upload');

    // Dashboard Route
    Route::get('/dashboard', [Dashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/update-check', [Dashboard::class, 'update_detector'])->name('admin.dashboard.update_detect');
    Route::post('/dashboard/updater', [Dashboard::class, 'updater'])->name('admin.dashboard.updater');

});
$modules_routes = glob(base_path() . "/routes/modules/admin/*.php");
foreach ($modules_routes as $route) {
    if(file_exists($route)){
        require_once $route;
    }
}
