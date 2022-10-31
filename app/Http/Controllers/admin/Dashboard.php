<?php

namespace App\Http\Controllers\admin;

use Analytics;
use Spatie\Analytics\Period;
use App\Http\Controllers\admin\AdminController;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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
        $published_posts = Post::where('status', 'published')->where('publish_date', '<=', Carbon::now())->where('deleted_at', null)->where('language_id', config('app.active_lang.id'))->count();
        $drafted_posts = Post::where('status', 'drafted')->where('deleted_at', null)->where('language_id', config('app.active_lang.id'))->count();
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

    public function update_detector()
    {
        $system_version = config('app.version');
        $response = Http::get('https://updater.neto.com.tr/incore/updater.php');
        $upto = false;
        if ($response) {
            $response = json_decode($response);
            $version = $response->version;
            if ($version > $system_version) {
                $upto = true;
            }
        }
        return response()->json([
            'update' => $upto,
            'message' => 'Yeni bir güncelleme mevcut. Sisteminizi şimdi <b>' . $version . '</b> sürümüne yükseltebilirsiniz.'
        ]);
    }
    public function updater()
    {
        $upto = false;
        $response = Http::post('https://updater.neto.com.tr/incore/updater.php', [
            'domain' => $_SERVER['SERVER_NAME']
        ]);
        if ($response) {
            $response = json_decode($response);
            if ($response->status == 200) {
                $file = base64_decode($response->file);
                Storage::disk('local')->put('updater/update.zip', $file);
                $zip = new ZipArchive;
                if ($zip->open(storage_path('app/updater') . "/update.zip") === TRUE) {
                    $zip->extractTo(base_path(''));
                    $zip->close();
                    if (file_exists(base_path() . "/updater.sql")) {
                        $sql = file_get_contents(base_path() . "/updater.sql");
                        $sql_query = DB::select(DB::raw($sql));
                        unlink(base_path() . "/updater.sql");
                    }
                    $upto = true;
                    unlink(storage_path('app/updater') . "/update.zip");
                    file_put_contents(storage_path('framework') . "/.version", $response->version);
                }
                return response()->json([
                    'update' => $upto,
                    'message' => '<p>Sisteminiz başarılı bir şekilde <b>' . $response->version . '</b> sürümüne yükseltildi.</p>' . $response->features
                ]);
            } else {
                return response()->json([
                    'update' => false,
                    'message' => 'Güncellemeler alınamadı. Lütfen Neto danışmanınız ile görüşün.'
                ]);
            }
        } else {
            return response()->json([
                'update' => false,
                'message' => 'Güncellemeler alınamadı. Lütfen Neto danışmanınız ile görüşün.'
            ]);
        }
    }
}
