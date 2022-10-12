<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function profileForm()
    {
        $user = auth()->user();
        return $this->render('user.profile', ['user' => $user]);
    }

    public function profileStore(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $user_id = auth()->user()->id;
        $validate_message = [
            'name.required' => __('"Name" is required. Please check and try again.'),
            'email.required' => __('"Email" is required. Please check and try again.'),
            'password.required' => __('"Password" is required. Please check and try again.'),
            'email.unique' => __('This email address is already registered in the system'),
        ];
        $validated = $request->validate([
            'name' => 'required|max:128',
            'email' => 'required',
        ], $validate_message);

        try {
            $fields = [
                'name' => $request->name,
                'email' => $request->email,
                'about' => $request->about ? json_encode($request->about) : NULL
            ];
            User::where('id', $user_id)->update($fields);

            session()->flash('success', __('Your changes have been saved'));

            if ($request->has('current_password')) {
                if ($request->has('new_password') && $request->has('confirm_password') && $request->new_password == $request->confirm_password) {
                    User::where('id', $user_id)->update(['password' => Hash::make($request->new_password)]);
                } else {
                    session()->flash('error', __('The passwords you entered do not match'));
                }
            }
            return redirect()->route('frontend.user.profile');
        } catch (Exception $e) {
            session()->flash('error', __('Your changes could not be saved!'));
            return redirect()->route('frontend.users.profile');
        }
    }
    public function favorites()
    {
        $user = auth()->user();
        $posts = Favorite::where('user_id', $user->id)->get();
        return $this->render('user.favorites', ['posts' => $posts, 'user' => $user]);
    }

    public function addFavorites($post_id)
    {
        $user = auth()->user();
        $favorites = Favorite::where('user_id', $user->id)->where('post_id', $post_id)->first();
        if ($favorites) {
            $favorites->delete();
            $output['status'] = 200;
            $output['message'] = 'deleted';
        } else {
            $arr = [
                'user_id' => $user->id,
                'post_id' => $post_id
            ];
            Favorite::create($arr);
            $output['status'] = 200;
            $output['message'] = 'added';
        }
        return response()->json($output);
    }

    public function removeFavorite($post_id){
        $fav = Favorite::where('user_id', auth()->user()->id)->where('post_id', $post_id)->first();
        if($fav){
            $fav->delete();
            session()->flash('success', __('Your changes have been saved'));
            return redirect()->route('frontend.user.favorites');
        } else {
            session()->flash('error', __('Something went wrong!'));
            return redirect()->route('frontend.user.favorites');
        }
    }
    public function comments()
    {
        $user = auth()->user();
        $comments = Comment::where('user_id', $user->id)->get();
        return $this->render('user.comments', ['comments' => $comments, 'user' => $user]);
    }

    public function removeComment($comment_id){
        $comment = Comment::where('user_id', auth()->user()->id)->where('id', $comment_id)->first();
        if($comment){
            $comment->delete();
            session()->flash('success', __('Your changes have been saved'));
            return redirect()->route('frontend.user.comments');
        } else {
            session()->flash('error', __('Something went wrong!'));
            return redirect()->route('frontend.user.comments');
        }
    }

    public function addPost(){
        return $this->render('user.posts.form', []);
    }
}
