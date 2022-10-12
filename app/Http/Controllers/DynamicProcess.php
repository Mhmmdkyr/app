<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DynamicProcess extends Controller
{
    public function reaction(Request $request)
    {
        $post_id = $request->post_id;
        $post = Post::where('id', $post_id)->first();
        if (!$post->reactions) {
            $post->reactions = json_encode(['like' => 0, 'love' => 0, 'funny' => 0, 'dislike' => 0, 'sad' => 0, 'angry' => 0]);
            $post->save();
        }
        $reaction = $request->reaction;
        $actions = [];
        if (session()->has('reactions') && count(session()->get('reactions')) > 0) {
            foreach ((array) session()->get('reactions') as $get_reaction) {
                $get_reaction = (array) $get_reaction;
                $key = key($get_reaction);
                if ($key == $post_id && isset($get_reaction[$post_id]) && $reaction == $get_reaction[$post_id]) {
                    $message = 'removed';
                    break;
                } elseif ($key == $post_id && isset($get_reaction[$post_id]) && $reaction != $get_reaction[$post_id]) {
                    $actions[] = [$post_id => $reaction];
                    $message = 'already_voted';
                    break;
                } else {
                    $actions[] = [$post_id => $reaction];
                    $message = 'added';
                    break;
                }
            }
            session()->put('reactions', $actions);
        } else {
            $actions[] = [$post_id => $reaction];
            session()->put('reactions', $actions);
            $message = 'added';
        }
        if ($message == 'added') {
            $reactions = (array) $post->reactions;
            unset($reactions[$reaction]);
            $reactions[$reaction] = (int) $post->reactions->$reaction + 1;
            $post->reactions = json_encode($reactions);
            $post->save();
        } elseif ($message == 'removed') {
            $reactions = (array) $post->reactions;
            unset($reactions[$reaction]);
            $reactions[$reaction] = (int) $post->reactions->$reaction - 1;
            if ($reactions[$reaction] >= 0) {
                $post->reactions = json_encode($reactions);
                $post->save();
            } else {
                $reactions[$reaction] = 0;
                $post->reactions = json_encode($reactions);
                $post->save();
            }
        }
        return response()->json(['message' => $message]);
    }

    public function darkMode()
    {
        if (session()->has('dark_mode')) {
            session()->forget('dark_mode');
        } else {
            session()->push('dark_mode', 'on');
        }
        return redirect()->back();
    }

    public function acceptCookie()
    {
        session()->push('cookie_alert', 'accepted');
    }

    public function closeNewsletter()
    {
        session()->push('newsletter_modal', 'close');
    }

    public function getCategoryPosts($category_id)
    {
        $category = Category::where('id', $category_id)->first();
        if ($category) {
            $layout = '<div class="col-lg-3">
                <a href="__uri__" class="mm-item transition">
                        <img data-src="__image__" src="__placeholder_img__"
                            alt="__title__"
                            class="lazy">
                            <h6 class="two-lines">__title__</h6>
                            <small><i class="fa fa-clock"></i> __date__</small>
                </a>
            </div>';
            $all_posts = new Posts();
            $posts = $all_posts->all_posts();
            $posts = $posts->whereRaw("FIND_IN_SET('" . $category->uniq_id . "', categories)")->take(4)->get();
            if ($posts) {
                $post_html = [];
                foreach ($posts as $post) {
                    $layout_post = $layout;
                    $layout_post = str_replace('__uri__', uri('post', $post->slug), $layout_post);
                    $layout_post = str_replace('__title__', $post->title, $layout_post);
                    $layout_post = str_replace('__image__', image_url($post->images->featured_image, '500x281'), $layout_post);
                    $layout_post = str_replace('__placeholder_img__', image_url('placeholders/lg.jpg', '500x281'), $layout_post);
                    $layout_post = str_replace('__date__', \Carbon\Carbon::parse($post->publish_date)->diffForHumans(), $layout_post);
                    $post_html[] = $layout_post;
                }
                echo implode("\n", $post_html);
            }
        }
    }
}
