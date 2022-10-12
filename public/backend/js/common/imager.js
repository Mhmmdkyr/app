feather.replace()
$('.add_image_button').text(lang_add_images)
if (queryString("multiple") !== 'true') {
    $('.add_image_button').text(lang_add_image)
}
function queryString(param) {
    var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < url.length; i++) {
        var urlparam = url[i].split('=');
        if (urlparam[0] == param) {
            return urlparam[1];
        }
    }
}

function selected_images() {
    var images = [];
    $('.image-container.active').each(function () {
        var elm = $(this);
        images.push(elm.find("img").attr("data-uri"));
    })
    var images_length = images.length;
    if (queryString("multiple") !== 'true') {
        if (images.length > 0) {
            images = images[0];
            images_length = 1;
        }
    }
    if (images.length > 0) {
        $('.display-selected').removeClass('d-none');
        $('.selected-count').removeClass('d-none');
        $('.selected-count').find('span').text(images_length);
        $('.selected-count').find('b').text(lang_selected_image);
        if (images.length > 1) {
            $('.selected-count').find('b').text(lang_selected_images);
        }
        $('.add_image_button').prop('disabled', false)
    } else {
        $('.display-selected').addClass('d-none');
        $('.selected-count').addClass('d-none');
        $('.add_image_button').prop('disabled', true)
        $('.popover').remove();
    }
    if (queryString('multiple') != 'true' && queryString('cropper') == 'true') {
        $('#cropper-tab').click();
        setTimeout(function () {
            $('#cropper-main').imageResizer({
				image: url + "/uploads/" + images,
				 imgFormat: queryString('w') + "x" + queryString("h"), // Formats: 3/2, 200x360, auto
				// circleCrop: true,
				// outBoundColor: 'white', // black, white
				btnDoneAttr: '.resize-done'
			}, function (imgResized) {
				console.log(imgResized)
			})

        }, 1000)
    }

    return images;
}
function deselect() {
    $('.image-container').removeClass('active');
    selected_images();
}
function delete_images() {
    var images = selected_images();
    if (images.length > 0) {
        $('#delete_image').modal('show');
    }
    console.log(images)
}
function init(default_data = false) {
    var data = {
        target: queryString('target'),
        multiple: queryString('multiple'),
        start: queryString('start'),
        limit: queryString('limit'),
        dir: queryString('dir'),
        sizes: queryString('sizes'),
        _token: csrf_token
    };
    if (default_data) {
        data = default_data;
    }
    $.post(url + '/admin/imager/files', data, function (response) {
        if (response && response.files) {
            var files_html = '';
            if ($('.image-box').length > 0) {
                $('.load-more-tag').remove();
            } else {
                $('.loading-div').text('File not found to display')
            }
            $(response.files).each(function (index, file) {
                var full_uri = url + '/uploads/' + file.uri;
                var src = url + '/uploads/' + file.uri;
                var uri = file.uri;
                if(queryString('dir') && queryString('dir') != 'false'){
                    src = url + '/uploads/' + queryString('dir') + '/' + file.uri;
                    full_uri = url + '/uploads/' + queryString('dir') + '/' + file.uri;
                    uri = queryString('dir') + "/" + file.uri;
                }
                files_html += '<div class="col-lg-2 col-md-2 col-4 mb-4 image-container">';
                files_html += '<div class="image-box" title="' + file.uri + '">';
                files_html += '<img src="' + src + '" data-uri="' + uri + '" data-full-uri="' + url + '/uploads/' + file.uri + '" loading="lazy" alt="">';
                files_html += '</div>';
                files_html += '<span>' + file.uri + '</span>';
                files_html += '</div>';
            })
            if (files_html != '') {
                if ($('.image-box').length > 0) {
                    $('.image-scaffold').append(files_html)
                } else {
                    $('.image-scaffold').html(files_html)
                }
                if (response.total != $('.image-box').length) {
                    $('.image-scaffold').append('<div class="text-center load-more-tag"><a class="btn btn-sm btn-outline-primary ps-4 pe-4 pl-4 pr-4 load-more">Load more</a></div>')
                }
            }
            $('.image-container').click(function () {
                var elm = $(this);
                if (queryString("multiple") !== 'true') {
                    $('.image-container').removeClass('active');
                }
                elm.toggleClass('active');
                selected_images();
            })
            $('.load-more').click(function () {
                var default_data = {
                    target: queryString('target'),
                    multiple: queryString('multiple'),
                    start: $('.image-box').length,
                    limit: queryString('limit'),
                    _token: csrf_token
                };
                init(default_data)
            })
            $('.image-container').dblclick(function () {
                var image = $(this);
                var image_full_uri = image.find("img").attr("data-full-uri");
                $.fancybox.open([
                    {
                        src: image_full_uri,
                        opts: {
                            caption: image.find("img").attr("data-uri")
                        }
                    }
                ]);
            })
        }
    })
}
$(document).ready(function () {
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
    init();
    $('#delete_images').on('shown.bs.popover', function () {

        $('.delete-images').click(function () {
            delete_images();
        })

        $('.popover').find('.selected-count').find('span').text($('.selected-count').find('span').text());

    });
    $('.image-container').click(function () {
        var elm = $(this);
        if (queryString("multiple") !== 'true') {
            $('.image-container').removeClass('active');
        }
        elm.toggleClass('active');
        selected_images();
    })
    $('.add_image_button').click(function () {
        var images = selected_images();
        if (Array.isArray(images) && images.length > 0) {
            images = images.join(",");
        }
        if (queryString('tinymce') == 'true') {
            var base_url = "{{ url('/') }}";
            window.parent.document.querySelector('#imager').setAttribute("data-last-select", images);
        } else {
            window.parent.select_imager(images, { multiple: queryString('multiple'), target: queryString('target') });
        }
        window.parent.close_modal();
    })

    $('#upload-input').change(function () {
        $('#upload_form').submit();
    })
    $('#upload_form').on('submit', (function (e) {
        e.preventDefault();
        var form_data = new FormData();
        form_data.append("_token", csrf_token);
        if(queryString('sizes') && queryString('sizes') != 'false'){
            form_data.append("sizes", queryString('sizes'));
        }
        if(queryString('dir') && queryString('dir') != 'false'){
            form_data.append("dir", queryString('dir'));
        }
        var totalfiles = document.getElementById('upload-input').files.length;
        for (var index = 0; index < totalfiles; index++) {
            form_data.append("images[]", document.getElementById('upload-input').files[index]);
        }
        console.log(form_data)
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data) {
                    $('.image-scaffold').html('');
                    init();
                    $('#library-tab').click();
                }
            },
            error: function (data) {
                console.log(data)
                alert("The file you are trying to upload is not in the allowed formats. (jpg, jpeg, png or gif)")
            }
        });
    }));

})

function close_modal() {
    window.parent.close_modal();
}
