jQuery(function($) {
    $(document).on('pjax:complete', function() {
        $(".field").val("");
        $('#my-captcha-image').yiiCaptcha('refresh');
    });
});