<style>
    #accordion-item-1 .btn-danger{
        display: none;
    }
</style>
<label for="content" class="w-100 mb-2">{{ __('Content') }} <span data-toggle="tooltip" data-placement="bottom" title="{{ __('Required Area') }}" class="text-danger float-right"><i class="fas fa-exclamation-triangle"></i></span></label>
<textarea id="editor" name="content[content]" class="editor" rows="3">{{ old('content[content]', $post && is_object($post->content) ? $post->content->content : '') }}</textarea>
<div class="gallery-items">
    @if(!$post)
    <div id="accordion-item-1" class="mt-3 gallery-item" data-id="1">
        <div class="card">
            <div class="card-header p-1" id="headingOne-item-1">
                <h5 class="mb-0 w-100">
                    <button type="button" class="btn btn-link text-dark text-left d-inline-block float-left" data-toggle="collapse"
                        data-target="#collapse-gallery-item-1" aria-expanded="true"
                        aria-controls="collapse-gallery-item-1">
                        <b>1. {{ __('List Item') }}</b>
                    </button>
                    <a href="javascript:;" class="btn btn-sm btn-danger float-right p-0 pl-2 pr-2 mt-2 mr-2" onClick="deleteItem(this)"><i class="fa fa-times"></i></a>
                </h5>
            </div>
            <div id="collapse-gallery-item-1" class="collapse show" aria-labelledby="headingOne-item-1"
                data-parent="#accordion-item-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group pt-0">
                                <label for="">{{ __('Item Title') }}</label>
                                <input type="text" class="form-control form-element" name="content[items][title][]">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="image-item border rounded">
                                @include('admin.common.imager.single', [
                                    'target' => 'item_image_1',
                                    'name' => 'content[items][image][]',
                                    'info_text' => false,
                                    'selected_image' => false
                                ])
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <textarea name="content[items][content][]" id="editor-item-1" class="mini-editor form-element"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    @foreach($post->content->items as $k => $item)
    @php
        $k++;
    @endphp
    <div id="accordion-item-{{ $k }}" class="mt-3 gallery-item" data-id="{{ $k }}">
        <div class="card">
            <div class="card-header p-1" id="headingOne-item-{{ $k }}">
                <h5 class="mb-0 w-100">
                    <button type="button" class="btn btn-link text-dark text-left d-inline-block float-left" data-toggle="collapse"
                        data-target="#collapse-gallery-item-{{ $k }}" aria-expanded="true"
                        aria-controls="collapse-gallery-item-{{ $k }}">
                        <b>{{ $k }}. {{ __('List Item') }}</b>
                    </button>
                    <a href="javascript:;" class="btn btn-sm btn-danger float-right p-0 pl-2 pr-2 mt-2 mr-2" onClick="deleteItem(this)"><i class="fa fa-times"></i></a>
                </h5>
            </div>
            <div id="collapse-gallery-item-{{ $k }}" class="collapse show" aria-labelledby="headingOne-item-{{ $k }}"
                data-parent="#accordion-item-{{ $k }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group pt-0">
                                <label for="">{{ __('Item Title') }}</label>
                                <input type="text" class="form-control form-element" name="content[items][title][]" value="{{ $item->title }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                            <div class="image-item border rounded">
                                @include('admin.common.imager.single', [
                                    'target' => 'item_image_'. $k,
                                    'name' => 'content[items][image][]',
                                    'info_text' => false,
                                    'selected_image' => $item->image
                                ])
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8">
                            <textarea name="content[items][content][]" id="editor-item-{{ $k }}" class="mini-editor form-element">{{ $item->content }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
<div class="text-center">
    <a href="javascript:;" class="btn btn-primary clone-item"><i class="fa fa-plus"></i> {{ __('Add List Item') }}</a>
</div>
<script>
    var item = $('.gallery-item').first().html();
    var id = 1;
    $(document).ready(function() {
        init_minieditor();
    })
    $('.clone-item').click(function() {
        id = $('.gallery-item').last().attr('data-id');
        id = parseInt(id) + 1
        var elm = $(this);
        var new_item = item.replaceAll('item-1', 'item-' + id);
        new_item = new_item.replaceAll('item_image_1', 'item_image_' + id);
        new_item = new_item.replace('data-id="1"', 'data-id="'+id+'"');
        new_item = new_item.replace('1.', id +".");
        $(new_item).find('.form-element').val('')
        $('.gallery-items').append('<div id="accordion-item-'+id+'" class="mt-3 gallery-item" data-id="'+id+'">' + new_item + '</div>');
        $('#accordion-item-'+id+'').find('.form-element').val('')
        $('#accordion-item-'+id+'').find('.remove-button').click();
        setTimeout(() => {
            init_minieditor();
        }, 300);
    })
    function deleteItem(item){
        var elm = $(item);
        var id = elm.parents('.gallery-item').attr("data-id");
        if(id == '1'){
            return false;
        } else {
            elm.parents('.gallery-item').remove();
        }
    }
</script>
