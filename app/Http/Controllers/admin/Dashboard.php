<?php

namespace App\Http\Controllers\admin;

use Analytics;
use Spatie\Analytics\Period;
use App\Http\Controllers\admin\AdminController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends AdminController
{
    public function index()
    {
        //retrieve visitors and pageview data for the current day and the last seven days
        //$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));

        //retrieve visitors and pageviews since the 6 months ago
        //$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::months(6));

        //retrieve sessions and pageviews with yearMonth dimension since 1 year ago
        /*$analyticsData = Analytics::performQuery(
            Period::years(1),
            'ga:sessions',
            [
                'metrics' => 'ga:sessions, ga:pageviews',
                'dimensions' => 'ga:yearMonth'
            ]
        );*/
        $posts = Post::get();
        $published_posts = $posts->filter(function($q){
            if($q->status){
                return true;
            }
        })->count();
        $drafted_posts = $posts->filter(function($q){
            if(!$q->status){
                return true;
            }
        })->count();
        $pending_comments_count = Comment::where('status', 0)->count();
        $pending_comments = Comment::where('status', 0)->take(4)->get();;
        $users = User::get();
        $users_count = $users->count();
        $latest_users = $users->take(5);
        return $this->render("dashboard", [
            'published_posts' => $published_posts, 
            'drafted_posts' => $drafted_posts, 
            'pending_comments_count' => $pending_comments_count, 
            'pending_comments' => $pending_comments, 
            'registered_users' => $users_count,
            'latest_users' => $latest_users,
        ]);
    }
}
