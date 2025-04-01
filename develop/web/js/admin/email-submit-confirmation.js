(function ($) {
    $(function () {
        $( "table" ).on( "click", "a[role='btn_send']", function(event) {
            if (!confirm('Вы уверены что хотите отправить почтовую рассылку?')) {
                event.preventDefault();
                event.stopPropagation();
                return false
            }
        });
    });
})(jQuery);
