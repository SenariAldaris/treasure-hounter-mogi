<script type="text/javascript">
	$('#speedbar').show();
	$('#speedbar').text(lang_fortuna);
</script>
<div class="cles_topggg"></div>
 <div class="box_right_owne" style=" margin-top: -7px;">
 <div class="activetab news_a"><a href="/loto?act=one" onClick="Page.Go(this.href); return false;">Фортуна</a></div>
 <a href="/loto?act=two" onClick="Page.Go(this.href); return false;">Лото 6 из 45</a>

 [first-game]

[/first-game]

</div>
<div class="clear"></div>
<li  class="wg2014-service">
<h3 class="wg2014-service-title">
Фортуна
<div class="wg2014-service-timer fl_r">
Следующая игра через
<strong class="wg2014-service-timer-value"><span id='cntdwn'></span></strong>
</div>
</h3>
 <div class="nonsense_titlewdffw">
 <div class="nonsense_titleww">Победитель выиграл {prev_prize} mix <span class="fl_r" style="font-weight: bold;"> Выигрышный номер: {winner_number}</span></div>
 <div class="nonsense_pobww">
  <div class="imgs_nones">
  <div class="box_bg_wens"></div>
   <div class="box_bg_wens2"></div>
    <div class="blcks"></div>  <div class="blcks2"></div>
 <a href="/u{winner_uid}" onClick="Page.Go(this.href); return false"><img src="{ava}" /></a><div class="blcks5"></div></div>
 <a href="/u{winner_uid}" onClick="Page.Go(this.href); return false"><b>{pob_name}</b></a>
 <div>{country-cuty}</div>
 <div>{age}</div>
 <div class="clear"></div>
</div></div>
 <div class="clear"></div>
<h3 class="wg2014-service-title">
Информация
</h3>
<div class="nonsense_info_block1">
<div class="nonsense_title" style="margin-top:30px">Розыгрыш</div>
<div class="nonsense_info">
 Розыгрыш происходит каждый день в <b>{nonsense_one_time}</b> по МСК.<br />
 Призовой фонд <b>{prize} mix.</b><br />
 Участие стоит <b>{nonsense_one_cost} mix.</b>
</div></div>
<div class="nonsense_info_block2">
<div class="nonsense_title" style="margin-top:10px">Участники</div>
<div class="nonsense_info">
 Всего участников: <b>{users_num}</b>
 <div class="clear"></div>
 <div class="err_yellow [game]no_display[/game]" style="font-weight:normal;margin-top:25px;margin-bottom:0px;border:0px">Ваш выигрышный номер в системе <b>{mynumber}</b></div>
 <div class="err_red no_display" style="font-weight:normal;margin-top:25px;margin-bottom:0px;border:0px">У Вас <b>недостаточно</b> mix. <a href="/balance" onClick="Page.Go(this.href); return false">Пополнить баланс</a></div>
 [game]<div style="width:120px;margin:auto" id="nonsenseButLogin"><div class="button_div fl_l" style="line-height:15px;margin-top:10px"><button id="nonsenseLogin" onClick="doLoad.data(3); nonsense.login()">Принять участие</button></div></div>[/game]
</div></div>
</li>
<div class="page_bg border_radius_5">
<div class="nonsense_title" style="margin-bottom:30px"></div>
<script language="JavaScript">
BID = 'cntdwn';
TargetDate = "{next-game}";
TekDate = "{tek-date}";
CountActive = true; 
CountStepper = -1;
LeadingZero = true; 
DisplayFormat = "%%H%%:%%M%%:%%S%%";
FinishMessage = "<a href=\"/loto?act=one\" onClick=\"Page.Go(this.href); return false\">Обновить страницу</a>";
</script>
<div class="cntdwn"><span id='cntdwn'></span>
</div>
<script type="text/javascript" src="{theme}/js/cd.js"></script>

<div id="ddtime"></div>
<div class="clear"></div>
<div class="clear"></div>
<h3 class="wg2014-service-title">Как это работает ?</h3>
<div class="nonsense_info" style="font-size:11px;color:#777;text-align: left;">
 Каждый день в назначенное время разыгрывается случайное число, которое генерирует система, от 1 до количества участников, и победитель получает весь призовой фонд себе на баланс, например участвует 7 человек, значит в указанное время будет сгенерировано случайное число от 1 до 7, ваше число выдается вам после того как вы нажали на кнопку "Принять участие". <br />На странице выводится результаты последнего розыгрыша.
</div>
</div>
<style>
.box_sdsss {

    height: 100%;
    margin: auto auto auto 222px;
    position: fixed;
    top: 0;
    width: 577px;
    z-index: 0;
}
</style>
 <style type="text/css" media="all">
.active_loto {
    background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.21);
    box-shadow: 0 0 3px -1px #000000 inset;
}</style>