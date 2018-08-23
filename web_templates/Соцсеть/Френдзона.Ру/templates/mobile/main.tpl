<!--?xml version="1.0" encoding="utf-8"?-->
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
{header}
<link type="text/css" rel="stylesheet" href="/templates/mobile/style/s_mbw.css">
<link type="text/css" rel="stylesheet" media="only screen" href="/templates/mobile/style/s_rt.css">
<link rel="shortcut icon" href="/templates/Default/images/favicon.ico">
{js}
</head>
[not-logged]
<body id="vk" class="x_wide x_head nt hover " onresize="onBodyResize(true);" onclick="">
	<div id="vk_head" class="mhead">
		<div class="btn">
			<div class="b">&nbsp;</div>
		</div>
	</div>
	<div id="vk_wrap" class="_vpan">
		
		<div id="m">
			<div id="mhead" class="mhead" onclick="">
				<div class="btn  logo">
					<a  class="b" accesskey="*" onclick="show();">
						<i></i>
					</a>
				</div>
				
				<div class="btn notify index">
					
				</div>
				
			</div>
			<div id="page" class="mcont">
				<div class="pcont login bl_cont">
<div class="panel prof_panel">
<div>Мобильная версия поможет Вам оставаться на сайте, даже если Вы далеко от компьютера.</div>
</div>
<div class="cont">
<form class="note_add_bg support_bg" style="margin-top:5px" action="" method="POST">
<dl>
<dt>Телефон или email:</dt>
<dd class="iwrap">
<input class="text" type="text" maxlength="50" name="email">
</dd>
</dl>
<dl>
<dt>Пароль:</dt>
<dd class="iwrap">
<input class="text" type="password" maxlength="50" name="password">
</dd>
</dl>
<dl>
<dd>
<div class="near_box">
<input class="btn" type="submit" value="Войти" name="log_in">
<div class="near_btn">
<a href="/restore" >Забыли пароль?</a>
</div>
</div>
</dd>
</dl>
</form>
</div>
</div>
			</div>
		</div>
	</div>
	<div id="mfoot" class="mfoot">
		<ul class="main_menu footer_menu">
			
			<li><a id="fv_link" class="fv_link" href="/?act=change_fullver">Полная версия</a></li>
			
		</ul>
	</div>
[/not-logged][logged]
<body id="vk" class="x_wide x_head nt hover _lm" onresize="onBodyResize(true);" onclick="">
	<div id="vk_head" class="mhead">
		<div class="btn">
			<div class="b">&nbsp;</div>
		</div>
	</div>
	<div id="vk_wrap" class="_vpan">
	
		<div id="l">
			<div class="mhead qs_enabled">
				<div class="head_search">
					<form action="/search" class="oneline qsearch with_icon with_clear" onsubmit="return lm_qsearch.go(event);">
						<input name="act" value="global" type="hidden">
						<table><tbody><tr>
						<td width="100%">
						<i class="search" onclick="elfocus('lm_search_field');"></i>
						<div style="display: none;" id="lm_search_clear" class="clear_btn" onclick="return lm_qsearch.clear(event, true);"></div>
						<div class="iwrap"><input id="lm_search_field" class="text" name="q" autocomplete="off" placeholder="Поиск" type="text"></div>
						</td>
						<td class="last"><input class="btn" value="Отмена" onclick="menu.cancelSearch();" type="button"></td>
						</tr>
						</tbody>
						</table>
					</form>
				</div>
				<div class="btn logo">
					<a onclick="Page.Go(this.href); return false;" href="{my-page-link}" class="b" onclick="return menu.headerAction(event);">
						<span class="bottom"></span><i></i>
					</a>
				</div>
			</div>
			<div id="lm_search_items" class="m_search_items"></div>
			<div id="lm_cont" class="m_search_cont">
				<div class="pcont main">
					<div id="lm_top_notify" style="display:none;">
					<div class="notify_panel">
					<div class="notify birth top_notify">
					<a class="close" onclick="return ajax.click(this, Notify);" href="/?act=hide_notify&notify=birthday"></a>
					<a href="/gifts?act=holidays&from=notify#birthdays" onclick="Page.Go(this.href); return false">
					<i class="gift"></i>
					<div class="cont">
					<div class="label">
					Завтра день рождения
					<span class="user">Ильи Клеймёнова</span>
					.
					</div>
					<div class="pics">
					<img width="" src="http://cs317324.userapi.com/v317324060/6338/iAb11iVY-XY.jpg">
					</div>
					</div>
					</a>
					</div>
					</div>
					</div>
					<div id="lm_prof_panel">
						<div class="panel prof_panel al_{my-page-link}" onclick="Page.Go('{my-page-link}'); return false;s('{my-name}');">
							<div class="user_wrap">
								<a onclick="Page.Go(this.href); return false;" class="al_u{my-id}" href="{my-page-link}">
									<img src="{my-ava}" class="u _{my-page-link}" align="left">
								</a>
								<i class="arr"></i>
								<div class="cont">
									<h2>
										<a onclick="Page.Go(this.href); return false;" class="al_id{my-id} aluser user" href="{my-page-link}">
										{my-name}
										
										</a> <b class="o lvi"></b>
									</h2>
									<div class="status">
										<a href="{my-page-link}">Установить статус</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<ul class="main_menu">
						<li class="friends">
						<a onclick="Page.Go(this.href); return false;" href="/friends{requests-link}" class="al_menu">
						<i></i><span class="wrap"><span class="label">Мои Друзья</span></span></a></li>
						<li class="photos">
						<a onclick="Page.Go(this.href); return false;" href="/albums/{my-id}" class="al_menu">
						<i></i><span class="wrap"><span class="label">Мои Фотографии</span><span id="new_photos"></span></span>
						</a>
						</li>
						<li class="mail">
						<a onclick="Page.Go(this.href); return false;" href="/messages" class="al_menu">
						<i></i>
						<span class="wrap"><span class="label">Мои Сообщения</span></span>
						</a>
						</li>
						<!--li class="feed">
						<a onclick="Page.Go(this.href); return false;" href="/news" class="al_menu">
						<i></i>
						<span class="wrap"><span class="label">Мои Новости</span></span>
						</a>
						</li--!>
						<li class="answers">
						<a onclick="Page.Go(this.href); return false;" href="/news/notifications" class="al_menu">
						<i></i>
						<span class="wrap"><span class="label">Мои Ответы</span></span>
						</a>
						</li>
						<li class="groups">
						<a onclick="Page.Go(this.href); return false;" href="/groups" class="al_menu">
						<i></i>
						<span class="wrap"><span class="label">Мои Группы</span></span>
						</a>
						</li>
						<li class="fave">
						<a onclick="Page.Go(this.href); return false;" href="/fave" class="al_menu">
						<i></i><span class="wrap"><span class="label">Мои Закладки</span></span>
						</a>
						</li>
						<li class="search">
						<a onclick="Page.Go(this.href); return false;" href="/?go=search&query=&type=1" class="al_menu">
						<i></i><span class="wrap"><span class="label">Поиск</span></span>
						</a>
						</li>
					</ul>
					<div style="display: none;" id="lm_player" class="player">
						<div id="lm_audio" class="audio al_player" data-href="#player" onclick="return audioplayer.openPlayer(this);">
							<div class="play" onclick="audioplayer.playPause(); cancelEvent(event);"><i></i></div>
							<div class="audio_cont">
								<i class="arr"></i>
								<div class="audio_label">
									<div class="artist"></div>
									<div class="title"></div>
								</div>
							</div>
						</div>
					</div>
					<div id="lm_bottom_notify"></div>
				</div>
				<div class="mfoot">
					<ul class="main_menu">
						<li class="settings">
							<a onclick="Page.Go(this.href); return false;" href="/settings" class="al_menu">
								<i></i><span class="wrap"><span class="label">Настройки</span></span>
							</a>
						</li>
						<li class="fv">
							<a id="lm_fv_link" href="/?act=change_fullver">
								<i></i><span class="wrap"><span class="label">Полная версия</span></span>
							</a>
						</li>
						<li class="logout">
							<a href="/?act=logout">
								<i></i><span class="wrap"><span class="label">Выход</span></span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>

