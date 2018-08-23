<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
   [logged]{url_img}   [/logged]
{header}
<noscript><meta http-equiv="refresh" content="0; URL=/badbrowser.php"></noscript>
   [logged]
<link media="screen" href="{theme}/style/style.css" type="text/css" rel="stylesheet" /> 
<script type="text/javascript" type="text/javascript" src="{theme}/js/payment.js?v={randjs}"></script>
<script type="text/javascript" src="{theme}/js/classie.js?v={randjs}"></script>
<script type="text/javascript" src="{theme}/js/modalEffects.js?v={randjs}"></script>
  [/logged]
[not-logged]<link media="screen" href="{theme}/reg_style/restore.css" type="text/css" rel="stylesheet" /> [/not-logged]
<link rel="shortcut icon" href="{theme}/images/uic.png" />
<link media="screen" href="{theme}/style/hint.css" type="text/css" rel="stylesheet" />
{js}
<script type="text/javascript" type="text/javascript" src="{theme}/js/ik.js?v={randjs}"></script>
<script type="text/javascript" type="text/javascript" src="{theme}/js/toolltips.js?v={randjs}"></script>
[not-logged]<script type="text/javascript" src="{theme}/js/reg.js"></script>[/not-logged]
<script type="text/javascript" src="{theme}/js/fon.js"></script>  
<script type="text/javascript" src="{theme}/js/js_top.js"></script>
<script type="text/javascript" src="{theme}/js/jquery.imagesloaded.js"></script>
<script type="text/javascript" src="{theme}/js/jquery.wookmark.js"></script>
<script type="text/javascript" src="{theme}/js/pins.js"></script>
<script type="text/javascript" src="{theme}/js/mybanners.js?{randjs}"></script>
<script type="text/javascript"> 
function diplay_hide (blockId)
{ 
    if ($(blockId).css('display') == 'none') 
        { 
            $(blockId).animate({height: 'show'}, 500); 
        } 
    else 
        {     
            $(blockId).animate({height: 'hide'}, 500); 
        }}
</script>
[logged]
<script>
var my_id = {my-id};
</script>
[/logged]
<script type="text/javascript" src="{theme}/js/audio_player.js"></script>
</head>
<body onResize="onBodyResize()" class="no_display" onload="slider(slider, 0)">
<div class="clear"></div> 
{url_img}<div id="doLoad"></div> 
[not-aviable=main]<div class="head">
  [logged]<div class="udinsMy"></div><div class="logo_user"></div>[/logged]
  [not-logged]<a href="/" class="udins"></a>[/not-logged]
    <div class="autowr">
	<div id="container-wrap">
	<div id="node-heap"></div></div>
  <div class="headmenu">
   [logged]
    <div class="text_head_left">
<a class="headm_posic_home active1" href="{my-page-link}" onClick="Page.Go(this.href); return false;">
<img src="{theme}/images/spacer.gif" class="headm_ic_home" />  <div class="text_head_risssgt">Моя страница </div>
<a  class="headm_posic_mes active2" href="/messages" title="Сообщения" onClick="Page.Go(this.href); return false;"> <img src="{theme}/images/spacer.gif" class="headm_ic_mess" /> 	<div class="bls_mess" id="new_msg">{msg}</div> </a> </a>
</div>
<div class="speedbar [speedbar]no_display[/speedbar]" id="speedbar">{speedbar}</div>
  <div class="text_head_rigt">
	  <span class="hint--bottom fl_l" data-hint="Поиск">
<a class="fl_l search_ic_sw active_search"  href="/?go=search&online=1" onClick="Page.Go(this.href); return false;">

<img src="{theme}/images/spacer.gif" class="headm_ic_search" />
</a>
</span>
	  <span class="hint--bottom fl_l" data-hint="Лото">
<a class="fl_l search_ic_sw active_loto"  href="/loto?act=two" onClick="Page.Go(this.href); return false;">

<img src="{theme}/images/spacer.gif" class="headm_ic_loto" />
</a>
</span>
<span class="hint--bottom fl_l" data-hint="Новости">
<a class="fl_l search_ic_sw active_news"  href="/news{news-link}" onClick="Page.Go(this.href); return false;" id="news_link">
<img src="{theme}/images/spacer.gif" class="headm_ic_news" />
</a>
</span>
<span class="hint--bottom fl_l" data-hint="Приложения">
<a class="fl_l search_ic_sw active_game" href="/webtomat" onClick="Page.Go(this.href); return false;">
<img src="{theme}/images/spacer.gif" class="headm_ic_games" />
</a>
</span>
<span class="hint--bottom fl_l" data-hint="Настройки">
<a class="fl_l search_ic_sw active_setings" href="/settings" onClick="Page.Go(this.href); return false;">
<img src="{theme}/images/spacer.gif" class="headm_ic_settings" />
</a>
</span>
<span class="hint--bottom fl_l" data-hint="Выйти">
<a class="fl_l search_ic_sw" href="/?act=logout">
<img src="{theme}/images/spacer.gif" class="headm_ic_logout" />
</a>
</span>
   <!--menu-konec-->
   <!--search-->
   <!--/search-->[/logged]
  </div>
   <div class="clear"></div>
   <div class="bbdeface"></div>
      <div class="bbdeface2"></div>
 </div>
 <div class="clear"></div>
