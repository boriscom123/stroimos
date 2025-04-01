(function ($) {

    $(document).ready(function() {
        var buttons = $('button[role="copier-content-button"]').click(function (event) {
            event.stopPropagation();
            var copyFromInstanceId = $('textarea[id$="' + $(this).data('copyFrom')+ '"]:first')
                ? $('textarea[id$="' + $(this).data('copyFrom')+ '"]:first').attr('id')
                : null;
            var copyToInstanceId = $('textarea[id$="' + $(this).data('copyTo') + '"]:first')
                ? $('textarea[id$="' + $(this).data('copyTo')+ '"]:first').attr('id')
                : null;

            if (!copyFromInstanceId) {
                throw new Error('Provider data elemt not found');
            }
            var ckeditorFromInstance = CKEDITOR.instances[copyFromInstanceId];
            if (!ckeditorFromInstance) {
                throw new Error('ckeditor instance not found');
            }

            if (!copyToInstanceId) {
                throw new Error('Data destination elemnt not found');
            }
            var ckeditorToInstance = CKEDITOR.instances[copyToInstanceId];
            if (!ckeditorToInstance) {
                throw new Error('ckeditor instance not found');
            }

            var label = $('label[for="' + copyToInstanceId + '"]:first');
            var canCopy = !ckeditorToInstance.getData()
                || (
                    ckeditorToInstance.getData()
                    && label
                    && confirm('Поле "' + label[0].innerText + '" уже имеет значение. Продолжить?')
                );

            if (canCopy) {
                ckeditorToInstance.setData(ckeditorFromInstance.getData());
            }

            return false;
        });

    });
})
(jQuery)