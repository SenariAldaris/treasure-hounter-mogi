<div class="block1
"><div class="h-title1
">Рыцари</div></div>
<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
                               
<?PHP
$_OPTIMIZATION["title"] = " Рыцарский состав";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

# Покупка нового дерева
if(isset($_POST["item"])){

$array_items = array(1 => "a_t", 2 => "b_t", 3 => "c_t", 4 => "d_t", 5 => "e_t", 6 => "f_t");
$array_name = array(1 => "Рабочий", 2 => "Хозяюшка", 3 => "Лесоруб", 4 => "Шахтер", 5 => "Рыцарь", 6 => "Главарь");
$item = intval($_POST["item"]);
$citem = $array_items[$item];
$all_items = ($user_data["a_t"] + $user_data["b_t"] + $user_data["c_t"] + $user_data["d_t"] + $user_data["e_t"] + $user_data["f_t"]);



	
	if(strlen($citem) >= 3){
		
		# Проверяем средства пользователя
		$need_money = $sonfig_site["amount_".$citem];

                                $need_ns = 1; 
                                if($need_ns <= $user_data["ns"]){

$max_g_t = 9+($user_data["g_t"]*20);
if($all_items <= $max_g_t){

                                $need_en = 2; 
                                if($need_en <= $user_data["en"]){
                


		if($need_money <= $user_data["money_b"]){
		
			//if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) )
//{
				


				$to_referer = $need_money * 0.1;
				# Добавляем дерево и списываем деньги
				$db->Query("UPDATE ".$pref."_users_b SET money_b = money_b - $need_money, $citem = $citem + 1, en = en - 2, ns = ns - 1,
				last_sbor = IF(last_sbor > 0, last_sbor, '".time()."') WHERE id = '$usid'");
				$db->Query("UPDATE ".$pref."_users_a SET balls = balls + 3 WHERE id = '$usid'");
				# Вносим запись о покупке
				$db->Query("INSERT INTO ".$pref."_stats_btree (user_id, user, tree_name, amount, date_add, date_del) 
				VALUES ('$usid','$usname','".$array_name[$item]."','$need_money','".time()."','".(time()+60*60*24*15)."')");
				$life_time->AddItem($usid,$citem);
				echo "<center><font color = '#914A1F'><b>Вы успешно пополнили свое войско!</b></font></center><BR />";
				header( 'Refresh: 3; url=/account/farm' );
				$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
				$user_data = $db->FetchArray();


				
			//}
//else echo "<center><font color = 'red'><b>Перед тем как нанять воина, следует собрать ресурсы за оградой!</b></font></center><BR />";
		
		}else echo "<center><font color = 'red'><b>Недостаточно серебра для оплаты</b></font></center><BR />";


}else echo "<center><font color = 'red'><b>Недостаточно энергии для оплаты!</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>Недостаточно места в казарме!</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>Недостаточно настроения для оплаты!</b></font></center><BR />";
	
	}else echo 222;

}

?>



<center>


Для того чтобы выжить и спастись от врагов, вам необходимо создать свое войско. <font color = 'red'><b>Внимание!!! Чтобы собирать ресурсы требуется построить склад!!! </b></font>Каждый воин будет нести службу в своей отрасли. Чтобы нанять воина, требуется 2ед. энергии, 1ед. настроения и дает вам 3 ед. опыта.


	</center>


<script type="text/javascript" src="http://yourjavascript.com/21139232152/bxslider.min.js"></script>
<script type="text/javascript" src="http://yourjavascript.com/11225442391/common.js"></script>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery('#slider1').bxSlider({
  auto: true,           // true, false - автоматическая смена слайдов
  speed: 2000,      // целое число - в милисекундах, скорость смены слайдов
 pause: 55000,  // целое число - в милисекундах, период между сменами слайдов
    });
  });
</script><div id="slider_cont">
<div id="slider1">

<div>

<!----><!---->
<center>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"> <font color="#000000"; ><b>Лесоруб</b></font></div>
<div colspan="3"><img src="/img/fruit/r3.png" name="slide_show"></div>

<!--<div id="example3" style=" display: none; ">-->
<center>

		
<div class="fr-te-gr"><b>Рубит деревья: </b><font color="#000000"><?=$sonfig_site["c_in_h"]; ?> в час</font></div>
<div class="fr-te-gr"><b>Цена:</b> <font color="#000000"><?=$sonfig_site["amount_c_t"]; ?> сер./ 3 месяца</font></div>
		<div class="fr-te-gr"><b>Нанято: </b><font color="#000000"><?=$user_data["c_t"]; ?> шт.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 5) { ?>
		<input type="hidden" name="item" value="3" />
		<input type="submit" value="Пригласить" style="height: 30px; margin-top:10px;" class="btn_8" /><?PHP } else {	?> <br><center><font color="red"><b>Доступно с 5 уровня</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!---->


<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"><font color="#000000"><b>Шахтер</b></font></div>
<div colspan="3"><img src="/img/fruit/r4.png" name="slide_show2"></div>

<!--<div id="example4" style=" display: none; ">-->
<center>
		<div class="fr-te-gr"><b>Добывает руду: </b><font color="#000000"><?=$sonfig_site["d_in_h"]; ?> в час</font></div>
		<div class="fr-te-gr"><b>Цена:</b> <font color="#000000"><?=$sonfig_site["amount_d_t"]; ?> сер./ 3 месяца</font></div>


		<div class="fr-te-gr"><b>Нанято:</b> <font color="#000000"><?=$user_data["d_t"]; ?> шт.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 10) { ?>
		<input type="hidden" name="item" value="4" />
		<input type="submit" value="Пригласить" style="height: 30px; margin-top:10px;"class="btn_8"><?PHP } else {	?> <br><center><font color="red"><b>Доступно с 10 уровня</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!----> 
</tr>
</table>
 </div>
<div><center>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"> <font color="#000000"; ><b>Рыцарь</b></font></div>
<div colspan="3"><img src="/img/fruit/r5.png" name="slide_show"></div>

<!--<div id="example3" style=" display: none; ">-->
<center>
<div class="fr-te-gr"><b>Участвует в бою: </b><font color="#000000"><?=$sonfig_site["e_in_h"]; ?> <img src="/img/fruit/zoloto.png" width="25" height="27" name="slide_show"> в час</font></div>
		<div class="fr-te-gr"><b>Цена:</b> <font color="#000000"><?=$sonfig_site["amount_e_t"]; ?> сер./ 3 месяца</font></div>


		<div class="fr-te-gr"><b>Нанято: </b><font color="#000000"><?=$user_data["e_t"]; ?> шт.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 20) { ?>
		<input type="hidden" name="item" value="5" />
		<input type="submit" value="Пригласить" style="height: 30px; margin-top:10px;" class="btn_8" /><?PHP } else {	?> <br><center><font color="red"><b>Доступно с 20 уровня</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!---->


<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"><font color="#000000"><b>Командир</b></font></div>
<div colspan="3"><img src="/img/fruit/r6.png" name="slide_show2" style="height: 240px;width:210px;"></div>

<!--<div id="example4" style=" display: none; ">-->
<center>
		
		
<div class="fr-te-gr"><b>Повышает все ресурсы: </b><font color="black">в 2 раза</font></div>
<div class="fr-te-gr"><b>Цена:</b> <font color="#000000"><?=$sonfig_site["amount_f_t"]; ?> сер./ 3 месяца</font></div>

		<div class="fr-te-gr"><b>Нанято:</b> <font color="#000000"><?=$user_data["f_t"]; ?> шт.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 30) { ?>
		<input type="hidden" name="item" value="6" />
		<input type="submit" value="Пригласить" style="height: 30px; margin-top:10px;"class="btn_8"><?PHP } else {	?> <br><center><font color="red"><b>Доступно с 30 уровня</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!----> 
</tr>
</table>

</div>


<div><center>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>

<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"> <font color="#000000"; ><b>Рабочий</b></font></div>
<div colspan="3"><img src="/img/fruit/r1.png" name="slide_show"></div>

<!--<div id="example3" style=" display: none; ">-->
<center>
<div class="fr-te-gr"><b>Копает глину: </b><font color="#000000"><?=$sonfig_site["a_in_h"]; ?> в час</font></div>
		<div class="fr-te-gr"><b>Цена:</b> <font color="#000000"><?=$sonfig_site["amount_a_t"]; ?> сер./ 3 месяца</font></div>


		<div class="fr-te-gr"><b>Нанято:</b> <font color="#000000"><?=$user_data["a_t"]; ?> шт.</font></div><form action="" method="post">

		<input type="hidden" name="item" value="1" />
		<input type="submit" value="Арендовать" style="height: 30px; margin-top:10px;" class="btn_8" />
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!---->


<!----><!---->
<td align="center">
<div class="fr-block3">
<div class="fr-te-gr-title"><font color="#000000"><b>Хозяюшка</b></font></div>
<div colspan="3"><img src="/img/fruit/r2.png" name="slide_show2"></div>

<!--<div id="example4" style=" display: none; ">-->
<center>
		<div class="fr-te-gr"><b>Выращивает злаки: </b><font color="#000000"><?=$sonfig_site["b_in_h"]; ?> в час</font></div>
		<div class="fr-te-gr"><b>Цена:</b> <font color="#000000"><?=$sonfig_site["amount_b_t"]; ?> сер./ 3 месяца</font></div>


		<div class="fr-te-gr"><b>Нанято:</b> <font color="#000000"><?=$user_data["b_t"]; ?> шт.</font></div><form action="" method="post">
<?if(user_level::getInstance()->get_level() >= 2) { ?>
		<input type="hidden" name="item" value="2" />
		<input type="submit" value="Пригласить" style="height: 30px; margin-top:10px;"class="btn_8"><?PHP } else {	?> <br><center><font color="red"><b>Доступно со 2 уровня</b></font></center><?PHP } ?>
	</div>
	</form>
</center>
<!--</div>-->


</td>
<!----><!----> 
</tr>
</table></div>

</div>
</div><style>
/* оформление и размер блока */
#slider_cont {
    border: 0px solid #006699;
    margin: 0px;
    width: 555px!important;
    padding: 0px;
}

/* кнопка следующее изображение */
.bx-prev {
position:absolute;
top:45%;
left:5px;
width:31px;
height:31px;
text-indent:-999999px;
background:url(/img/prev.png) no-repeat  0 -30px;
}

/* кнопка предыдущее изображение */
.bx-next {
position:absolute;
top:45%;
right:5px;
width:31px;
height:31px;
text-indent:-999999px;
background:url(/img/next.png) no-repeat 0 -30px;
}

/* для кнопок при наведении курсора */
.bx-next:hover {
background:url(/img/next1.png) no-repeat 0 -30px;
border:0;
}
/* для кнопок при наведении курсора */
.bx-prev:hover {
background:url(/img/prev1.png) no-repeat  0 -30px;
border:0;
}
</style>




 






</div></div>

</div>
<div class="block3"></div>