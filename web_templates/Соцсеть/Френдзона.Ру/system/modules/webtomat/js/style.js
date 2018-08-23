function bindReady(handler){

    var called = false

    function ready() {
        if (called) return
        called = true
        handler()
    }

    if ( document.addEventListener ) {
        document.addEventListener( "DOMContentLoaded", function(){
            ready()
        }, false )
    } else if ( document.attachEvent ) {

        if ( document.documentElement.doScroll && window == window.top ) {
            function tryScroll(){
                if (called) return
                if (!document.body) return
                try {
                    document.documentElement.doScroll("left")
                    ready()
                } catch(e) {
                    setTimeout(tryScroll, 0)
                }
            }
            tryScroll()
        }

        document.attachEvent("onreadystatechange", function(){

            if ( document.readyState === "complete" ) {
                ready()
            }
        })
    }

    if (window.addEventListener)
        window.addEventListener('load', ready, false)
    else if (window.attachEvent)
        window.attachEvent('onload', ready)
		
//*  Else window.onload=ready *//
    	 
}
readyList = []
function onReady(handler) {

    if (!readyList.length) {
        bindReady(function() {
            for(var i=0; i<readyList.length; i++) {
                readyList[i]()
            }
        })
    }

    readyList.push(handler)
}

function getXmlHttp(){
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;

}

if(document.getElementsByClassName) {

    getElementsByClass = function(classList, node) {
        return (node || document).getElementsByClassName(classList)
    }

} else {

    getElementsByClass = function(classList, node) {
        var node = node || document,
            list = node.getElementsByTagName('*'),
            length = list.length,
            classArray = classList.split(/\s+/),
            classes = classArray.length,
            result = [], i,j
        for(i = 0; i < length; i++) {
            for(j = 0; j < classes; j++)  {
                if(list[i].className.search('\\b' + classArray[j] + '\\b') != -1) {
                    result.push(list[i])
                    break
                }
            }
        }

        return result
    }
}

wt_slid = 0;
wt_page = 20;
var wt_id = '';
var wt_rnum = Math.round(Math.random()*100000);

function wt_st(el,h){
    var menu =  document.getElementById('wt_menu');
    if (menu.style.height != 'auto' && !h) {
        menu.style.height = 'auto';
        menu.style.borderColor = '#cccccc';
        menu.style.boxShadow = '3px 3px 3px #ccc';
            el.innerHTML = wt_show_all[1];
            el.style.color = '#ea360c';
            el.style.backgroundImage = 'url('+location.protocol+'//'+location.host+'//'+wt_dir+'/images/dotted-kr.png)';
    } else {
        menu.style.height = '25px';
        menu.style.borderColor = 'transparent';
        menu.style.boxShadow = '';
            el.innerHTML = wt_show_all[0];
            el.style.color = '#808080';
            el.style.backgroundImage = 'url('+location.protocol+'//'+location.host+'//'+wt_dir+'/images/dotted.png)';
    }
    return false;
}

function wt_rt_start(obj){
    if (!wt_uv && wt_id != '') {
        var val = obj.getElementsByTagName('input')[0].value;
        var col = document.getElementById('wt_rate_color');
        col.style.width = val*20+'%'
    }
}

function wt_rt_end(){
    if (!wt_uv && wt_id != '') {
        var col = document.getElementById('wt_rate_color');
        col.style.width = wt_reatWidth+'%'
    }
}

function wt_rt_vote(obj){

    if (wt_id == '')
        return false;

    var colorBox = document.getElementById('wt_rate_color');
    var rateLoad = getElementsByClass('wt_load',obj.parentNode)[0];

    wt_uv = true;
    colorBox.style.width = wt_reatWidth+'%';
    rateLoad.style.display = 'block';

    var rate = obj.getElementsByTagName('input')[0].value;
    var url = document.location+'&rate='+rate+'&wt_id='+wt_id;

    var req = getXmlHttp();

    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                var rep = req.responseText;
                if ( /\|WT_SPLIT\|/.test(rep) )
                    rep = rep.split("|WT_SPLIT|")[1];
                wt_reatWidth = parseFloat(rep) / 0.05;

                colorBox.style.width = wt_reatWidth+'%';
            }
            rateLoad.style.display = 'none';
        }
    }

    req.open('POST', url+'&wt_ajax=1', true);
    req.send(null);

}
var wt_sligGo = false;

