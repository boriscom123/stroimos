( function() {
CKEDITOR.plugins.add( 'photo_lenta_grid', {

	getPhotoLentaGridDialogCss : function()
	{
		return '' +
            '.container__pull-left {' +
                'width: 532px;' +
            '}' +
            '.photolenta-gallery__list {' +
                'margin: 0;' +
                'padding: 0;' +
                'border: 0;' +
                'overflow: hidden;' +
                'line-height: 0;' +
            '}' +
            '.photolenta-gallery__list[data-columns]:before {' +
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
            '.photolenta-gallery__list-item {' +
                'float: left;' +
                'width: 50%;' +
                'list-style: none;' +
                'margin-bottom: 0px;' +
            '}' +
            'a:link {' +
                'outline: none;' +
            '}' +
            '.photolenta-gallery__list-item img {' +
                'width: 100%;' +
                'height: 100%;' +
                'outline: none !important;' +
                'padding: 0;' +
                'margin: 0;' +
            '}'
        ;
	},

	icons: 'photo_lenta_grid',
	
	onLoad : function(editor)
	{
	},

	init: function( editor ) {

        CKEDITOR.addCss(this.getPhotoLentaGridDialogCss());

        var iconPath = this.path + 'icons/photo_lenta_grid.png';

		editor.addCommand( 'photo_lenta_grid', new CKEDITOR.dialogCommand( 'photoLentaGridDialog', {

		} ) );

		editor.ui.addButton( 'PhotoLentaGrid', {
			label: 'Вставить набор изображений',
			command: 'photo_lenta_grid',
			toolbar: 'insert',
            icon: iconPath
		});

		CKEDITOR.dialog.add( 'photoLentaGridDialog', this.path + 'dialogs/photoLentaGridDialog.js' );
	}
});
})();
