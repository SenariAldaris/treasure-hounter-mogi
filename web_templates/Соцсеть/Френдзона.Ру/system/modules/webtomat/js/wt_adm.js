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

function wt_goupd(cont,key){

    var req = getXmlHttp()
    var url = location.href;

    cont.innerHTML = cont.innerHTML+'<img src="'+wt_dir+'/images/load40.gif" height="20" width="20" style="position:absolute;left:-22px;top:-3px" />';

    req.onreadystatechange = function() {
        if (req.readyState == 4) {
            if(req.status == 200) {
                var reply = req.responseText;
                if ( /|WT_SPLIT|/.test(reply))
                    reply = reply.split("|WT_SPLIT|")[1];
                cont.innerHTML = reply;
                cont.style.color = '#00aa00';
                cont.style.cursor = 'default';
                cont.onclick = '';
            }
        }
    }
    if (key && key == "upd")
        var params = 'u=1';
    else
        var params = 'res=1';
    req.open('POST', url, true);
    req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    req.send(params);

}
wt_upd_ho = 0;
wt_res_ho = 0;
wt_main_ho = 0;
wt_webid_ho = 0;
wtGo = 0;
function wt_goupdhelp(obj,nh,t){
	var el = document.getElementById('wt_'+obj+'_help');
	var text = el.innerHTML;
    el.innerHTML = '';
	if (el.style.display == 'none'){
		el.style.display = 'block';
		el.style.height = nh+'px';
		setTimeout(function (){
	        el.innerHTML = text;
		},20);
	}
	else {
		el.style.height = '0px';
		setTimeout(function (){
			el.style.display = 'none';
			el.innerHTML = text;
		},200);
		return false;
	}
	
	var arr = ['wt_upd_help','wt_res_help','wt_main_help','wt_webid_help'];
	for (var i=0,len=arr.length;i<len;i++){
		if (arr[i] != 'wt_'+obj+'_help'){
			document.getElementById(arr[i]).style.height = '0px';
			document.getElementById(arr[i]).style.display = 'none';
		}
	}
    
}

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

onReady(function() {
	
})