<div id="m">
			<div id="mhead" class="mhead" onclick="">
				<div class="btn home ">
					<a  class="b" accesskey="*" onclick="show();">
						<i></i>
					</a>
				</div>
				
				<div class="btn notify ">
					<a onclick="Page.Go(this.href); return false;" id="header_msgs" href="/messages" class="b no_notify" accesskey="#">
						<i></i>
					</a>
				</div>
				
				<div class="btn back">
					<div class="b">
						<div id="titles" class="title">
							<h1><h1>{my-name}</h1></h1>
						</div>
					</div>
				</div>
				
			</div>
<div id="page" class="mcont">
				<div id="meseg" class="pcont settings" >
<div class="cont bl_item">
<form onsubmit="return false;">
{info}{content}
</div></div></div>
	<div id="mfoot" class="mfoot">
		<ul class="main_menu footer_menu">
			<li><a onclick="Page.Go(this.href); return false;" href="/u{my-id}">На главную</a></li>
			<li><a id="fv_link" class="fv_link" href="/?act=change_fullver">Полная версия</a></li>
			<li><a href="/?act=logout">Выход</a></li>
		</ul>
	</div>
	<script type="text/javascript">
function upClose(xnid){
	$('#event'+xnid).remove();
	$('#updates').css('height', $('.update_box').size()*123+'px');
}

	function show(){
		$('#mhead').attr('onClick', 'hide();');
		$('body').addClass('lm_opened');
		
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
				else uTitle = 'Событие';
				temp = '<div class="update_box cursor_pointer" id="event'+row[4]+'" onClick="GoPage(event, \''+row[6]+'\'); upClose('+row[4]+')"><div class="update_box_margin"><div style="height:19px"><span>'+uTitle+'</span><div class="update_close fl_r no_display" id="update_close" onMouseDown="upClose('+row[4]+')"><div class="update_close_ic" id="update_close2"></div></div></div><div class="clear"></div><div class="update_inpad"><a href="/u'+row[2]+'" onClick="Page.Go(this.href); return false"><img src="'+row[5]+'" id="no_ev" /></a><div class="update_data"><a id="no_ev" href="/u'+row[2]+'" onClick="Page.Go(this.href); return false">'+row[1]+'</a>&nbsp;&nbsp;<br>'+row[3]+'</div></div><div class="clear"></div></div></div>';
				$('#updates').html($('#updates').html()+temp);
				if($('.update_box').size() <= 5) $('#updates').animate({'height': (123*$('.update_box').size())+'px'});
				if($('.update_box').size() > 5){
					evFirst = $('.update_box:first').attr('id');
					$('#'+evFirst).animate({'margin-top': '-123px'}, 400, function(){
						$('#'+evFirst).fadeOut('fast', function(){
							$('#'+evFirst).remove();
						});
					});
				}
				function icqmess(){     
					$('body').append('<embed type="application/x-shockwave-flash" src="http://s104.ucoz.net/flash/audio1.swf?song_url=/templates/Default/js/001.mp3&autoplay=1&loop=0" width="0" height="0"/>')   
				}
			   icqmess()  
			}
		});
	}, 4000);
});
</script>[/logged]
</body>
</html>