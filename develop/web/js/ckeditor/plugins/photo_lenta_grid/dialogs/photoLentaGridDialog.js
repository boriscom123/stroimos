
getPhotoLentaGridDialogCss = function()
{
    return '' +
        '#sortable .ui-state-default img {' +
            'cursor: move;' +
        '}' +
        '#sortable .ui-state-default .delete {' +
            'cursor: pointer;' +
        '}' +
        '#sortable {' +
            'list-style-type: none;' +
            'margin: 0;' +
            'padding: 0;' +
            'overflow: hidden;' +
            'width: 210px;' +
        '} ' +
        '#sortable li {' +
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
        '#sortable li .delete {' +
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

CKEDITOR.dialog.add( 'photoLentaGridDialog', function( editor ) {
    return {
        title : 'Загрузка изображений',
        width: 210,
        height: 380,
        resizable: CKEDITOR.DIALOG_RESIZE_NONE,
        contents:
        [
            {
                // Definition of the Basic Settings dialog (page).
                id: 'slideshowinfoid',
                label: 'Basic Settings',
                align: 'center',
                elements:
                [
                    {
                        type: 'text',
                        id: 'txturlid',
                        style: 'display:none',
                        onChange: function() {
                            var newUrl = this.getValue();
                            var $li = $("#sortable li");
                            for(var i=0; i < $li.length; i++) {
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
                        html: '<style>' + getPhotoLentaGridDialogCss() + '</style>' + '<ul id="sortable" style=""><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li><li class="ui-state-default"></li></ul>'
                    },
                    {
                        type : 'button',
                        id : 'browse',
                        hidden : 'true',
                        style : 'float: left;margin-top: 10px',
                        filebrowser :
                        {
                            action : 'Browse',
                            target: 'slideshowinfoid:txturlid',
                            url: '/admin/sonata/media/media/image_list?context=gallery_media'
                        },
                        label : 'Загрузить'
                    }
                ]
            }
        ],
        onShow: function() {
            $( "#sortable" ).sortable();
            $( "#sortable" ).disableSelection();
            $("#sortable li").on('click', '.delete', {}, function(){
                $(this).parent('li').html('');
            });
        },
        onOk: function() {
            var items = $("#sortable img") ;
            var container = editor.document.createElement('div');
            //container.setAttribute('class', 'container__pull-left');
            //container.setAttribute('contenteditable', 'false');
            var img = '';

            $.each(items, function(key, value){
                img += '<li class="photolenta-gallery__list-item" contenteditable="false">';
                img += '<a href="' + $(value).attr('src').replace('thumb780', 'full') + '"><img src="' + $(value).attr('src') + '" contenteditable="false"/></a></li>';
            });

            if (img !== ''){
                container.setHtml('<div class="container__pull-left" contenteditable="false"><ul class="photolenta-gallery__list" data-columns contenteditable="false">' + img + '</ul></div>');
                editor.insertElement(container);
                $("#sortable li").html('');
            }
        }
    }
});