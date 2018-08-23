<script type="text/javascript">
$(document).ready(function(){
	myhtml.checked(['{n_friends}', '{n_wall}', '{n_comm}', '{n_comm_ph}', '{n_comm_note}', '{n_gifts}', '{n_rec}', '{n_im}']);
});
function save_notify(){
	var n_friends = $('#n_friends').val();
	var n_wall = $('#n_wall').val();
	var n_comm = $('#n_comm').val();
	var n_comm_ph = $('#n_comm_ph').val();
	var n_comm_note = $('#n_comm_note').val();
	var n_gifts = $('#n_gifts').val();
	var n_rec = $('#n_rec').val();
	var n_im = $('#n_im').val();
	$.post('/index.php?go=settings&act=save_notify', {n_friends: n_friends, n_wall: n_wall, n_comm: n_comm, n_comm_ph: n_comm_ph, n_comm_note: n_comm_note, n_gifts: n_gifts, n_rec: n_rec, n_im: n_im});
}
</script>
 <div class="cles_topggg"></div>
 <div class="box_right_owne" style=" margin-top: -12PX;">
  <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <div class="activetab news_a"><a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a></div>
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
</div><div class="margin_top_10"></div><div class="allbar_title_vip">Оповещения по электронной почте</div>
<div class="page_ii">
<div class="html_checkbox" id="n_friends" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при новой заявки в друзья</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_wall" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при ответе на запись</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_comm" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при комментировании видео</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_comm_ph" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при комментировании фото</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_comm_note" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при комментировании заметки</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_gifts" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при новом подарке</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_rec" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при новой записи на стене</div><div class="clear" style="height:10px"></div>
<div class="html_checkbox" id="n_im" onClick="myhtml.checkbox(this.id); save_notify()">Уведомление при новом персональном сообщении</div><div class="clear"></div>
</div>