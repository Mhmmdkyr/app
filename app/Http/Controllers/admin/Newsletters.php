<?php

namespace App\Http\Controllers\admin;

use App\Models\Newsletter;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class Newsletters extends AdminController
{
    public function index(Request $request)
    {
        $users = User::where('status', 1)->paginate(50);
        $subscribers = Newsletter::paginate(50);
        return $this->render("newsletters.list", ["users" => $users, 'subscribers' => $subscribers]);
    }

    public function editor(Request $request){
        $validate = $request->validate([
            'type' => ['required', 'string'],
        ]);
        $users = [];
        $subs = [];
        if($request->type == 'user'){
            $users = User::whereIn('id', $request->users)->get();
        } elseif($request->type == 'subscriber'){
            $subs = Newsletter::whereIn('id', $request->subscribers)->get();
        }
        return $this->render("newsletters.editor", ["users" => $users, 'subscribers' => $subs, 'imager' => true]);
    }

    public function send(Request $request){
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
      $define = [
        'logo' => image_url(config('settings.logo'), '308x60'),
        'site_url' => url('/'),
        'unsubscriber' => url('/'),
        'content' => $request->content,
        'subject' => $request->subject,
      ];
        try {
            Mail::send("admin.newsletters.template",$define,function ($message) use ($request){
                $message->to($request->email,$request->email)->subject($request->subject);
             });
             $request->session()->flash('status', __('Your changes have been saved'));
             sleep(0.5);
             return response()->json(['message' => 'sent']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'error']);
        }

    }
}
