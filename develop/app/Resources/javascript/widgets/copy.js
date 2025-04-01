jQuery.fn.addtocopy = function() {
    var url_params_pre = window.location.search.substr(1);
    url_params_pre = (url_params_pre == '' ? [] : url_params_pre.split('&'));
    var url_params = url_params_pre.reduce(function (params, param) {
        var paramSplit = param.split('=').map(function (value) {
            return decodeURIComponent(value.replace('+', ' '));
        });
        params[paramSplit[0]] = paramSplit[1];
        return params;
    }, {});
    url_params['from'] = 'cl';
    var base_url = [location.protocol, '//', location.host, location.pathname].join('');
    var new_url = base_url + '?' + $.param(url_params);
    var options = {htmlcopytxt: '<br>Подробнее: <a href="'+new_url+'">'+new_url+'</a><br>', minlen: 50, addcopyfirst: false}
    var copy_sp = document.createElement('span');
    copy_sp.id = 'ctrlcopy';
    copy_sp.innerHTML = options.htmlcopytxt;
    return this.each(function(){
        $(this).mousedown(function(event){
            if(event.target.tagName === 'INPUT') return;

            $('#ctrlcopy').remove();});

        $(this).mouseup(function(event){
            if(event.target.tagName === 'INPUT' || document.activeElement.tagName === 'INPUT') return;

            if(window.getSelection){	//good times
                var slcted=window.getSelection();
                var seltxt=slcted.toString();
                if(!seltxt||seltxt.length<options.minlen) return;
                var nslct = slcted.getRangeAt(0);
                seltxt = nslct.cloneRange();
                seltxt.collapse(options.addcopyfirst);
                seltxt.insertNode(copy_sp);
                if (!options.addcopyfirst) nslct.setEndAfter(copy_sp);
                slcted.removeAllRanges();
                slcted.addRange(nslct);
            } else if(document.selection){	//bad times
                var slcted = document.selection;
                var nslct=slcted.createRange();
                var seltxt=nslct.text;
                if (!seltxt||seltxt.length<options.minlen) return;
                seltxt=nslct.duplicate();
                seltxt.collapse(options.addcopyfirst);
                seltxt.pasteHTML(copy_sp.outerHTML);
                if (!options.addcopyfirst) {nslct.setEndPoint("EndToEnd",seltxt); nslct.select();}
            }
        });
    });
}

$(function(){
    $("body").addtocopy();
});

/*
 function addLink() {
 var body_element = document.getElementsByTagName('body')[0];
 var selection;
 selection = window.getSelection();
 var pagelink = "Подробнее: <a href='"+document.location.href+"'>"+document.location.href+"</a>";
 var copytext = selection + pagelink;
 console.log(copytext);
 var newdiv = document.createElement('div');
 newdiv.style.position='absolute';
 newdiv.style.left='-99999px';
 body_element.appendChild(newdiv);
 newdiv.innerHTML = copytext;
 selection.selectAllChildren(newdiv);
 window.setTimeout(function() {
 body_element.removeChild(newdiv);
 },0);
 }*/
