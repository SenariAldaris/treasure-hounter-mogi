
/* Smoke.js */
(function(e,t){var n={smoketimeout:[],init:false,zindex:1e3,i:0,bodyload:function(e){var r=t.createElement("div");r.setAttribute("id","smoke-out-"+e);r.className="smoke-base";r.style.zIndex=9999999;n.zindex++;t.body.appendChild(r)},newdialog:function(){var t=(new Date).getTime();t=Math.random(1,99)+t;if(!n.init){n.listen(e,"load",function(){n.bodyload(t)})}else{n.bodyload(t)}return t},forceload:function(){},build:function(t,r){n.i++;r.stack=n.i;t=t.replace(/\n/g,"<br />");t=t.replace(/\r/g,"<br />");var i="",s="OK",o="Cancel",u="",a="",f;if(r.type==="prompt"){i='<div class="dialog-prompt">'+'<input id="dialog-input-'+r.newid+'" type="text" '+(r.params.value?'value="'+r.params.value+'"':"")+" />"+"</div>"}if(r.params.ok){s=r.params.ok}if(r.params.cancel){o=r.params.cancel}if(r.params.classname){u=r.params.classname}if(r.type!=="signal"){a='<div class="dialog-buttons">';if(r.type==="alert"){a+='<button id="alert-ok-'+r.newid+'">'+s+"</button>"}else if(r.type==="quiz"){if(r.params.button_1){a+='<button class="quiz-button" id="'+r.type+"-ok1-"+r.newid+'">'+r.params.button_1+"</button>"}if(r.params.button_2){a+='<button class="quiz-button" id="'+r.type+"-ok2-"+r.newid+'">'+r.params.button_2+"</button>"}if(r.params.button_3){a+='<button class="quiz-button" id="'+r.type+"-ok3-"+r.newid+'">'+r.params.button_3+"</button>"}if(r.params.button_cancel){a+='<button id="'+r.type+"-cancel-"+r.newid+'" class="cancel">'+r.params.button_cancel+"</button>"}}else if(r.type==="prompt"||r.type==="confirm"){if(r.params.reverseButtons){a+='<button id="'+r.type+"-ok-"+r.newid+'">'+s+"</button>"+'<button id="'+r.type+"-cancel-"+r.newid+'" class="cancel">'+o+"</button>"}else{a+='<button id="'+r.type+"-cancel-"+r.newid+'" class="cancel">'+o+"</button>"+'<button id="'+r.type+"-ok-"+r.newid+'">'+s+"</button>"}}a+="</div>"}f='<div id="smoke-bg-'+r.newid+'" class="smokebg"></div>'+'<div class="dialog smoke '+u+'">'+'<div class="dialog-inner">'+t+i+a+"</div>"+"</div>";if(!n.init){n.listen(e,"load",function(){n.finishbuild(t,r,f)})}else{n.finishbuild(t,r,f)}},finishbuild:function(e,r,i){var s=t.getElementById("smoke-out-"+r.newid);s.className="smoke-base smoke-visible  smoke-"+r.type;s.innerHTML=i;while(s.innerHTML===""){s.innerHTML=i}if(n.smoketimeout[r.newid]){clearTimeout(n.smoketimeout[r.newid])}n.listen(t.getElementById("smoke-bg-"+r.newid),"click",function(){n.destroy(r.type,r.newid);if(r.type==="prompt"||r.type==="confirm"||r.type==="quiz"){r.callback(false)}else if(r.type==="alert"&&typeof r.callback!=="undefined"){r.callback()}});switch(r.type){case"alert":n.finishbuildAlert(e,r,i);break;case"confirm":n.finishbuildConfirm(e,r,i);break;case"quiz":n.finishbuildQuiz(e,r,i);break;case"prompt":n.finishbuildPrompt(e,r,i);break;case"signal":n.finishbuildSignal(e,r,i);break;default:throw"Unknown type: "+r.type}},finishbuildAlert:function(r,i,s){n.listen(t.getElementById("alert-ok-"+i.newid),"click",function(){n.destroy(i.type,i.newid);if(typeof i.callback!=="undefined"){i.callback()}});t.onkeyup=function(t){if(!t){t=e.event}if(t.keyCode===13||t.keyCode===32||t.keyCode===27){n.destroy(i.type,i.newid);if(typeof i.callback!=="undefined"){i.callback()}}}},finishbuildConfirm:function(r,i,s){n.listen(t.getElementById("confirm-cancel-"+i.newid),"click",function(){n.destroy(i.type,i.newid);i.callback(false)});n.listen(t.getElementById("confirm-ok-"+i.newid),"click",function(){n.destroy(i.type,i.newid);i.callback(true)});t.onkeyup=function(t){if(!t){t=e.event}if(t.keyCode===13||t.keyCode===32){n.destroy(i.type,i.newid);i.callback(true)}else if(t.keyCode===27){n.destroy(i.type,i.newid);i.callback(false)}}},finishbuildQuiz:function(r,i,s){var o,u,a;n.listen(t.getElementById("quiz-cancel-"+i.newid),"click",function(){n.destroy(i.type,i.newid);i.callback(false)});if(o=t.getElementById("quiz-ok1-"+i.newid))n.listen(o,"click",function(){n.destroy(i.type,i.newid);i.callback(o.innerHTML)});if(u=t.getElementById("quiz-ok2-"+i.newid))n.listen(u,"click",function(){n.destroy(i.type,i.newid);i.callback(u.innerHTML)});if(a=t.getElementById("quiz-ok3-"+i.newid))n.listen(a,"click",function(){n.destroy(i.type,i.newid);i.callback(a.innerHTML)});t.onkeyup=function(t){if(!t){t=e.event}if(t.keyCode===27){n.destroy(i.type,i.newid);i.callback(false)}}},finishbuildPrompt:function(r,i,s){var o=t.getElementById("dialog-input-"+i.newid);setTimeout(function(){o.focus();o.select()},100);n.listen(t.getElementById("prompt-cancel-"+i.newid),"click",function(){n.destroy(i.type,i.newid);i.callback(false)});n.listen(t.getElementById("prompt-ok-"+i.newid),"click",function(){n.destroy(i.type,i.newid);i.callback(o.value)});t.onkeyup=function(t){if(!t){t=e.event}if(t.keyCode===13){n.destroy(i.type,i.newid);i.callback(o.value)}else if(t.keyCode===27){n.destroy(i.type,i.newid);i.callback(false)}}},finishbuildSignal:function(r,i,s){t.onkeyup=function(t){if(!t){t=e.event}if(t.keyCode===27){n.destroy(i.type,i.newid);if(typeof i.callback!=="undefined"){i.callback()}}};n.smoketimeout[i.newid]=setTimeout(function(){n.destroy(i.type,i.newid);if(typeof i.callback!=="undefined"){i.callback()}},i.timeout)},destroy:function(e,r){var i=t.getElementById("smoke-out-"+r);if(e!=="quiz"){var s=t.getElementById(e+"-ok-"+r)}var o=t.getElementById(e+"-cancel-"+r);i.className="smoke-base";if(s){n.stoplistening(s,"click",function(){});t.onkeyup=null}if(e==="quiz"){var u=t.getElementsByClassName("quiz-button");for(var a=0;a<u.length;a++){n.stoplistening(u[a],"click",function(){});t.onkeyup=null}}if(o){n.stoplistening(o,"click",function(){})}n.i=0;i.innerHTML=""},alert:function(e,t,r){if(typeof r!=="object"){r=false}var i=n.newdialog();n.build(e,{type:"alert",callback:t,params:r,newid:i})},signal:function(e,t,r){if(typeof r!=="object"){r=false}var i=5e3;if(r.duration!=="undefined"){i=r.duration}var s=n.newdialog();n.build(e,{type:"signal",callback:t,timeout:i,params:r,newid:s})},confirm:function(e,t,r){if(typeof r!=="object"){r=false}var i=n.newdialog();n.build(e,{type:"confirm",callback:t,params:r,newid:i})},quiz:function(e,t,r){if(typeof r!=="object"){r=false}var i=n.newdialog();n.build(e,{type:"quiz",callback:t,params:r,newid:i})},prompt:function(e,t,r){if(typeof r!=="object"){r=false}var i=n.newdialog();return n.build(e,{type:"prompt",callback:t,params:r,newid:i})},listen:function(e,t,n){if(e.addEventListener){return e.addEventListener(t,n,false)}if(e.attachEvent){return e.attachEvent("on"+t,n)}return false},stoplistening:function(e,t,n){if(e.removeEventListener){return e.removeEventListener(t,n,false)}if(e.detachEvent){return e.detachEvent("on"+t,n)}return false}};n.init=true;if(typeof module!="undefined"&&module.exports){module.exports=n}else if(typeof define==="function"&&define.amd){define("smoke",[],function(){return n})}else{this.smoke=n}})(window,document);

