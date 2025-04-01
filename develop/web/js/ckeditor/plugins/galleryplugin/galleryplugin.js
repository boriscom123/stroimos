CKEDITOR.plugins.add( 'galleryplugin', {
        init: function(editor) {
            var iconPath = this.path + 'images/icon.png';
            var funcRef = CKEDITOR.tools.addFunction( function(params) {
                var gallery = editor.document.createElement( 'p' );
                gallery.setAttribute('data-embedded-type', 'gallery');
                gallery.setAttribute('data-embedded-parameters', params.id);
                gallery.setAttribute('width', '100%');
                gallery.setAttribute('contenteditable', 'false');
                gallery.setHtml('<img src="'+ params.image +'" width="100%" contenteditable="false" /><br> Галерея: ' + params.title);
                editor.insertElement(gallery);
            } );

            editor.addCommand( 'insertGallery', {
                exec: function( editor) {
                    var prefix = '';
                    if (/^http.*\/app_dev.php.*$/g.test(window.location.href)) {
                        prefix = '/app_dev.php';
                    }
                    newWin = window.open(prefix + '/admin/app/gallery/browse?CKEditorFuncType=image&CKEditorFuncNum=' + funcRef, undefined, 'width=1200,height=400,menubar=no,toolbar=no,resizable=yes,scrollbars=yes');
                }
            });

            editor.ui.addButton( 'Gallery',
                {
                    label: 'Вставить галерею',
                    command: 'insertGallery',
                    icon: iconPath
                }
            );
        }
    } );