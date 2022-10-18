"use strict"
$(function () {
  var breaking = new Swiper(".breakings", {
    pagination: {
      el: ".swiper-pagination",
    },
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".bread-next",
      prevEl: ".bread-prev",
    },
  });

  var banner = new Swiper(".main-banners", {
    loop: true,
    lazy: true,
    pagination: {
      el: ".banner-pagination",
      clickable: true,
    },
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
  });
  $('.lazy').lazy();
  $('.collapse-search').click(function () {
    $('.search-area').css({ "width": "auto", "opacity": "1" });
    $('.search-area').find('input').focusin(function () {
      $(this).on('keyup', function (e) {
        if (e.key == "Enter") {
          // Submit
        }
        if (e.key == "Escape") {
          $('.search-area').css({ "width": "0", "opacity": "0" })
        }
      });
    });
  })

  $('.uncollapse-search').click(function () {
    $('.search-area').css({ "width": "0", "opacity": "0" })
  })
  $('.run-dark-mode-toggle').change(function () {
    var elm = $(this);
    var url = elm.attr('data-change');
    if ($('body').hasClass('dark-mode')) {
      $('body').removeClass('dark-mode')
      $('.logo').each(function () {
        $(this).find('img').attr('src', $(this).find('img').attr('data-light'));
      })
    } else {
      $('body').addClass('dark-mode')
      $('.logo').each(function () {
        $(this).find('img').attr('src', $(this).find('img').attr('data-dark'));
      })
    }
    $.get(url)
  })
  $(document).ready(function () {
    $('.preloader').remove();
    $(window).scroll(function () {
      if ($(this).scrollTop() > 50) {
        $('#back-to-top').fadeIn();
      } else {
        $('#back-to-top').fadeOut();
      }
    });
    $('#back-to-top').click(function () {
      $('#back-to-top').tooltip('hide');
      $('body,html').animate({
        scrollTop: 0
      }, 800);
      return false;
    });

    setTimeout(function () {
      $('.cookie-alert').css('bottom', 0)
    }, 3000)
    setTimeout(function () {
      if ($('#newsletter-modal').length > 0) {
        $('#newsletter-modal').modal('show');
      }
    }, 2000)
    $('.mm-tab-content>a').hover(function () {
      var elm = $(this);
      var category_id = elm.attr('data-id');
      var current_id = elm.parents('.megamenu').find('.sbanners').attr('data-category');
      if (category_id == current_id) {
        return false;
      }
      elm.parents('.megamenu').find('.sbanners').attr('data-category', category_id)
      elm.parent().find('a').removeClass('active');
      elm.parent().find('a').addClass('disabled');
      elm.addClass('active')
      elm.parents('.megamenu').find('.sbanners').html('Loading');
      var url = base_url + "/dynamic/category-post/" + category_id
      $.get(url, function (response) {
        elm.parents('.megamenu').find('.sbanners').html(response);
        $('.lazy').lazy();
        setTimeout(function () {
          elm.parent().find('a').removeClass('disabled');
        }, 500)
      })
    })
    $('.mm-megamenu').hover(function () {
      var elm1 = $(this);
      var elm = elm1.parent().find('.mm-tab-content').find('a').first();
      var category_id = elm.attr('data-id');
      var current_id = elm.parents('.megamenu').find('.sbanners').attr('data-category');
      if (category_id == current_id) {
        return false;
      }
      elm.parents('.megamenu').find('.sbanners').attr('data-category', category_id)
      elm.parent().find('a').removeClass('active');
      elm.parent().find('a').addClass('disabled');
      elm.addClass('active')
      elm.parents('.megamenu').find('.sbanners').html('');
      elm.parents('.megamenu').find('.sbanners').addClass('loading-panel')
      var url = base_url + "/dynamic/category-post/" + category_id
      $.get(url, function (response) {
        elm.parents('.megamenu').find('.sbanners').removeClass('loading-panel')
        elm.parents('.megamenu').find('.sbanners').html(response);
        $('.lazy').lazy();
        setTimeout(function () {
          elm.parent().find('a').removeClass('disabled');
        }, 500)
      })
    })
    $('.collapse-search').click(function () {
      $('.search-wrapper').toggleClass('active')
    })
  })
  $('.accept-cookie').click(function () {
    $.get(base_url + "/accept-cookie", function () {
      $('.cookie-alert').css('bottom', '-300px')
    })
  })
  $('.close-newsletter').click(function () {
    $.get(base_url + "/close-newsletter", function () {
      $('#newsletter-modal').modal('hide')
    })
  })
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
  $("[data-toggle='ahtoogler']").click(function () {
    var elm = $(this);
    var target = elm.attr("data-target");
    var change = elm.attr("data-change");
    console.log(target, change);
    $(target).toggleClass(change);
  })
  $('.dynamic-button').click(function (e) {
    e.preventDefault();
    var elm = $(this);
    var url = elm.attr('href');
    $.get(url, function (response) {
      if (response && response.status == 200) {
        if (response.message == 'added') {
          elm.removeClass('btn-dark')
          elm.addClass('btn-success')
          elm.html('<i class="fa fa-check"></i>');
        } else {
          elm.removeClass('btn-success')
          elm.addClass('btn-dark')
          elm.html('<i class="far fa-star"></i>');
        }
      }
    }).fail(function () {
      window.location = elm.attr('data-href')
    })
  })
  $("[data-toggle='clicker']").click(function () {
    var elm = $(this);
    var target = elm.attr("data-target");
    $(target).click()
  });
  $(document).on("submit", "#login-form", function () {
    var e = this;
    $(this).find("[type='submit']").prop('disabled', true);

    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      if (data.status && data.status == 200) {
        $(e).find('.error-handler').html('<div class="alert alert-success">' + data.message + '</div>');
        setTimeout(function () {
          window.location = data.redirect
        }, 2000)
      } else {
        $(e).find("[type='submit']").prop('disabled', false);
        $(e).find('.error-handler').html('<div class="alert alert-danger">' + data.message + '</div>');
      }
    }).fail(function (response) {
      $(e).find("[type='submit']").prop('disabled', false);
      $(e).find('.error-handler').html('<div class="alert alert-danger">' + response.responseJSON.message + '</div>');
    });
    return false;
  });
  $(document).on("submit", "#login-page-form", function () {
    var e = this;
    $(this).find("[type='submit']").prop('disabled', true);

    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      if (data.status && data.status == 200) {
        $(e).find('.error-handler').html('<div class="alert alert-success">' + data.message + '</div>');
        setTimeout(function () {
          window.location = data.redirect
        }, 2000)
      } else {
        $(e).find("[type='submit']").prop('disabled', false);
        $(e).find('.error-handler').html('<div class="alert alert-danger">' + data.message + '</div>');
      }
    }).fail(function (response) {
      $(e).find("[type='submit']").prop('disabled', false);
      $(e).find('.error-handler').html('<div class="alert alert-danger">' + response.responseJSON.message + '</div>');
    });
    return false;
  });
  $(document).on("submit", "#register-form", function () {
    var e = this;
    $(this).find("[type='submit']").prop('disabled', true);

    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      if (data.status && data.status == 200) {
        $(e).find('.error-handler').html('<div class="alert alert-success">' + data.message + '</div>');
        if (data.redirect) {
          setTimeout(function () {
            window.location = data.redirect
          }, 2000)
        }
      } else {
        $(e).find("[type='submit']").prop('disabled', false);
        $(e).find('.error-handler').html('<div class="alert alert-danger">' + data.message + '</div>');
      }
    }).fail(function (response) {
      $(e).find("[type='submit']").prop('disabled', false);
      $(e).find('.error-handler').html('<div class="alert alert-danger">' + response.responseJSON.message + '</div>');
    });
    return false;
  });

  $(document).on("submit", "#reset-form", function () {
    var e = this;
    $(this).find("[type='submit']").prop('disabled', true);

    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      if (data.status && data.status == 200) {
        $(e).find('.error-handler').html('<div class="alert alert-success">' + data.message + '</div>');
        if (data.redirect) {
          setTimeout(function () {
            window.location = data.redirect
          }, 2000)
        }
      } else {
        $(e).find("[type='submit']").prop('disabled', false);
        $(e).find('.error-handler').html('<div class="alert alert-danger">' + data.message + '</div>');
      }
    }).fail(function (response) {
      $(e).find("[type='submit']").prop('disabled', false);
      $(e).find('.error-handler').html('<div class="alert alert-danger">' + response.responseJSON.message + '</div>');
    });
    return false;
  });

  $(document).on("submit", "#resetting-form", function () {
    var e = this;
    $(this).find("[type='submit']").prop('disabled', true);

    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      if (data.status && data.status == 200) {
        $(e).find('.error-handler').html('<div class="alert alert-success">' + data.message + '</div>');
        if (data.redirect) {
          setTimeout(function () {
            window.location = data.redirect
          }, 2000)
        }
      } else {
        $(e).find("[type='submit']").prop('disabled', false);
        $(e).find('.error-handler').html('<div class="alert alert-danger">' + data.message + '</div>');
      }
    }).fail(function (response) {
      $(e).find("[type='submit']").prop('disabled', false);
      $(e).find('.error-handler').html('<div class="alert alert-danger">' + response.responseJSON.message + '</div>');
    });
    return false;
  });
  $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
    console.log($(event.target).attr('id'));
    if ($(event.target).attr('id') == 'forgot-password-tab') {
      $('.login-modal-footer').addClass('d-none')
    } else {
      $('.login-modal-footer').removeClass('d-none')

    }
  })
  $('.reaction-item').click(function () {
    var elm = $(this);
    var count = elm.find('.reaction-item-img').attr('data-count');
    count = parseInt(count);
    var reaction = elm.attr('data-reaction');
    var post = elm.parent().attr('data-id');
    var data = { post_id: post, reaction: reaction, _token: token };
    elm.parents('.reactions-container').find('.alert').addClass('d-none');
    $.post(base_url + "/dynamic/reaction", data, function (response) {
      console.log(response);
      if (response.message == 'added') {
        elm.find('.reaction-item-img').attr('data-count', count + 1);
        elm.find('.reaction-item-img').addClass('reitem-1');
        elm.find('.reaction-item-img').removeClass('reitem-0');
      } else if (response.message == 'removed') {
        elm.find('.reaction-item-img').attr('data-count', count - 1);
        if (elm.find('.reaction-item-img').attr('data-count') == 0) {
          elm.find('.reaction-item-img').removeClass('reitem-1');
          elm.find('.reaction-item-img').addClass('reitem-0');
        }
      } else if (response.message == 'already_voted') {
        elm.parents('.reactions-container').find('.alert').removeClass('d-none');
        if (elm.find('.reaction-item-img').attr('data-count') == 0) {
          elm.find('.reaction-item-img').removeClass('reitem-1');
          elm.find('.reaction-item-img').addClass('reitem-0');

        }
      }
    })
  })

  $('#newsletter-email').keyup(function () {
    var elm = $(this);
    $('.newsletter-recaptcha').removeClass('d-none')
  })
  $('#newsletter-email-modal').keyup(function () {
    var elm = $(this);
    $('.newsletter-recaptcha-modal').removeClass('d-none')
  })
  $('.back-newsletter, .modal-newsletter').submit(function () {
    var elm = $(this);
    var datastring = elm.serialize();
    $.ajax({
      type: "POST",
      url: elm.attr('action'),
      data: datastring,
      dataType: "json",
      success: function (data) {
        console.log(data)
        elm.find('.newsletter_form_response').text(data.message)
      },
      error: function (data) {
        elm.find('.newsletter_form_response').text(data.message)
      }
    });
    return false;
  })

  $(document).on("submit", "#add-comment", function () {
    var e = this;
    $(this).find("[type='submit']").prop('disabled', true);

    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      if (data.status && data.status == 200) {
        $(e).find('.error-handler').html('<div class="alert alert-success">' + data.message + '</div>');
      } else {
        $(e).find("[type='submit']").prop('disabled', false);
        $(e).find('.error-handler').html('<div class="alert alert-danger">' + data.message + '</div>');
      }
    }).fail(function (response) {
      $(e).find("[type='submit']").prop('disabled', false);
      $(e).find('.error-handler').html('<div class="alert alert-danger">' + response.responseJSON.message + '</div>');
    });
    return false;
  });

  $(document).on("submit", "#send-message", function () {
    var e = this;
    $(this).find("[type='submit']").prop('disabled', true);

    $.post($(this).attr('action'), $(this).serialize(), function (data) {
      if (data.status && data.status == 200) {
        $(e).find('.error-handler').html('<div class="alert alert-success">' + data.message + '</div>');
      } else {
        $(e).find("[type='submit']").prop('disabled', false);
        $(e).find('.error-handler').html('<div class="alert alert-danger">' + data.message + '</div>');
      }
    }).fail(function (response) {
      $(e).find("[type='submit']").prop('disabled', false);
      $(e).find('.error-handler').html('<div class="alert alert-danger">' + response.responseJSON.message + '</div>');
    });
    return false;
  });
});