function wt_nextSlid(s,t,shagov,f){
    if ((!wt_sligGo && f) || (wt_sligGo && !f)) {
    if (!shagov) shagov = 1;
    for(var z=0; z<shagov; z++){
        wt_slid++;
        var step = s / t;
        var n = 5;
        var j = 5;
        var el = document.getElementById('wt_slider_content');

        for (var i=0; i<=t; i++){
            j = j - 0.05;
            n = n + j;
            if ( i < t) {
                setTimeout(function (){
                    var left = el.style.left;
                    left = left.substr(0, left.length - 2);
                    if (!left) { left = 0; }
                    var newleft = left - step;
                    newleft = parseFloat(newleft,2);
                    el.style.left = newleft+'px';
                },n)
            } else if ( i == t ) {
                setTimeout(function (){
                    var a1 = el.getElementsByTagName('a')[0];
                    var a1clone = a1.cloneNode(true);
                    el.appendChild(a1clone);
                    el.removeChild(a1);
                    el.style.left = '';
                },n)
            }
        }
    }
    }
}

function wt_sn(el){

    var url = document.location+'&p='+wt_page;
    var cont = document.getElementById('wt_content');

    wt_ajax(url,cont,true,el);

//El.parentNode.removeChild(el); *//

    wt_page = wt_page + 20;

    return false;

}

function refreshIFrame(id) {
    var code = document.getElementById(id);
    if (code)
        code.src = code.src;
}

function webTomatAuth(token){

    var host = encodeURIComponent(location.host);
    var url = 'http://games.apitech.ru/Web/Service/GetTokenInfo?token='+token+'&h='+host+'&c=wgauth'+wt_rnum;

    function goRemote(url) {
        var script = document.createElement("script");
        script.src=url;
        document.body.appendChild(script);
    }

    goRemote(url);

	setTimeout(function(){refreshIFrame('wt_game_iframe')},200);

}

function wt_logout(){

    var url = 'http://games.apitech.ru/Web/Service/GetAuthInfo?a=1&c=wgauth'+wt_rnum;

    function goRemote(url) {
        var script = document.createElement("script");
        script.src=url;
        document.body.appendChild(script);
    }
    goRemote(url);
	setTimeout(function(){
		refreshIFrame('wt_game_iframe')
		wt_testAuth();
	},100);


    var req = getXmlHttp();
    var url = location.href+'&wtid=logout';
    req.open('POST', url+'&wt_ajax=1', true);
    req.send(null);
	
	if (window.wt_network) {
		var button = document.getElementById('wt_share_'+wt_network);
		if (button) button.style.display = 'none';
		wt_network = '';
	}
	
}

function wt_testAuth(){

    var url = 'http://games.apitech.ru/Web/Service/GetAuthInfo?c=wgauth'+wt_rnum;

    function goRemote(url) {
        var script = document.createElement("script");
        script.src=url;
        script.async = true;
        document.body.appendChild(script);
    }
    goRemote(url);
	setTimeout(function(){refreshIFrame('wt_game_iframe')},200);

}

var f_callback="wgauth"+wt_rnum;
eval("function "+f_callback+" (data) { wt_goauth(data) }");

function onAuth(logout) {
    if (!logout)
        wt_testAuth();
}

function wt_goauth(json){

    var arr = json;

    var block_on = document.getElementById('wtl_on');
    var block_of = document.getElementById('wtl_off');
    document.getElementById('wtl_load').style.display = 'none';

    if ( !arr.uid || arr.uid == null || arr.uid == "0" ) {

        block_of.style.display = 'block';
        block_on.style.display = 'none';

        wt_id = '';

    } else {

        var block_name = getElementsByClass('wtl_name',block_on)[0];
		var name1 = arr.first_name.length > 16 ? arr.first_name.substr(0,16) : arr.first_name;
		var name2 = arr.last_name.length > 16 ? arr.last_name.substr(0,16) : arr.last_name;
        block_name.innerHTML = name1+'<br />'+name2;

        var block_foto = getElementsByClass('wtl_foto_img',block_on)[0];
        block_foto.src = arr.photo;

        var block_net = getElementsByClass('wtl_net',block_on)[0];
        wt_network = arr.network;
        switch (wt_network) {
            case 'vkontakte':
                block_net.style.backgroundPosition = '0 -19px'
                break
            case 'facebook':
                block_net.style.backgroundPosition = '0 -88px'
                break
            case 'mailru':
                block_net.style.backgroundPosition = '0 -65px'
                break
            case 'odnoklassniki':
                block_net.style.backgroundPosition = '0 -42px'
                break
            case 'google':
                block_net.style.backgroundPosition = '0 -134px'
                break
            case 'twitter':
                block_net.style.backgroundPosition = '0 -111px'
                break
            case 'yandex':
                block_net.style.backgroundPosition = '0 -157px'
                break
            case 'livejournal':
                block_net.style.backgroundPosition = '0 -180px'
                break
            case 'openid':
                block_net.style.backgroundPosition = '0 -203px'
                break
            case 'lastfm':
                block_net.style.backgroundPosition = '0 -272px'
                break
            case 'linkedin':
                block_net.style.backgroundPosition = '0 -295px'
                break
            case 'liveid':
                block_net.style.backgroundPosition = '0 -318px'
                break
            case 'soundcloud':
                block_net.style.backgroundPosition = '0 -341px'
                break
            case 'steam':
                block_net.style.backgroundPosition = '0 -364px'
                break
            default:
                block_net.style.backgroundPosition = '200% 200%'
        }
		
		var button = document.getElementById('wt_share_'+wt_network);
		if (button) button.style.display = 'block';

        if ( arr.identity && arr.identity != '' ) {
            wt_id = arr.identity;
            var req = getXmlHttp();
            var url = location.href+'&wtid='+wt_id;

            req.open('POST', url+'&wt_ajax=1', true);
            req.send(null);
        }

        block_of.style.display = 'none';
        block_on.style.display = 'block';

    }
}

