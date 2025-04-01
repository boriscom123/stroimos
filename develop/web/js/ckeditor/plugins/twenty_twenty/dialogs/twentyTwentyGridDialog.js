getPhotoLentaGridDialogCss = function () {
    return '' +
        '#twenty_twenty_sortable .ui-state-default img {' +
        'cursor: move;' +
        '}' +
        '#twenty_twenty_sortable .ui-state-default .delete {' +
        'cursor: pointer;' +
        '}' +
        '#twenty_twenty_sortable {' +
        'list-style-type: none;' +
        'margin: 0;' +
        'padding: 0;' +
        'overflow: hidden;' +
        'width: 210px;' +
        '} ' +
        '#twenty_twenty_sortable li {' +
        'margin: 3px 3px 3px 0;' +
        'padding: 1px; ' +
        'float: left;' +
        'width: 100px;' +
        'height: 90px;' +
        'font-size: 4em;' +
        'text-align: center;' +
        'background: transparent;' +
        'position: relative;' +
        '}' +
        '#twenty_twenty_sortable li .delete {' +
        'position: absolute;' +
        'width: 14px;' +
        'height: 14px;' +
        'font-size: 14px;' +
        'text-align: center;' +
        'color: white;' +
        'background: red;' +
        'top: 0;' +
        'right: 0;' +
        'cursor: pointer;' +
        '}'
        ;
};

CKEDITOR.dialog.add('twentyTwentyGridDialog', function (editor) {
    return {
        title: 'Загрузить изображения',
        width: 210,
        height: 380,
        resizable: CKEDITOR.DIALOG_RESIZE_NONE,
        contents:
            [
                {
                    id: 'twenty_twenty_slideshowinfoid',
                    label: 'Basic Settings',
                    align: 'center',
                    elements:
                        [
                            {
                                type: 'text',
                                id: 'twenty_twenty_txturlid',
                                style: 'display:none',
                                onChange: function () {
                                    var newUrl = this.getValue();
                                    var $li = $("#twenty_twenty_sortable li");
                                    for (var i = 0; i < $li.length; i++) {
                                        if ($li.eq(i).find('img').length == 0) {
                                            $li.eq(i).html('<img src="' + newUrl + '" style="max-width: 99%"><div class="delete">X</div>');
                                            break;
                                        }
                                    }
                                }
                            },
                            {
                                type: 'html',
                                align: 'center',
                                id: 'sortableContainer',
                                html: '<style>' + getPhotoLentaGridDialogCss() + '</style>' + '<ul id="twenty_twenty_sortable" style=""><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li></ul>'
                            },
                            {
                                type: 'button',
                                id: 'browse',
                                hidden: 'true',
                                style: 'float: left;margin-top: 10px',
                                filebrowser:
                                    {
                                        action: 'Browse',
                                        target: 'twenty_twenty_slideshowinfoid:twenty_twenty_txturlid',
                                        url: '/admin/sonata/media/media/image_list?context=gallery_media'
                                    },
                                label: 'Загрузить'
                            }
                        ]
                }
            ],
        onShow: function () {
            $("#twenty_twenty_sortable").sortable();
            $("#twenty_twenty_sortable").disableSelection();
            $("#twenty_twenty_sortable li").on('click', '.delete', {}, function () {
                $(this).parent('li').html('');
            });
        },
        onOk: function () {
            var items = $("#twenty_twenty_sortable img");
            var container = editor.document.createElement('div');
            container.setAttribute('data-embedded-type', 'twenty_twenty');
            container.setAttribute('width', '100%');
            container.setAttribute('contenteditable', 'false');
            container.setAttribute('style', 'padding: 5px; border: 2px dashed #ccc; background: #ececec;'); // KOSTYL
            var img = '';

            $.each(items, function (key, value) {
                if (key > 1) {
                    return;
                }
                img += '<img src="' + $(value).attr('src') + '" width="30%" style="margin-right: 10px" contenteditable="false"/>';
            });

            if (img !== '') {
                container.setHtml(img + '<div class="twentytwenty-admin_title">Изображения для сравнения</div>'); // KOSTYL
                editor.insertElement(container);
                $("#twenty_twenty_sortable li").html('');
            }
        }
    }
});