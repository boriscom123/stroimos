CKEDITOR.plugins.add( 'keystrokes', {
        init: function( editor ) {
            editor.addCommand( 'cs_1', {
                exec: function( editor ) {
                    var format = { name: 'Ссылка-маркер', element: 'a', attributes: { 'class': 'marked-link' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                    var selectedText = editor.getSelection().getNative();
                }
            } );
            editor.addCommand( 'cs_2', {
                exec: function( editor ) {
                    var format = { name: 'Без подчёркивания', element: 'a', attributes: { 'class': 'without-underline' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                }
            } );
            editor.addCommand( 'cs_3', {
                exec: function( editor ) {
                    var format = { name: 'Синяя рамка', element: 'p', attributes: { 'class': 'blue-frame-block' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                }
            } );
            editor.addCommand( 'cs_4', {
                exec: function( editor ) {
                    var format = { name: 'Рубрика вопрос–ответ', element: 'p', attributes: { 'class': 'faq-table-title' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                }
            } );
            editor.addCommand( 'cs_5', {
                exec: function( editor ) {
                    var format = { name: 'Верт. с заголовком', element: 'ul', attributes: { 'class': 'vertical-titled-list' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                }
            } );
            editor.addCommand( 'cs_6', {
                exec: function( editor ) {
                    var format = { name: 'С заголовком', element: 'ul', attributes: { 'class': 'titled-list' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                }
            } );
            editor.addCommand( 'cs_7', {
                exec: function( editor ) {
                    var format = { name: '1 колонка', element: 'ul', attributes: { 'class': 'list-columns list-columns_columns_1' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                }
            } );
            editor.addCommand( 'cs_8', {
                exec: function( editor ) {
                    var format = { name: 'Крупный подзаголовок', element: 'p', attributes: { 'class': 'lava-subtitle' } };
                    var style = new CKEDITOR.style(format);
                    style.apply(editor.document);
                }
            } );
            
            editor.setKeystroke( CKEDITOR.ALT + 32 /*SPACE*/, 'removeFormat' ); // ALT + SPACE

            editor.setKeystroke( CKEDITOR.ALT + 49 , 'cs_1' ); // ALT + 1
            editor.setKeystroke( CKEDITOR.ALT + 50 , 'cs_2' ); // ALT + 2
            editor.setKeystroke( CKEDITOR.ALT + 51 , 'cs_3' ); // ALT + 3
            editor.setKeystroke( CKEDITOR.ALT + 52 , 'cs_4' ); // ALT + 4
            editor.setKeystroke( CKEDITOR.ALT + 53 , 'cs_5' ); // ALT + 5
            editor.setKeystroke( CKEDITOR.ALT + 54 , 'cs_6' ); // ALT + 6
            editor.setKeystroke( CKEDITOR.ALT + 55 , 'cs_7' ); // ALT + 7
            editor.setKeystroke( CKEDITOR.ALT + 56 , 'cs_8' ); // ALT + 7

            editor.setKeystroke( CKEDITOR.ALT + 76 /*L*/, 'link' );
            editor.setKeystroke( CKEDITOR.ALT + CKEDITOR.SHIFT + 76 /*L*/, 'unlink' );

            editor.setKeystroke( CKEDITOR.ALT + 89 /*Y*/, 'youtube' );
            editor.setKeystroke( CKEDITOR.ALT + 66 /*B*/, 'insertBanner' );
            editor.setKeystroke( CKEDITOR.ALT + 71 /*G*/, 'insertGallery' );
            editor.setKeystroke( CKEDITOR.ALT + 73 /*I*/, 'image' );
            editor.setKeystroke( CKEDITOR.ALT + 80 /*P*/, 'photo_lenta_grid' );
            editor.setKeystroke( CKEDITOR.ALT + 82 /*P*/, 'twenty_twenty' );
            editor.setKeystroke( CKEDITOR.ALT + 81 /*Q*/, 'insertQuote' );
            
            editor.setKeystroke( CKEDITOR.ALT + 77 /*M*/, 'bulletedlist' );
            editor.setKeystroke( CKEDITOR.ALT + 78 /*N*/, 'numberedlist' );

            editor.setKeystroke( CKEDITOR.ALT + 70 /*F*/, 'insertFaqBlock' );
            editor.setKeystroke( CKEDITOR.ALT + 65 /*A*/, 'insertInfographics' );
            editor.setKeystroke( CKEDITOR.ALT + 83 /*S*/, 'customSource');
        }
    });
