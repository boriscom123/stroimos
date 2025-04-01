( function() {
CKEDITOR.plugins.add( 'twenty_twenty', {

	getPhotoLentaGridDialogCss : function()
	{
		return '' +
            '.container__pull-left {' +
                'width: 532px;' +
            '}' +
            '.twenty_twenty__list {' +
                'margin: 0;' +
                'padding: 0;' +
                'border: 0;' +
                'overflow: hidden;' +
                'line-height: 0;' +
            '}' +
            '.twenty_twenty__list[data-columns]:before {' +
                'content: "2 .column.size-1of2";' +
            '}' +
            '[data-columns]::before {' +
                'visibility: hidden;' +
                'position: absolute;' +
                'font-size: 1px;' +
            '}' +
            '.size-1of2:nth-child(odd) {' +
                'margin-right: 20px;' +
            '}' +
            '.size-1of2 {' +
                'width: 470px;' +
            '}' +
            '.column {' +
                'float: left' +
            '}' +
            '.twenty_twenty__list-item {' +
                'float: left;' +
                'width: 50%;' +
                'list-style: none;' +
                'margin-bottom: 0px;' +
            '}' +
            'a:link {' +
                'outline: none;' +
            '}' +
            '.twenty_twenty__list-item img {' +
                'width: 100%;' +
                'height: 100%;' +
                'outline: none !important;' +
                'padding: 0;' +
                'margin: 0;' +
            '}'
        ;
	},

	icons: 'icon',
	
	onLoad : function(editor)
	{
	},

	init: function( editor ) {
        CKEDITOR.addCss(this.getPhotoLentaGridDialogCss());

        var iconPath = this.path + 'icons/icon.png';

		editor.addCommand( 'twenty_twenty', new CKEDITOR.dialogCommand('twentyTwentyGridDialog', {

		}));

		editor.ui.addButton( 'TwentyTwenty', {
			label: 'Выбрать изображения для сравнения',
			command: 'twenty_twenty',
			toolbar: 'insert',
            icon: iconPath
		});

		CKEDITOR.dialog.add( 'twentyTwentyGridDialog', this.path + 'dialogs/twentyTwentyGridDialog.js' );
	}
});
})();
