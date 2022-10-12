@if (count($item->posts) > 0)
<div class="card card-type-1 mt-d mb-d">
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
        <div class="col-lg-12 col-md-12">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="big-item">
                <a href="{{ uri('post', $item->posts[0]->slug)}}"><img src="{{ image_url('placeholders/lg.jpg', '700x394') }}" data-src="{{ image_url($item->posts[0]->images->featured_image, '700x394') }}" alt="{{ $item->posts[0]->title }}" class="lazy"></a>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 big-item-caption">
              <h4><a href="{{ uri('post', $item->posts[0]->slug)}}" class="category-{{ $item->id }}-color">{{ $item->posts[0]->title }}</a></h4>
              <p>{{Str::limit($item->posts[0]->description, 300, $end='...')}}</p>
              <small><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($item->posts[0]->publish_date)->diffForHumans() }}</small>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-md-12">
          <div class="list-items with-img half-style">
            <ul class="list-item">
                @foreach ($item->posts as $i => $post)
                @if ($i != 0 && $i < 5)
                    <li><a href="{{ uri('post', $post->slug)}}"><img
                      src="{{ image_url('placeholders/lg.jpg', '500x281') }}"
                                data-src="{{ image_url($post->images->featured_image, '500x281') }}"
                                alt="{{ $post->title }}" class="lazy"> {{ $post->title }}<span><i
                                    class="fa-regular fa-clock"></i>
                                {{ \Carbon\Carbon::parse($post->publish_date)->diffForHumans() }}</span></a>
                    </li>
                @endif
            @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif