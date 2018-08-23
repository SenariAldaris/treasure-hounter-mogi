<div class="miniature_box">
 <div class="miniature_pos" style="width:500px">
  <div class="payment_title">
   <img src="{ava}" width="50" height="50" />
   <div class="fl_l">
    Вы собираетесь пополнить счет на <b>vzex.ru</b>.<br />
    Ваш баланс: <b>{rub} {text-rub}</b>
   </div>
   <div class="fl_r">
    <a class="cursor_pointer" onClick="viiBox.clos('rk', 1)">Закрыть</a>
   </div>
   <div class="clear"></div>
  </div>
  <div class="clear"></div>
  <div class="payment_h2" style="text-align:center">Введите сумму пополнения:</div>
  <center>
   <input type="text" class="inpst payment_inp" maxlength="10" id="min" />
   <div class="rating_text_balance">После нажатия на кнопку <b>"Оплатить"</b> вы будите перенаправлены на страницу подтверждения платежа</div>
  </center>
  <div class="button_div fl_l" style="margin-left:210px;margin-top:15px"><button onClick="payment.send_inter()" id="sending">Пополнить</button></div>
  <div class="clear"></div>
 </div>
 <div class="clear" style="height:50px"></div>
</div>