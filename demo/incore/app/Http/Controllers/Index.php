<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContentMeta;
use App\Models\Navigation;
use App\Models\NavigationItem;
use App\Models\Newsletter;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Shortener;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Index extends Controller
{
  public function index()
  {
    
    $all_posts = new Posts();
    $sliders = $all_posts->all_posts();
    $sliders = $sliders->where('features', 'LIKE', '%slider%')->limit(10)->orderBy('publish_date', 'desc')->get();

    $slider_right = $all_posts->all_posts();
    $slider_right = $slider_right->where('features', 'LIKE', '%slider%')->limit(2)->skip(10)->orderBy('publish_date', 'desc')->get();

    $featureds = $all_posts->all_posts();
    $featureds = $featureds->where('features', 'LIKE', '%featured%')->limit(4)->orderBy('publish_date', 'desc')->get();



    $recommendeds = $all_posts->all_posts();
    $recommendeds = $recommendeds->where('features', 'LIKE', '%recommended%')->limit(4)->orderBy('publish_date', 'desc')->get();


    $latest_posts =  $all_posts->all_posts();
    $latest_posts = $latest_posts->orderBy('publish_date', 'desc')->limit(5)->get();

    $videos = $all_posts->all_posts();
    $videos = $videos->where('type', 'video')->limit(11)->orderBy('publish_date', 'desc')->get();

    $home_blocks = Category::where('shown', 'LIKE', '%"home_enable":"1"%')->where('language_id', config('app.active_lang.id'))->limit(10)->get();
    $blocks = [];
    foreach ($home_blocks as $block) {
      $block->posts = $all_posts->all_posts()->whereRaw("FIND_IN_SET('" . $block->uniq_id . "', categories)")->take(10)->get();
      $blocks[] = $block;
    }
    return $this->render(
      "index",
      [
        'sliders' => $sliders,
        'slider_right' => $slider_right,
        'featureds' => $featureds,
        'recommendeds' => $recommendeds,
        'latest_posts' => $latest_posts,
        'blocks' => $blocks,
        'videos' => $videos
      ]
    );
  }

  public function login()
  {
    return $this->render(
      "login"
    );
  }
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
      $output['status'] = 200;
      $output['message'] = __('Login successful. You are being redirected...');
      if ($request->has('redirect_url')) {
        $output['redirect'] = $request->redirect_url;
      } else {
        $output['redirect'] = route('frontend.index.show');
      }
    } else {
      $output['status'] = 403;
      $output['message'] = __('Looks like these are not your correct details. Please try again.');
    }
    return response()->json($output);
  }

  public function register(Request $request)
  {
    $validation = $request->validate([
      'name' => 'required',
      'email' => 'required|unique:users|max:255',
      'password' => 'required',
      'confirm_password' => 'required'
    ]);
    list($username, $domain) = explode('@', $request->email);

    if (checkdnsrr($domain, 'MX')) {
      if ($request->password != $request->confirm_password) {
        $output['status'] = 403;
        $output['message'] = __('The passwords you entered do not match');
      } else {
        $arr = [
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'status' => config('settings.mail')->verification ? 0 : 1,
          'role_id' => 1,
          'remember_token' => uniq_id('rt$')
        ];
        $user = User::create($arr);
        if ($user) {
          $output['status'] = 200;
          $output['message'] = __('You have successfully registered and activation mail has been sent to your e-mail address. Please check your inbox.');
          if (!isset(config('settings.mail')->verification) || !config('settings.mail')->verification) {
            $user_data = array(
              'email'  => $request->get('email'),
              'password' => $request->get('password')
            );
            if (Auth::attempt($user_data)) {
              $request->session()->regenerate();
              if ($request->has('redirect_url')) {
                $output['redirect'] = $request->redirect_url;
              } else {
                $output['redirect'] = route('frontend.index.show');
              }
              $output['message'] = __('You have successfully registered. You are being redirected...');
            }
          } else {
            $token = base64_encode($request->email . "##" . $arr['remember_token']);
            $define = [
              'logo' => image_url(config('settings.logo'), '308x60'),
              'site_url' => url('/'),
              'verification_url' => url('/') . "/confirm-account/" . $token,
              'subject' => __('Please Confirm Your Email Address'),
              'name' => $request->name
            ];
            Mail::send("emails.verification", $define, function ($message) use ($request) {
              $message->to($request->email, $request->name)->subject(__('Please Confirm Your Email Address'));
            });
          }
        }
      }
    } else {
      $output['status'] = 403;
      $output['message'] = __('Please enter a valid e-mail address.');
    }
    return response()->json($output);
  }

  public function confirm($token)
  {
    $token = base64_decode($token);
    if (count(explode('##', $token)) > 1) {
      $email = explode('##', $token)[0];
      $token = explode('##', $token)[1];
      $user = User::where('email', $email)->where('remember_token', $token)->first();
      if ($user && !$user->status) {
        $user->status = 1;
        $user->remember_token = uniq_id('rt$');
        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();
        session()->flash('success', 'Your account has been successfully verified. You can login now.');
      } else {
        session()->flash('danger', __('Your verification code is invalid.'));
      }
    } else {
      session()->flash('danger', __('Something went wrong'));
    }
    return redirect()->route('frontend.login');
  }

  public function getRememberToken(Request $request)
  {
    $validate = $request->validate(['email' => 'required']);
    $email = $request->email;
    $user = User::where('email', $email)->where('status', 1)->first();
    if ($user) {
      $token = base64_encode($request->email . "##" . $user->remember_token);
      $define = [
        'logo' => image_url(config('settings.logo'), '308x60'),
        'site_url' => url('/'),
        'reset_link' => url('/') . "/reset-password/" . $token,
        'subject' => __('Reset Password Instructions'),
        'short_title' => config('settings.short_title') ? config('settings.short_title') : config('settings.title'),
        'name' => $user->name
      ];
      Mail::send("emails.resetPassword", $define, function ($message) use ($request, $user) {
        $message->to($request->email, $user->name)->subject(__('Reset Password Instructions'));
      });
      $output['status'] = 200;
      $output['message'] = __('Your password reset email has been sent to your email address. Please check your inbox.');
    } else {
      $output['status'] = 403;
      $output['message'] = __('The e-mail address you entered did not match the addresses in the system.');
    }
    return response()->json($output);
  }

  public function resetPasswordForm($token)
  {
    $token_d = base64_decode($token);
    if (count(explode('##', $token_d)) > 1) {
      $email = explode('##', $token_d)[0];
      $token_d = explode('##', $token_d)[1];
      $user = User::where('email', $email)->where('remember_token', $token_d)->first();
      if ($user) {
        return $this->render(
          "reset-password",
          ['email' => $email, 'token' => $token_d]
        );
      } else {
        session()->flash('danger', __('Something went wrong'));
        return redirect()->route('frontend.login');
      }
    } else {
      session()->flash('danger', __('Something went wrong'));
      return redirect()->route('frontend.login');
    }
    return redirect()->route('frontend.login');
  }

  public function resetPassword(Request $request)
  {
    $validate = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
      'confirm_password' => 'required'
    ]);

    if ($request->password != $request->confirm_password) {
      $output['status'] = 403;
      $output['message'] = __('The passwords you entered are not the same.');
    } else {
      $user = User::where('email', $request->email)->where('remember_token', $request->token)->first();
      if (!$user) {
        $output['status'] = 403;
        $output['message'] = __('Something went wrong');
      } else {
        $user->password = Hash::make($request->password);
        $user->remember_token = uniq_id('rt$');
        $user->save();
        $output['status'] = 200;
        $output['message'] = __('You have successfully changed your password. You can login with your new password.');
      }
    }
    return response()->json($output);
  }
  function logout()
  {
    Auth::logout();
    return redirect()->route('frontend.index.show');
  }

  public function addNewsletter(Request $request)
  {
    $valid_area = [
      'email' => ['required', 'string', 'email']
    ];
    if(config('settings.recaptcha') && isset(config('settings.recaptcha')->secret)){
      $valid_area['g-recaptcha-response'] = ['required', new ReCaptcha];
    }
    $validate = $request->validate($valid_area);
    session()->push('newsletter_modal', 'close');
    if (Newsletter::where('email', $request->email)->count() == 0) {
      Newsletter::create(['email' => $request->email]);
      return response()->json(['message' => __('Your subscription has been successfully registered.')]);
    } else {
      return response()->json(['message' => 'This email address is already registered']);
    }
  }
}
