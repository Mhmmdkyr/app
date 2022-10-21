function init_minieditor() {
    tinymce.init({
        selector: ".mini-editor",
        height: 180,
        menubar: false,
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        plugins: [
            "advlist autolink lists link charmap print preview anchor textcolor colorpicker",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste code wordcount imager table",
        ],
        mobile: {
            theme: "mobile",
        },
        toolbar:
            "insert | undo redo |  formatselect | bold italic forecolor backcolor link | alignleft aligncenter alignright alignjustify | bullist numlist | removeformat",
        image_advtab: false,
    });
}
$(document).ready(function () {
    $('.dynamic_select').on('change', function () {
        var url = $(this).val(); // get selected value
        if (url) { // require a URL
            window.location = url; // redirect
        }
        return false;
    });
    tinymce.init({
        selector: ".editor",
        height: 500,
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        },
        language: 'tr_TR',
        plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern code imager',
  toolbar1: 'insert | undo redo |  formatselect | bold italic strikethrough forecolor backcolor | link unlink | media imager | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
        mobile: {
            theme: "mobile",
        },
        toolbar:
            "insert | undo redo |  formatselect | bold italic forecolor backcolor link  | media imager | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | removeformat",
        image_advtab: false,
    });


    $('*[data-slugit="true"]').each(function () {
        var elm = $(this);
        var target = elm.attr("data-target");
        $(target).keyup(function () {
            if (elm.attr("data-slugit") == "true") {
                slugit = string_to_slug($(target).val());
                elm.val(slugit);
            }
        });
    });

    $('*[data-toggle="checkboxer"]').each(function () {
        var elm = $(this)
        var target = elm.attr("data-target");
        elm.change(function(){
            $(target).find('.group-checkbox').each(function (i, item) {
                if(elm.is(':checked')){
                    $(item).prop('checked', true)
                } else {
                    $(item).prop('checked', false)
                }
            });
        })

    });

    $('*[data-duplicate="true"]').each(function () {
        var elm = $(this);
        var target = elm.attr("data-target");
        $(target).keyup(function () {
            if (elm.attr("data-duplicate") == "true") {
                slugit = $(target).val();
                elm.val(slugit);
            }
        });
    });

    $("*[data-collapsed]").change(function () {
        var elm = $(this);
        var target = elm.attr("data-collapsed");
        var checked = elm.attr("data-checked");
        var condition = elm.is(":checked");
        if (checked == "false") {
            var condition = !elm.is(":checked");
        }
        if (condition) {
            $(target).removeClass("d-none");
            $(target).addClass("d-block");
        } else {
            $(target).removeClass("d-block");
            $(target).addClass("d-none");
        }
    });

    $(".delete-single").click(function () {
        swal({
            title: lang.are_you_sure,
            text: lang.delete_message,
            icon: "warning",
            buttons: [lang.cancel, lang.confirm],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var elm = $(this);
                var id = elm.attr("data-id");
                var section = elm.attr("data-section");
                $.post(
                    base_url + "/admin/" + section + "/item/trash",
                    { id: id, _token: token },
                    function (response) {
                        if (response && response.message == "trashed") {
                            location.reload();
                        } else {
                            swal({
                                text: response.message,
                                icon: "warning"
                            })
                        }
                    }
                );
            }
        });
    });

    $(".revert-item").click(function () {
        var elm = $(this);
        var id = elm.attr("data-id");
        $.post(
            base_url + "/admin/posts/item/revert",
            { post_id: id, _token: token },
            function (response) {
                if (response && response.message == "reverted") {
                    location.reload();
                }
            }
        );
    });

    $(".hard-delete").click(function () {
        swal({
            title: lang.are_you_sure,
            text: lang.hard_delete_message,
            icon: "warning",
            buttons: [lang.cancel, lang.confirm],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var elm = $(this);
                var id = elm.attr("data-id");
                $.post(
                    base_url + "/admin/posts/item/delete",
                    { post_id: id, _token: token },
                    function (response) {
                        if (response && response.message == "deleted") {
                            location.reload();
                        }
                    }
                );
            }
        });
    });

    $("#customControlInline").change(function () {
        var elm = $(this);
        if (elm.is(":checked")) {
            $(".bulk-checkbox").prop("checked", true);
        } else {
            $(".bulk-checkbox").prop("checked", false);
        }
    });

    $(".bulk-checkbox-group").change(function () {
        var elm = $(this);
        var checked = [];
        $(this).parents('table').find(".bulk-checkbox").each(function (i, item) {
            if ($(item).is(":checked")) {
                checked.push($(item).attr("data-id"));
            }
        });
        if (checked.length > 0) {
            $(".bulk-actions-tools").removeClass("d-none");
            $(".bulk-delete-button").click(function () {
                var section = $(this).attr('data-section');
                swal({
                    title: lang.are_you_sure,
                    text: lang.bulk_delete_message,
                    icon: "warning",
                    buttons: [lang.cancel, lang.confirm],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.post(
                            base_url + "/admin/" + section + "/item/trash",
                            { id: checked, _token: token },
                            function (response) {
                                if (response && response.message == "trashed") {
                                    location.reload();
                                }
                            }
                        );
                    }
                });
            });
        } else {
            $(".bulk-actions-tools").addClass("d-none");
        }
    });
    $(".datetime").datetimepicker({
        format: "YYYY-MM-DD H:mm",
    });

    $(".tagsinput").tagsinput({
        tagClass: "badge-info",
    });

    $('.posttype-item').click(function () {
        var elm = $(this)
        $('.posttype-item').removeClass('active');
        elm.addClass('active');
    })

    $('.add-post-button').click(function () {
        var elm = $(this);
        var type = $('.posttype-item.active').attr('data-id');
        var lang = $('.language-select').val();
        var href = elm.attr('data-href') + "?type=" + type + "&lang=" + lang;
        location.href = href;
    })
    $(function () {
        $('#featured_image').change(function () {
            alert("test")
        })
        if(typeof categories != 'undefined'){
            init_category_tree(categories);
        }
    })
    function init_category_tree(categories) {
        if ($('.category-nested').length > 0) {
            if (categories != '[]') {
                $('.category-nested').html('<ul>' + category_tree(categories[lang_id]) + '</ul>');
            } else {
                $('.category-nested').html('<div class="category-no-result text-center mt-4"><img src="' + base_url + '/assets/admin/not-result.jpg" class="category-not-result" width="200" alt=""></div>');
            }
        }
        $('.category-nested-input').change(function () {
            var elm = $(this);
            var parent = elm.attr("data-parent");
            if (elm.is(':checked')) {
                category_parent_checker(parent);
            } else {
                category_parent_unchecker(elm)
            }
        })
    }
    function category_tree(categories) {
        var html = '';
        $.each(categories, function (i, item) {
            var checked = '';
            $.each(selected_categories, function (a, atem) {
                if (atem == item.uniq_id) {
                    checked = 'checked';
                }
            })
            html += '<li class="category-nested-parent-' + item.id +
                '"><div class="custom-control custom-checkbox"><input class="custom-control-input category-nested-input" ' +
                checked + ' type="checkbox" id="category-checklist-' + item.id + '" value="' + item.uniq_id +
                '" data-parent="' + item.parent + '" name="categories[]"><label for="category-checklist-' + item
                    .id + '" class="custom-control-label">' + item.category_title + '</label></div></li>';
            if (item.subs) {
                html += '<ul class="category-nested-ul category-nested-subs-' + item.uniq_id + '" data-parent="' +
                    item.id + '">' + category_tree(item.subs) + '</ul>';
            }
        })
        return html;
    }

    function category_parent_checker(parent_id) {
        var parent = $(".category-nested-input[value|='" + parent_id + "']");
        parent.prop("checked", true);
        if (parent.attr("data-parent") != 0) {
            category_parent_checker(parent.attr("data-parent"))
        }
    }

    function category_parent_unchecker(elm) {
        elm.parents(".category-nested-ul").find("input").prop("checked", false);
        if (elm.attr("data-parent") == 0) {
            elm.parent().parent().next().find("input").prop("checked", false);
        }
    }
    $(document).ready(function () {
        $('.add-category-input').click(function () {
            var elm = $(this);
            var category = elm.parents('.input-group').find('.category-name').val();
            if (category) {
                var slug = string_to_slug(category);
                var data = { category_title: category, meta_title: category, parent: '', category_description: '', meta_description: '', slug: slug, _token: token, response: true };
                $.post(
                    base_url + "/admin/categories/item/save",
                    data,
                    function (response) {
                        $('.category-nested').html('re');
                        elm.parents('.input-group').find('.category-name').val('');
                        init_category_tree(response);
                        swal("Kategori Eklendi", '', "success");
                    }
                );
            }
        })
    })
});
function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, "");
    str = str.toLowerCase();

    var from = "àáäâèéëêìíïîòóöôùúüûñçşğüıöİ·/_,:;";
    var to = "aaaaeeeeiiiioooouuuuncsguioi------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }

    str = str
        .replace(/[^a-z0-9 -]/g, "")
        .replace(/\s+/g, "-")
        .replace(/-+/g, "-");

    return str;
}

function confirmswal(message) {
    swal({
        title: lang.are_you_sure,
        text: message,
        icon: "warning",
        buttons: [lang.cancel, lang.confirm],
        dangerMode: true,
    }).then((willDelete) => {
        return true;
    });
}
