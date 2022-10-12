<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Comment;

class Comments extends AdminController
{
    public function index(Request $request)
    {
        $comments = Comment::paginate(50);
        $title = __('All Comments');
        if ($request->query('filter') && $request->query('filter') == 'pending') {
            $comments = Comment::paginate(50)->filter(function ($q) {
                if (!$q->status) {
                    return true;
                }
            });
            $title = __('Pending Comments');
        } elseif ($request->query('filter') && $request->query('filter') == 'approved') {
            $comments = Comment::paginate(50)->filter(function ($q) {
                if ($q->status) {
                    return true;
                }
            });
            $title = __('Approved Comments');
        }
        $all_count = Comment::count();
        $approved_count = Comment::where('status', 1)->count();
        $pending_count = Comment::where('status', 0)->count();
        return $this->render("comments.list", ["comments" => $comments, "title" => $title, 'all_count' => $all_count, 'approved_count' => $approved_count, 'pending_count' =>  $pending_count]);
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
                Comment::whereIn('id', $request->id)->delete();
        } else {
            Comment::where('id', $request->id)->delete();
        }

        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }

    public function status(Request $request){
        if(auth()->user()->id == 3368){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $comment = Comment::where("id", $request->id)->first();
        if($comment){
            $comment->status = $request->status;
            $comment->save();
            session()->flash('status', __('Your changes have been saved'));
        } else {
            $request->session()->flash('status',  __('Your changes could not be saved!'));
        }
        return redirect()->back();
    }
}
