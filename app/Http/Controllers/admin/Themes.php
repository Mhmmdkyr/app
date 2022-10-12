<?php

namespace App\Http\Controllers\admin;

use App\Models\Theme;
use Illuminate\Http\Request;

class Themes extends AdminController
{
    public function index(Request $request)
    {
        $themes = Theme::orderBy('created_at', 'desc')->orderBy('active','desc')->get();
        return $this->render("settings.themes", ["themes" => $themes]);
    }

    public function setTheme(Request $request, $id){
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $set = Theme::where('active', 1)->first();
        if($set){
            $set->active = 0;
            $set->save();
        }
        $new = Theme::where('id', $id)->first();
        if($new){
            $new->active = 1;
            $new->save();
        }
        session()->flash('status', __('Your changes have been saved'));
        return redirect(route('admin.themes.index'));
    }

}
