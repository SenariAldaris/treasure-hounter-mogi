<script type="text/javascript" src="{theme}/js/like/ik.js"></script>
<script type="text/javascript" src="{theme}/js/like/toolltips.js"></script>
<script type="text/javascript">
var startResizeCss = false;
$(document).ready(function(){
	[admin]
		[admin]Xajax = new AjaxUpload('upload_3', {
		action: '/index.php?go=groups&act=upload&public_id={id}',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(doc|docx|xls|xlsx|ppt|pptx|rtf|pdf|png|jpg|gif|psd|mp3|djvu|fb2|ps|jpeg|txt)$/.test(ext))) {
				addAllErr('Неверный формат файла', 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, row){
			if(row == 1)
				addAllErr('Превышен максимальный размер файла 5 МБ', 3300);
			else {
				window.location.href = window.location.href;
			}
			Page.Loading('stop');
		}
	});
ajaxUpload = new AjaxUpload('upload_cover_profile', {
action: '/index.php?go=groups&act=upload_cover&id={id}',
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
				coverpro.init('/uploads/groups/'+row[0], rheihht);
				$('.cover_addut_edits_profile').attr('onClick', 'coverpro.startedit(\'/uploads/groups/'+row[0]+'\', '+rheihht+')');}

}
});[/admin]
	/*[admin]Xajax = new AjaxUpload('upload_3', {
		action: '/index.php?go=groups&act=uploadfile&public_id={id}',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(png|jpg|gif|jpeg)$/.test(ext))) {
				addAllErr('Неверный формат файла', 3300);
				return false;
			}
			Page.Loading('start');
		},
		onComplete: function (file, row){
			if(row == 1)
				addAllErr('Превышен максимальный размер файла 5 МБ', 3300);
			else {
				window.location.href = window.location.href;
			}
			Page.Loading('stop');
		}
	});
	$('#wall_text, .fast_form_width').autoResize();
	myhtml.checked(['{settings-comments}', '{settings-discussion}', '{background_repeat}']);[/admin]*/
	$('#wall_text, .fast_form_width').autoResize();
	myhtml.checked(['{settings-comments}', '{settings-discussion}']);
	music.jPlayerInc();
	$(window).scroll(function(){
		
	});
	langNumric('langForum', '{forum-num}', 'обсуждение', 'обсуждения', 'обсуждений', 'обсуждение', 'Нет обсуждений');
	langNumric('langNumricAll', '{audio-num}', 'аудиозапись', 'аудиозаписи', 'аудиозаписей', 'аудиозапись', 'аудиозаписей');
	langNumric('langNumricVide', '{videos-num}', 'видеозапись', 'видеозаписи', 'видеозаписей', 'видеозапись', 'видеозаписей');
});
$(document).click(function(event){
	wall.event(event);
});
</script>

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

[not-admin]
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
</script>[/not-admin]
<input type="hidden" id="type_page" value="public" />
<style>{background}</style>
<div id="jquery_jplayer"></div>
<div id="addStyleClass"></div>
<input type="hidden" id="teck_id" value="" />
<input type="hidden" id="teck_prefix" value="" />
<input type="hidden" id="typePlay" value="standart" />
<input type="hidden" id="public_id" value="{id}" />
<div class="avsdaa"></div>
<div class="ava" style="float:right;margin-right:-211px" onMouseOver="groups.wall_like_users_five_hide()">

<div class="userAvatarPositionBox">
<div id="avatarBox" class="userAvatarBox ng-avatar ng-scope" data-target="userPhoto" data-href="/users/w_setan/saveUserPhoto">
<div class="img_profiles" data-href="/users/w_setan/gallery" data-id="904944">
<span id="ava" class="img_avas"><img class="ava_groups" src="{photo}" id="ava_groups" /></span>
</div>

<div class="avatarMenu" style="  margin-left: 184px; margin-top: -32px;">
 [admin]<div class="icon"></div>
<ul>
<li class="uploadItem">
<form id="avatarForm" class="upload ng-pristine ng-valid"  href="/" onClick="groups.loadphoto('{id}'); return false">
<div style="display:none">
</div>
<span class="icon1"></span>
<p>Загрузить новую фотографию</p>
</form>
</li>
<li class="remove" href="/" onClick="groups.delphoto('{id}'); return false;">
<span class="icon3"></span>

