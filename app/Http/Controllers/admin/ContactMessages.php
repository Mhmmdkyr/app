<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactMessages extends AdminController
{
    public function index(Request $request)
    {
        $messages = ContactMessage::paginate(50);
        $title = __('All Messages');
        $all_count = ContactMessage::count();
        return $this->render("messages.list", ["messages" => $messages, "title" => $title, 'all_count' => $all_count]);
    }

    public function trash(Request $request) {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $request->validate([
            'id' => 'required'
        ]);
        if(is_array($request->id)){
                ContactMessage::whereIn('id', $request->id)->delete();
        } else {
            ContactMessage::where('id', $request->id)->delete();
        }

        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }
}
