<div class="block1
"><div class="h-title1
">Столовая</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<?PHP
$_OPTIMIZATION["title"] = "Столовая";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_power LIMIT 1");
$trade = $db->FetchArray();

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
# максимум лезет в склад
$maxab = 10000;
?><table border="0">
<tbody>
<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/obshepit.png" name="slide_show"></div>   
</td>
<td valign="top">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; Это общественная столовая. Здесь можно пополнить жизненную энергию. </span></h3>
<center>
Главное меню: </br>
<div colspan="3">Хлеб <img src="/img/fruit/hleb.png" width="40" height="30" name="slide_show"> = <?=$sonfig_site["buy_coctel_ap"];?> <img src="/img/fruit/serebro.png" width="30" height="30" name="slide_show"> (+10 ед.эн.)</div>
<div colspan="3">Шашлык <img src="/img/fruit/shashlik.png" width="40" height="40" name="slide_show"> = <?=$sonfig_site["buy_coctel_bp"];?> <img src="/img/fruit/serebro.png" width="30" height="30"name="slide_show"> (+15 ед.эн.)</div>
<div colspan="3">Колбаса <img src="/img/fruit/kolbasa.png" width="35" height="30" name="slide_show"> = <?=$sonfig_site["buy_coctel_cp"];?> <img src="/img/fruit/serebro.png" width="30" height="30"name="slide_show"> (+25 ед.эн.)</div>

</center> 
</td>
</tr>
</tbody>
</table>
<hr>

<?php
if(isset($_POST["sell"])){

$sum = intval($_POST["sum"]);
$array_items2 = array(7 => "coctel_a", 8 => "coctel_b", 9 => "coctel_c");
$array_name2 = array(7 => "Хлеб", 8 => "Шашлык", 9 => "Колбаса");
$item = intval($_POST["sell"]);
$citem = $array_items2[$item];

$array_items3 = array(7 => "coctel_ap", 8 => "coctel_bp", 9 => "coctel_cp");
$array_name3 = array(7 => "Хлеб", 8 => "Шашлык", 9 => "Колбаса");
$pitem = intval($_POST["sell"]);
$pcitem = $array_items3[$pitem];

$lol = $sonfig_site["buy_".$pcitem];
if(strlen($citem) >= 3){
$need = $user_data[$citem];

if($need >= $sum){
if($sum >= 100){

$db->Query("SELECT COUNT(*) FROM db_power WHERE user_id = '$usid'");
if($db->FetchRow() == 0){


$sellb = $sum + $trade[$citem]; 
if($maxab > $sellb){	
$money = $sum * $sonfig_site["sell_".$citem];
# снимаем продукты
$db->Query("UPDATE db_users_b SET $citem = $citem - '$sum' WHERE id = '$usid'");
# добавляем в очередь 
$db->Query("INSERT INTO db_power (user_id, user, $citem, amount, kolvo, date_add) VALUES ('$usid','$usname','1','$lol','$sum','".time()."')");


	echo "<div class='success message'><center><font color = '#914A1F'><b>Продажа прошла успешно.</b></font></center><BR /></div>";
	header( 'Refresh: 1; url=/account/power' );
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

$array_items2 = array(7 => "coctel_ap", 8 => "coctel_bp", 9 => "coctel_cp");
$array_name2 = array(7 => "Хлеб", 8 => "Шашлык", 9 => "Колбаса");
$pitem = intval($_POST["buy"]);
$pcitem = $array_items2[$pitem];

$array_items3 = array(7 => "coctel_a", 8 => "coctel_b", 9 => "coctel_c");
$array_name3 = array(7 => "Хлеб", 8 => "Шашлык", 9 => "Колбаса");
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
$db->Query("UPDATE db_power SET kolvo = kolvo - '$sum' LIMIT 1");
# зачисляем бабки продавцу
$usbabki = $trade["user_id"];
$money2 = $sum * $sonfig_site["sell_".$citem];
$db->Query("UPDATE db_users_b SET money_p = money_p + $money2 WHERE id = '$usbabki'");
  
$db->Query("INSERT INTO db_power_buy (user_id, user, coctel, amount, kolvo, date_add) VALUES ('$usid','$usname','".$array_name3[$item]."','$money','$sum','".time()."')");
  
echo "<div class='success message'><center><font color = '#914A1F'><b>Покупка прошла успешно.</b></font></center><BR /></div>";
	header( 'Refresh: 3; url=/account/power' );
}else echo "<div class='error message'><center><font color = 'red'><b>Недостаточно средств для покупки.</b></font></center><BR /></div>";
}else echo "<div class='warning message'><center><font color = 'red'><b>Кол-во покупаемого товара не может быть больше, чем находится в резерве  лавки.</b></font></center><BR /></div>";
}else echo "<div class='warning message'><center><font color = 'red'><b>В резерве лавки недостаточно товара для покупки. Используйте меньшее количество или выберите другую продукцию.</b></font></center><BR /></div>";
}else echo "<div class='warning message'><center><font color = 'red'><b>Кол-во покупаемого товара не может быть меньше 0.</b></font></center><BR /></div>";
}
}
?>






