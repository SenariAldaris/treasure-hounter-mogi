<div class="block1
"><div class="h-title1
">Бар "Охотник"</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<?PHP
$_OPTIMIZATION["title"] = "Бар";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_power2 LIMIT 1");
$trade = $db->FetchArray();

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
# максимум лезет в склад
$maxab = 10000;
?>
	
<table border="0">
<tbody>
<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/bar.png" name="slide_show"></div>   
</td>
<td valign="top">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; Это Бар "Охотник"!. Здесь можно поднять настроение - выпить пива!
Купите необходимое колличество и <br />пейте по мере необходимости, Пиво <br />не портится и не пропадает.</span></h3>
<center>
Меню бара: </br>
<div colspan="3">Пиво 0.5л. <img src="/img/fruit/pivo1.png" width="60" height="50" name="slide_show"> = <?=$sonfig_site["buy_coctel_dp"];?> <img src="/img/fruit/serebro.png" width="40" height="40"name="slide_show"> (+10 ед.н.)</div>


</center> 
</td>
</tr>
</tbody>
</table>
<hr>


<?php
if(isset($_POST["sell"])){

$sum = intval($_POST["sum"]);
$array_items2 = array(10 => "coctel_d");
$array_name2 = array(10 => "Пиво");
$item = intval($_POST["sell"]);
$citem = $array_items2[$item];

$array_items3 = array(10 => "coctel_dp");
$array_name3 = array(10 => "Пиво 0.5");
$pitem = intval($_POST["sell"]);
$pcitem = $array_items3[$pitem];

$lol = $sonfig_site["buy_".$pcitem];
if(strlen($citem) >= 3){
$need = $user_data[$citem];

if($need >= $sum){
if($sum >= 100){

$db->Query("SELECT COUNT(*) FROM db_power2 WHERE user_id = '$usid'");
if($db->FetchRow() == 0){


$sellb = $sum + $trade[$citem]; 
if($maxab > $sellb){	
$money = $sum * $sonfig_site["sell_".$citem];
# снимаем продукты
$db->Query("UPDATE db_users_b SET $citem = $citem - '$sum' WHERE id = '$usid'");
# добавляем в очередь 
$db->Query("INSERT INTO db_power2 (user_id, user, $citem, amount, kolvo, date_add) VALUES ('$usid','$usname','1','$lol','$sum','".time()."')");


	echo "<div class='success message'><center><font color = '#914A1F'><b>Продажа прошла успешно.</b></font></center><BR /></div>";
	header( 'Refresh: 1; url=/account/power1' );
	}else echo "<div class='warning message'><center><font color = 'red'><b>Резерв лавки переполнен. Попробуйте позже или продайте меньше товара.</b></font></center><BR /></div>";
	
	}else echo "<div class='warning message'><center><font color = 'red'><b>Ваш товар уже продаётся в лавке. Дождитесь его продажи.</b></font></center><BR /></div>";
	
	}else echo "<div class='warning message'><center><font color = 'red'><b>Кол-во продаваемого товара не может быть меньше 100.</b></font></center><BR /></div>";
	}else echo "<div class='error message'><center><font color = 'red'><b>Недостаточно товара для продажи.</b></font></center><BR /></div>";
}
}
?>

<?php
if(isset($_POST["buy"])){
$sum = intval($_POST["sum"]);

$array_items2 = array(10 => "coctel_dp");
$array_name2 = array(10=> "Пиво");
$pitem = intval($_POST["buy"]);
$pcitem = $array_items2[$pitem];

$array_items3 = array(10 => "coctel_d");
$array_name3 = array(10 => "Пиво");
$item = intval($_POST["buy"]);
$citem = $array_items3[$item];

if(strlen($pcitem) >= 3){
$need = $trade[$citem];
if($sum > 0){	
if($sum >= $need){

$kolvo = $trade["kolvo"];
if($kolvo >= $sum){
	

$money = $sum * $sonfig_site["buy_".$pcitem];

if($user_data["money_b"] >= $money){	
# зачисляем продукцию и снимаем деньги
$db->Query("UPDATE db_users_b SET money_b = money_b - $money, $pcitem = $pcitem + '$sum' WHERE id = '$usid'");
# обновляем лавку
$db->Query("UPDATE db_power2 SET kolvo = kolvo - '$sum' LIMIT 1");
# зачисляем бабки продавцу
$usbabki = $trade["user_id"];
$money2 = $sum * $sonfig_site["sell_".$citem];
$db->Query("UPDATE db_users_b SET money_p = money_p + $money2 WHERE id = '$usbabki'");
  
$db->Query("INSERT INTO db_power_buy2 (user_id, user, coctel, amount, kolvo, date_add) VALUES ('$usid','$usname','".$array_name3[$item]."','$money','$sum','".time()."')");
  
echo "<div class='success message'><center><font color = '#914A1F'><b>Покупка прошла успешно.</b></font></center><BR /></div>";
	header( 'Refresh: 3; url=/account/power1' );
}else echo "<div class='error message'><center><font color = 'red'><b>Недостаточно средств для покупки.</b></font></center><BR /></div>";
}else echo "<div class='warning message'><center><font color = 'red'><b>Кол-во покупаемого товара не может быть больше, чем находится в резерве  лавки.</b></font></center><BR /></div>";
}else echo "<div class='warning message'><center><font color = 'red'><b>В резерве лавки недостаточно товара для покупки. Используйте меньшее количество или выберите другую продукцию.</b></font></center><BR /></div>";
}else echo "<div class='warning message'><center><font color = 'red'><b>Кол-во покупаемого товара не может быть меньше 0.</b></font></center><BR /></div>";
}
}
?>






