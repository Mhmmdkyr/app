@if (count($item->posts) > 0)
<div class="card card-type-1 mt-4 mb-4">
    <div class="card-header">
      <div class="row">
        <div class="col-lg-4 col-md-4"><span class="card-rounded-title category-{{ $item->id }}"><i class="fas fa-genderless"></i> {{ $item->category_title }}</span></div>
        <div class="col-lg-8 col-md-8">
            <ul class="card-tab">
                @if($item->subs)
                @foreach($item->subs as $sub)
                <li><a href="{{ uri('category', $sub->slug) }}"><i class="fas fa-genderless"></i> {{ $sub->category_title }}</a></li>
                @endforeach
                @endif
                <li><a href="{{ uri('category', $item->slug) }}" class="text-primary"><i class="fas fa-caret-right"></i> {{ __('All Posts') }}</a></li>
            </ul>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row" style="position: relative; z-index: 12;">
        <div class="col-lg-12 col-md-12 mb-4">
          <div class="row">
            @foreach($item->posts as $i => $post)
            @if($i < 2)
            <div class="col-lg-6 col-md-6">
              <div class="card-banner-item position-relative">
                <div class="card-banner-item-content">
                  <a href="{{ uri('post', $post->slug)}}"><img src="{{ image_url('placeholders/lg.jpg', '700x394') }}" data-src="{{ image_url($post->images->featured_image, '700x394') }}" alt="{{ $post->title }}" class="lazy"></a>
                  <div class="card-banner-item-desc">
                    <p><a href="{{ uri('post', $post->slug)}}" class="text-white">{{ $post->title }}</a></p>
                    <small class="d-block"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($post->publish_date)->diffForHumans() }}</small>
                  </div>
                </div>
              </div>
            </div>
            @endif
            @endforeach
          </div>
        </div>
        @foreach($item->posts as $i => $post)
        @if($i >= 2 && $i < 5)
        <div class="col-lg-4 col-md-4">
          <div class="big-item">
            <a href="{{ uri('post', $post->slug)}}"><img src="{{ image_url('placeholders/lg.jpg', '500x281') }}" data-src="{{ image_url($post->images->featured_image, '500x281') }}" alt="{{ $post->title }}" class="lazy"></a>
            <h5><a href="{{ uri('post', $post->slug)}}" class="category-{{ $item->id }}-color">{{ $post->title }}</a></h5>
            <small><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($post->publish_date)->diffForHumans() }}</small>
          </div>
        </div>
        @endif
        @endforeach
      </div>
    </div>
  </div>
  @endif