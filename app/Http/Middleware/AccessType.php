<?php

namespace App\Http\Middleware;
    
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessType
{
     public function handle(Request $request, Closure $next,$access){
        
        $role=Auth::user()->role->access;
        $acc = false;
        foreach($role as $k => $r){
            if($k == $access || $k == "all"){
                $acc = true;
            }
        }
        if ($acc) {
            return $next($request);
        }
            $message="Unauthorized action.";         
            $request->session()->flash('error', $message);
            return redirect()->route('admin.errors.permission');
    }
}