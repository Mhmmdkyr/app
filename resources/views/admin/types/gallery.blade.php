
<label for="content" class="w-100 mb-2">{{ __('Content') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
<textarea id="editor" name="content[content]" class="editor" rows="3">{{ old('content', $post && is_object($post->content) ? $post->content->content : '') }}</textarea>
<div class="card mt-4">
    <h5 class="card-header">{{ __('Gallery Items') }}</h5>
    <div class="card-body">
        @include('admin.common.imager.multiple', [
            'target' => 'item_image_1',
            'name' => 'content[image][]',
            'info_text' => false,
            'selected_image' =>
                $post && is_object($post->content)
                    ? $post->content->image
                    : false,
        ])

    </div>
</div>
