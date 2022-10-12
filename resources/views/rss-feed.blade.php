<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ {{ config('settings.title') }} ]]></title>
        <link><![CDATA[ {{ uri('rss-feeds') }} ]]></link>
        <description><![CDATA[ {{ config('settings.description') }}  ]]></description>
        <language>en</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->title }}]]></title>
                <link>{{ uri('post', $post->slug) }}</link>
                <description><![CDATA[{!! $post->description !!}  <img src="{{ image_url($post->images->featured_image, '500x281') }}" alt="{{ $post->title }}">]]></description>
                <category>{{ $category->category_title }}</category>
                <author><![CDATA[{{ $post->user->name  }}]]></author>
                <guid>{{ $post->id }}</guid>
                <pubDate>{{ $post->created_at }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>