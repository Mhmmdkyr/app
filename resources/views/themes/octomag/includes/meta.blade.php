<title>{{ $meta['title'] }}</title>
<meta name="description" content="{{ $meta['description'] }}" />
<meta name="keywords" content="{{ $meta['keywords'] }}" />
<meta name="author" content="{{ $meta['title'] }}" />
<meta property="og:title" content="{{ $meta['title'] }}" />
<meta property="og:description" content="{{ $meta['description'] }}" />
<meta property="og:type" content="article" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $meta['title'] }}" />
<meta name="twitter:description" content="{{ $meta['description'] }}" />
<meta name="description" content="{{ $meta['description'] }}" />
<meta name="keywords" content="{{ $meta['keywords'] }}" />
@if (isset($settings['favicon']))
    <meta property="og:image" content="{{ $settings['favicon'] }}" />
    <meta property="og:image:width" content="240" />
    <meta property="og:image:height" content="240" />
@endif
<meta name="twitter:title" content="{{ $meta['title'] }}" />
<meta name="twitter:description" content="{{ $meta['description'] }}" />
@if(isset($post))
<meta property="og:image" content="{{ image_url($post->images->featured_image, '1000x563') }}" />
<meta property="og:url" content="{{ uri('post', $post->slug) }}" />
<meta property="article:id" content="{{ $post->short_link }}" />
<meta property="article:author" content="{{ $post->user->name }}" />
@if ($post->categories && isset($post->categories[0]))
<meta property="article:section" content="{{ $post->categories[0]->slug }}" />
@endif
<meta property="article:section:type" content="Detail Page" />
@if ($post->categories && isset($post->categories[0]))
<meta property="article:section:list" content="{{ $post->categories[0]->slug }}" />
@endif
<meta property="article:tag" content="{{ $meta['keywords'] }}" />
<meta property="path-string" content="/posts/" />
<meta property="last-ancestor-url" content="/posts/" />
<meta property="dfp-entity-path" content="/posts" />
@if ($post->categories && isset($post->categories[0]))
<meta property="literal-category" content="{{ $post->categories[0]->category_title }}" />
@endif
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:image" content="{{ image_url($post->images->featured_image, '1000x563') }}" />
<meta name="twitter:url" content="{{ uri('post', $post->slug) }}" />
<meta name="robots" content="max-image-preview:large, max-video-preview:-1">
<link rel="image_src" href="{{ image_url($post->images->featured_image, '1000x563') }}" />
<link rel="canonical" href="{{ uri('post', $post->slug) }}" />
@else
<meta property="og:type" content="website" />
<link rel="canonical" href="{{ url()->current() }}" />
@endif
@if ($settings['socials'] && $settings['socials']->twitter)
    <meta name="twitter:site" content="{{ $settings['socials']->twitter }}" />
@endif
@if (isset($settings['favicon']))
    <link rel="shortcut icon" type="image/png" href="{{ image_url($settings['favicon'], '128x128') }}" />
@endif
@foreach ($languages as $lang)
    @if ($lang->id != config('app.default_lang.id'))
        <link rel="alternate" href="{{ url('/' . $lang->slug) }}" hreflang="{{ $lang->slug }}" />
    @endif
@endforeach
<link rel="stylesheet" href="{{ url('/') }}/themes/{{ $theme->path }}/css/ahtaport.min.css" />
@if (config('app.active_lang.rtl'))
    <link rel="stylesheet" href="{{ url('/') }}/themes/{{ $theme->path }}/css/rtl.min.css" />
@endif
@if (config('settings.header_html'))
    {!! config('settings.header_html') !!}
@endif
<meta name="theme-color" content="{{ config('settings.color') ? config('settings.color') : '#0093ab' }}" />
<script type="application/ld+json">
  {
      "@context": "https://schema.org",
      "@type": "WebSite",
      "name": "{{ $settings['title'] }}",
      "url": "{{ uri('') }}",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ uri('') }}/search?q={q}",
        "query": "required",
        "query-input": "required name=q"
      }
  }
  </script>
<style>
    :root {
        --primary-color: {{ config('settings.color') ? config('settings.color') : '#0093ab' }}
    }

    @foreach ($categoriesForColours as $category).category-{{ $category->id }} {
        background-color: {{ $category->color ? '#' . $category->color : 'var(--primary-color)' }};
    }

    @endforeach
</style>
