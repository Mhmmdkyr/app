<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{

    public function index()
    {
        return view('admin.auth.login');
    }
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required|alphaNum|min:3'
        ]);

        $user_data = array(
            'email'  => $request->get('email'),
            'password' => $request->get('password')
        );

        if (Auth::attempt($user_data)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        } else {
            return back()->withErrors(['msg' => __('These credentials do not match our records.')]);
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect('main');
    }
}
