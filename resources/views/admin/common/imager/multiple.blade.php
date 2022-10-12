@php
    $imager_id =  $target;
@endphp
<input type="hidden" name="{{ isset($name) ? $name : $target }}" id="{{ $target }}" value="{{ isset($selected_image) && (is_object($selected_image) || is_array($selected_image)) ? implode(',',$selected_image ): '' }}" class="{{ $target }}">
<div class="tab-content" id="multiple-imager-{{ $imager_id }}" data-target="#{{ $target }}" data-id="{{ $imager_id }}">
    <div class="tab-pane fade show active" id="select-{{ $imager_id }}" role="tabpanel" aria-labelledby="select-{{ $imager_id }}-tab">
        <div class="multiple-tab-container">
             <a href="javascript:;" onClick="open_imager({multiple: 'true', target: '#{{ $target }}', sizes: '{{isset($sizes) ? implode(',', $sizes) : 'false' }}', dir: '{{ isset($dir) ? $dir : 'false' }}'})" class="btn-block btn"><i class="fa fa-image"></i> {{ $info_text ? $info_text : __('Select Images') }}</a>
        </div>
    </div>
    <div class="tab-pane fade{{  (is_object($selected_image) || is_array($selected_image)) ? ' show active' : '' }}" id="already-{{ $imager_id }}" role="tabpanel" aria-labelledby="already-{{ $imager_id }}-tab">
        <div class="already-image multiple-image text-center pt-3 pl-3 pr-3 pb-0">
            <div class="gallery-container">
                @if($selected_image && isset($selected_image[0]))
            @foreach(explode(',', $selected_image[0]) as $image)
            <figure>
                    <img src="{{ image_url($image) }}" data-img="{{ $image }}" 
                        class="rounded border" />
            <a href="javascript:;" onCLick="multiple_delete(this)" class="remove-button-multiple btn btn-text text-danger"><i class="fa fa-times"></i></a>
            </figure>
            @endforeach
            @endif
        </div>
        </div>
    </div>
  </div>
