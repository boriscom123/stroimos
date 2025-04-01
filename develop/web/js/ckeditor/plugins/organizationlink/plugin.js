CKEDITOR.on('dialogDefinition', function ( ev ){
    if(ev.data.name == 'link'){
        ev.data.definition.getContents('target').get('linkTargetType')['default']='_blank';
    }
});
CKEDITOR.plugins.add('organizationlink', {
    icons: 'organizationlink',
    init: function (editor) {
        var funcRef = CKEDITOR.tools.addFunction(function (data) {
            var link = editor.document.createElement('a'),
                text = data.text;

            var selection = editor.getSelection();
            if (
                selection.getType() == CKEDITOR.SELECTION_TEXT &&
                selection.getSelectedText().length > 0
            ) {
                text = selection.getSelectedText();
            }

            link.setAttribute('href', data.url);
            link.setAttribute('class', 'organization-link');
            link.setText(text);

            editor.insertElement(link);
        });

        editor.addCommand('commandOrganizationLink', {
            exec: function (/*editor*/) {
                window.open('/admin/app/organization/browse?CKEditorFuncNum=' + funcRef, undefined, 'width=1200,height=800,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
            }
        });

        editor.ui.addButton('OrganizationLink', {
            label: 'Вставить ссылку на Организацию',
            command: 'commandOrganizationLink',
            toolbar: 'links,1'
        });
    }
});
