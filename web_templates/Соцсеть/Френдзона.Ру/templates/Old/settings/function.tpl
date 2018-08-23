<script type="text/javascript">
$(document).click(function(event){
	settings.event(event);
});
</script>
<div class="search_form_tab" style="margin-top:-9px">
 <div class="buttonsprofile albumsbuttonsprofile buttonsprofileSecond" style="height:22px">
  <a href="/settings" onClick="Page.Go(this.href); return false;"><div><b>Общее</b></div></a>
  <a href="/settings/privacy" onClick="Page.Go(this.href); return false;"><div><b>Приватность</b></div></a>
  <div class="buttonsprofileSec"><a href="/settings/function" onClick="Page.Go(this.href); return false;"><div><b>V.I.P</b></div></a></div>
  <a href="/settings/blacklist" onClick="Page.Go(this.href); return false;"><div><b>Черный список</b></div></a>
  <a href="/balance" onClick="Page.Go(this.href); return false;"><div><b>Баланс</b></div></a>
 </div>
</div>
<div class="clear" style="margin-top:25px"></div>

<div id="pricing-table" class="clear">
<div class="margin_top_10">

<div class="plan"><h3>Блок <p>Хочу общаться</p><span><img src="/templates/vseti/images/ob12.jpg"></span></h3><a class="signup"></a><ul><li><b>Цена<font color=\"ff0000\">-10 Голосов.</font> <br><b>Срок действия: <font color=\"ff0000\"> 7 Дней.</font></b></li></ul><br><div class="button_div fl_l {obshenie_offline}" style="margin-left: 73px;" id="obshenieok"><button onclick="settings.addobshenie(); return false" id="obshenieokd">Купить</button></div><br></div></div> 
<div class="plan"><h3>Значёк <p>Vip пользователя </p><span><img src="/templates/vseti/images/vip.png"></span></h3><a class="signup"></a><ul><li><b>Цена <font color=\"ff0000\">-1000 Голосов.</font> </b><br><b>Срок действия: <font color=\"ff0000\">Навсегда.</font></b></li></ul><br><div class="button_div fl_l {vip_offline}" style="margin-left: 73px;" id="vipok"><button onclick="settings.addvip(); return false" id="vipokd">Купить</button></div><br></div></div>

<div class="mgclr"></div>