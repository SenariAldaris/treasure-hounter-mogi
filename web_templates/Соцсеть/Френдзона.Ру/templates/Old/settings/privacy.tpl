
<style type="text/css" media="all">
.active_setings {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>
<script type="text/javascript">
	$('#speedbar').show();
	$('#speedbar').text(lang_setings_privacy);
$(document).click(function(event){
	settings.event(event);
});
</script>
<div class="clear_tps"></div>
<div class="box_right_owne" style=" margin-top: -12PX;">
  <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <div class="activetab news_a"><a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a></div>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a>
 <div class="box_name_srtaw">Редактирование моей страницы</div>
 <a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>Основное</div></a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;"><div>Контакты</div></a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;"><div>Интересы</div></a>
 <a href="/editmypage/all" onClick="Page.Go(this.href); return false;"><div>Другое</div></a>
  <div class="box_name_srtaw">Платное</div>
 <a href="/ads&act=ads_target" onClick="Page.Go(this.href); return false;"><div>Реклама</div></a>
<a href="/mybanners" onClick="Page.Go(this.href); return false;"><div>Баннеры</div></a>
   <a href="/vip" onClick="Page.Go(this.href); return false;"><div>VIP Статус</div></a>
   <a href="/obshenie" onClick="Page.Go(this.href); return false;"><div>Хочу общаться</div></a>
<a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои Подарки</div></a>
   <div class="box_name_srtaw">Развлечение</div>
      <a href="/miss" onClick="Page.Go(this.href); return false;"><div>Miss сайта</div></a>
</div>

<div class="clear" style="margin-top:10px"></div>

<div class="err_yellow_on no_display" id="ok_update" style="font-weight:normal;">Новые настройки приватности вступили в силу.</div>
<div class="box_fix"></div>
<div class="texta color_000" style="width:300px">Кто может писать мне личные <b>сообщения</b>:</div>
 <div class="sett_privacy" onClick="settings.privacyOpen('msg')" id="privacy_lnk_msg">{val_msg_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_msg">
  <div id="selected_p_privacy_lnk_msg" class="sett_selected" onClick="settings.privacyClose('msg')">{val_msg_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_msg', 'Все пользователи', '1', 'privacy_lnk_msg')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_msg', 'Только друзья', '2', 'privacy_lnk_msg')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_msg', 'Никто', '3', 'privacy_lnk_msg')">Никто</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_msg', 'Только верифицированные', '4', 'privacy_lnk_msg')">Только верифицированные</div>
 </div>
 <input type="hidden" id="val_msg" value="{val_msg}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто видит чужие записи на моей <b>стене</b>:</div>
 <div class="sett_privacy" onClick="settings.privacyOpen('wall1')" id="privacy_lnk_wall1">{val_wall1_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall1" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_wall1" class="sett_selected" onClick="settings.privacyClose('wall1')">{val_wall1_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall1', 'Все пользователи', '1', 'privacy_lnk_wall1')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall1', 'Только друзья', '2', 'privacy_lnk_wall1')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall1', 'Только я', '3', 'privacy_lnk_wall1')">Только я</div>
 </div>
 <input type="hidden" id="val_wall1" value="{val_wall1}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может оставлять сообщения на моей <b>стене</b>:</div>
 <div class="sett_privacy" onClick="settings.privacyOpen('wall2')" id="privacy_lnk_wall2">{val_wall2_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall2" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_wall2" class="sett_selected" onClick="settings.privacyClose('wall2')">{val_wall2_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall2', 'Все пользователи', '1', 'privacy_lnk_wall2')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall2', 'Только друзья', '2', 'privacy_lnk_wall2')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall2', 'Только я', '3', 'privacy_lnk_wall2')">Только я</div>
 </div>
 <input type="hidden" id="val_wall2" value="{val_wall2}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто может комментировать мои <b>записи</b>:</div>
 <div class="sett_privacy" onClick="settings.privacyOpen('wall3')" id="privacy_lnk_wall3">{val_wall3_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_wall3" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_wall3" class="sett_selected" onClick="settings.privacyClose('wall3')">{val_wall3_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall3', 'Все пользователи', '1', 'privacy_lnk_wall3')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall3', 'Только друзья', '2', 'privacy_lnk_wall3')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_wall3', 'Только я', '3', 'privacy_lnk_wall3')">Только я</div>
 </div>
 <input type="hidden" id="val_wall3" value="{val_wall3}" />
<div class="mgclr"></div>

<div class="texta color_000" style="width:300px">Кто видит основную информацию моей <b>страницы</b>:</div>
 <div class="sett_privacy" onClick="settings.privacyOpen('info')" id="privacy_lnk_info">{val_info_text}</div>
 <div class="sett_openmenu no_display" id="privacyMenu_info" style="margin-top:-1px">
  <div id="selected_p_privacy_lnk_info" class="sett_selected" onClick="settings.privacyClose('info')">{val_info_text}</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_info', 'Все пользователи', '1', 'privacy_lnk_info')">Все пользователи</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_info', 'Только друзья', '2', 'privacy_lnk_info')">Только друзья</div>
  <div class="sett_hover" onClick="settings.setPrivacy('val_info', 'Только я', '3', 'privacy_lnk_info')">Только я</div>
 </div>
 <input type="hidden" id="val_info" value="{val_info}" />
<div class="mgclr"></div>
<div class="texta color_000" style="width:300px">Кто может просматривать список моих <b>гостей</b></div>

 <div class="sett_privacy" onClick="settings.privacyOpen('guests1')" id="privacy_lnk_guests1">{val_guests1_text}</div>

 <div class="sett_openmenu no_display" id="privacyMenu_guests1" style="margin-top:-1px">

  <div id="selected_p_privacy_lnk_guests1" class="sett_selected" onClick="settings.privacyClose('guests1')">{val_guests1_text}</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests1', 'Все пользователи', '1', 'privacy_lnk_guests1')">Все пользователи</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests1', 'Только друзья', '2', 'privacy_lnk_guests1')">Только друзья</div>

  <div class="sett_hover" onClick="settings.setPrivacy('val_guests1', 'Только я', '3', 'privacy_lnk_guests1')">Только я</div>

 </div>

 <input type="hidden" id="val_guests1" value="{val_guests1}" />

<div class="mgclr"></div>

<div class="texta color_000" style="width:210px">&nbsp;</div>
 <div class="savweswt_sasvw fl_l"><button onClick="settings.savePrivacy(); return false" id="savePrivacy">Сохранить</button></div>
<div class="mgclr"></div>