function wt_ajax(url,cont,add,loader) {

    var req = getXmlHttp()
    loader.innerHTML = '<img src="'+location.protocol+'//'+location.host+'//'+wt_dir+'images/load40.gif" height="20" width="20" />';
    loader.style.borderColor = 'transparent';
    req.onreadystatechange = function() {

        if (req.readyState == 4) {

            if(req.status == 200) {
                loader.parentNode.removeChild(loader);
                if (add) {
                    var subj = req.responseText;
					pos = subj.search('wt_item');
					if (pos == -1) subj='';
                    cont.innerHTML = cont.innerHTML+subj;
                } else {
                    cont.innerHTML = req.responseText;
                }
            }
        }
    }

    req.open('POST', url+'&wt_ajax=1', true);
    req.send(null);

}

function wt_gameXY(){

    var obj = document.getElementById('wt_game_iframe');
    var cont = document.getElementById('wt_content');

    if (obj){
        if ( obj.offsetWidth > cont.offsetWidth ) {
            var wt_h = obj.offsetHeight;
            var wt_w = obj.offsetWidth;
            var prop = wt_h / wt_w;
            var new_width = cont.offsetWidth - 40;
            var new_height = new_width * prop;

            obj.width = new_width;
            obj.height = new_height;
        }
    }
}
var wLoginBlock = document.getElementById('wt_login') ? 185 : 0;
function wt_showSlider(){
    var wt_cont = document.getElementById("wt_cont");
    var slid = document.getElementById("wt_slid");
	var in_main = getElementsByClass('in-main',slid.parentNode)[0];
    var x = 0;
    var width = 0;
    do {
        if (x == 8) break;
        width = x == 0 ? (25 + 124) : (width + 124);
        x++;
    } while (wt_cont.clientWidth - wLoginBlock - 124 - ( in_main ? parseInt(in_main.offsetWidth) : 0 ) > width );
    slid.style.width = width+"px";
    var n = 1;
    var j = 5;
    slid.style.opacity = 0;
    for (var i=0; i<100; i++){
        j = j > 0 ? j - 0.02 : j;
        n = n + j;
        setTimeout(function (){
            slid.style.opacity = (parseFloat(slid.style.opacity) + 0.01);
        },n)
    }
}

function wt_contWH(){
    var wt_cont = document.getElementById("wt_cont");
    var wrap = document.getElementById("wt_wrapper");
	wt_cont.style.width = wrap.offsetWidth + "px";
    wt_cont.style.height = wrap.offsetHeight + "px";
}

wt_idslid = '';
if (window.wt_idslid == '') window.wt_idslid = setInterval('wt_nextSlid(123,80,2,true)',5000);

onReady(function() {
    if (document.getElementById('wt_login')) wt_testAuth();
	if (!document.getElementById('wt_slid')) return false;
    wt_gameXY();
    wt_showSlider();
    wt_contWH();

    document.getElementById('wt_slid').onmouseover = function(event){
        wt_sligGo = true;
    }
    document.getElementById('wt_slid').onmouseout = function(event){
        wt_sligGo = false;
    }


})
if (readyList[0]) readyList[0]();
