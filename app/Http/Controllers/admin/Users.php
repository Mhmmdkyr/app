<?php

namespace App\Http\Controllers\admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class Users extends AdminController
{
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $users = $users->where('name', 'like', '%' . $request->search . '%');
        }
        $approved_count = $users->get()->filter(function ($q) {
            if ($q->status == 1) {
                return true;
            }
            return false;
        })->count();
        $pending_count = $users->get()->filter(function ($q) {
            if ($q->status == 0) {
                return true;
            }
            return false;
        })->count();
        if ($request->has('status') && $request->status != "all") {
            $users = $users->where('status', $request->status == 'approved' ? 1 : 0)->paginate(50);
        } else {
            $users = $users->paginate(50);
        }
        return $this->render("users.list", ["users" => $users, "all_count" => ($approved_count + $pending_count), "approved_count" => $approved_count, "pending_count" => $pending_count, "columns" => ["Name", "Email", "Current Team ID"]]);
    }

    public function edit($user_id)
    {
        $user = User::where('id', $user_id)->firstOrFail();
        $roles = Role::get();
        return $this->render("users.form", ['users' => $user,  "imager" => true, "roles" => $roles]);
    }

    public function create(Request $request)
    {
        $roles = Role::get();
        return $this->render("users.form", ['users' => false,  "imager" => true, "roles" => $roles]);
    }

    public function save(Request $request, $id = false)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $user_id = false;
        if ($id) {
            $user_id = $id;
        }
        $validate_message = [
            'name.required' => __('"Name" is required. Please check and try again.'),
            'email.required' => __('"Email" is required. Please check and try again.'),
            'password.required' => __('"Password" is required. Please check and try again.'),
            'role_id.required' => __('"Role" is required. Please check and try again.'),
            'email.unique' => __('This email address is already registered in the system'),
        ];
        if (!$user_id) {
            $validated = $request->validate([
                'name' => 'required|max:128',
                'email' => 'required|email|unique:users',
                'role_id' => 'required',
            ], $validate_message);
        } else {
            $validated = $request->validate([
                'name' => 'required|max:128',
                'email' => 'required',
                'role_id' => 'required',
            ], $validate_message);
        }

        try {
            $fields = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'avatar' => $request->avatar,
                'remember_token' => uniqid(),
                'about' => $request->about ? json_encode($request->about) : NULL
            ];
            if (!$request->password && $user_id) {
                unset($fields['password']);
            }
            if ($user_id) {
                User::where('id', $user_id)->update($fields);
            } else {
                $user = User::create($fields);
                $user_id = $user->id;
            }
            session()->flash('status', __('Your changes have been saved'));
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            session()->flash('status', __('Your changes could not be saved!'));
            return redirect()->route('admin.users.index');
        }
    }

    public function update(Request $request, User $users)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $users->update($request->only(["name", "email", "password", "current_team_id", "profile_photo_path"]));
        session()->flash('status', __('Your changes have been saved'));
        return redirect()->route('admin.users.list', $users)->withSuccess(__('users.updated'));
    }

    public function trash(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $request->validate([
            'id' => 'required'
        ]);
        if (!is_array($request->id) && $request->id == 1) {
            return response()->json(['message' => 'not-trashed']);
        }
        if (is_array($request->id)) {
            foreach ($request->id as $post_id) {
                if ($post_id == 1) {
                    return response()->json(['message' => 'not-trashed']);
                }
                User::where('id', $post_id)->delete();
            }
        } else {
            User::where('id', $request->id)->delete();
        }
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }

    public function status(Request $request)
    {
      if(auth()->user()->id == 0){
          $request->session()->flash('error', __('You have no permission for this as demo account!'));
          return redirect()->back();
      }
        $user = User::where("id", $request->id)->first();
        if ($user) {
            $user->status = $request->status;
            $user->save();
        }
        session()->flash('status', __('Your changes have been saved'));
        return redirect()->back();
    }
}
