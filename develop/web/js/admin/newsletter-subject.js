(function($){

    $(function() {
        $('select[name*="highlight"]:first').on('change', function (e) {
            $('input[name*="subject"]:first').val(e.added.text);
        });
    })

})(jQuery);