(function ($) {
    $(function () {
        var $form = $('form');
        var submitting = false;
        var isSubmitButtonClicked = false;

        $('button[type="submit"]:not([name="btn_preview"])', $form)
            .click(function (event) {
                isSubmitButtonClicked = true
            });

        $form.submit(function (event) {
            if (isSubmitButtonClicked && submitting) {
                return false;
            }
            submitting = true;
        })
    });
})(jQuery);
