<?PHP
$_OPTIMIZATION["title"] = " Деревня";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

?>

<div style="
    width: 1017px;
    height: 825px;
    background: url(/img/mapdesign2.png);
    position: relative;
    left: -50px;
    top: 0px;
    z-index: 1;
    margin-bottom: 30px;
    overflow: hidden;
    background-repeat: no-repeat;
    background-size: 100% 100%;
">



<div id="link100" style="
    width: 1108px;
    height: 342px;
    background: url(/img/g33_01_normal_top.png) no-repeat;
    position: relative;
    left: -52px;
    top: 107px;
    z-index: 3;
"></div>

<div id="link200" style="
    width: 1108px;
    height: 760px;
    background: url(/img/g33_01_normal_bottom.png) no-repeat;
    position: relative;
    left: -50px;
    top: -235px;
    z-index: 1;
"></div>

<div id="vstavka" style="
    width: 101px;
    height: 27px;
    position: relative;
    left: 492px;
    top: -847px;
    z-index: 3;
"></div>

<div id="link1" style="
    width: 151px;
    height: 118px;
    background: url(/img/dom.png) no-repeat;
    position: relative;
    left: 477px;
    top: -847px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account';
"></div>


<div id="link2" style="
    width: 156px;
    height: 198px;
    background: url(/img/chat.png) no-repeat;
    position: relative;
    left: 585px;
    top: -886px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/chat';
"></div>


<div id="link3" style="
    width: 151px;
    height: 145px;
    background: url(/img/kazna.png) no-repeat;
    position: relative;
    left: 297px;
    top: -1154px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/kazna';
"></div> 

<div id="link4" style="
    width: 170px;
    height: 150px;
    background: url(/img/lavka.png) no-repeat;
    position: relative;
    left: 515px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -1047px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/trade';
"></div>


<div id="link5" style="
    width: 160px;
    height: 120px;
    background: url(/img/bar.png) no-repeat;
    position: relative;
    left: 630px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -1124px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/power1';
"></div>


<div id="link6" style="
    width: 160px;
    height: 130px;
    background: url(/img/obshepit.png) no-repeat;
    position: relative;
    left: 242px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -1258px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/power';
"></div>


<div id="link8" style="
        width: 180px;
    height: 180px;
    background: url(/img/dvorec.png) no-repeat;
    position: relative;
    left: 400px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -1570px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/help';
"></div>

<div id="link9" style="
    width: 160px;
    height: 140px;
    background: url(/img/pit.png);
    position: relative;
    left: 243px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -1770px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/igrun';
"></div>

<div id="link10" style="
    width: 150px;
    height: 127px;
    background: url(/img/kazarma1.png) no-repeat;
    position: relative;
    left: 717px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2040px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/kazarma';
"></div>

<?php if($user_data["g_t"] == 0) { ?>
<div id="vstavka" style="
    width: 180px;
    height: 130px;
    
    position: relative;
    left: 670px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2168px;
    z-index: 0;
"></div>
<? } ?>

<?php if($user_data["g_t"] == 1) { ?>
<div id="link11" style="
    width: 180px;
    height: 130px;
    background: url(/img/kazarma2.png) no-repeat;
    position: relative;
    left: 715px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2168px;
    z-index: 5;
    cursor: pointer;
"onclick="location.href='/account/kazarma';
"></div>
<? } ?>


<div class="metka1" id="metka1" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 430px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2350px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/melnica';
"></div>


<?php if($user_data["l_t"] == 0) { ?>
<div id="vstavka" style="
    width: 150px;
    height: 150px;
    position: relative;
    left: 370px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
   top: -4550px;
    z-index: 0;
"></div>
<? } ?>


<?php if($user_data["l_t"] == 1) { ?>
<div id="link7" style="
    width: 150px;
    height: 150px;
    background: url(/img/melnica.png) no-repeat;
    position: relative;
    left: 380px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2490px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/melnica';
"></div>
<? } ?>

<?php if($user_data["m_t"] == 0) { ?>
<div id="vstavka" style="
    width: 130px;
    height: 130px;
    position: relative;
    left: 380px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
   top: -4550px;
    z-index: 0;
"></div>
<? } ?>

<?php if($user_data["m_t"] == 1) { ?>
<div id="link12" style="
    width: 130px;
    height: 130px;
    background: url(/img/kirpichzavod.png);
    position: relative;
    left: 278px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2580px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/kirpichzavod';
"></div>
<? } ?>


<?php if($user_data["n_t"] == 0) { ?>
<div id="vstavka" style="
    width: 130px;
    height: 130px;
    position: relative;
    left: 370px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
  top: -4550px;
    z-index: 0;
"></div>
<? } ?>

<?php if($user_data["n_t"] == 1) { ?>
<div id="link13" style="
width: 130px;
    height: 130px;
    background: url(/img/pilorama.png) no-repeat;
    position: relative;
    left: 647px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2705px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/pilorama';
"></div>
<? } ?>


<?php if($user_data["r_t"] == 0) { ?>
<div id="vstavka" style="
    width: 130px;
    height: 130px;
    position: relative;
    left: 830px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
  top: -4550px;
    z-index: 0;
"></div>
<? } ?>

