<script type="text/javascript">
	$('#speedbar').show();
	$('#speedbar').text(lang_fortuna2);
</script>
<div class="cles_topggg"></div>
 <div class="box_right_owne" style=" margin-top: -7px;">
<a href="/loto?act=one" onClick="Page.Go(this.href); return false;">Фортуна</a>
  <div class="activetab news_a"><a href="/loto?act=two" onClick="Page.Go(this.href); return false;">Лото 6 из 45</a></div>
</div>
<div class="clear"></div>
<li  class="wg2014-service">
<h3 class="wg2014-service-title">
Лото 6 из 45
<div class="wg2014-service-timer fl_r">
Следующая игра через <strong class="wg2014-service-timer-value"><span id='cntdwn3'></span> </strong>
</div></h3>
<div class="nonsense_titlewdffw">
<div class="nonsense_titleww"><span class="" style="font-weight: bold;">[game]Выигрышные числа
<div class="nonsense_number">
 <a>{num1}</a>
 <a>{num2}</a>
 <a>{num3}</a>
 <a>{num4}</a>
 <a>{num5}</a>
 <a>{num6}</a>
</div>
[/game]</span></div>
</div>
<div class="nonsense_title">Результаты сыгранных билетов</div>
<div class="nonsense_info">
 {prizers-2}
 {prizers-3}
 {prizers-4}
 {prizers-5}
 {prizers-6}
 {none}
</div>
</li>

<div class="page_bg border_radius_5">
<div class="nonsense_title" style="margin-bottom:30px"></div>
<script language="JavaScript">
BID = 'cntdwn3';
TargetDate = "{next-game}";
TekDate = "{tek-date}";
CountActive = true; 
CountStepper = -1;
LeadingZero = true;
DisplayFormat = "%%H%%:%%M%%:%%S%%";
FinishMessage = "<a href=\"/loto?act=two\" onClick=\"Page.Go(this.href); return false\">Обновить страницу</a>";
</script>

<script type="text/javascript" src="{theme}/js/cd.js"></script>
<div id="ddtime"></div>
<div class="clear"></div>

<h3 class="wg2014-service-title">Время проведения<div class=" fl_r">
 Розыгрыш происходит каждый день в <b>{nonsense_two_time}</b> по МСК.<br />
</div></h3>
<div class="nonsense_info_block1" style=" margin-right: 26px;">
<div class="nonsense_title" style="margin-top:10px">Призовой фонд</div>
<div class="nonsense_info">
 2 из 45 = <b>{nonsense_two_prize_2} mix</b><br />
 3 из 45 = <b>{nonsense_two_prize_3} mix</b><br />
 4 из 45 = <b>{nonsense_two_prize_4} mix</b><br />
 5 из 45 = <b>{nonsense_two_prize_5} mix</b><br />
 6 из 45 = <b>{nonsense_two_prize_6}</b>
</div></div>
<div class="nonsense_info_block2" style="  margin-top: -24px;">
<div class="nonsense_title">Цена билета</div>
<div class="nonsense_info">
 Стоимость одного билета <b>{nonsense_two_cost} mix.</b>
</div></div>
<div class="nonsense_info_block2">
<div class="nonsense_info">
 Куплено уже билетов: <b>{users_num}</b>
</div>
<div class="nonsense_title" style="margin-top:10px"></div>

<div class="nonsense_info">
 <div style="width:150px;margin:auto">
  <div class="button_div fl_l" style="line-height:15px;margin-top:10px"><button onClick="doLoad.data(3); nonsense.biletBox()" style="width:150px">Купить билет</button></div>
  <div class="clear"></div>
 </div>
</div>
</div>
 <div class="clear"></div>
<h3 class="wg2014-service-title">Ваши билеты</h3>
<div id="mybilets">{my-bilets}</div>
<div class="clear"></div>
 [prev]<div class="rate_alluser cursor_pointer border_radius_5_bottom" style=" margin: 8px 10px -5px;" onClick="doLoad.data(3); nonsense.page()" id="loto_prev_ubut"><div id="load_loto_prev_ubut">Показать больше билетов</div></div>[/prev]


</div>
 <div class="clear"></div>
 <style type="text/css" media="all">
.active_loto {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>