</div>		 </div>
<div class="autowr">
<div style="margin-top:49px;"></div>
<div class="clear"></div>
  <div class="box_sdsss"> </div>
 	  <div class="box_sd"> </div>
	   	  <div class="box_sdS"> </div>
 <div class="content" [logged]style="width:1022px;"[/logged]> 
{banner-top}
    <div class="padcont">
	 [logged]
 <div class="flw_lef">
    <div class="clesadasdasdasdasdasdasdasdar"></div>
 <div class="ava">
<div class="userAvatarPositionBox">
<div id="avatarBox" class="userAvatarBox ng-avatar ng-scope">
<div class="img_profiles">
<span id="ava" class="img_avas">{myphoto_headser}</span>
</div>
<div class="avatarMenu">
<div class="icon"></div>
<ul>
<li class="uploadItem">
<form id="avatarForm" class="upload ng-pristine ng-valid"  onClick="Profile.LoadPhoto(); $('.profileMenu').hide(); return false;">
<div style="display:none">
</div>
<span class="icon1"></span>
<p>Загрузить новую фотографию</p>
</form>
</li>
<li class="edit" onClick="Profile.miniature(); return false;">
<span class="icon2"></span>
<p>Изменить миниатюру</p>
</li>
<li class="remove" onClick="Profile.DelPhoto(); $('.profileMenu').hide(); return false;">
<span class="icon3"></span>
<p>Удалить</p>
</li>
</ul>
</div></div></div>
<span id="vip_conr" class="tolleft_trigger">
{vip_status}</span> 
 <div class="status_profile_box nclear" id="status_profile_box">
<div class="set_status_bg no_display" id="set_status_bg">
<textarea type="text" class="status_inp_profile" id="status_text" maxlength="255"  onKeyPress="if(event.keyCode == 13)gStatus.set()">{val-status-text-profile}</textarea>
<div class="fl_l status_text"><span class="no_status_text [status]no_display[/status]"></span></div>
<div class="btnstatus"><button id="status_but" onClick="gStatus.set()">Сохранить</button></div>
</div>
<div class="status_profile_inset" id="status_profile_inset">
<div>
<a href="/" id="new_status" onClick="gStatus.open(); return false">
{status-text-profile}
</a>
</div>
<span id="tellBlockPos"></span>
<a href="#" onClick="gStatus.open(); return false" id="status_link" [status]class="no_display"[/status]><div class="img_no_status"></div>У меня пока нет статуса.</a>
</div>
</div>
  <div class="flo_men">
  </div>
 <div class="box_scroll2">
<a href="/friends{requests-link}" onClick="Page.Go(this.href); return false;" id="requests_link"> 
<div class="frine"></div>
Друзья	<span id="new_requests"><div class="new_frie">{demands}</div></span></a>
<a href="/albums/{my-id}" onClick="Page.Go(this.href); return false;">
<div class="foto_my"></div>
Альбомы<span id="new_photos">{new_photos}</span></a>
<a href="/videos"onClick="Page.Go(this.href); return false;"><div class="videos"></div>Видео</a>
<a href="/audio" onclick="doLoad.js(0); player.open(); return false;"><div class="music_my"></div>Музыка</a>
<a href="{groups-link}" onClick="Page.Go(this.href); return false;" id="new_groups_lnk"><div class="groups_ics"></div>Сообщества<span id="new_groups">{new_groups}</span></a>
<a href="/fave" onClick="Page.Go(this.href); return false;"><div class="fave_ics"></div>Закладки</a>
<a href="/notes" onClick="Page.Go(this.href); return false;"><div class="blog_ics"></div>Заметки</a>
<a href="/guests" onClick="Page.Go(this.href); return false;"><div class="guests_ics"></div>Мои гости</a>
<a href="#" onclick="diplay_hide('#menu_ls');return false;"><div class="sidebar-collapse">...</div></a>
<span id="menu_ls" class="ffiwq" style="display: none;">
<a onclick="Page.Go(this.href); return false;" href="/my_stats">
<div><div class="static_proif"></div>Статистика страницы</div>
</a>
<a href="#" onclick="doLoad.data(1); fon.addbox()"><div class="fon_style"></div>Фон страницы</a>
<a href="/balance" onClick="Page.Go(this.href); return false;"><div class="balams"></div>Пополнить счёт</a>
<a href="/settings/privacy" onClick="Page.Go(this.href); return false;" ><div class="pivacy"></div>Приватность страницы</a>
</span>
</div>
{banner-right-1}
{banner-right-2}
{banner-right-3}
<div id="ads_view" style="display:none;"></div>
<div class="clear"></div>
<div class="go-up" title="Вверх" id='ToTop'><div class="scroll_fix_page_top"> Наверх</div></div>
</div> 
</div>[/logged]
    <div id="fplayer_pos" ></div>

	  <div class="flwsss_lef">
	 <div id="audioPlayer"></div>
	 <div id="page">{info}{content}</div>
	{banner-bottom}
	 <div class="clear"></div>
	</div>	 <div class="clear"></div>	
	</div>
