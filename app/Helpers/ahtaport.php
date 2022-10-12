<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Cocur\Slugify\Slugify;


function admin_url()
{
    return url('/') . "/admin/";
}

function image_url($image, $wh = false)
{

    if (substr($image, 0, 4) == 'http') {
        return $image;
    }
    $folder = false;
    $thumbnail_path = 'thumbnails';
    if (count(explode('/', $image)) > 1) {
        $folder = explode('/', $image)[0];
        $thumbnail_path = $folder . "/thumbnails";
    }
    $filename = pathinfo($image, PATHINFO_FILENAME);
    $extension = pathinfo($image, PATHINFO_EXTENSION);
    if ($wh) {
        $filename = '/uploads/' . $thumbnail_path . '/' . $filename . '-' . $wh . "." . $extension;
    } else {
        $filename = '/uploads/' . $image;
    }
    return url('/') . $filename;
}

function set_querystring($name = "", $value = "", $url = false)
{
    if ($url == false) {
        $url = url()->current();
    }
    if (!isset($_GET[$name]) && $value != '') {
        $add[] = $name . "=" . $value;
    }
    foreach ($_GET as $key => $val) {
        if ($name == $key) {
            $val = $value;
        }
        $add[] = $key . "=" . $val;
    }
    if (isset($add)) {
        return $url . "?" . implode("&", $add);
    }
}

function make_querystring($name = "", $value = "", $url = false)
{
    if ($url == false) {
        $url = url()->current();
    }
    if (!isset($_GET[$name]) && $value != '') {
        $add[] = $name . "=" . $value;
    }
    foreach ($_GET as $key => $val) {
        if ($name == $key) {
            $val = $value;
            if ($val == "") {
                continue;
            }
        }
        $add[] = $key . "=" . $val;
    }
    if (isset($add)) {
        return $url . "?" . implode("&", $add);
    } else {
        return $url;
    }
}
function getRow($value, $type = 'input:text')
{
    switch ($type) {
        case 'image':
            return '<img src="' . image_url($value) . '" alt="image" width="70" style="border-radius: 4px; border: 1px solid #dedede; box-shadow:  0 0 10px rgba(0,0,0,0.1)" />';
            break;
        case 'input:text:datetime':
            return Carbon::parse($value)->format('d.m.Y H:i');
            break;
        default:
            return $value;
            break;
    }
}

function avatar_letter($name)
{
    $name = explode(' ', $name);
    $fl = [];
    for ($i = 0; $i < count($name); $i++) {
        if ($i < 2) {
            $fl[] = mb_substr($name[$i], 0, 1, "UTF-8");
        }
    }
    if (count($fl) > 0) {
        return implode('', $fl);
    }
}

function is_json($string)
{

    try {
        json_decode($string);
        if (json_last_error() === JSON_ERROR_NONE) {
            return true;
        }
    } catch (\Throwable $th) {
        return false;
    }
}

function getAccessList()
{
    return [
        'users', 'posts', 'categories', 'roles', 'newsletter', 'comments', 'pages', 'themes', 'navigations', 'ad_spaces', 'settings'
    ];
}

function theme_sreenshot($path)
{
    $path = resource_path('views/themes/' . $path . '/screenshot.png');
    $c = file_get_contents($path, true);
    $c = base64_encode($c);
    return $c;
}

function uniq_id($prefix = 'i$')
{
    return uniqid($prefix);
}

function uri($section, $slug = "", $withLang = true)
{
    $url = url('/') . "/" . $section . "/" . $slug;
    if (app()->getLocale() != config('app.default_lang')->slug) {
        $url = url('/' . config('app.locale')) . "/" . $section . "/" . $slug;
    }
    $url = rtrim($url, '/');
    return $url;
}
/*
function short_link($id)
{
    $domain = url('/');
    if (config('settings.shortener')) {
        $domain = config('settings.shortener_domain');
    }
    return $domain . "/" . $id;
}*/
function getYoutubeID($url)
{
    $reg = '/(?im)\b(?:https?:\/\/)?(?:w{3}\.)?youtu(?:be)?\.(?:com|be)\/(?:(?:\??v=?i?=?\/?)|watch\?vi?=|watch\?.*?&v=|embed\/|)([A-Z0-9_-]{11})\S*(?=\s|$)/';

    preg_match($reg, $url, $matches);
    return !$matches == Null ? $matches[1] : "";
}
function getYoutubeThumb($url)
{
    return "https://img.youtube.com/vi/" . getYoutubeID($url) . "/maxresdefault.jpg";
}

function getYoutubeEmbed($url)
{
    return 'https://www.youtube.com/embed/' . getYoutubeID($url);
}
function getVimeoID($url)
{
    $regex = '~
		# Match Vimeo link and embed code
		(?:<iframe [^>]*src=")?              # If iframe match up to first quote of src
		(?:                                  # Group vimeo url
				https?:\/\/                  # Either http or https
				(?:[\w]+\.)*                 # Optional subdomains
				vimeo\.com                   # Match vimeo.com
				(?:[\/\w:]*(?:\/videos)?)?   # Optional video sub directory this handles groups links also
				\/                           # Slash before Id
				([0-9]+)                     # $1: VIDEO_ID is numeric
				[^\s]*                       # Not a space
		)                                    # End group
		"?                                   # Match end quote if part of src
		(?:[^>]*></iframe>)?                 # Match the end of the iframe
		(?:<p>.*</p>)?                       # Match any title information stuff
		~ix';

    preg_match($regex, $url, $matches);

    return isset($matches[1]) ? $matches[1] : false;
}
function getVimeoThumb($url)
{
    $id = getVimeoID($url);
    if (!$id) {
        return false;
    }
    $data = file_get_contents("http://vimeo.com/api/v2/video/" . $id . ".json");
    $data = json_decode($data);
    Log::alert($data);
    if ($data && isset($data[0]) && isset($data[0]->thumbnail_large)) {
        return str_replace('_640', '_1000', $data[0]->thumbnail_large);
    }
}
function getVimeoEmbed($url)
{
    return 'https://player.vimeo.com/video/' . getVimeoID($url);
}

function slugify($str, $sep = "-")
{
    $slugify = new Slugify();
    return $slugify->slugify($str, ['separator' => $sep]);
}

function is_html($string)
{
    // Check if string contains any html tags.
    return preg_match('/<\s?[^\>]*\/?\s?>/i', $string);
}
function generateRandomString($length = 25)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function share_link($post)
{
    if (config('settings.shortener')) {
        $url = uri($post->short_link);
        if(config('settings.select_domain') && config('settings.shortener_domain')){
            $url = config('settings.shortener_domain')."/".$post->short_link;
        }
    } else {
        $url = uri('posts', $post->slug);
    }
    return $url;
}
