CKEDITOR.plugins.add('quote', {
    init: function (editor) {
        var iconPath = this.path + 'images/icon.png';
        var funcRef = CKEDITOR.tools.addFunction(function (params) {
            var item = editor.document.createElement('p');
            item.setAttribute('data-embedded-type', 'quote');
            item.setAttribute('data-embedded-parameters', params.id);
            item.setAttribute('width', '100%');
            item.setAttribute('contenteditable', 'false');
            item.setAttribute('style', 'padding: 5px; border: 2px dashed #ccc; background: #ececec;');
            item.setHtml('<img src="'+ params.image +'" height="200px" contenteditable="false" /><br> Цитата: ' + params.title);
            editor.insertElement(item);
        });

        editor.addCommand('insertQuote', {
            exec: function (editor) {
                var prefix = '';
                if (/^http.*\/app_dev.php.*$/g.test(window.location.href)) {
                    prefix = '/app_dev.php';
                }
                newWin = window.open(prefix + '/admin/app/embeddedcontent-quote/browse?CKEditorFuncType=image&CKEditorFuncNum=' + funcRef, undefined, 'width=1200,height=400,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
            }
        });

        editor.ui.addButton('Quote',
            {
                label: 'Вставить цитату',
                command: 'insertQuote',
                icon: iconPath
            }
        );


        var iconPath1 = this.path + 'images/faq-icon.png';
        var funcRef1 = CKEDITOR.tools.addFunction(function (params) {
            var item = editor.document.createElement('p');
            item.setAttribute('data-embedded-type', 'Faq\\FaqBlock');
            item.setAttribute('data-embedded-parameters', params.id);
            item.setAttribute('width', '100%');
            item.setAttribute('contenteditable', 'false');
            item.setAttribute('style', 'padding: 5px; border: 2px dashed #ccc; background: #ececec;');
            item.setHtml('Блок вопрос ответ: ' + params.title);
            editor.insertElement(item);
        });

        editor.addCommand('insertFaqBlock', {
            exec: function (editor) {
                var prefix = '';
                if (/^http.*\/app_dev.php.*$/g.test(window.location.href)) {
                    prefix = '/app_dev.php';
                }
                newWin = window.open(prefix + '/admin/app/embeddedcontent-faq-faqblock/browse?CKEditorFuncType=image&CKEditorFuncNum=' + funcRef1, undefined, 'width=1200,height=400,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
            }
        });

        editor.addCommand('customSource', {
            exec: function (editor) {
                editor.commands.source.exec(editor);
                if (editor.mode === 'source') {
                    editor.focus();
                }
            },
            modes: {
                wysiwyg:1,
                source:1
            }
        });

        editor.ui.addButton('FaqBlock',
            {
                label: 'Вставить блок FAQ',
                command: 'insertFaqBlock',
                icon: iconPath1
            }
        );

    }
});