<?php if($user_data["r_t"] == 1) { ?>
<div id="link14" style="
    width: 130px;
    height: 130px;
    background: url(/img/pecarna.png) no-repeat;
    position: relative;
    left: 835px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2680px;
    z-index: 5;
    cursor: pointer;
"onclick="location.href='/account/pekarna';
"></div>
<? } ?>

<?php if($user_data["k_t"] == 0) { ?>
<div id="vstavka" style="
    width: 130px;
    height: 130px;
    position: relative;
    left: 370px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
  top: -4550px;
    z-index: 0;
"></div>
<? } ?>

<?php if($user_data["k_t"] == 1) { ?>
<div id="link15" style="
    width: 130px;
    height: 130px;
    background: url(/img/sklad2.png) no-repeat;
    position: relative;
    left: 525px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2990px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/sklad';
"></div>
<? } ?>


<?php if($user_data["o_t"] == 0) { ?>
<div id="vstavka" style="
    width: 150px;
    height: 140px;
    position: relative;
    left: 40px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
   top: -4550px;
    z-index: 0;
"></div><? } ?>


<?php if($user_data["o_t"] == 1) { ?>
<div id="link16" style="
    width: 150px;
    height: 140px;
    background: url(/img/stalzavod.png) no-repeat;
    position: relative;
    left: 50px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2955px;
    z-index: 5;
    cursor: pointer;
"onclick="location.href='/account/liteyniyzavod';
"></div><? } ?>

<?php if($user_data["q_t"] == 0) { ?>
<div id="vstavka" style="
    width: 140px;
    height: 120px;
    position: relative;
    left: 710px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
 top: -4550px;
    z-index: 0;
"></div><? } ?>


<?php if($user_data["q_t"] == 1) { ?>
<div id="link17" style="
    width: 130px;
    height: 120px;
    background: url(/img/zagon.png) no-repeat;
    position: relative;
    left: 130px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -2880px;
    z-index: 6;
    cursor: pointer;
"onclick="location.href='/account/market';
"></div><? } ?>







<?php if($user_data["t_t"] == 0) { ?>
<div id="vstavka" style="
    width: 140px;
    height: 140px;
    position: relative;
    left: 845px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
  top: -4550px;
    z-index: 0;
"></div><? } ?>

<?php if($user_data["t_t"] == 1) { ?>
<div id="link18" style="
    width: 130px;
    height: 140px;
    background: url(/img/maysokombinat.png) no-repeat;
    position: relative;
    left: 845px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -3095px;
    z-index: 5;
    cursor: pointer;
"onclick="location.href='/account/shashlichnaya';
"></div><? } ?>


<?php if($user_data["s_t"] == 0) { ?>
<div id="vstavka" style="
    width: 140px;
    height: 120px;
    position: relative;
    left: 627px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
   top: -4550px;
    z-index: 0;
"></div><? } ?>

<?php if($user_data["s_t"] == 1) { ?>
<div id="link19" style="
    width: 140px;
    height: 120px;
    background: url(/img/pivovarna.png) no-repeat;
    position: relative;
    left: 740px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -3175px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/pivovarna';
"></div><? } ?>



<div id="vstavkasvobodnaya-netrogat" style="
   width: 140px;
    height: 140px;
    position: relative;
    left: 0px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4530px;
    z-index: 0;
"></div>




<?php if($user_data["p_t"] == 0) { ?>
<div id="vstavka" style="
    width: 150px;
    height: 140px;
    position: relative;
    left: 120px; top: -4050px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    z-index: 0;
"></div><? } ?>

<?php if($user_data["p_t"] == 1) { ?>
<div id="link21" style="
    width: 150px;
    height: 140px;
    background: url(/img/ceh.png) no-repeat;
    position: relative;
    left: 39px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -3500px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/kolbasniyceh';
"></div><? } ?>


<div id="link22" style="
    width: 120px;
    height: 110px;
    background: url(/img/fond.png) no-repeat;
    position: relative;
    left: 132px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -3823px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/account/bonus';
"></div>


<div id="link23" style="
    width: 140px;
    height: 140px;
    background: url(/img/konkurs.png) no-repeat;
    position: relative;
    left: 418px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -3565px;
    z-index: 4;
    cursor: pointer;
"onclick="location.href='/competition';
"></div>




<div class="metka1" id="metka2" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 558px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4100px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/sklad';
"></div>


<div class="metka1" id="metka3" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 308px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4115px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/kirpichzavod';
"></div>


<div class="metka1" id="metka4" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 678px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4155px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/pilorama';
"></div>







<div class="metka1" id="metka5" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 98px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4045px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/liteyniyzavod';
"></div>


<div class="metka1" id="metka6" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 82px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -3980px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/kolbasniyceh';
"></div>


<div class="metka1" id="metka7" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 168px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -3940px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/farm2';
"></div>





<div class="metka1" id="metka8" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 878px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4175px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/pekarna';
"></div>


<div class="metka1" id="metka9" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 892px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4110px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/shashlichnaya';
"></div>


<div class="metka1" id="metka10" style="
    width: 60px;
    height: 40px;
    position: relative;
    left: 785px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -4070px;
    z-index: 3;
    cursor: pointer;
"onclick="location.href='/account/pivovarna';
"></div>



</div>




<style>



body {


background:
  
url(../img/bg1.jpg) top -220px  center no-repeat, 
  #8EBF66 url(../img/body_bg.png) center repeat-y;  height-min:1060px; 					margin-left: 50px;	
  font-family: "PTSansRegular"; }
img { border:0px; }
.clr { clear:both;}


.stn:link, .stn:visited { color: #609143; text-decoration: none; font-weight: bold; } 
.stn:active, .stn:hover { color: #d77906; text-decoration: none; }

.stn-sort:link, .stn-sort:visited { color: #FFFFFF; text-decoration: none; font-weight: bold; } 
.stn-sort:active, .stn-sort:hover { color: #000000; text-decoration: none; }
</style>





<script>
$(document).ready(function(){ 
$("#link1").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Ваше жилье</b></div></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#link2").easyTooltip({
yOffset: 50,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Пункт сбора</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link3").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Казна золота</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link4").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Торговля</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link5").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Бар "Охотник"</b></div></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#link6").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Столовая</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link7").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Мельница</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link8").easyTooltip({
yOffset: 60,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Дворец</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link9").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Клуб игроков</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link10").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Казарма</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link11").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Казарма</b></div></h4></p>'
});
});
</script>



<script>
$(document).ready(function(){ 
$("#metka1").easyTooltip({
yOffset: 70,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Мельница</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#metka4").easyTooltip({
yOffset: 70,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Пилорама</b></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#metka3").easyTooltip({
yOffset: 70,
xOffset: -70,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Кирпичный завод</b></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#metka2").easyTooltip({
yOffset: 70,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Склад</b></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#metka5").easyTooltip({
yOffset: 70,
xOffset: -60,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Литейный завод</b></h4></p>'
});
});
</script>

<script>
$(document).ready(function(){ 
$("#metka6").easyTooltip({
yOffset: 70,
xOffset: -70,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Колбасный цех</b></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#metka7").easyTooltip({
yOffset: 70,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Загоны</b></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#metka8").easyTooltip({
yOffset: 70,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Пекарня</b></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#metka9").easyTooltip({
yOffset: 70,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Шашлычная</b></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#metka10").easyTooltip({
yOffset: 70,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><b>Пивоварня</b></h4></p>'
});
});
</script>


<script>
$(document).ready(function(){ 
$("#link12").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Кирпичный завод</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link13").easyTooltip({
yOffset: 60,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Пилорама</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link14").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Пекарня</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link15").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Хранилище</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link16").easyTooltip({
yOffset: 60,
xOffset: -30,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Литейный завод</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link17").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Загоны</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link18").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Шашлычная</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link19").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Пивоварня</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link20").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Наковальня</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link21").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Колбасный цех</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link22").easyTooltip({
yOffset: 60,
xOffset: -40,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Госфонд</b></div></h4></p>'
});
});
</script>
<script>
$(document).ready(function(){ 
$("#link23").easyTooltip({
yOffset: 60,
xOffset: -50,
tooltipId: "easyTooltip4", 
content: '<h4p><div class="fr-te-gr-title"><b>Состязания</b></div></h4></p>'
});
});
</script>




<style>
#easyTooltip{
	color: #2C3719;
	margin:0 10px 1em 0;
	width:250px;
	padding:8px;
	background: rgba(255, 255, 255, 0.72);
	border:1px solid #7C7C79;
	line-height:130%;xOffset: -100px;
	border-radius: 15px 15px 15px 15px;
	box-shadow: rgb(243, 252, 57) 0px 0px 5px 0px;
	z-index:100;
	}
#easyTooltip h3{
	margin:0 0 .5em 0;
	font:13px Arial, Helvetica, sans-serif;
	text-transform:uppercase;
	}	
#easyTooltip p{
	margin:0 0 .5em 0;
	}		
#easyTooltip img{
		background:#fff;
		padding:1px;
		border:1px solid #e1e1e1;
		float:left;
		margin-right:10px;
		}	
		
#easyTooltip4{
	color: #2C3719;
	margin:0 10px 1em 0;
	/*width:100px;*/
	padding:8px;height:20px;
	background: rgba(245, 245, 245, 0.72);
	border:1px solid #E0FFFF;
	line-height:130%;
	border-radius: 10px 10px 10px 10px;
        box-shadow: inset 0px 1px 10px 0px rgba(55, 55, 55, 0.400), 3px 5px 10px rgba(0, 0, 0, 0.402); text-align: center;
	z-index:100;
	}
	
	
.metka1 {
    width: 60px;
    height: 40px;
    
    z-index: 4;
    cursor: pointer;

}


.metka1:hover {
    width: 60px;
    height: 40px;
    background: url(/img/metka.png) no-repeat;
    opacity: 0.7;
    z-index: 4;
    cursor: pointer;
}
</style>







