<style type="text/css" media="all">
.active_setings {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>
 <script type="text/javascript" src="{theme}/js/profile_edit.js"></script>
[general]
<div class="clear_tps"></div>
<div class="box_right_owne" style="margin-top: -9px;">
       <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a>
 <div class="box_name_srtaw">Редактирование моей страницы</div>
 <div class="activetab news_a"><a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>Основное</div></a></div>
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

<div class="clear"></div>
<div class="margintop10"></div>
<div class="err_yellow_on" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="box_fix"></div>
<div class="clear"></div>
<div class="box_edit">
<div class="texta">Пол:</div>
 <div class="padstylej"><select  style="width: 245px;" id="sex" onChange="sp.check()">
  <option value="0">- Не выбрано -</option>
  {sex}
 </select></div>
<div class="mgclr"></div>
<div class="[sp-all]no_display[/sp-all]" id="sp_block"><div class="texta">Семейное положение:</div>
 <div class="padstylej">
 <div class="[user-m]no_display[/user-m]" id="sp_sel_m"><select id="sp" class="selectbox" onChange="sp.openfriends()" style="width: 245px;">
  <option value="0">- Не выбрано -</option>
  <option value="1" [instSelect-sp-1]>Не женат</option>
  <option value="2" [instSelect-sp-2]>Есть подруга</option>
  <option value="3" [instSelect-sp-3]>Помовлен</option>
  <option value="4" [instSelect-sp-4]>Женат</option>
  <option value="5" [instSelect-sp-5]>Влюблён</option>
  <option value="6" [instSelect-sp-6]>Всё сложно</option>
  <option value="7" [instSelect-sp-7]>В активном поиске</option>
 </select></div>
 <div class="[user-w]no_display[/user-w]" id="sp_sel_w"><select id="sp_w" onChange="sp.openfriends()">
  <option value="0">- Не выбрано -</option>
  <option value="1" [instSelect-sp-1]>Не замужем</option>
  <option value="2" [instSelect-sp-2]>Есть друг</option>
  <option value="3" [instSelect-sp-3]>Помовлена</option>
  <option value="4" [instSelect-sp-4]>Замужем</option>
  <option value="5" [instSelect-sp-5]>Влюблена</option>
  <option value="6" [instSelect-sp-6]>Всё сложно</option>
  <option value="7" [instSelect-sp-7]>В активном поиске</option>
 </select></div>
 </div>
<div class="mgclr"></div></div>
<div class="[sp]no_display[/sp]" id="sp_type">
<div class="texta" id="sp_text">{sp-text}</div>
 <div class="padstylej fl_l"><div style="margin-top:3px;margin-bottom:10px;padding-left:1px;float:left"><a href="/" id="sp_name" onClick="sp.openfriends(); return false">{sp-name}</a></div><img src="{theme}/images/close_a_wall.png" class="sp_del" onClick="sp.del()" /></div>
<div class="mgclr"></div>
<input type="hidden" id="sp_val" />
</div>
<div class="texta">Дата рождения:</div>
 <div class="padstylej"><select id="day">
  <option>- День -</option>
  {user-day}
 </select>
 <select id="month">
  <option>- Месяц -</option>
  {user-month}
 </select>
 <select id="year"  style="width: 76px;">
  <option>- Год -</option>{user-year}
 </select></div>
<div class="mgclr"></div>
<div class="texta">Страна:</div>
 <div class="padstylej"><select id="country" onChange="Profile.LoadCity(this.value); return false;" style="width: 245px;">
  <option value="0">- Не выбрано -</option>
  {country}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div>
<span id="city"><div class="texta">Город:</div>
 <div class="padstylej"><select style="width: 245px;" id="select_city">
  <option value="0">- Не выбрано -</option>
  {city}
 </select><img src="{theme}/images/loading_mini.gif" alt="" class="load_mini" id="load_mini" /></div>
<div class="mgclr"></div></span>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button id="saveform">Сохранить</button></div><div class="mgclr"></div>
</div>
[/general]
[contact]
<div class="clear_tps"></div>
<div class="box_right_owne" style="margin-top: -9px;">
        <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a>
 <div class="box_name_srtaw">Редактирование моей страницы</div>
 <a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>Основное</div></a>
 <div class="activetab news_a"><a href="/editmypage/contact" onClick="Page.Go(this.href); return false;"><div>Контакты</div></a></div>
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
</div><div class="clear"></div>
<div class="margintop10"></div>
<div class="err_yellow_on" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="box_fix"></div>
<div class="clear"></div>
<div class="texta">Мобильный телефон:</div><input type="text" id="phone" class="inpst" maxlength="50" value="{phone}" style="width:200px;" /><span id="validPhone"></span><div class="mgclr"></div>
<div class="texta">В контакте:</div><input type="text" id="vk" class="inpst" maxlength="100" value="{vk}" style="width:200px;" /><span id="validVk"></span><div class="mgclr"></div>
<div class="texta">Одноклассники:</div><input type="text" id="od" class="inpst" maxlength="100" value="{od}" style="width:200px;" /><span id="validOd"></span><div class="mgclr"></div>
<div class="texta">FaceBook:</div><input type="text" id="fb" class="inpst" maxlength="100" value="{fb}" style="width:200px;" /><span id="validFb"></span><div class="mgclr"></div>
<div class="texta">Skype:</div><input type="text" id="skype" class="inpst" maxlength="100" value="{skype}" style="width:200px;" /><span id="validSkype"></span><div class="mgclr"></div>
<div class="texta">ICQ:</div><input type="text" id="icq" class="inpst" maxlength="9" value="{icq}" style="width:200px;" /><span id="validIcq"></span><div class="mgclr"></div>
<div class="texta">Личный сайт:</div><input type="text" id="site" class="inpst" maxlength="100" value="{site}" style="width:200px;" /><span id="validSite"></span><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button name="save" id="saveform_contact">Сохранить</button></div><div class="mgclr"></div>
[/contact]
[interests]
<div class="clear_tps"></div>
<div class="box_right_owne" style="margin-top: -9px;">
        <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a>
 <div class="box_name_srtaw">Редактирование моей страницы</div>
 <a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>Основное</div></a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;"><div>Контакты</div></a>
 <div class="activetab news_a"><a href="/editmypage/interests" onClick="Page.Go(this.href); return false;"><div>Интересы</div></a></div>
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
<div class="clear"></div>
<div class="margintop10"></div>
<div class="err_yellow_on" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="box_fix"></div>
<div class="clear"></div>
<div class="texta">Деятельность:</div><textarea id="activity" class="inpst" style="width:300px;height:50px;overflow:hidden;">{activity}</textarea><div class="mgclr"></div>
<div class="texta">Интересы:</div><textarea id="interests" class="inpst" style="width:300px;height:50px;">{interests}</textarea><div class="mgclr"></div>
<div class="texta">Любимая музыка:</div><textarea id="music" class="inpst" style="width:300px;height:50px;">{music}</textarea><div class="mgclr"></div>
<div class="texta">Любимые фильмы:</div><textarea id="kino" class="inpst" style="width:300px;height:50px;">{kino}</textarea><div class="mgclr"></div>
<div class="texta">Любимые книги:</div><textarea id="books" class="inpst" style="width:300px;height:50px;">{books}</textarea><div class="mgclr"></div>
<div class="texta">Любимые игры:</div><textarea id="games" class="inpst" style="width:300px;height:50px;">{games}</textarea><div class="mgclr"></div>
<div class="texta">Любимые цитаты:</div><textarea id="quote" class="inpst" style="width:300px;height:50px;">{quote}</textarea><div class="mgclr"></div>
<div class="texta">О себе:</div><textarea id="myinfo" class="inpst" style="width:300px;height:50px;">{myinfo}</textarea><div class="mgclr"></div>
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button name="save" id="saveform_interests">Сохранить</button></div><div class="mgclr"></div>
[/interests]
[xfields]
<script type="text/javascript">
$(document).ready(function(){
	//Сохранение доп.полей
	$('#saveform_xfields').click(function(){
		butloading('saveform_xfields', '55', 'disabled', '');
		$.post('/index.php?go=editprofile&act=save_xfields', {{for-js-list}}, function(d){
			$('#info_save').html(lang_infosave).show();
			butloading('saveform_xfields', '55', 'enabled', lang_box_save);
		});
	});
});
</script>
<div class="clear_tps"></div>
<div class="box_right_owne" style="margin-top: -9px;">
         <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a>
 <div class="box_name_srtaw">Редактирование моей страницы</div>
 <a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>Основное</div></a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;"><div>Контакты</div></a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;"><div>Интересы</div></a>
 <div class="activetab news_a"><a href="/editmypage/all" onClick="Page.Go(this.href); return false;"><div>Другое</div></a></div>
  <div class="box_name_srtaw">Платное</div>
 <a href="/ads&act=ads_target" onClick="Page.Go(this.href); return false;"><div>Реклама</div></a>
<a href="/mybanners" onClick="Page.Go(this.href); return false;"><div>Баннеры</div></a>
   <a href="/vip" onClick="Page.Go(this.href); return false;"><div>VIP Статус</div></a>
   <a href="/obshenie" onClick="Page.Go(this.href); return false;"><div>Хочу общаться</div></a>
<a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои Подарки</div></a>
   <div class="box_name_srtaw">Развлечение</div>
      <a href="/miss" onClick="Page.Go(this.href); return false;"><div>Miss сайта</div></a>
</div>
<div class="clear"></div>
<div class="margintop10"></div>
<div class="err_yellow_on" id="info_save" style="display:none;font-weight:normal;"></div>
<div class="box_fix"></div>
<div class="clear"></div>
<div class="clear"></div>
{xfields}
<div class="texta">&nbsp;</div><div class="button_div fl_l"><button name="save" id="saveform_xfields">Сохранить</button></div><div class="mgclr"></div>
[/xfields]