<p id="del_pho_but" class="{display-ava}">Удалить</p>
</li>
</ul>[/admin]
</div></div></div> 
  <div class="publick_subscblock">
   <div id="yes" class="{yes}">
    <div class="bitqqq"><button onClick="groups.login('{id}'); return false" style="width:195px">Подписаться</button></div>
    <div id="num2" class="namposd" >{num-2}</div>
   </div>
   <div id="no" class="{no} bsqqqqaaaaa" style="text-align:left">
	    <div class="boo_podpisi">Вы подписаны на новости этого сообщества.<br />
</div>
	   <a href="/public{id}" class="bitqqqs" onClick="groups.exit2('{id}', '{viewer-id}'); return false">Отписаться</a>  
   </div>

   <div class="clear"></div>
  </div>
<div class="menulseftssssss442s">
</div>
<div class="leftcbosssssssssr">
  [admin]
 <div class="box_menu_user"> <a href="/" onClick="groups.editform(); return false"><div>Управление страницей</div></a>   </div>
   <div class="box_menu_user">  <a href="/" onClick="groups.inviteBox('{id}'); return false"><div>Пригласить друзей</div></a>  </div>
  [ver]<div class="box_menu_user"><a href="/" onClick="groups.sendver({id}); return false" id="sendverlnk"><div id="sendver">Отправить заявку на верификацию</div></a> </div>[/ver][/admin]
 </div>

 <div style="margin-top:7px">
  <div class="{no-users}" id="users_block">
   <div class="albtitle_proz cursor_pointer" onClick="groups.all_people('{id}')">Подписчики</div>
   <div class="newmesnobg_style">
    <div class="color777 public_margbut">{num}</div>
	<div class="public_usersblockhidden">{users}</div>
    <div class="clear"></div>
   </div>
  </div>
 </div>
 
[feedback]<div class="albtitle_proz cursor_pointer" onClick="groups.allfeedbacklist('{id}')">Контакты [yes][admin]<a href="/public{id}" class="fl_r" onClick="groups.allfeedbacklist('{id}'); return false">ред.</a>[/admin][/yes]</div>
 <div class="newmesnobg_style" id="feddbackusers">
  [yes]<div class="color777 public_margbut">{num-feedback}</div>[/yes]
  {feedback-users}
  [no]<div class="block_pos_a" align="center">Страницы представителей, номера телефонов, e-mail<br />
  <a href="/public{id}" onClick="groups.addcontact('{id}'); return false">Добавить контакты</a></div>[/no]
 </div>[/feedback]

 <div id="fortoAutoSizeStyle"></div>
</div>
<div class="profiewr">
 <div id="public_editbg_container">
 <div class="public_editbg_container">
 <div class="fl_l" style="width:560px">
[admin]<div class="cover_loading_profile no_display"><img src="{theme}/images/progress_gray.gif" /></div>
<div class="cover_profile_bg_profile cover_groups_bg">
 <div class="cover_buts_pos_profile">
  <div class="cover_newpos_profile" {cover-param-3}>
   <div class="cover_newposswrt_profile"></div>
  <div class="cover_addut_profile cover_hidded_but_profile" onClick="coverpro.cancel('{cover-pos}')">Отмена</div>
  <div class="cover_addut_profile cover_hidded_but_profile" onClick="coverpro.del('{id}')">Удалить</div>
  <div class="cover_addut_profile cover_addut_profile {cover-param-2}" id="upload_cover_profile" style="position: relative; z-index: 2; margin-left: 432px;margin-top: -177px;border-radius:0px; min-width: 105px;text-align: center;">Добавить обложку</div>
  <div class="cover_addut_profile cover_hidded_but_profile" onClick="coverpro.save()">Сохранить</div>
  <div id="cover_addut_edit_profile" class="no_display"><div class="cover_addut_edits_profile {cover-param}" onClick="coverpro.startedit('{cover}', '{cover-height}')"><div class="icon_cover_profile"></div></div></div>
  </div>
  <div class="cover_loaddef_bg_profile {cover-param}" {cover-param-4}>
   <div id="les10_ex2_profile" {cover-param-5}><img src="{cover}" width="600" id="cover_img" /></div>
   <div id="cover_restart_profile"></div>
  </div>
 </div>
