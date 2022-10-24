<?php

namespace App\Http\Controllers\admin;

error_reporting(E_ALL);

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Imager extends AdminController
{
    protected $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    public function show(Request $request)
    {
        return view('admin.common.imager');
    }

    public function files(Request $request)
    {
        $storage_path = public_path("uploads") . "/";
        if ($request->has('dir') && is_dir(public_path("uploads") . "/" . $request->dir)) {
            $storage_path = public_path("uploads") . "/" . $request->dir . "/";
        }
        $files = glob($storage_path . '*.{jpeg,gif,png,jpg}', GLOB_BRACE);
        if ($request->has('filetype')) {
            switch ($request->filetype) {
                case 'images':
                    $files = glob($storage_path . '*.{jpeg,gif,png,jpg}', GLOB_BRACE);
                    break;
                case 'videos':
                    $files = glob($storage_path . '*.{mov,mp4,avi,mpeg}', GLOB_BRACE);
                    break;
                default:
                    $files = glob($storage_path . '*.{jpeg,gif,png,jpg}', GLOB_BRACE);
                    break;
            }
        }
        $all_files = [];
        $start = 0;
        $limit = 60;
        if ($request->has('start')) {
            $start = $request->start;
        }
        $m = 0;
        foreach ($files as $file) {
            if ($m < $start) {
                $m++;
                continue;
            }
            if ($m > ($start + $limit - 1)) {
                $m++;
                continue;
            }
            $file_uri = str_replace($storage_path, "", $file);
            $add_files['uri'] = $file_uri;
            $add_files['full_uri'] = $file;
            $add_files['thumb'] = "thumbnails/" . $file_uri;
            $add_files['created'] = strtotime(date("Y-m-d H:i:s", filemtime($storage_path . $file_uri)));
            $all_files[] = $add_files;
            $m++;
        }
        usort($all_files, function ($a, $b) {
            return $a['created'] - $b['created'];
        });
        $pages = round($m / $limit);
        $collection = ['files' => array_reverse($all_files), 'total' => $m, 'pages' => $pages];
        return response()->json($collection);
    }

    public function upload(Request $request)
    {
        ini_set('memory_limit', '256M');
        if (auth()->user()->id == 0) {
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        try {
            $file_path = public_path('uploads');
            $sizes = config('image.thumbnails');
            if ($request->has('dir') && $request->dir != 'false') {
                $file_path = public_path('uploads/'  . $request->dir);
            }
            if ($request->has('sizes') && $request->dir != 'false') {
                $sizes = explode(",", $request->sizes);
            }
            foreach ($request->file('images') as $file) {
                $file_name = $file->getClientOriginalName();
                $file_name = pathinfo($file_name, PATHINFO_FILENAME);
                $file_name = $file_name . "-" . uniq_id('i');
                $extension = $file->extension();
                $name = $file_name . '.' . $extension;
                if (!in_array($extension, $this->allowed_extensions)) {
                    return response()->json(['message' => 'Not allowed file format', 'status' => 403], 403);
                }
                $file->move($file_path, $name);
                if (count($sizes) == 1) {
                    $wh1 = explode("x", $sizes[0]);
                    $w1 = $wh1[0];
                    $h1 = $wh1[1];
                    if ($w1 == '0') {
                        $path = Image::make($file_path . "/" . $name)->heighten($h1);
                    } elseif ($h1 == '0') {
                        $path = Image::make($file_path . "/" . $name)->widen($w1);
                    } else {
                        $path = Image::make($file_path . "/" . $name)->fit($w1 ? $w1 : NULL, $h1 ? $h1 : NULL);
                    }
                    $path->save($file_path . "/" . $name, 80);
                } else {
                    $path = Image::make($file_path . "/" . $name)->widen(1000);
                    $path->save($file_path . "/" . $name, 80);

                    foreach ($sizes as $thumbnail) {
                        $wh = explode("x", $thumbnail);
                        $w = $wh[0];
                        $h = $wh[1];
                        $thumbnail_path = $file_path . "/thumbnails/" . $file_name . "-" . $thumbnail . "." . $extension;
                        if ($w == '0') {
                            $path = Image::make($file_path . "/" . $name)->heighten($w);
                        } elseif ($h == '0') {
                            $path = Image::make($file_path . "/" . $name)->widen($h);
                        } else {
                            $path = Image::make($file_path . "/" . $name)->fit($w ? $w : NULL, $h ? $h : NULL);
                        }
                        $path->save($thumbnail_path, 80);
                    }
                }

                $files[] = $name;
            }
            return response()->json($files);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
