<label for="content" class="w-100 mb-2">{{ __('Content') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
<textarea id="editor" name="content" class="editor" rows="3">{{ old('content', $post ? $post->content : '') }}</textarea>