</div>[/admin]
[not-admin][cover]<div class="cover_profile_bg_profile cover_groups_bg"><img src="{cover}" width="600" id="cover_img" {cover-param-5} /></div>[/cover] [/not-admin]
 <div class="container">
    <ul [admin]class="tabs tabsgroups"[/admin] [not-admin][no-cover]class="tabs_cover tabsgroups"[/no-cover][/not-admin][cover]class="tabs tabsgroups"[/cover]>
        <li><a href="#tab1"><div class="profile-tab-icon"></div>Информация</a></li>
	   <li><a href="#tab3"><div class="profile-tab-icon_audio"></div>Аудио    [yesaudio]{audio-num}   [/yesaudio] </a></li>
	     <li><a href="#tab4"><div class="profile-tab-icon_video"></div>Видео   [yesvideo] {videos-num}   [/yesvideo]</a></li>
         [discussion] <li><a href="#tab5"><div class="profile-tab-icon_guest"></div>Обсуждение </a></li>[/discussion]
    </ul>
	 <div class="tab_container">
        <div id="tab1" class="tab_content tabgorpscont">
		 <div class="{descr-css}" id="descr_display"><div class="flpodtexts">Описание:</div> <div class="flpodinfo" id="e_descr">{descr}</div></div>
  <div class="flpodtexts">Дата создания:</div> <div class="flpodinfo">{date}</div>
 [web]<div class="flpodtexts">Веб-сайт:</div> <div class="flpodinfo"><a href="{web}" target="_blank">{web}</a></div>[/web]
		
		</div>        
 
<div id="tab3" style=" margin-top: 12px;" class="tab_content tabgorpscont">	 [audios] 
   [yesaudio]<div class="newmesnobg_styleswqq"> 
<div class=" public_margbsut">{audio-num} <span id="langNumricAll"></span></div>[/yesaudio]
   [yesaudio] {audios}  
   	 <a href="/public/audio{id}" onClick="Page.Go(this.href); return false" style="text-decoration:none">
<div style=" margin-left: 7px;" class="profile_hide_opne veisof">Смотреть все аудиозаписи </div></a>
   [/yesaudio]
  [noaudio]
  				   <div class="img_audio"></div>
		<div class="swrf" align="center"> [admin]Вы можете загружать аудиозаписи в группу[/admin][not-admin]Композиции или другие аудиоматериалы отсутствуют<br>[/not-admin]<br />
  [admin]<a href="/public/audio{id}" onClick="Page.Go(this.href); return false">Добавить аудиозапись</a><br><br>[/admin]</div>
  [/noaudio]
   [yesaudio]</div>  [/yesaudio][/audios]		</div>   	
		<div id="tab4" style=" margin-top: 12px;" class="tab_content tabgorpscont">
		[videos]
  [yesvideo] 
<div class="color777 public_margbsut">{videos-num} <span id="langNumricVide"></span></div>[/yesvideo]
    [yesvideo] <div class="swry_viwosd">{videos}</div> 
	 <a href="/public/videos{id}" onClick="Page.Go(this.href); return false" style="text-decoration:none">
<div style=" margin-left: 7px;" class="profile_hide_opne veisof">Смотреть все видеозаписи </div></a>
	[/yesvideo]
  [novideo]
  
  
		  <div class="img_video"></div>
		<div class="swrf" align="center"> [admin]Вы можете загружать видеозаписи в группу[/admin][not-admin]Видеоматериалы отсутствуют<br>[/not-admin]<br />
  [admin]<a href="/public/videos{id}" onClick="Page.Go(this.href); return false">Добавить видео</a><br><br>[/admin]
		 </div>
  [/novideo]
[/videos]</div> 
		<div id="tab5" class="tab_content tabgorpscont">
[discussion]
 <a href="/forum{id}" onClick="Page.Go(this.href); return false" class="fl_l blwii" style="text-decoration:none">
<div class="albtitle_bwall" style="width: 563px; margin-left: 3px;">
 {forum-num}  <a href="/forum{id}?act=new" onClick="Page.Go(this.href); return false" class="fl_r  {no}" style="text-decoration:none"><div class="albtitle_publick">Новая тема</div></a>
 <div id="langForum">Нет обсуждений</div></div></a>
 <div class="clear"></div>{thems}<div class="clear"></div>[/discussion]
		</div>
</div></div>