<div class="clear"></div>
  <div class="cont_border_bottom"></div>

 </div>
 <div class="clear"></div>
 [logged]
</div>
[/logged]
[/not-aviable]
[aviable=main]
{info}{content}
<div class="clear"></div>
[/aviable]
[logged]<script type="text/javascript">
function upClose(xnid){
	$('#event'+xnid).remove();
	$('#updates').css('height', $('.update_box').size()*123+'px');
}
function GoPage(event, p){
	var oi = (event.target) ? event.target.id: ((event.srcElement) ? event.srcElement.id : null);
	if(oi == 'no_ev' || oi == 'update_close' || oi == 'update_close2') return false;
	else {
		pattern = new RegExp(/photo[0-9]/i);
		pattern2 = new RegExp(/video[0-9]/i);
		if(pattern.test(p))
			Photo.Show(p);
		else if(pattern2.test(p)){
			vid = p.replace('/video', '');
			vid = vid.split('_');
			videos.show(vid[1], p, location.href);
		} else
			Page.Go(p);
	}
}
$(document).ready(function(){
	setInterval(function(){
		$.post('/index.php?go=updates', function(d){
			row = d.split('|');
			if(d && row[1]){
				if(row[0] == 1) uTitle = 'Новый ответ на стене';
				else if(row[0] == 2) uTitle = 'Новый комментарий к фотографии';
				else if(row[0] == 3) uTitle = 'Новый комментарий к видеозаписи';
				else if(row[0] == 4) uTitle = 'Новый комментарий к заметке';
				else if(row[0] == 5) uTitle = 'Новый ответ на Ваш комментарий';
				else if(row[0] == 6) uTitle = 'Новый ответ в теме';
				else if(row[0] == 7) uTitle = 'Новый подарок';
				else if(row[0] == 8) uTitle = 'Новое сообщение';
				else if(row[0] == 9) uTitle = 'Новая оценка';
				else if(row[0] == 10) uTitle = 'Ваша запись понравилась';
				else if(row[0] == 11) uTitle = 'Новая заявка';
				else if(row[0] == 12) uTitle = 'Заявка принята';
				else if(row[0] == 13) uTitle = 'Подписки';
                                else uTitle = 'Событие';
				if(row[0] == 8){
					sli = row[6].split('/');
					tURL = (location.href).replace('http://'+location.host, '').replace('/', '').split('#');
					if(!sli[2] && tURL[0] == 'messages') return false;
					if($('#new_msg').text()) msg_num = parseInt($('#new_msg').text().replace(')', '').replace('(', ''))+1;
					else msg_num = 1;
					$('#new_msg').html("<div class=\"ic_newAct\">"+msg_num+"</div>");
				}
					if(row[0] == 11){
					sli = row[6].split('/');
					tURL = (location.href).replace('http://'+location.host, '').replace('/', '').split('#');
					if(!sli[2] && tURL[0] == 'friends') return false;
					if($('#new_requests').text()) friends_demands = parseInt($('#new_requests').text().replace(')', '').replace('(', ''))+1;
					else friends_demands = 1;
					$('#new_requests').html("<div class=\"ic_newAct\" >+"+friends_demands+"</div>");
				}
				setTimeout('upClose('+row[4]+');', 10000);
				temp = '<div class="update_box cursor_pointer" id="event'+row[4]+'" onClick="GoPage(event, \''+row[6]+'\'); upClose('+row[4]+')"><div class="update_box_margin"><div style="height:19px"><span>'+uTitle+'</span><div class="update_close fl_r no_display" id="update_close" onMouseDown="upClose('+row[4]+')"><div class="update_close_ic" id="update_close2"></div></div></div><div class="clear"></div><div class="update_inpad"><a href="/u'+row[2]+'" onClick="Page.Go(this.href); return false"><div class="update_box_marginimg"><img src="'+row[5]+'" id="no_ev" /></div></a><div class="update_data"><a id="no_ev" href="/u'+row[2]+'" onClick="Page.Go(this.href); return false">'+row[1]+'</a>&nbsp;&nbsp;'+row[3]+'</div></div><div class="clear"></div></div></div>';
				$('#updates').html($('#updates').html()+temp);
				var beepThree = $("#beep-three")[0];
				document.getElementById("beep-three").volume = 0.7;
				beepThree.play();
				if($('.update_box').size() <= 5) $('#updates').animate({'height': (123*$('.update_box').size())+'px'});
				if($('.update_box').size() > 5){
					evFirst = $('.update_box:first').attr('id');
					$('#'+evFirst).animate({'margin-top': '-123px'}, 400, function(){
						$('#'+evFirst).fadeOut('fast', function(){
							$('#'+evFirst).remove();
						});
					});
				}
			}
		});
	}, 3500);
});
</script>
<div class="no_display"><audio id="beep-three" controls preload="auto"><source src="{theme}/images/soundact.ogg"></source></audio></div>[/logged]
<div id="updates"></div>
<div class="clear"></div>

</body>

</html>