<div class="text-center reactions-container">
    <div class="reactions" data-id="{{ $post->id }}">
        <div class="reaction-item transition" data-reaction="like">
            <div class="reaction-item-img reitem-{{ $post->reactions && $post->reactions->like > 0 ? 1 : 0 }}" data-count="{{ $post->reactions ? $post->reactions->like : 0 }}">
                <img src="{{ url('/') }}/themes/{{ $theme->path }}/img/reactions/like.png" class="transition" alt="">
            </div>
            <div class="reaction-item-span">{{ __('Like') }}</div>
        </div>
        <div class="reaction-item transition" data-reaction="love">
            <div class="reaction-item-img reitem-{{ $post->reactions && $post->reactions->love > 0 ? 1 : 0 }}" data-count="{{ $post->reactions ? $post->reactions->love : 0 }}">
                <img src="{{ url('/') }}/themes/{{ $theme->path }}/img/reactions/love.png" class="transition" alt="">
            </div>
            <div class="reaction-item-span">{{ __('Love') }}</div>
        </div>
        <div class="reaction-item transition" data-reaction="funny">
            <div class="reaction-item-img reitem-{{ $post->reactions && $post->reactions->funny > 0 ? 1 : 0 }}" data-count="{{ $post->reactions ? $post->reactions->funny : 0 }}">
                <img src="{{ url('/') }}/themes/{{ $theme->path }}/img/reactions/funny.png" class="transition" alt="">
            </div>
            <div class="reaction-item-span">{{ __('Funny') }}</div>
        </div>
        <div class="reaction-item transition" data-reaction="dislike">
            <div class="reaction-item-img reitem-{{ $post->reactions && $post->reactions->dislike > 0 ? 1 : 0 }}" data-count="{{ $post->reactions ? $post->reactions->dislike : 0 }}">
                <img src="{{ url('/') }}/themes/{{ $theme->path }}/img/reactions/dislike.png" class="transition" alt="">
            </div>
            <div class="reaction-item-span">{{ __('Dislike') }}</div>
        </div>
        <div class="reaction-item transition" data-reaction="sad">
            <div class="reaction-item-img reitem-{{ $post->reactions && $post->reactions->sad > 0 ? 1 : 0 }}" data-count="{{ $post->reactions ? $post->reactions->sad : 0 }}">
                <img src="{{ url('/') }}/themes/{{ $theme->path }}/img/reactions/sad.png" class="transition" alt="">
            </div>
            <div class="reaction-item-span">{{ __('Sad') }}</div>
        </div>
        <div class="reaction-item transition" data-reaction="angry">
            <div class="reaction-item-img reitem-{{ $post->reactions && $post->reactions->angry > 0 ? 1 : 0 }}" data-count="{{ $post->reactions ? $post->reactions->angry : 0 }}">
                <img src="{{ url('/') }}/themes/{{ $theme->path }}/img/reactions/angry.png" class="transition" alt="">
            </div>
            <div class="reaction-item-span">{{ __('Angry') }}</div>
        </div>
    </div>
    <div class="alert alert-warning d-none">{{ __('You have already voted for this post.') }}</div>
</div>