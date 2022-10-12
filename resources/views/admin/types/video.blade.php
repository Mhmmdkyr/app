<input type="hidden" name="content[source]" id="content_source" value="{{ old('content[source]', $post ? $post->content->source : '') }}">
<input type="hidden" name="content[url]" id="content_url" value="{{ old('content[url]', $post ? $post->content->url : '') }}">
<label for="content" class="w-100 mb-2">{{ __('Content') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
<textarea id="editor" name="content[content]" class="editor" rows="3">{{ old('content["content"]', $post ? $post->content->content : '') }}</textarea>

<div class="card mt-4">
    <h4 class="card-header">{{ __('Video Information') }}</h4>
    <div class="card-body">
        <div class="form-group">
            <label for="">{{ __('Video URL (Youtube or Vimeo)') }}</label>
            <input type="text" class="form-control video-input" value="">
        </div>
        <button type="button" class="btn btn-success get-video-information">{{ __('Get Video Information') }}</button>
        <div class="video-information{{ !$post ? '  d-none' : '' }}">
            <hr>
            <h5>{{ __('Video Preview') }}</h5>
            @if($post)
            <iframe src="{{ $post->content->url }}" width="640" height="412" frameborder="0" title="ReflectionVOID" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            @endif
        </div>
    </div>
</div>
<script>
    $('.get-video-information').click(function(){
        var elm = $(this);
        var inp = $('.video-input');
        var val = inp.val();
        var token = '{{ csrf_token() }}';
        if(!val){
            return false;
        }
        var data = {url: val, _token: token}
        var url = '{{ url('/admin/posts/video-information') }}';
        $.post(url, data, function(res){
            console.log(res);
            if(res){
                $('.video-information').find('iframe').remove();
                var iframe = '<iframe src="'+res.embed+'" width="640" height="412" frameborder="0" title="ReflectionVOID" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                $('.video-information').removeClass('d-none');
                $('.video-information').append(iframe);
                $('#select-featured_image').removeClass('show active');
                $('#already-featured_image').find('img').attr('src', res.thumb);
                $('#featured_image').val(res.thumb)
                $('#already-featured_image').addClass('show active');
                $('#content_source').val(res.source);
                $('#content_url').val(res.embed);
            } else {
                swal("Video informations not found", '', "error");
            }
        })
    })
</script>
