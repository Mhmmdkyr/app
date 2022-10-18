<?php

namespace App\Http\Controllers\admin;

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
        $storage_path = public_path("uploads")."/";
        if ($request->has('dir') && is_dir(public_path("uploads")."/".$request->dir)) {
            $storage_path = public_path("uploads")."/".$request->dir."/";
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
            $all_files[] = $add_files;
            $m++;
        }

        $pages = round($m / $limit);
        $collection = ['files' => array_reverse($all_files), 'total' => $m, 'pages' => $pages];
        return response()->json($collection);
    }

    public function upload(Request $request)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $file_path = public_path('uploads');
        $sizes = config('image.thumbnails');
        if ($request->has('dir') && $request->dir != 'false') {
            $file_path = public_path('uploads/'  . $request->dir);
        }
        if ($request->has('sizes') && $request->dir != 'false') {
            $sizes = explode(",", $request->sizes);
        }
        foreach ($request->file('images') as $file) {
            $file_name = $file->getClientOriginalName()."-".uniq_id('i');
            $extension = $file->extension();
            $name = $file_name . '.' . $extension;
            if (!in_array($extension, $this->allowed_extensions)) {
                return response()->json(['message' => 'Not allowed file format', 'status' => 403], 403);
            }
            $file->move($file_path, $name);
            $path = Image::make($file_path . "/" . $name)->fit(256, 256);
            $path->save($file_path . "/thumbnails/" . $name, 60);

            foreach ($sizes as $thumbnail) {
                $wh = explode("x", $thumbnail);
                $w = $wh[0];
                $h = $wh[1];
                $thumbnail_path = $file_path . "/thumbnails/" . $file_name . "-" . $thumbnail . "." . $extension;
                $path = Image::make($file_path . "/" . $name)->fit($w, $h);
                $path->save($thumbnail_path, 80);
            }
            $files[] = $name;
        }
        return response()->json($files);
    }
}