</div>
 [admin]<div class="public_editbg fl_l no_display" id="edittab1">
  <div class="public_title">Редактирование страницы</div>
  <div class="public_hr"></div>
  <div class="texta">Название:</div>
   <input type="text" id="title" class="inpst" maxlength="100"  style="width:260px;" value="{title}" />
  <div class="mgclr"></div>
  <div class="texta">Описание:</div>
   <textarea id="descr" class="inpst" style="width:260px;height:80px">{edit-descr}</textarea>
  <div class="mgclr"></div>
  <div class="texta">Адрес страницы:</div>
   <input type="hidden" id="prev_adres_page" class="inpst" maxlength="100"  style="width:260px;" value="{adres}" />
   <input type="text" id="adres_page" class="inpst" maxlength="100"  style="width:260px;" value="{adres}" />
  <div class="mgclr"></div>
  <div class="texta">Веб-сайт:</div>
   <input type="text" id="web" class="inpst" maxlength="100"  style="width:260px;" value="{web}" />
  <div class="mgclr"></div>
  <div class="texta">Фон страницы:</div>
   <div class="button_div_gray fl_l"><button id="upload_3">Загрузить</button></div>
   <div class="clear"></div>
   <small style="margin-left:150px">Файл не должен превышать 5 Mб.</small>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
   <div class="html_checkbox" id="comments" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Комментарии включены</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
   <div class="html_checkbox" id="discussion" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Обсуждения включены</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
   <div class="html_checkbox" id="background_repeat" onClick="myhtml.checkbox(this.id)" style="margin-bottom:8px">Растянуть фон на весь экран</div>
  <div class="mgclr clear"></div>
  <div class="texta">&nbsp;</div>
   <a href="/public{id}" onClick="groups.edittab_admin(); return false">Назначить администраторов &raquo;</a>
  <div class="mgclr"></div>
  <div class="texta">&nbsp;</div>
   <div class="button_div fl_l"><button onClick="groups.saveinfo('{id}'); return false" id="pubInfoSave">Сохранить</button></div>
   <div class="button_div_gray fl_l margin_left"><button onClick="groups.editformClose(); return false">Отмена</button></div>
  <div class="mgclr"></div>
 </div>
 <div class="public_editbg fl_l no_display" id="edittab2">
  <div class="public_title">Руководители страницы</div>
  <div class="public_hr"></div>
  <input 
	type="text" 
	placeholder="Введите ссылку на страницу или введите ID страницы пользователя и нажмите Enter" 
	class="videos_input" 
	style="width:526px"
	onKeyPress="if(event.keyCode == 13)groups.addadmin('{id}')"
	id="new_admin_id"
   />
  <div class="clear"></div>
  <div style="width:600px" id="admins_tab">{admins}</div>
  <div class="clear"></div>
  <div class="button_div fl_l"><button onClick="groups.editform(); return false">Назад</button></div>
 </div>[/admin]
 </div>
 </div>
 
 <div class="albtitle_bwall" style="width: 563px;  margin-left: -12px;">{rec-num}</div>
 [admin]<div class="ava_walls" style="   margin-top: 10px;"><img src="{photo_groups}" /> </div><div class="sdfshsdas" id="wall_tab" style=" margin-bottom: -6px;  width: 557px; margin-left: -12px;">
  <input type="hidden" value="Что у Вас нового?" id="wall_input_text" />
  <input type="text" class="wall_sinpst" value="Что у Вас нового?" onMouseDown="wall.form_open(); return false" id="wall_input" style="margin:0px" />
  <div class="no_display" id="wall_textarea">
   <textarea id="wall_text" class="wall_sinpst wall_fast_opened_texta" style=""
	onKeyUp="wall.CheckLinkText(this.value)"
	onBlur="wall.CheckLinkText(this.value, 1)"
	onKeyPress="if(event.keyCode == 10 || (event.ctrlKey && event.keyCode == 13)) groups.wall_send('{id}')"
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
   <div class="button_div_sends fl_r " style="margin-right: 10px;"><button onClick="groups.wall_send('{id}'); return false" id="wall_send">Отправить</button></div>
   <div class="sdawfffffs"  id="wall_attach">
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addsmile()"><div class="img_smiles"></div>Смайлик</div>
<div class="wall_attachs" id="wall_attach_link" onClick="groups.wall_attach_addphoto(0, 0, '{id}')"><div class="img_photo"></div>Фотографию</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addvideo_public(0, 0, '{id}')"><div class="img_videos"></div>Видеозапись</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addaudio()"><div class="img_audios"></div>Аудиозапись</div>
<div class="wall_attachs" id="wall_attach_link" onClick="wall.attach_addDoc()"><div class="img_files"></div>Документ</div>
</div> 
  </div>
  <div class="clear"></div>
 </div>[/admin]
 <div id="public_wall_records">{records}</div>
 <div class="cursor_pointer {wall-page-display}" onClick="groups.wall_page('{id}'); return false" id="wall_all_records"><div class="public_wall_all_comm" id="load_wall_all_records" style="margin-left:0px">к предыдущим записям</div></div>
 <input type="hidden" id="page_cnt" value="1" />
</div>
<div class="clear"></div>