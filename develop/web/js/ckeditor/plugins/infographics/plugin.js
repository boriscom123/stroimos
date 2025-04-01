CKEDITOR.plugins.add('infographics', {
    init: function (editor) {
        console.log('infographics init')
        var iconPath = this.path + 'images/icon.png';
        var funcRef = CKEDITOR.tools.addFunction(function (params) {
            var item = editor.document.createElement('p');
            item.setAttribute('data-embedded-type', 'infographics');
            item.setAttribute('data-embedded-parameters', params.id);
            item.setAttribute('width', '100%');
            item.setAttribute('contenteditable', 'false');
            item.setAttribute('style', 'padding: 5px; border: 2px dashed #ccc; background: #ececec;');
            item.setHtml('Инфографика: ' + params.title);
            editor.insertElement(item);
        });

        editor.addCommand('insertInfographics', {
            exec: function (editors) {
                var prefix = '';
                if (/^http.*\/app_dev.php.*$/g.test(window.location.href)) {
                    prefix = '/app_dev.php';
                }
                newWin = window.open(prefix + '/admin/app/infographics/browse?CKEditorFuncType=image&CKEditorFuncNum=' + funcRef, undefined, 'width=1200,height=400,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
            }
        });

        editor.ui.addButton('Infographics',
            {
                label: 'Вставить инфографику',
                command: 'insertInfographics',
                icon: iconPath
            }
        );
    }
});