<?PHP
if(isset($_POST["add1"])){
if(1 <= $user_data["coctel_dp"]){
# Добавляем энергию и отнимаем продукцию
$db->Query("UPDATE db_users_b SET ns = ns + 10, coctel_dp = coctel_dp - 1 WHERE id = '$usid'");
$db->Query("INSERT INTO db_power_add2 (user_id, user, coctel, kolvo, date_add) VALUES ('$usid','$usname','Пиво','10','".time()."')");
echo "<div class='success message'><center><font color = '#914A1F'><b>Вы успешно улучшили настроение</b></font></center><BR /></div>";
	header( 'Refresh: 1; url=/account/power1' );
}else echo "<div class='error message'><center><font color = 'red'><b>У вас нет продукции.</b></font></center><BR /></div>";
}
?>

<table class="ta" align="center" width="100%">
<tr><td colspan="2"><center><b><font size="+0" color="#6F462A">У вас продукции</font></b></center></td></tr>
<tr>
<td ><center><b><font size="+0">Для продажи</font></b></center></td>
<td ><center><b><font size="+0">Для употребления</font></b></center></td>
</tr>
<tr><td width="60%">
<center>Пива: <?=$user_data["coctel_d"];?> шт. | Цена: <?=$sonfig_site["sell_coctel_d"];?> сер/ед.</center>
<? if(user_level::getInstance()->get_level() >= 20) { ?>
<center>
<form action="" method="post">
<select type="hidden" name="sell">
<option value="10">Пива</option>
</select><br />
<input name="sum" size="6" type="text" value="100"/>	
<input type="submit" class="btn_9" value="Продать" /></form>
</center>

<?PHP } else {	?> <br><center><font color="red"><b>Доступно с 20 уровня</b></font></center><?PHP } ?> 

</td><td width="50%">
<form action="" method="post">
<center>Пива: <?=$user_data["coctel_dp"];?> шт.</center>
<center>
<input type="hidden" name="add1"  />
<input type="submit" class="btn_9" value="Выпить" />
</form>
</center>


</td></tr></table>


<br />

<table cellpadding='3' cellspacing='0' border='0' class="ta" align='center' width="100%">
  <tr>
    <td colspan="5" align="center"><font color="#6F462A" size="+1"><b><center>Купить пиво</center></b></font></td>
    </tr>
   <tr bgcolor="#914A1F">
    <td align="center" ><font color="#FFF">Продавец</td>
	<td align="center" ><font color="#FFF">Продукция</font></td>
	<td align="center" ><font color="#FFF">Цена</font></td>
	<td align="center" ><font color="#FFF">Кол-во</font></td>
	<td align="center" ><font color="#FFF">Купить</font></td>
  </tr>
<?PHP
	$db->Query("SELECT * FROM db_power2 ORDER BY id ASC LIMIT 1");
		if($db->NumRows() > 0){
			while($bon = $db->FetchArray()){
?>
<tr class="htt">
<td align="center"><b><font color="#914A1F"><a href='/account/wall/<?=$bon["user"]; ?>' target='_blank'><?=$bon["user"]; ?></a></font></b></td>
<td align="center"> 
<?PHP		
if ($bon["coctel_d"]==1) { ?> 
<div class="cl-fr-lf">
<img style="border:3px solid #D7A984" src="/img/fruit/pivo1.png" width="40" height="30"/>
</div>
<b>Пиво</b>

<?PHP	} ?>  </td>
<td align="center"><b><?=$bon["amount"]; ?> сер.</b></td> 
<td align="center"><b><?=$bon["kolvo"]; ?></b></td> 

<td align="center">

<?php if ($trade["coctel_d"]==1) { ?>
<form action="" method="post">
<input type="hidden" name="buy" value="10" />
<input name="sum" size="6" type="text"  value="10" style="width: 40px;"/>	
<input type="submit" class="btn_9" value="Купить" />
</form>

<?PHP } ?>
</td></tr>
<?PHP
}
}else echo '<hr>'
?>
</table>







<br />



<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="100%">
  <tr>
    <td colspan="6" align="center"><font color="#6F462A" size="+1"><b><center>Очередь продукции (~50)</center></b></font></td>
    </tr>
   <tr bgcolor="#914A1F">
    <td align="center" >#</td>
    <td align="center" ><font color="#FFF">Продавец</font></td>
	<td align="center" ><font color="#FFF">Продукция</font></td>
	<td align="center" ><font color="#FFF">Цена</font></td>
	<td align="center" ><font color="#FFF">Кол-во</font></td>
	<td align="center" ><font color="#FFF">Дата добавления</font></td>
  </tr>
  <?PHP

  $db->Query("SELECT * FROM db_power2 ORDER BY id ASC LIMIT 50");

	if($db->NumRows() > 0){

  		while($bon = $db->FetchArray()){

		?>
		<tr class="htt">
		<td align="center">#</td>
    	<td align="center"><a href='/account/wall/<?=$bon["user"]; ?>' target='_blank'><?=$bon["user"]; ?></a></td>
    	<td align="center"> 
<?PHP 		
if ($bon["coctel_d"]==1) { ?> Пиво

<?PHP	} ?>  </td>
    	<td align="center"><?=$bon["amount"]; ?> сер.</td> 
		<td align="center"><?=$bon["kolvo"]; ?> </td> 
		<td align="center"><?=date("d.m.Y H:m:s",$bon["date_add"]); ?></td>
  		</tr>
		<?PHP

		}

	}else echo '<tr><td align="center" colspan="6">В продаже нет продукции...</td></tr>'
  ?>
</table>
</div></div>
</div>
<div class="block3"></div>
<div class="clr"></div>