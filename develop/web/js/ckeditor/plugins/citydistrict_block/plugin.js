CKEDITOR.plugins.add('citydistrict_block', {
    init: function (editor) {
        var iconPath = this.path + 'images/icon.png';

        editor.addCommand('insertCityDistrictBlock', {
            exec: function () {
                var item = editor.document.createElement('p');
                item.setAttribute('data-embedded-type', 'block');
                item.setAttribute('data-embedded-parameters', 'city-district');
                item.setAttribute('width', '100%');
                item.setAttribute('contenteditable', 'false');
                item.setAttribute('style', 'padding: 5px; border: 2px dashed #ccc; background: #ececec;');
                item.setHtml('Список районов');
                editor.insertElement(item);
            }
        });

        editor.ui.addButton('CityDistrictBlock',
            {
                label: 'Вставить блок с районами',
                command: 'insertCityDistrictBlock',
                icon: iconPath,
            }
        );
    }
});
