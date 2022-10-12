$(document).ready(function () {
    $('.check-db').click(function () {
        var hostname = $('#db_host').val();
        var db_name = $('#db_name').val();
        var db_username = $('#db_username').val();
        var db_password = $('#db_password').val();
        if (!hostname || !db_name || !db_username || !db_password) {
            alert('Veritabanı ayarlarınızı eksiksiz tamamlayıp tekrar deneyin.');
            return false;
        }
        $('.db-error').html('')
        var data = { 'db_host': hostname, 'db_name': db_name, 'db_username': db_username, 'db_password': db_password, 'db_test': true };
        $.post('', data, function (response) {
            if (response != 'connected') {
                $('.db-error').html('<div class="alert alert-danger">' + response + '</div>');
            } else {
                $('.headingFour').prop('disabled', false);
                $('.headingFour').click();
                $('.db-error').html('<div class="alert alert-success">Bağlantı başarılı!</div>');
            }
        })
    })

    $('.completed').click(function () {
        var elm = $(this);
        elm.prop('disabled', true);
        $('.setting-error').html('<div class="alert alert-warning">Kurulum başladı. Lütfen sayfayı kapatmadan kurulumun tamamlanmasını bekleyin...</div>');
        var hostname = $('#db_host').val();
        var db_name = $('#db_name').val();
        var db_username = $('#db_username').val();
        var db_password = $('#db_password').val();
        var app_name = $('#app_name').val();
        var protocol = $('#protocol').val();
        var site_url = $('#site_url').val();
        var license_code = $('#license_code').val();
        if (!hostname || !db_name || !db_username || !db_password || !license_code) {
            $('.setting-error').html('');
            alert('Veritabanı ayarlarınızı eksiksiz tamamlayıp tekrar deneyin.');
            return false;
        }
        $('.form-control').prop('disabled', true);
        var data = { 'db_host': hostname, 'db_name': db_name, 'db_username': db_username, 'db_password': db_password, 'completed': true, 'app_name': app_name, 'protocol': protocol, 'site_url': site_url, 'license_code': license_code };
        $.post('', data, function (response) {
            console.log(response);
            if (response == 'success') {
                $('.gotosite').attr('href', protocol + site_url)
                $('.headingFive').prop('disabled', false);
                $('.headingFive').click();
                $('.btn-block').prop('disabled', true);
            } else {
                $('.form-control').prop('disabled', false);
                $('.btn-block').prop('disabled', false);
                $('.setting-error').html('<div class="alert alert-danger">' + response + '</div>');
            }
        })
    })

    $('.next').click(function () {
        var elm = $(this);
        var target = elm.attr('data-target');
        $(target).prop('disabled', false);
        $(target).click();
    })
});