<?PHP
$sum1 = intval($_POST["sum1"]);
$sumop = $sum1 * 10;
if(isset($_POST["add1"])){
if($sum1 <= $user_data["coctel_ap"]){
# Добавляем энергию и отнимаем продукцию
$db->Query("UPDATE db_users_b SET en = en + '$sumop', coctel_ap = coctel_ap - '$sum1' WHERE id = '$usid'");
$db->Query("INSERT INTO db_power_add (user_id, user, coctel, kolvo, date_add) VALUES ('$usid','$usname','Хлеб','$sumop','".time()."')");
echo "<div class='success message'><center><font color = '#914A1F'><b>Вы успешно пополнили энергию</b></font></center><BR /></div>";
	header( 'Refresh: 1; url=/account/power' );
}else echo "<div class='error message'><center><font color = 'red'><b>У вас нет столько продукции.</b></font></center><BR /></div>";
}
?>
<?PHP
$sum2 = intval($_POST["sum2"]);
$sumop = $sum2 * 15;
if(isset($_POST["add2"])){
if($sum2 <= $user_data["coctel_bp"]){
# Добавляем энергию и отнимаем продукцию
$db->Query("UPDATE db_users_b SET en = en + '$sumop', coctel_bp = coctel_bp - '$sum2' WHERE id = '$usid'");
$db->Query("INSERT INTO db_power_add (user_id, user, coctel, kolvo, date_add) VALUES ('$usid','$usname','Шашлык','$sumop','".time()."')");
echo "<div class='success message'><center><font color = '#914A1F'><b>Вы успешно пополнили энергию</b></font></center><BR /></div>";
	header( 'Refresh: 1; url=/account/power' );
}else echo "<div class='error message'><center><font color = 'red'><b>У вас нет столько продукции.</b></font></center><BR /></div>";
}
?>
<?PHP
$sum3 = intval($_POST["sum3"]);
$sumop = $sum3 * 25;
if(isset($_POST["add3"])){
if($sum3 <= $user_data["coctel_cp"]){
# Добавляем энергию и отнимаем продукцию
$db->Query("UPDATE db_users_b SET en = en + '$sumop', coctel_cp = coctel_cp - '$sum3' WHERE id = '$usid'");
$db->Query("INSERT INTO db_power_add (user_id, user, coctel, kolvo, date_add) VALUES ('$usid','$usname','Колбаса','$sumop','".time()."')");
echo "<div class='success message'><center><font color = '#914A1F'><b>Вы успешно пополнили энергию</b></font></center><BR /></div>";
	header( 'Refresh: 1; url=/account/power' );
}else echo "<div class='error message'><center><font color = 'red'><b>У вас нет столько продукции.</b></font></center><BR /></div>";
}
?>
<table class="ta" align="center" width="100%">
<tr><td colspan="2"><center><b><font size="+1" color="#6F462A">У вас продукции</font></b></center></td></tr>
<tr>
<td ><center><b><font size="+1">Для продажи</font></b></center></td>
<td ><center><b><font size="+1">Для употребления</font></b></center></td>
</tr>
<tr><td width="60%">
Хлеба: <?=$user_data["coctel_a"];?> шт. | Цена: <?=$sonfig_site["sell_coctel_a"];?> сер/ед.<br />
Шашлыков: <?=$user_data["coctel_b"];?> шт. | Цена: <?=$sonfig_site["sell_coctel_b"];?> сер/ед.<br />
Колбасы: <?=$user_data["coctel_c"];?> шт. | Цена: <?=$sonfig_site["sell_coctel_c"];?> сер/ед.<br />



<? if(user_level::getInstance()->get_level() >= 20) { ?>

<center>
<form action="" method="post">
<select type="hidden" name="sell">
<option value="7">Хлеб</option>
<option value="8">Шашлык</option>
<option value="9">Колбаса</option>
</select><br />
<input name="sum" size="6" type="text" value="100"/>	
<input type="submit" class="btn_9" value="Продать" /></form>
</center>
<?PHP } else {	?> <br><center><font color="red"><b>Доступно с 20 уровня</b></font></center><?PHP } ?> 

