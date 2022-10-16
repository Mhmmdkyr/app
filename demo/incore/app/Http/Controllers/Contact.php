<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\PostCategory;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class Contact extends Controller
{
    public function index()
    {
        return $this->render('contact');
    }

    public function sendMessage(Request $request)
    {
       $valid_area = [
           'name' => 'required',
           'email' => 'required|email',
           'message' => 'required|string',
       ];
       if (config('settings.recaptcha') && isset(config('settings.recaptcha')->secret)) {
           $valid_area['g-recaptcha-response'] = ['required', new ReCaptcha];
       }
        $validate = $request->validate($valid_area);
        if (is_html($request->message)) {
            $output['status'] = 403;
            $output['message'] = __('Do not include HTML Code in the message.');
        } else {
            $fields = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'ip_address' => $request->ip()
            ];
            try {
                $add = ContactMessage::create($fields);
                $output['status'] = 200;
                $output['message'] = __('Your message has been successfully delivered. We thank you.');
            } catch (\Throwable $th) {
                $output['status'] = 403;
                $output['message'] = __('Something went wrong');
            }
        }
        return response()->json($output);
    }
}
