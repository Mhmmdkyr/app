<?php

namespace App\Http\Controllers\admin;

use App\Models\Role;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Hash;

class Roles extends AdminController
{
    public function index(Request $request)
    {
        $roles = Role::orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $roles = $roles->where('role', 'like', '%' . $request->search . '%');
        }

        $roles = $roles->paginate(50);
        return $this->render("roles.list", ["roles" => $roles,  "columns" => ["Name", "Email", "Current Team ID"]]);
    }

    public function edit($role_id)
    {
        $role = Role::where('id', $role_id)->firstOrFail();
        $roles = Role::get();
        $access = $this->getAccess();
        return $this->render("roles.form", ['role' => $role, "accesses" => $access]);
    }

    public function create(Request $request)
    {
        $roles = Role::get();
        $access = $this->getAccess();
        return $this->render("roles.form", ['role' => false, "accesses" => $access, "imager" => false]);
    }

    public function save(Request $request, $role_id = false)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
            $validated = $request->validate([
                'role' => 'required|max:128',
            ]);
        try {
            $fields = [
                'role' => $request->role,
                'access' => $request->has('access') ? $request->access : NULL,
                'panel_login' => $request->has('panel_login') ? $request->panel_login : NULL,


            ];
            if ($role_id) {
                Role::where('id', $role_id)->update($fields);
            } else {
                $role = Role::create($fields);
                $role_id = $role->id;
            }
            session()->flash('status', __('Your changes have been saved'));
            return redirect()->route('admin.roles.index');
        } catch (Exception $e) {
            session()->flash('status', __('Your changes could not be saved!'));
            return redirect()->route('admin.roles.index');
        }
    }

    public function update(Request $request, Role $roles)
    {
        if(auth()->user()->id == 0){
            $request->session()->flash('error', __('You have no permission for this as demo account!'));
            return redirect()->back();
        }
        $req = $request->only(["name", "email", "password", "current_team_id", "profile_photo_path"]);
        if($request->has('access')){
            $req['access'] = json_encode($request->access);
        }
        $roles->update($req);
        session()->flash('status', __('Your changes have been saved'));
        return redirect()->route('admin.roles.list', $roles)->withSuccess(__('roles.updated'));
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
                Role::where('id', $post_id)->delete();
            }
        } else {
            Role::where('id', $request->id)->delete();
        }
        session()->flash('status', __('Your changes have been saved'));
        return response()->json(['message' => 'trashed']);
    }

    public function getAccess(){
        return [
            [
                "label" => __('Post Managament'),
                "name" => 'posts',
                ""
            ],[
                "label" => __('Comment Managament'),
                "name" => 'comments'
            ],[
                "label" => __('Contact Messages Managament'),
                "name" => 'messages'
            ],[
                "label" => __('User Managament'),
                "name" => 'users'
            ],[
                "label" => __('Page Managament'),
                "name" => 'pages'
            ],[
                "label" => __('Newsletter Managament'),
                "name" => 'newsletter_managament'
            ],[
                "label" => __('Setting Managament'),
                "name" => 'settings'
            ]
        ];
    }

}