/*  Roulette */
(function($){var Roulette=function(options){var defaultSettings={maxPlayCount:null,speed:10,stopImageNumber:null,rollCount:3,duration:3,stopCallback:function(){},startCallback:function(){},slowDownCallback:function(){}};var defaultProperty={playCount:0,$rouletteTarget:null,imageCount:null,$images:null,originalStopImageNumber:null,totalHeight:null,topPosition:0,maxDistance:null,slowDownStartDistance:null,isRunUp:true,isSlowdown:false,isStop:false,distance:0,runUpDistance:null,isIE:navigator.userAgent.toLowerCase().indexOf("msie")>-1};var p=$.extend({},defaultSettings,options,defaultProperty);var reset=function(){p.maxDistance=defaultProperty.maxDistance;p.slowDownStartDistance=defaultProperty.slowDownStartDistance;p.distance=defaultProperty.distance;p.isRunUp=defaultProperty.isRunUp;p.isSlowdown=defaultProperty.isSlowdown;p.isStop=defaultProperty.isStop;p.topPosition=defaultProperty.topPosition};var slowDownSetup=function(){if(p.isSlowdown){return}p.slowDownCallback();p.isSlowdown=true;p.slowDownStartDistance=p.distance;p.maxDistance=p.distance+2*p.totalHeight;p.maxDistance+=p.imageHeight-p.topPosition%p.imageHeight;if(p.stopImageNumber!=null){p.maxDistance+=(p.totalHeight-p.maxDistance%p.totalHeight+p.stopImageNumber*p.imageHeight)%p.totalHeight}};var roll=function(){var speed_=p.speed;if(p.isRunUp){if(p.distance<=p.runUpDistance){var rate_=~~(p.distance/p.runUpDistance*p.speed);speed_=rate_+1}else{p.isRunUp=false}}else if(p.isSlowdown){var rate_=~~((p.maxDistance-p.distance)/(p.maxDistance-p.slowDownStartDistance)*p.speed);speed_=rate_+1}if(p.maxDistance&&p.distance>=p.maxDistance){p.isStop=true;reset();p.stopCallback(p.$rouletteTarget.find("img").eq(p.stopImageNumber));return}p.distance+=speed_;p.topPosition+=speed_;if(p.topPosition>=p.totalHeight){p.topPosition=p.topPosition-p.totalHeight}if(p.isIE){p.$rouletteTarget.css("top","-"+p.topPosition+"px")}else{p.$rouletteTarget.css("transform","translate(0px, -"+p.topPosition+"px)")}setTimeout(roll,1)};var init=function($roulette){$roulette.css({overflow:"hidden"});defaultProperty.originalStopImageNumber=p.stopImageNumber;if(!p.$images){p.$images=$roulette.find("img").remove();p.imageCount=p.$images.length;p.$images.eq(0).bind("load",function(){p.imageHeight=$(this).height();$roulette.css({height:p.imageHeight+"px"});p.totalHeight=p.imageCount*p.imageHeight;p.runUpDistance=2*p.imageHeight}).each(function(){if(this.complete||this.complete===undefined){var src=this.src;this.src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";this.src=src}})}$roulette.find("div").remove();p.$images.css({display:"block"});p.$rouletteTarget=$("<div>").css({position:"relative",top:"0"}).attr("class","roulette-inner");$roulette.append(p.$rouletteTarget);p.$rouletteTarget.append(p.$images);p.$rouletteTarget.append(p.$images.eq(0).clone());$roulette.show()};var start=function(){p.playCount++;if(p.maxPlayCount&&p.playCount>p.maxPlayCount){return}p.stopImageNumber=$.isNumeric(defaultProperty.originalStopImageNumber)&&Number(defaultProperty.originalStopImageNumber)>=0?Number(defaultProperty.originalStopImageNumber):Math.floor(Math.random()*p.imageCount);p.startCallback();roll();setTimeout(function(){slowDownSetup()},p.duration*1e3)};var stop=function(option){if(!p.isSlowdown){if(option){var stopImageNumber=Number(option.stopImageNumber);if(0<=stopImageNumber&&stopImageNumber<=p.imageCount-1){p.stopImageNumber=option.stopImageNumber}}slowDownSetup()}};var option=function(options){p=$.extend(p,options);p.speed=Number(p.speed);p.duration=Number(p.duration);p.duration=p.duration>1?p.duration-1:1;defaultProperty.originalStopImageNumber=options.stopImageNumber};var ret={start:start,stop:stop,init:init,option:option};return ret};var pluginName="roulette";$.fn[pluginName]=function(method,options){return this.each(function(){var self=$(this);var roulette=self.data("plugin_"+pluginName);if(roulette){if(roulette[method]){roulette[method](options)}else{console&&console.error("Method "+method+" does not exist on jQuery.roulette")}}else{roulette=new Roulette(method);roulette.init(self,method);$(this).data("plugin_"+pluginName,roulette)}})}})(jQuery);

/* animateNumber */
(function(d){var q=function(b){return b.split("").reverse().join("")},m={numberStep:function(b,a){var e=Math.floor(b);d(a.elem).text(e)}},h=function(b){var a=b.elem;a.nodeType&&a.parentNode&&(a=a._animateNumberSetter,a||(a=m.numberStep),a(b.now,b))};d.Tween&&d.Tween.propHooks?d.Tween.propHooks.number={set:h}:d.fx.step.number=h;d.animateNumber={numberStepFactories:{append:function(b){return function(a,e){var g=Math.floor(a);d(e.elem).prop("number",a).text(g+b)}},separator:function(b,a,e){b=b||" ";
    a=a||3;e=e||"";return function(g,k){var c=Math.floor(g).toString(),t=d(k.elem);if(c.length>a){for(var f=c,l=a,m=f.split("").reverse(),c=[],n,r,p,s=0,h=Math.ceil(f.length/l);s<h;s++){n="";for(p=0;p<l;p++){r=s*l+p;if(r===f.length)break;n+=m[r]}c.push(n)}f=c.length-1;l=q(c[f]);c[f]=q(parseInt(l,10).toString());c=c.join(b);c=q(c)}t.prop("number",g).text(c+e)}}}};d.fn.animateNumber=function(){for(var b=arguments[0],a=d.extend({},m,b),e=d(this),g=[a],k=1,c=arguments.length;k<c;k++)g.push(arguments[k]);
    if(b.numberStep){var h=this.each(function(){this._animateNumberSetter=b.numberStep}),f=a.complete;a.complete=function(){h.each(function(){delete this._animateNumberSetter});f&&f.apply(this,arguments)}}return e.animate.apply(e,g)}})(jQuery);

/* lc_switch.js */
(function(a){if("undefined"!=typeof a.fn.lc_switch)return!1;a.fn.lc_switch=function(d,f){a.fn.lcs_destroy=function(){a(this).each(function(){a(this).parents(".lcs_wrap").children().not("input").remove();a(this).unwrap()});return!0};a.fn.lcs_on=function(){a(this).each(function(){var b=a(this).parents(".lcs_wrap"),c=b.find("input");"function"==typeof a.fn.prop?b.find("input").prop("checked",!0):b.find("input").attr("checked",!0);b.find("input").trigger("lcs-on");b.find("input").trigger("lcs-statuschange");
    b.find(".lcs_switch").removeClass("lcs_off").addClass("lcs_on");if(b.find(".lcs_switch").hasClass("lcs_radio_switch")){var d=c.attr("name");b.parents("form").find("input[name="+d+"]").not(c).lcs_off()}});return!0};a.fn.lcs_off=function(){a(this).each(function(){var b=a(this).parents(".lcs_wrap");"function"==typeof a.fn.prop?b.find("input").prop("checked",!1):b.find("input").attr("checked",!1);b.find("input").trigger("lcs-off");b.find("input").trigger("lcs-statuschange");b.find(".lcs_switch").removeClass("lcs_on").addClass("lcs_off")});
    return!0};return this.each(function(){if(!a(this).parent().hasClass("lcs_wrap")){var b="undefined"==typeof d?"ВКЛ":d,c="undefined"==typeof f?"ВЫКЛ":f,b=b?'<div class="lcs_label lcs_label_on">'+b+"</div>":"",c=c?'<div class="lcs_label lcs_label_off">'+c+"</div>":"",g=a(this).is(":disabled")?!0:!1,e=a(this).is(":checked")?!0:!1,e=""+(e?" lcs_on":" lcs_off");g&&(e+=" lcs_disabled");b='<div class="lcs_switch '+e+'"><div class="lcs_cursor"></div>'+b+c+"</div>";!a(this).is(":input")||"checkbox"!=a(this).attr("type")&&
"radio"!=a(this).attr("type")||(a(this).wrap('<div class="lcs_wrap"></div>'),a(this).parent().append(b),a(this).parent().find(".lcs_switch").addClass("lcs_"+a(this).attr("type")+"_switch"))}})};a(document).ready(function(){a(document).delegate(".lcs_switch:not(.lcs_disabled)","click tap",function(d){a(this).hasClass("lcs_on")?a(this).hasClass("lcs_radio_switch")||a(this).lcs_off():a(this).lcs_on()});a(document).delegate(".lcs_wrap input","change",function(){a(this).is(":checked")?a(this).lcs_on():
    a(this).lcs_off()})})})(jQuery);

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#buttonz22').click(function() {
        var id = $('#buttonz22').attr("data-steamid");
      $.ajax({
        url: '/api/addbonus',
        type: 'get',
        data: {user: id},
        dataType: 'json',
        success: function(rdata){
          if('success' == rdata.status){
              smoke.alert("Баланс пополнен!");
          }else{
            smoke.alert("Для бонуса необходимо подождать -: "+rdata.hoursleft+" часов");
          }
        }
      });
    });
    var socket = io.connect(':2020');

    /* Get last gifts list */
    socket.on('last gifts', function (data_gifts) {


        var data_g = '';
        var live_gifts_list = '';


        $.each(data_gifts, function(i) {

            data_lgift = data_gifts[i];

            if (data_lgift['user'] != undefined && data_lgift['gift'] != undefined) {
                live_gifts_list += '<div class="b eas"><div class="winner-box eas"><div class="winner eas"><a href="/profile/'+data_lgift['user_id']+'"><img src="'+data_lgift['user_avatar']+'" alt="'+data_lgift['gift']+'"></a></div></div><img src="'+data_lgift['gift_img']+'" alt="150"></div>';
            }

        });

        $("#live-prize-box").html(live_gifts_list);


    });


    /* Get last one gift */
    socket.on('last gift get', function (data_gift) {

        var live_gift = '<div class="b eas"><div class="winner-box eas"><div class="winner eas"><a href="/profile/'+data_gift.user_id+'"><img src="'+data_gift.user_avatar+'" alt="'+data_gift.gift+'"></a></div></div><img src="'+data_gift.gift_img+'" alt="150"></div>';

        $("#live-prize-box").prepend(live_gift);
        $('#live-prize-box .b').last().remove();

    });

    /* Live statbox  */
    window.statbox = {'online':0, 'users':0, 'cases':0};

    socket.on('statbox', function (data_statbox) {

        var csns = $.animateNumber.numberStepFactories.separator(',');

        if (window.statbox['online'] != data_statbox[0]) {
            $('#st-online').animateNumber({ number: data_statbox[0], numberStep: csns }, 300);
            window.statbox['online'] = data_statbox[0];
        }

        if (window.statbox['users'] != data_statbox[1]) {
            $('#st-users').animateNumber({ number: data_statbox[1], numberStep: csns }, 300);
            window.statbox['users'] = data_statbox[1];
        }

        if (window.statbox['cases'] != data_statbox[2]) {
            $('#st-cases').animateNumber({ number: data_statbox[2], numberStep: csns }, 300);
            window.statbox['cases'] = data_statbox[2];
        }

    });

    if (($(".lcs_check").length > 0)) {

        $('.lcs_check').lc_switch();

        $('body').delegate('.lcs_check', 'lcs-statuschange', function() {
            var status = ($(this).is(':checked')) ? 'checked' : 'unchecked';
            var value = ($(this).is(':checked')) ? $(this).data('lcs') : 0;
            var visual_value = ($(this).is(':checked')) ? $(this).val() : 0;


            if (status == 'checked') {
                spin_chance = value;
                $(".lcs_check").lcs_off();
            }

            window.spin_chance = value;
            var total = parseInt(visual_value) + parseInt(window.spin_amount);

            $("#spin-amount").text(total);
        });
    }

    /* Cases animation */
    if ($('.case-grid').length > 0) {

        var item = document.querySelectorAll('.case-grid');

        (function animate(counter) {

            setTimeout(function() {

                item[counter].classList.add('show');

                counter++;

                if(counter < item.length) animate(counter);

            }, 150);

        })(0);

    }

    /* Responsive navigation */
    $(".nav-button").click(function(){
        var status = $(".nav ul").css("display");

        if (status == 'none') {
            $(".nav ul").fadeIn(0);
        }
        else {
            $(".nav ul").fadeOut(100);
        }
    });
});

function cleanWinAnimation() {

    //$("#audio-win").animate({volume: 0.0}, 300, function(){
    var audioWin = document.getElementById("audio-win-"+window.win_sound);
    audioWin.currentTime = 0;
    audioWin.pause();
    //});

    //$("#audio-spin").animate({volume: 0.0}, 300, function(){
    var audioSpin = document.getElementById("audio-spin");
    audioSpin.currentTime = 0;
    audioSpin.pause();
    //});

    $(".spin-won").fadeOut(300);
    $(".history-cases").fadeIn(300);
    $(".case-page-title").fadeIn(300);
}

function winAnimation(type) {

    window.win_sound = Math.round(Math.random()*1);

    if (type == 2) {
        $(".spin-won h4").fadeIn(0);
    }
    else {
        $(".spin-won h4").fadeOut(0);
    }

    $("#audio-spin").animate({volume: 0.0}, 300, function(){
        $("#audio-spin").trigger('stop');
        $("#audio-win-"+window.win_sound).trigger('play');
        $("#audio-win-"+window.win_sound).animate({volume: 1.0}, 1000);
    });

    $(".spin-won").fadeIn(300);
    $(".history-cases").fadeOut(0);
    $(".case-page-title").fadeOut(0);
}

var roundOptions = new Array;
var rouletteObject = new Array;

function spinbox(gameId, button, count) {

    var gameButton = $(button);
    var gamePrice = parseFloat($("#spin-amount").text());
    var gameButtonText = $(button).html();
    var gameLoader = $("#game-"+gameId+" .loading");
    var otherButtons = $(".three .btn");
    var gameChance = window.spin_chance;

    gameButton.text("Открываем кейс...");
    gameButton.attr("disabled", "disabled");

    $("#audio-win-"+window.win_sound).animate({volume: 0.0}, 0);
    $("#audio-spin").animate({volume: 0.0}, 0);





    // BEGIN AJAX REQUEST
    $.post('/opencase/'+gameId+'/'+gameChance, function(data) {

        var resultData = data;
        var showResult = resultData.data;

        if (resultData.status == 1) {

            var giftImg = 0;
            $.each( $('.roulette img'), function() {
                var g = parseInt($(this).attr("id").split('gift-id-')[1]);
                giftImg++;
                if (g == showResult['gift']) {
                    showResult.result = giftImg-1;

                }
            });

            roundOptions[gameId] = {
                speed : 24,
                duration : 1,
                stopImageNumber : showResult.result,
                startCallback: function() {

                    UpdateBalance(-1*gamePrice);

                    var socket = io.connect(':2020');

                    socket.emit('last gift set');

                },
                stopCallback : function() {

                    var startNewGame = setTimeout(function(){

                        gameButton.html(gameButtonText);
                        gameButton.removeAttr("disabled");

                        UpdateBalance(showResult['win_sum']);

                        /* win info */
                        $("#spin-win-name").html(showResult['text']);
                        $("#spin-win-icon").attr("src", showResult['photo']);

                        winAnimation(showResult['type']);

                    }, 1000);
                }
            }


            if (rouletteObject[gameId] == undefined || rouletteObject[gameId] == 'undefined') {
                rouletteObject[gameId] = $(".roulette").roulette(roundOptions[gameId]);
            }
            else {
                rouletteObject[gameId].roulette('option', roundOptions[gameId]);
            }
            rouletteObject[gameId].roulette('start');

            $("#audio-spin").trigger('play');
            $("#audio-spin").animate({volume: 1.0}, 2000);

        }
        else {
            smoke.alert(resultData.error);

            gameButton.html(gameButtonText);
            gameButton.removeAttr("disabled");
        }

    });
    // END AJAX REQUEST

}

function CreateTicket() {
    var ticketForm = 'form[name="form-support"]';
    var ticketData = $( ticketForm ).serialize();

    $(ticketForm+' .loader').fadeIn(100);

    $.post("/supports/"+ticketData ,function(data) {
        data = JSON.parse(data);

        /* success */
        if (data['status'] == 1) {
            $(ticketForm).html('<div class="infobox">'+data['message']+'</div>');
        }
        /* error */
        else {
            smoke.alert(data['message']);
        }

    }).done(function(){
        $(ticketForm+' .loader').fadeOut(1000);
    });
}


function RedeemCode(code, btn, loader) {
    $(loader).fadeIn(100);

    $.post("/refuse", '&code='+$(code).val() ,function(data) {
        data = JSON.parse(data);

        /* success */
        if (data['status'] == 1) {
            smoke.alert(data['message']);
            UpdateBalance(data['sum']);
            $(code).attr("disabled","disabled");
            $(btn).remove();
        }
        /* error */
        else {
            smoke.alert(data['message']);
        }

    }).done(function(){
        $(loader).fadeOut(500);
    });
}

function UpdateBalance(sum) {
    $("#user-balance").text(parseFloat($("#user-balance").text()) + parseFloat(sum));

    if (($("#u-balance-field").length > 0)) {
        $("#u-balance-field").text(parseFloat($("#u-balance-field").text()) + parseFloat(sum));
    }
}

function popupOpen(id) {
    $(id +" .popup-container").css("top","200%");
    $(id).fadeIn(300);

    $(id +" .popup-container").animate({
        top: "40%"
    }, 500, function() {

        $( ".popup-container" ).animate({
            top: "50%"
        }, 500, function() {

        });
    });
}

function popupClose(id) {
    $(id +" .popup-container").animate({
        top: "60%"
    }, 500, function() {

        $(id).fadeOut(500);

        $(id+" .popup-container").animate({
            top: "-300%"
        }, 500, function() {

        });
    });
}

function changePaymentMethod(pm, holder) {
    $(".payment-method").removeClass("active");
    $(".pm-"+pm).addClass("active");

    $("#form-deposit").prop("action", "/payment/"+pm+"/go/");
    $("#withdrawal-type-field").val(pm);

    if (holder != undefined) {
        document.getElementsByClassName('PurseHolder')[0].placeholder=holder;
    }
}

function withdrawalNow() {

	var withdrawalForm = 'form[name="form-withdrawal"]';
	var loader = withdrawalForm+' .loader';
		$(loader).fadeIn(100);

    var price = $("#amountVivod").val();
    var koshel = $('#koshelekVivod').val();

	$.post('/vivod/'+price+'/'+koshel,function(data) {

		if (data['status'] == 1) {
			smoke.alert(data['message']);
			popupClose('#withdrawal');
		}
		else {
			smoke.alert(data['message']);
		}

	}).done(function(){
		$(loader).fadeOut(500);
	});
}

function depositNow() {
    $("#form-deposit").submit();
}
