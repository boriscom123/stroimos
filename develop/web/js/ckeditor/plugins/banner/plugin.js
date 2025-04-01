CKEDITOR.plugins.add('banner', {
    init: function (editor) {
        var iconPath = this.path + 'images/icon.png';
        var funcRef = CKEDITOR.tools.addFunction(function (params) {
            var banner = editor.document.createElement('p');
            banner.setAttribute('data-embedded-type', 'banner');
            banner.setAttribute('data-embedded-parameters', params.id);
            banner.setAttribute('width', '100%');
            banner.setAttribute('contenteditable', 'false');
            banner.setAttribute('style', 'padding: 5px; border: 2px dashed #ccc; background: #ececec;');
            banner.setHtml('<img src="'+ params.image +'" height="200px" contenteditable="false" /><br> Баннер: ' + params.title);
            editor.insertElement(banner);
        });

        editor.addCommand('insertBanner', {
            exec: function (editor) {
                var prefix = '';
                if (/^http.*\/app_dev.php.*$/g.test(window.location.href)) {
                    prefix = '/app_dev.php';
                }
                newWin = window.open(prefix + '/admin/app/embeddedcontent-banner/browse?CKEditorFuncType=image&CKEditorFuncNum=' + funcRef, undefined, 'width=1200,height=400,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
            }
        });

        editor.ui.addButton('Banner',
            {
                label: 'Вставить баннер',
                command: 'insertBanner',
                icon: iconPath
            }
        );
    }
});
