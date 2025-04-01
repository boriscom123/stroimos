(function ($) {
    $(function () {
        $('form').on('form-pre-serialize', function (form, options, veto) {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });
    });
})
(jQuery)