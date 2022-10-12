<div class="sidebars sticky-top">
    <div class="sidebar mb-4">
        <div class="sidebar-title text-uppercase">{{ __('Categories') }}</div>
        <div class="list-group with-img">
            <div class="list-item">
                @foreach ($parent_categories as $category)
                    <a href="{{ uri('category', $category->slug) }}"
                        class="list-group-item transition"><i class="fas fa-genderless"></i> {{ $category->category_title }}
                        <i class="fa fa-chevron-right float-right transition"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="clear"></div>
    @if (config('settings.ads') && isset(config('settings.ads')->sidebar_top_desktop))
        {!! config('settings.ads')->sidebar_top_desktop !!}
    @endif


    <div class="clear"></div>
    @if(count($popular_posts) > 0)
    <div class="sidebar mt-4">
        <div class="sidebar-title text-uppercase">{{ __('Popular Posts') }}</div>
        <div class="list-items with-img">
            <ul class="list-item">
                @foreach ($popular_posts as $i => $post)
                    <li><a href="{{ uri('post', $post->slug) }}"><img
                                src="{{ image_url('placeholders/lg.jpg', '500x281') }}"
                                data-src="{{ image_url($post->images->featured_image, '500x281') }}"
                                alt="{{ $post->title }}" class="lazy"> <b
                                class="two-lines">{{ $post->title }}</b><span><i class="fa-regular fa-clock"></i>
                                {{ \Carbon\Carbon::parse($post->publish_date)->diffForHumans() }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    @endif
</div>
