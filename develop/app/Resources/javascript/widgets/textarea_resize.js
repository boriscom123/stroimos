var observe;
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}
function init () {
    var text = $('#error_report_message');
    function resize () {
        text[0].style.height = text[0].scrollHeight+'px';
    }
    /* 0-timeout to get the already changed text */
    function delayedResize () {
        window.setTimeout(resize, 0);
    }

    if (text.length) {
        observe(text[0], 'change',  resize);
        observe(text[0], 'cut',     delayedResize);
        observe(text[0], 'paste',   delayedResize);
        observe(text[0], 'drop',    delayedResize);
        observe(text[0], 'keydown', delayedResize);

        text.focus();
        text.select();
        resize();
    }
}

init();
