CKEDITOR.plugins.add('contactpersonlink', {
    icons: 'contactpersonlink',
    init: function (editor) {
        var selectedText = '';

        var funcRef = CKEDITOR.tools.addFunction(function (data) {
            var link = editor.document.createElement('a'),
                text = data.text;

            if (selectedText) {
                text = selectedText;
                selectedText = '';
            }

            link.setAttribute('href', data.url);
            link.setAttribute('class', 'personalitiy-link');
            link.setText(text);

            editor.insertElement(link);
        });

        editor.addCommand('commandContactPersonLink', {
            exec: function () {
                var selection = editor.getSelection();
                if (
                    selection.getType() == CKEDITOR.SELECTION_TEXT &&
                    selection.getSelectedText().length > 0
                ) {
                    selectedText = selection.getSelectedText();
                    selection.getRanges()[0].deleteContents();
                    selection.getRanges()[0].select();
                }

                window.open('/admin/app/contactperson/browse?CKEditorFuncNum=' + funcRef, undefined, 'width=1200,height=800,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
            }
        });

        editor.ui.addButton('ContactPersonLink',
            {
                label: 'Вставить ссылку на Персону',
                command: 'commandContactPersonLink',
                toolbar: 'links,1'
            }
        );
    }
});