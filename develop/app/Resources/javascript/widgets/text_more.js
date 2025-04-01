$(function () {
    var moreContainer = '.text-more__container',
        moreBlock = '.text-more__wrapper',
        moreButton = 'span.text-more__button',
        moreTitle = '.text-more__title',
        moreOptions = {
            ellipsis: '',
            after: moreButton,
            height: 42,
            tolerance: 21,
            callback: function (isTruncated) {
                if (!isTruncated){
                    $(this).find(moreButton).addClass('hidden');
                }
            }
        },
        buttonStates = ['еще', 'скрыть'];

    $(moreBlock).dotdotdot(moreOptions);

    $(document).on('click', moreButton, function (e) {
        var content,
            $this = $(this),
            $target = $this.closest(moreBlock),
            $container = $this.closest(moreContainer),
            isTruncated = $target.triggerHandler("isTruncated");

        e.preventDefault();

        if (isTruncated) {
            content = $target.triggerHandler('originalContent');
            $target
                .trigger('destroy.dot')
                .html(content)
                .find(moreButton)
                .text(buttonStates[1]+' ('+$target.data('length')+')');
            $container
                .addClass('text-more__showed')
                .find(moreTitle)
                .removeClass('hidden');
        } else {
            $container
                .removeClass('text-more__showed')
                .find(moreTitle)
                .addClass('hidden');
            $target
                .dotdotdot(moreOptions)
                .find(moreButton)
                .text(buttonStates[0]);
        }
    });

//    $(document).on('mouseleave', moreContainer, function(){
//        var $this = $(this),
//            $target = $this.find(moreBlock);
//
//        $this.removeClass('text-more__showed');
//        $target
//            .dotdotdot(moreOptions)
//            .find(moreButton)
//            .text(buttonStates[0]);
//    });

    $(document).on('loadmore:contentAdded', function(){
        $(moreBlock).dotdotdot(moreOptions);
    });
});