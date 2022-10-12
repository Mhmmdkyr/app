function close_modal() {
    $('.modal').modal('hide')
    $('#imager').find('iframe').attr("src", base_url + "/admin/imager?");
}
function open_imager(options) {
    var multiple = options.multiple ? options.multiple : false;
    var target = options.target ? options.target : '.image';
    var start = options.start ? options.start : 0;
    var tinymce = options.tinymce ? options.tinymce : 'false';
    var sizes = options.sizes ? options.sizes : 'false';
    var dir = options.dir ? options.dir : 'false';
    $('#imager').find('iframe').attr("src", base_url + "/admin/imager?" + "multiple=" + multiple + "&target=" + target + "&start=" + start + "&tinymce=" + tinymce + "&sizes=" + sizes + "&dir=" + dir);
    $('#imager').modal('show')
}
function select_imager(image, options) {
    var target = options.target ? options.target : null;
    var multiple = options.multiple ? options.multiple : false;
    if (multiple == 'false') {
        $(target).val(image);
        var id = $('*[data-target="' + target + '"]').attr("data-id");
        $('#select-' + id).removeClass('show active');
        $('#already-' + id).find("img").attr("src", base_url + "/uploads/" + image);
        $('#already-' + id).addClass('show active');
    } else if(multiple == 'true') {
        var images = image.split(',');
        var id = $('*[data-target="' + target + '"]').attr("data-id");
        $.each(images, function(i, item){
            $('.gallery-container').append('<figure><img src="'+base_url+'/uploads/'+item+'" data-img="'+item+'" class="rounded border" /><a href="javascript:;" onClick="multiple_delete(this)" class="remove-button-multiple btn btn-text text-danger"><i class="fa fa-times"></i></a></figure>')
        })
        var imgs = []
        $('.gallery-container').find('figure').each(function(i, item){
            var im = $(item).find('img').attr('data-img');
            if(im){
                imgs.push(im)
            }
        })
        $(target).val(imgs);
        $('#already-' + id).addClass('show active');
    }
}
$(document).ready(function () {
    $('.remove-button').click(function () {
        var elm = $(this)
        var id = elm.parents('.tab-content').attr("data-id");
        var target = elm.parents('.tab-content').attr("data-target");
        elm.parents('.already-image').find("img").attr("src", "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
        $('#select-' + id).addClass('show active');
        $('#already-' + id).removeClass('show active');
        $(target).val("")
    })

  
    
})
function single_delete(elm){
    var elm =  $(elm)
    var id = elm.parents('.tab-content').attr("data-id");
    var target = elm.parents('.tab-content').attr("data-target");
    elm.parents('.already-image').find("img").attr("src", "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==");
    $('#select-' + id).addClass('show active');
    $('#already-' + id).removeClass('show active');
    $(target).val("")
}
function multiple_delete(elm){
    var elm =  $(elm)
    var img = elm.parents('figure').find('img').attr('data-img')
    console.log(img);

    var id = elm.parents('.tab-content').attr("data-id");
    var target = elm.parents('.tab-content').attr("data-target");
    var input = target.replace('#', '.');
    var images = $(input).val();
        images = images.split(',');
    var new_images = []
    $.each(images, function(i, item){
        if(item != img){
            new_images.push(item)
        }
    })
    $(target).val(new_images.join(','))
    elm.parents('figure').remove();
}