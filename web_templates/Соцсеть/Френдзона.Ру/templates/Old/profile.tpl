<script type="text/javascript">
$(document).ready(function() {

//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});

});
</script>

[not-owner]
<script type="text/javascript">
//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs_cover li:first").addClass("active_tab_cover").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content 
	$(document).ready(function() {
		//On Click Event cover
	$("ul.tabs_cover li").click(function() {
		$("ul.tabs_cover li").removeClass("active_tab_cover"); //Remove any "active" class
		$(this).addClass("active_tab_cover"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
	});
</script>[/not-owner]
<script type="text/javascript" src="{theme}/js/ik.js"></script>
<script type="text/javascript" src="{theme}/js/toolltips.js"></script>
{url_img}
<div class="avsdaa"></div>
<script type="text/javascript">
[after-reg]Profile.LoadPhoto();[/after-reg]
var startResizeCss = false;
var user_id = '{user-id}';
$(document).ready(function(){
$(window).scroll(function(){
if($('#type_page').val() == 'profile'){
if($(document).height() - $(window).height() <= $(window).scrollTop()+($(document).height()/2-250)){
wall.page(user_id);
}
if($(window).scrollTop() < $('#fortoAutoSizeStyleProfile').offset().top){
startResizeCss = false;
$('#addStyleClass').remove();
}
}
});
music.jPlayerInc();
[owner]if($('.profile_onefriend_happy').size() > 4) $('#happyAllLnk').show();
ajaxUpload = new AjaxUpload('upload_cover_profile', {
action: '/index.php?go=editprofile&act=upload_cover',
name: 'uploadfile',
onSubmit: function (file, ext) {
if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
addAllErr(lang_bad_format, 3300);
return false;
}
$("#les10_ex2_profile").draggable('destroy');
$('.cover_loaddef_bg_profile').css('cursor', 'default');
$('.cover_loading_profile').show();
$('.cover_newpos_profile, .cover_descring_profile').hide();
$('.cover_profile_bg_profile').css('opacity', '0.4');
},
onComplete: function (file, row){
if(row == 1 || row == 2) addAllErr('Максимальны размер 7 МБ.', 3300);
else {
$('.cover_loading_profile').hide();
$('.cover_newpos_profile').show();
$('.cover_loaddef_bg_profile, .cover_hidded_but_profile, .cover_loaddef_bg_profile, .cover_descring_profile').show();
$('#upload_cover_profile').text('Изменить фото');
$('.cover_profile_bg_profile').css('opacity', '1');
$('.cover_loaddef_bg_profile').css('cursor', 'move');
$('#upload_cover_profile').css('margin-left', '0px');
$('#upload_cover_profile').css('margin-top', '12px');
$('.cover_newposswrt_profile').css('width', '577px');
$('.cover_newpos_profile').css('margin-left', '-7px');
$('.cover_newpos_profile').css('width', '577px');
$('.cover_newposswrt_profile').css('width', '577px');
$('.cover_newposswrt_profile').css('background', 'url("") repeat scroll 0 0 rgba(0, 0, 0, 0.59)');
$('.tabs').hide();
row = row.split('|');
				rheihht = row[1];
				postop = (parseInt(rheihht/2)-100);
				if(rheihht <= 230) postop = 0;
				$('#les10_ex2_profile').css('height', +rheihht+'px').css('top', '-'+postop+'px');
				coverpro.init('/uploads/users/'+row[0], rheihht);
				$('.cover_addut_edits_profile').attr('onClick', 'coverpro.startedit(\'/uploads/users/'+row[0]+'\', '+rheihht+')');}

}
});[/owner]
});
$(document).click(function(event){
wall.event(event);
});
function nshb(){
$('#nshb').text('Скрыть блоки').attr('onClick', 'nshbb(); return false');
$('.b_friends, .b_friends_online, .b_people, .b_pages, .b_video, .b_audio, .b_notes, .b_albums, .b_gifts, .b_photo, .b_wall').show();
}
function nshbb(){
$('#nshb').text('Показать скрытые блоки').attr('onClick', 'nshb(); return false');
$('.b_friends, .b_friends_online, .b_people, .b_pages, .b_video, .b_audio, .b_notes, .b_albums, .b_wall, .b_gifts[owner], .b_photo[/owner]').hide();
}
var lastBannerId = 1;
var intValBanner = false;
intValBanner = '';
function startShowBanners(){
var siBanner = $('.bannerSite').size();
if(siBanner > 1){
$('#banner1, #banner2, #banner3, #banner4').hide();
lastBannerId++;
if(lastBannerId >= 5) lastBannerId = 1;
if(!$('#banner'+lastBannerId).length) startShowBanners();
$('#banner'+lastBannerId).fadeIn(3000);
}
}
[update-banner]intValBanner = setInterval('startShowBanners()', 30000);[/update-banner]
</script>

<input type="hidden" id="type_page" value="profile" />
<div id="jquery_jplayer"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
<div class="leftcbosadsr">

<div class="ava" style="float:right;margin-right:-211px">

[owner][obshenie]<div class="blok_obzid">
  <h4 class="title_obshenie">Хочу общаться!</h4><div class="obshenie">{avatar_obshenie}<div class="p_blos_vipo">{vip_obze}</div><div class="name_obshenie">{name_obshenie}</div><div class="text_obshenie"><div class="obze2"></div>{text}</div></div>
</div>[/obshenie][/owner]
<div class="clear"></div>
[not-owner]
<div style="position: absolute; margin-left: 182px; margin-top: -20px; z-index: 50;">{user_znachok}</div>
<div class="menulseftssssss442s"><div class="b_photo {b_photo}"><span id="ava"><a class="cursor_pointer" onClick="Profile.ava('{ava}', '{user-id}')"><div class="b_photoS"><img src="{ava}" alt="" title="" id="ava_{user-id}" /></div></a></span></div>{vip_status}</div>[/not-owner]
[not-owner]
 <div class="status_profile_box" id="status_profile_box">


<div class="status_profile_inset_not_owner" id="status_profile_inset">
<div>
{status-text}
</div>
<a href="#" [status]class="no_display"[/status]><div class="img_no_status"></div>У меня пока нет статуса.</a>
</div>


</div>
<div class="menulseft" style="margin-top:5px">
<div class="menulseftssss">
[no-friends][blacklist]<a href="/" onClick="friends.add({user-id}); return false"><div class="box_inf_x_dob"><div class="box_inf_x_dob_img"></div><div>Добавить в друзья</div></div></a>[/blacklist][/no-friends]
[blacklist][privacy-msg]<a href="/" onClick="messages.new_({user-id}); return false"><div class="box_inf_x_mess"><div class="box_inf_x_dob_imgs"></div><div>Отправить сообщение</div></div></a>[/privacy-msg][/blacklist]
[yes-friends]<a href="/" onClick="friends.delet({user-id}, 1); return false"><div class="box_inf_x_dob_del"><img class="icon del_friends" src="{theme}/images/spacer.gif" alt="" /><div>Убрать из друзей</div></div></a>[/yes-friends]</div>
<div class="leftcbossssssssr">
[blacklist][no-subscription]<a href="/" onClick="subscriptions.add({user-id}); return false" id="lnk_unsubscription"><div class="box_inf_x_podps"><img class="icon subs_ic" src="{theme}/images/spacer.gif" alt="" /><div><span id="text_add_subscription">Подписаться на обновления</span><img src="/templates/Old/images/loading_mini.gif" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></div></a>[/no-subscription][/blacklist]
[yes-subscription]<a href="/" onClick="subscriptions.del({user-id}); return false" id="lnk_unsubscription"><div class="box_inf_x_otps"><img class="icon subs_ic" src="{theme}/images/spacer.gif" alt="" /><div><span id="text_add_subscription">Отписаться от обновлений</span><img src="" class="imgpods" alt="" id="addsubscription_load" class="no_display" style="margin-right:-13px" /></div></div></a>[/yes-subscription]
<a href="/" onClick="gifts.box('{user-id}'); return false"><div class="box_menu_user"><img class="icon new_gift" src="{theme}/images/spacer.gif" alt="" /><div>Отправить подарок</div></div></a>
[no-fave]<a href="/" onClick="fave.add({user-id}); return false" id="addfave_but"><div class="box_menu_user"><img class="icon fav_ic" src="{theme}/images/spacer.gif" alt="" /><div><span id="text_add_fave">Добавить в закладки</span> <img src="/templates/Old/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></div></a>[/no-fave]
[yes-fave]<a href="/" onClick="fave.delet({user-id}); return false" id="addfave_but"><div class="box_menu_user"><img class="icon fav_ic" src="{theme}/images/spacer.gif" alt="" /><div><span id="text_add_fave">Удалить из закладок</span> <img src="/templates/Old/images/loading_mini.gif" alt="" id="addfave_load" class="no_display" /></div></div></a>[/yes-fave]
[no-blacklist]<a href="/" onClick="settings.addblacklist({user-id}); return false" id="addblacklist_but"><div class="box_menu_user"><img class="icon compla_ic" src="{theme}/images/spacer.gif" alt="" /><div><span id="text_add_blacklist">Заблокировать</span> <img src="/templates/Old/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></div></a>[/no-blacklist]
[yes-blacklist]<a href="/" onClick="settings.delblacklist({user-id}, 1); return false" id="addblacklist_but"><div class="box_menu_user"><img class="icon compla_ic" src="{theme}/images/spacer.gif" alt="" /><div><span id="text_add_blacklist">Разблокировать</span> <img src="/templates/Old/images/loading_mini.gif" alt="" id="addblacklist_load" class="no_display" /></div></div></a>[/yes-blacklist]
</div>
</div>[/not-owner]
<div class="clear"></div>
[blacklist]<div class="leftcbor">
[banners]<div class="albtitle_proz">Реклама</div><div style="padding-top:10px;padding-bottom:10px">{banner-left}{banner-right}{banner-top}{banner-bottom}</div>[/banners]
[owner][happy-friends]<div id="happyBLockSess"><div class="albtitle_proz">Дни рожденья друзей <span>{happy-friends-num}</span><div class="profile_happy_hide"><img class="hide_happy" onMouseOver="myhtml.title('1', 'Скрыть', 'happy_block_')" id="happy_block_1" onClick="HappyFr.HideSess(); return false" /></div></div>
<div class="newmesnobg_style profile_block_happy_friends" style="padding:0px;padding-top:10px;">{happy-friends}<div class="clear"></div></div>
<div class="cursor_pointer no_display" onMouseDown="HappyFr.Show(); return false" id="happyAllLnk"><div class="public_wall_all_comm profile_block_happy_friends_lnk">Показать все</div></div></div>
[/happy-friends][/owner]


[subscriptions]<div class="b_people {b_people}"><div class="albtitle_proz">Интересные люди <span>{subscriptions-num}</span><div><a href="/" onClick="subscriptions.all({user-id}, '', {subscriptions-num}); return false">Все</a></div></div>
<div class="newmesnobg_style" style="padding-right:0px;padding-bottom:0px;">{subscriptions}<div class="clear"></div>
</div></div>[/subscriptions]
[owner]
<div class="no_block_tp">
[no-groupsw]<a onclick="Page.Go(this.href); return false;" href="/?go=search&type=4&query="><div class="box_florswq"><center><div class="img_podipsi""></div></center> Подписывайтесь на интересные вам группы и читайте их обновления в Ленте новостей.</div>
</a>
[/no-groupsw]
[no-friendinfo]
<a onclick="Page.Go(this.href); return false;" href="/?go=search&query=&type=1"><div class="box_florswq""><center><div class="img_friends"></div></center>Добавьте друзей и просматривайте их обновления в Ленте новостей.</div>
</a>[/no-friendinfo]
[no-nots]
	 <a onclick="Page.Go(this.href); return false" href="/notes">
<div class="box_florswq""><center><div class="img_notdws"></div></center>С помощью заметок Вы можете делиться событиями из жизни с друзьями, а также быть в курсе того, что нового происходит у них.</div>
</a>[/no-nots]
[no-audio]
<a href="/audio" onclick="Page.Go(this.href); return false">
<div class="box_florswq"">
<center>
<div class="img_audioss"></div>
</center>
У вас ещё нет аудиозаписей
Для того, чтобы загрузить Вашу первую аудиозапись, нажмите сюда.
</div>
</a>
[/no-audio]
	 [no-videos]	
	 <a onclick="Page.Go(this.href); return false" href="/videos/{user-id}">
<div class="box_florswq"">
<center>
<div class="img_videososs"></div>
</center>
Вы можете хранить неограниченное количество видеофайлов.
Для того, чтобы добавить Ваш первый видеоматериал, нажмите сюда.
</div></a>
	 [/no-videos]
	 
	 {miss}
	
	 </div>
[/owner]
[groups]<div class="b_pages {b_pages}"><div class="albtitle_proz cursor_pointer" onClick="groups.all_groups_user('{user-id}')">Интересные страницы <span id="groups_num">{groups-num}</span></div>
<div class="newmesnobg_style" style="padding-right:0px;padding-bottom:0px;">{groups}<div class="clear"></div>
</div></div>[/groups]

[friends]<div class="b_friends {b_friends}"><div class="albtitle_proz">Друзья <span>{friends-num}</span><div><a href="/friends/{user-id}" onClick="Page.Go(this.href); return false">Все</a></div></div>
<div class="newmesnobg_style">{friends}<div class="clear"></div>
</div></div>[/friends]
[online-friends]<div class="b_friends_online {b_friends_online}"><div class="albtitle_proz">Друзья на сайте <span>{online-friends-num}</span><div><a href="/friends/online/{user-id}" onClick="Page.Go(this.href); return false">Все</a></div></div>
<div class="newmesnobg_style">{online-friends}<div class="clear"></div>
</div></div>[/online-friends]

[notes]<div class="{b_notes}"><a href="/notes/{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle_proz"><div class="profile_ic_notes fl_l"></div>Заметки <span>{notes-num}</span></div></a>
 <div class="newmesnobg_style">{notes}<div class="clear"></div>
 </div></div>[/notes]
<div class="clear"></div>
<span id="fortoAutoSizeStyleProfile"></span>
</div>[/blacklist]
</div>

<div class="profisssewr">
[blacklist]
[owner]<div class="cover_loading_profile no_display"><img src="{theme}/images/progress_gray.gif" /></div>
<div class="cover_profile_bg_profile">
 <div class="cover_buts_pos_profile">
  <div class="cover_newpos_profile" {cover-param-3}>
   <div class="cover_newposswrt_profile"></div>
  <div class="cover_addut_profile cover_hidded_but_profile" onClick="coverpro.cancel('{cover-pos}')">Отмена</div>
  <div class="cover_addut_profile cover_hidded_but_profile" onClick="coverpro.del()">Удалить</div>
  <div class="cover_addut_profile cover_addut_profile {cover-param-2}" id="upload_cover_profile" style="position: relative; z-index: 2; margin-left: 432px;margin-top: -177px;border-radius:0px; min-width: 81px;text-align: center;">Добавить обложку</div>
  <div class="cover_addut_profile cover_hidded_but_profile" onClick="coverpro.save()">Сохранить</div>
  <div id="cover_addut_edit_profile" class="no_display"><div class="cover_addut_edits_profile {cover-param}" onClick="coverpro.startedit('{cover}', '{cover-height}')"><div class="icon_cover_profile"></div></div></div>
  </div>
  <div class="cover_loaddef_bg_profile {cover-param}" {cover-param-4}>
   <div id="les10_ex2_profile" {cover-param-5}><img src="{cover}" width="600" id="cover_img" /></div>
   <div id="cover_restart_profile"></div>
  </div>
 </div>
</div>[/owner]
[not-owner][cover]<div class="cover_profile_bg_profile"><img src="{cover}" width="600" id="cover_img" {cover-param-5} /></div>[/cover] [/not-owner]


<div class="container">
    <ul [owner]class="tabs"[/owner] [not-owner][no-cover]class="tabs_cover"[/no-cover][/not-owner][cover]class="tabs"[/cover]>
        <li><a href="#tab1"><div class="profile-tab-icon"></div>О себе</a></li>
     [privacy-info] <li><a href="#tab2"><div class="profile-tab-icon_photo"></div>Альбомы</a></li>[/privacy-info]
	   [privacy-info]<li><a href="#tab3"><div class="profile-tab-icon_audio"></div>Аудио [audios]{audios-num}[/audios]</a></li>[/privacy-info]
	     [privacy-info]<li><a href="#tab4"><div class="profile-tab-icon_video"></div>Видео  <span>{videos-num}</span></a></li>[/privacy-info]
         [privacy-info][privacy-guests] <li><a href="#tab5"><div class="profile-tab-icon_guest"></div>Гости {guests-num}</a></li>[/privacy-guests]  [/privacy-info]
		     <div class="online_ww">{online}</div>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
           <div class="info_style">
<div class="title_inf">Информация [owner]<a href="/editmypage"onClick="Page.Go(this.href); return false"> <div class="red_info"></div></a>[/owner]</div>
[no-infos]<div class="no_dd_info" style="color: rgb(153, 153, 153); padding: 9px;">Информация отсутствует.</div>[/no-infos]
[not-all-country]<div class="flpodtext_top">Страна:</div> <div class="flpodinfowr"><a href="/?go=search&country={country-id}" onClick="Page.Go(this.href); return false">{country}</a></div>[/not-all-country]
[not-all-city]<div class="flpodtext_top">Город:</div> <div class="flpodinfowr"><a href="/?go=search&country={country-id}&city={city-id}" onClick="Page.Go(this.href); return false">{city}</a></div>[/not-all-city]
[blacklist][not-all-birthday]<div class="flpodtext_top">День рождения:</div> <div class="flpodinfowr">{birth-day}</div>[/not-all-birthday]
[privacy-info][not-all-sp][sp]<div class="flpodtext_top">Семейное положение:</div> <div class="flpodinfowr">{sp}</div>[/sp][/not-all-sp][/privacy-info]
<div class="flpodtext_top">Рейтинг:</div><div class="flpodinfowr"><div class="profile_rate_pos"><center>{rating}</center></div></div>
</div>
<a href="/gifts{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="title_inf_pod">Подарки    [gifts]  {gifts-text}[/gifts]</div>
   <div class="info_style_pod">    
[gifts]   
<center>{gifts}</center>
[/gifts] </a>
[no-gifts]<div class="nogift"><br />
[not-owner] <a href="/" onClick="gifts.box('{user-id}'); return false;">{pod}</a> У {name} еще нет подарков.<br />Вы можете стать первым, кто отправит подарок. Для этого нажмите <a href="/" onClick="gifts.box('{user-id}'); return false;">здесь</a>.[/not-owner]
[owner]{name} у Вас пока нет подарков от других пользователей :(
Попробуйте сделать кому-нибудь подарок и возможно, в знак благодарности, подарок появится и у Вас![/owner]<br /><br /><br /></div>[/no-gifts]
</div> 
		<div class="info_styleacon">

[privacy-info]<div class="cursor_pointessssr"><div class="cursor_pointer" onClick="Profile.MoreInfo(); return false" id="moreInfoLnk"><div class=" profile_hide_opne" id="moreInfoText">Показать подробную информацию</div></div>
<div id="moreInfo" class="no_display">
<div class="cursor_pointesssssssr">
<div class="title_inf_contackt">Контактная информация [owner]<a href="/editmypage/contact"onClick="Page.Go(this.href); return false"> <div class="red_info"></div></a>[/owner]</div>
{not-block-info-cona}
[not-block-contact]
[not-contact-phone]<div class="flpodtext_top">Моб. телефон:</div> <div class="flpodinfo">{phone}</div>[/not-contact-phone]
[not-contact-vk]<div class="flpodtext_top">В контакте:</div> <div class="flpodinfo">{vk}</div>[/not-contact-vk]
[not-contact-od]<div class="flpodtext_top">Одноклассники:</div> <div class="flpodinfo">{od}</div>[/not-contact-od]
[not-contact-fb]<div class="flpodtext_top">FaceBook:</div> <div class="flpodinfo">{fb}</div>[/not-contact-fb]
[not-contact-skype]<div class="flpodtext_top">Skype:</div> <div class="flpodinfo"><a href="skype:{skype}">{skype}</a></div>[/not-contact-skype]
[not-contact-icq]<div class="flpodtext_top">ICQ:</div> <div class="flpodinfo">{icq}</div>[/not-contact-icq]
[not-contact-site]<div class="flpodtext_top">Веб-сайт:</div> <div class="flpodinfo">{site}</div>[/not-contact-site][/not-block-contact]

<div class="title_inf_contackt">Личная информация [owner]<a href="/editmypage/interests"onClick="Page.Go(this.href); return false"> <div class="red_info"></div></a>[/owner]</div>
{not-block-info}
[not-info-activity]<div class="flpodtext">Деятельность:</div> <div class="flpodinfo">{activity}</div>[/not-info-activity]
[not-info-interests]<div class="flpodtext">Интересы:</div> <div class="flpodinfo">{interests}</div>[/not-info-interests]
[not-info-music]<div class="flpodtext">Любимая музыка:</div> <div class="flpodinfo">{music}</div>[/not-info-music]
[not-info-kino]<div class="flpodtext">Любимые фильмы:</div> <div class="flpodinfo">{kino}</div>[/not-info-kino]
[not-info-books]<div class="flpodtext">Любимые книги:</div> <div class="flpodinfo">{books}</div>[/not-info-books]
[not-info-games]<div class="flpodtext">Любимые игры:</div> <div class="flpodinfo">{games}</div>[/not-info-games]
[not-info-quote]<div class="flpodtext">Любимые цитаты:</div> <div class="flpodinfo">{quote}</div>[/not-info-quote]
[not-info-myinfo]<div class="flpodtext">О себе:</div> <div class="flpodinfo">{myinfo}</div>[/not-info-myinfo]
</div> </div></div></div>[/privacy-info]
		</div>
        <div id="tab2" class="tab_content">
	[albums]
		 <div class="b_video {b_video}">
<div class="newmesnobg_sv" style="margin-left: -20px;padding-right:0px;padding-bottom:0px;">{albums}<div class="clear"></div>
</div></div>	
[phet]
<div class="bjjj" style="margin-top:5px;">{five-photo}</div>
[/phet]
 <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none">
<div class="profile_hide_opne veisof">Смотреть все Альбомы </div></a>
[/albums]
			[no-albums]
<div class="module clear people_module" id="profile_friends">
 <a href="/albums/{user-id}" onClick="Page.Go(this.href); return false"  class="module_header">
</a><br>
  <div class="img_albums"></div>
<div class="swrf" align="center">[owner]Вы можете загружать фотографии в альбомы[/owner][not-owner]У пользователя нет альбомов<br>[/not-owner]<br />
  [owner]<a href="/albums/{user-id}" onClick="Page.Go(this.href); return false">Создать альбом</a><br><br>[/owner]</div></div>[/no-albums]
       
	   </div>
        <div id="tab3" class="tab_content">
[audios] <a href="/audio{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle"><div class="profile_ic_videos fl_l"></div>Аудио<div class="fl_r_blocks"><a href="/audio{user-id}" onClick="Page.Go(this.href); return false">Все</a></div></div></a>
{audios}<div class="clear"></div>
 <a href="/audio{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none">
<div class="profile_hide_opne veisof">Смотреть все Аудиозаписи </div></a>
[/audios]
				 [no-audio]
				   <div class="img_audio"></div>
		<div class="swrf" align="center"> [owner]Вы можете загружать аудиозаписей[/owner][not-owner]У пользователя нет аудиозаписей<br>[/not-owner]<br />
  [owner]<a href="/audio" onClick="Page.Go(this.href); return false">Добавить аудиозапись</a><br><br>[/owner]</div>
		 [/no-audio]
     </div>
        <div id="tab4" class="tab_content">
		 [no-videos]
		 
		  <div class="img_video"></div>
		<div class="swrf" align="center"> [owner]Вы можете загружать видеозаписи[/owner][not-owner]У пользователя нет видеозаписей<br>[/not-owner]<br />
  [owner]<a href="/videos/{user-id}" onClick="Page.Go(this.href); return false">Добавить видео</a><br><br>[/owner]
		 </div>
		 [/no-videos]
         [videos]
		 <div class="b_video {b_video}">
<div class="newmesnobg_sv" style="padding-right:0px;padding-bottom:0px;">{videos}<div class="clear"></div>
</div></div>
<div class="clear"></div>

 <a href="/videos/{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none">
<div class="profile_hide_opne veisof">Смотреть все видеозаписи </div></a>
[/videos]
        </div>
		<div id="tab5" class="tab_content">
		[no-guests] 	<div class="swrf" align="center">  [owner]{name} вашу страницу пока что никто не посетил :([/owner][not-owner]Вы стали первым кто посетил страницу {name}[/not-owner]</div>[/no-guests]
         [privacy-guests]
[guests]
<div class="newmesnobgsw" style="padding:0px;padding-top:4px;margin-top: -24px;">{guests}<div class="clear"></div>
 <a href="/guests/{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none">
<div class=" profile_hide_opne">Смотреть всех гостей </div></a>
</div>
[/guests]
[/privacy-guests] 
        </div>
    </div>
</div>



</div>

<div class="b_wall {b_wall}">
<a href="/wall{user-id}" onClick="Page.Go(this.href); return false" style="text-decoration:none"><div class="albtitle_bwall">Стена <span id="wall_rec_num">{wall-rec-num}</span></div></a>
[privacy-wall]<div class="sdfshsdas" id="wall_tab" style="margin-bottom:-5px">
<div class="ava_walls"><img src="{ava3}" /> </div>
<input onclick="diplay_hide('#wall_input_text');return false;" href="#" type="hidden" value="[owner]Что у Вас нового?[/owner][not-owner]Написать сообщение...[/not-owner]" id="wall_input_text" />
<input type="text" class="wall_sinpst" value="[owner]Что у Вас нового?[/owner][not-owner]Написать сообщение...[/not-owner]" onMouseDown="wall.form_open(); return false" id="wall_input" style="margin:0px" />
<div class="no_display" id="wall_textarea">
<textarea id="wall_text" class="wall_sinpst wall_fast_opened_texta"
onKeyUp="wall.CheckLinkText(this.value)"
onBlur="wall.CheckLinkText(this.value, 1)"
>
</textarea>
<div id="attach_files" class="margin_top_10 no_display"></div>
<div id="attach_block_lnk" class="no_display clear">
<div class="attach_link_bg">
<div align="center" id="loading_att_lnk"><img src="{theme}/images/loading_mini.gif" style="margin-bottom:-2px" /></div>
<img src="" align="left" id="attatch_link_img" class="no_display cursor_pointer" onClick="wall.UrlNextImg()" />
<div id="attatch_link_title"></div>
<div id="attatch_link_descr"></div>
<div class="clear"></div>
</div>
<div class="attach_toolip_but"></div>
<div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">Ссылка: <a href="/" id="attatch_link_url" target="_blank"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', 'Не прикреплять', 'attach_lnk_')" id="attach_lnk_1" onClick="wall.RemoveAttachLnk()" /></div>
<input type="hidden" id="attach_lnk_stared" />
<input type="hidden" id="teck_link_attach" />
<span id="urlParseImgs" class="no_display"></span>
</div>
<div class="clear"></div>
<div id="attach_block_vote" class="no_display">
<div class="attach_link_bg">
<div class="texta">Тема опроса:</div><input type="text" id="vote_title" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px"
onKeyUp="$('#attatch_vote_title').text(this.value)"
/><div class="mgclr"></div>
<div class="texta">Варианты ответа:<br /><small><span id="addNewAnswer"><a class="cursor_pointer" onClick="Votes.AddInp()">добавить</a></span> | <span id="addDelAnswer">удалить</span></small></div><input type="text" id="vote_answer_1" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" /><div class="mgclr"></div>
<div class="texta">&nbsp;</div><input type="text" id="vote_answer_2" class="inpst" maxlength="80" value="" style="width:355px;margin-left:5px" /><div class="mgclr"></div>
<div id="addAnswerInp"></div>
<div class="clear"></div>
</div>
<div class="attach_toolip_but"></div>
<div class="attach_link_block_ic fl_l"></div><div class="attach_link_block_te"><div class="fl_l">Опрос: <a id="attatch_vote_title" style="text-decoration:none;cursor:default"></a></div><img class="fl_l cursor_pointer" style="margin-top:2px;margin-left:5px" src="{theme}/images/close_a.png" onMouseOver="myhtml.title('1', 'Не прикреплять', 'attach_vote_')" id="attach_vote_1" onClick="Votes.RemoveForAttach()" /></div>
<input type="hidden" id="answerNum" value="2" />
</div>
<div class="clear"></div>
<input id="vaLattach_files" type="hidden" />
<div class="clear"></div>
<div class="button_div_sends fl_r " style="margin-right: 10px;"><button onClick="wall.send(); return false" id="wall_send">Отправить</button></div>
<div class="sdawfffffs"  id="wall_attach">
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addsmile()"><div class="img_smiles"></div>Смайлик</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addphoto()"><div class="img_photo"></div>Фотографию</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addvideo()"><div class="img_videos"></div>Видеозапись</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addaudio()"><div class="img_audios"></div>Аудиозапись</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addDoc()"><div class="img_files"></div>Документ</div>
</div> </div>
<div class="clear"></div>
</div>[/privacy-wall]
<div id="wall_records">{records}[no-records]<div class="wall_none" [privacy-wall]style="border-top:0px"[/privacy-wall]>На стене пока нет ни одной записи.</div>[/no-records]</div>
[wall-link]<span id="wall_all_record"></span><div onClick="wall.page('{user-id}'); return false" id="wall_l_href" class="cursor_pointer"><div class="photo_all_comm_bg wall_upgwi" id="wall_link">к предыдущим записям</div></div>[/wall-link][/blacklist]
</div>
[not-blacklist]<div class="err_yellowwq" style="font-weight:normal;margin-top:-19px">{name} ограничил доступ к своей странице.</div>[/not-blacklist]
<div class="clear"></div>
</div>
<style type="text/css" media="all">
.public_wall_all_comm {
margin-top: -22px;
}</style>



[owner]<style type="text/css" media="all">
.active1 {
background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
box-shadow: 0 0 3px -1px #000000 inset;
}

.box_sdsss {
    background: none repeat scroll 0 0 #FFFFFF;
    height: 100%;
    margin: auto auto auto 222px;
    position: fixed;
    top: 0;
    width: 577px;
    z-index: 0;
}

</style>[/owner]

[not-owner]<style type="text/css" media="all">

</style>[/not-owner]