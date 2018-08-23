<style type="text/css" media="all">
.active_setings {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>

<script type="text/javascript">
	$('#speedbar').show();
	$('#speedbar').text(lang_setings_balance);
</script>

  <div class="cles_topggg"></div>
<div class="box_right_owne" style=" margin-top: -12PX;">
  <div class="box_name_srtaw">Настройки</div>
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <div class="activetab news_a"><a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Личный счёт</b></div></a></div>
  <a href="/balance?act=invited" onClick="Page.Go(this.href); return false;"><div><b>Приглашённые друзья</b></div></a>
  <a href="/settings/notify" onClick="Page.Go(this.href); return false;">Оповещения</a>
 <div class="box_name_srtaw">Редактирование моей страницы</div>
 <a href="/editmypage" onClick="Page.Go(this.href); return false;"><div>Основное</div></a>
 <a href="/editmypage/contact" onClick="Page.Go(this.href); return false;"><div>Контакты</div></a>
 <a href="/editmypage/interests" onClick="Page.Go(this.href); return false;"><div>Интересы</div></a>
 <a href="/editmypage/all" onClick="Page.Go(this.href); return false;"><div>Другое</div></a>
  <div class="box_name_srtaw">Платное</div>
 <a href="/ads&act=ads_target" onClick="Page.Go(this.href); return false;"><div>Реклама</div></a>
   <a href="/vip" onClick="Page.Go(this.href); return false;"><div>VIP Статус</div></a>
   <a href="/obshenie" onClick="Page.Go(this.href); return false;"><div>Хочу общаться</div></a>
<a href="/balance?act=business" onClick="Page.Go(this.href); return false;"><div>Мои Подарки</div></a>
   <div class="box_name_srtaw">Развлечение</div>
      <a href="/miss" onClick="Page.Go(this.href); return false;"><div>Miss сайта</div></a>
</div>

<div style=" margin-top: 13px;"></div>

  <div class="clear"></div>
  <div class="payment_h2" style="text-align:center">Введите сумму пополнения:</div>
  <center>
   <input type="text" class="inpst payment_inp" maxlength="10" id="min" />
   <div class="rating_text_balance">После нажатия на кнопку <b>"Оплатить"</b> вы будите перенаправлены на страницу подтверждения платежа</div>
  </center>
  <div class="button_div fl_l" style="margin-left:250px;margin-top:15px"><button onClick="payment.send_inter()" id="sending">Пополнить</button></div>
  <div class="clear"></div>
 </div>
 <div class="clear" style="height:50px"></div>
</div>