</td><td width="50%">
<form action="" method="post">
Хлеба: <?=$user_data["coctel_ap"];?> шт. 
<center>
<input name="sum1" type="text" value="10" style="width: 60px;" />
<input type="hidden" name="add1" value="3" />
<input type="submit" class="btn_9" value="Покушать" />
</form>
</center>

<form action="" method="post">
Шашлыков: <?=$user_data["coctel_bp"];?> шт.
<center>
<input name="sum2" type="text" value="10" style="width: 60px;" />
<input type="hidden" name="add2" value="3" />
<input type="submit" class="btn_9" value="Покушать" />
</form>
</center>

<form action="" method="post">
Колбасы: <?=$user_data["coctel_cp"];?> шт.
<center>
<input name="sum3" type="text" value="10" style="width: 60px;" />
<input type="hidden" name="add3" value="3" />
<input type="submit" class="btn_9" value="Покушать" />
</form>
</center>
</td></tr></table>
<br />

<table cellpadding='3' cellspacing='0' border='0' class="ta" align='center' width="96%">
  <tr>
    <td colspan="5" align="center"><font color="#6F462A" size="+1"><b><center>Купить продукцию</center></b></font></td>
    </tr>
   <tr bgcolor="#914A1F">
    <td align="center" ><font color="#FFF">Продавец</td>
	<td align="center" ><font color="#FFF">Продукция</font></td>
	<td align="center" ><font color="#FFF">Цена</font></td>
	<td align="center" ><font color="#FFF">Количество</font></td>
	<td align="center" ><font color="#FFF">Купить</font></td>
  </tr>
<?PHP
	$db->Query("SELECT * FROM db_power ORDER BY id ASC LIMIT 1");
		if($db->NumRows() > 0){
			while($bon = $db->FetchArray()){
?>
<tr class="htt">
<td align="center"><b><font color="#914A1F"><a href='/account/wall/<?=$bon["user"]; ?>' target='_blank'><?=$bon["user"]; ?></a></font></b></td>
<td align="center"> 
<?PHP		
if ($bon["coctel_a"]==1) { ?> 
<div class="cl-fr-lf">
<img style="border:3px solid #D7A984" src="/img/fruit/hleb.png" width="40" height="40"/>
</div>
<b>Хлеб</b>
<?PHP	}	if ($bon["coctel_b"]==1) { ?> 
<div class="cl-fr-lf">
<img style="border:3px solid #D7A984" src="/img/fruit/shashlik.png" width="40" height="40"/>
</div>
<b>Шашлык</b>
<?PHP	}	if ($bon["coctel_c"]==1) { ?> 
<div class="cl-fr-lf">
<img style="border:3px solid #D7A984"src="/img/fruit/kolbasa.png" width="40" height="40"/>
</div>
<b><BR />Колбаса</b>
<?PHP	} ?>  </td>
<td align="center"><b><?=$bon["amount"]; ?> сер.</b></td> 
<td align="center"><b><?=$bon["kolvo"]; ?></b></td> 

<td align="center">

<?php if ($trade["coctel_a"]==1) { ?>
<form action="" method="post">
<input type="hidden" name="buy" value="7" />
<input name="sum" size="6" type="text" value="10" style="width: 40px;"/>	
<input type="submit" class="btn_9" value="Купить" />
</form>
<?PHP	}	if ($trade["coctel_b"]==1) { ?>
<form action="" method="post">
<input type="hidden" name="buy" value="8" />
<input name="sum" size="6" type="text" value="10" style="width: 40px;"/>	
<input type="submit" class="btn_9" value="Купить" />
</form>
<?PHP	}	if ($trade["coctel_c"]==1) { ?>
<form action="" method="post">
<input type="hidden" name="buy" value="9" />
<input name="sum" size="6" type="text" value="10" style="width: 40px;"/>	
<input type="submit" class="btn_9" value="Купить" />
</form>
<?PHP } ?>
</td></tr>
<?PHP
}
}else echo '<center>__________________________</center>'
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
	<td align="center" ><font color="#FFF">Количество</font></td>
	<td align="center" ><font color="#FFF">Дата добавления</font></td>
  </tr>
  <?PHP

  $db->Query("SELECT * FROM db_power ORDER BY id ASC LIMIT 50");

	if($db->NumRows() > 0){

  		while($bon = $db->FetchArray()){

		?>
		<tr class="htt">
		<td align="center">#</td>
    	<td align="center"><a href='/account/wall/<?=$bon["user"]; ?>' target='_blank'><?=$bon["user"]; ?></a></td>
    	<td align="center"> 
<?PHP 		
if ($bon["coctel_a"]==1) { ?> Хлеб
<?PHP	}	if ($bon["coctel_b"]==1) { ?> Шашлык
<?PHP	}	if ($bon["coctel_c"]==1) { ?> Колбаса
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