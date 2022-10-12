<?php

namespace App\Http\Middleware;
    
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Demo
{
     public function handle(Request $request){
        
        if($request->isMethod('post')){
            return redirect()->back();
        }
    }
}