<div class="block1
"><div class="h-title1
">Торговая лавка</div></div>
<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<table border="0">
<tbody>
<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/lavka.png" name="slide_show"></div>   
</td>
<td valign="top">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; На этом рынке можно приобрести готовое сырье для переработки, или продать свой товар. Минимум для покупки - 50 ед. товара, а продажи - 100 ед.товара.
Резерв лавки - 200000 ед товара на лот. <font color = 'red'><b>Внимание!!! Чтобы продать ресурсы требуется построить склад!!! </b></font>
При покупке/продаже снимается 1 ед.энергии и настроения.
Средства с продажи поступают на счёт для вывода. </span></h3>


</td>
</tr>
</tbody>
</table>
<hr>

<?PHP
$_OPTIMIZATION["title"] = "Лавка";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_trade WHERE id = '1' LIMIT 1");
$trade = $db->FetchArray();

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
# максимум лезет в склад
$maxab = 200000;
?>

<?php
if(isset($_POST["sell"])){
$sum = intval($_POST["sum"]);
$array_items2 = array(1 => "a_b", 2 => "b_b", 3 => "c_b", 4 => "d_b", 5 => "f_b", 6 => "l_b", 7 => "h_b", 8 => "i_b", 9 => "u_b", 10 => "v_b");
$array_name2 = array(1 => "Глина", 2 => "Злаки", 3 => "Бревна", 4 => "Руда", 5 => "Кирпичи", 6 => "Мука", 7 => "Доски", 8 => "Сталь", 9 => "Баранина", 10 => "Конина");
$item = intval($_POST["sell"]);
$citem = $array_items2[$item];
if(strlen($citem) >= 3){
$need = $user_data[$citem];

$need_en = 1;
if($need_en <= $user_data["en"]){

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){

$need_s = 1;
                if($need_s <= $user_data["k_t"]){

if($need >= $sum){
if($sum >= 100){
$sellb = $sum + $trade[$citem]; 
if($maxab > $sellb){	
$money = $sum * $sonfig_site["sell_".$citem];
# даём бабки и снимаем продукты
$db->Query("UPDATE db_users_b SET money_p = money_p + $money, en = en - $need_en, ns = ns - $need_ns, $citem = $citem - '$sum' WHERE id = '$usid'");
# обновляем лавку
$db->Query("UPDATE db_trade SET $citem = $citem + '$sum'");

$db->Query("INSERT INTO db_sell_trade (user_id, user, kolvo, amount, citem, date_add, date_del) VALUES ('$usid','$usname', '$sum','$money','".$array_name2[$item]."','".time()."','".(time()+60*60*24*30*6)."')");
  
	echo "<center><font color = '#964D1F'><b>Продажа прошла успешно.</b></font></center><BR />";
		header( 'Refresh: 1; url=/account/trade' );
	}else echo "<center><font color = 'red'><b>Резерв лавки переполнен. Попробуйте позже или продайте меньше товара.</b></font></center>";
	
	}else echo "<center><font color = 'red'><b>Кол-во продаваемого сырья не может быть меньше 100 ед.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>Недостаточно сырья для продажи.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>Вы не можете продать ресурсы. <BR />У вас еще нет склада.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>Недостаточно настроения.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>Недостаточно энергии.</b></font></center><BR />";
}
}
?>

<?php
if(isset($_POST["buy"])){
$sum = intval($_POST["sum"]);

$array_items2 = array(1 => "a_b", 2 => "b_b", 3 => "c_b", 4 => "d_b", 5 => "f_b", 6 => "l_b", 7 => "h_b", 8 => "i_b", 9 => "u_b", 10 => "v_b");
$array_name2 = array(1 => "Глина", 2 => "Злаки", 3 => "Бревна", 4 => "Руда", 5 => "Кирпичи", 6 => "Мука", 7 => "Доски", 8 => "Сталь", 9 => "Баранина", 10 => "Конина");
$pitem = intval($_POST["buy"]);
$pcitem = $array_items2[$pitem];

$array_items3 = array(1 => "a_b", 2 => "b_b", 3 => "c_b", 4 => "d_b", 5 => "f_b", 6 => "l_b", 7 => "h_b", 8 => "i_b", 9 => "u_b", 10 => "v_b");
$array_name3 = array(1 => "Глина", 2 => "Злаки", 3 => "Бревна", 4 => "Руда", 5 => "Кирпичи", 6 => "Мука", 7 => "Доски", 8 => "Сталь", 9 => "Баранина", 10 => "Конина");
$item = intval($_POST["buy"]);
$citem = $array_items3[$item];

if(strlen($pcitem) >= 3){
$need = $trade[$citem];

if($need >= $sum){
if($sum >= 50){	
		
		$need_en = 1;
if($need_en <= $user_data["en"]){
		

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){


                

$money = $sum * $sonfig_site["buy_".$pcitem];
if($money <= $user_data["money_b"]){	
# зачисляем продукцию и снимаем деньги
$db->Query("UPDATE db_users_b SET money_b = money_b - $money, en = en - $need_en, ns = ns - $need_ns,  $pcitem = $pcitem + '$sum' WHERE id = '$usid'");

$db->Query("INSERT INTO db_buy_trade (user_id, user, kolvo, amount, citem, date_add, date_del) VALUES ('$usid','$usname', '$sum', '$money','".$array_name3[$item]."','".time()."','".(time()+60*60*24*30*6)."')");

# обновляем лавку
$db->Query("UPDATE db_trade SET $citem = $citem - '$sum'");
  
	echo "<center><font color = '#964D1F'><b>Покупка прошла успешно.</b></font></center><BR />";
		header( 'Refresh: 1; url=/account/trade' );
	}else echo "<center><font color = 'red'><b>Недостаточно средств для покупки.</b></font></center><BR />";

		}else echo "<center><font color = 'red'><b>Недостаточно настроения.</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>Недостаточно энергии.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>Кол-во покупаемого сырья не может быть меньше 50.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>В лавке недостаточно сырья для покупки.</b></font></center><BR />";
}
}
?>

 <?PHP
  
  $db->Query("SELECT * FROM db_trade WHERE id = '1' LIMIT 1");
$trade = $db->FetchArray();
		
		?>


<table width = "100%" class="ta" align="center">
<tr><td align="center">

<form action="" method="post">
<select type="hidden" name="sell">
<option value="1"><b>Глина</b> (Цена: <?=$sonfig_site["sell_a_b"]; ?> зол/кг)</option>
<option value="2"><b>Злаки</b> (Цена: <?=$sonfig_site["sell_b_b"]; ?> зол/кг)</option>
<option value="3"><b>Бревна</b> (Цена: <?=$sonfig_site["sell_c_b"]; ?> зол/шт)</option>
<option value="4"><b>Руда</b> (Цена: <?=$sonfig_site["sell_d_b"]; ?> зол/кг)</option>
<option value="5"><b>Кирпичи</b> (Цена: <?=$sonfig_site["sell_f_b"]; ?> зол/шт)</option>
<option value="6"><b>Мука</b> (Цена: <?=$sonfig_site["sell_l_b"]; ?> зол/кг)</option>
<option value="7"><b>Доски</b> (Цена: <?=$sonfig_site["sell_h_b"]; ?> зол/шт)</option>
<option value="8"><b>Сталь</b> (Цена: <?=$sonfig_site["sell_i_b"]; ?> зол/шт)</option>
<option value="9"><b>Баранина</b> (Цена: <?=$sonfig_site["sell_u_b"]; ?> зол/кг)</option>
<option value="10"><b>Конина</b> (Цена: <?=$sonfig_site["sell_v_b"]; ?> зол/кг)</option>
</select>
<input name="sum" size="6" type="text" value="100" style="width: 40px; margin-right: 25px"/><br />
<center>
<input type="submit" class="btn_8" value="Продать" style="height: 30px; margin-top:15px;" /></form> 
</center>
</td>
<td align="center">


<form action="" method="post">
<select type="hidden" name="buy">
<option value="1"><b>Глина</b> (Цена: <?=$sonfig_site["buy_a_b"]; ?> сер/кг)</option>
<option value="2"><b>Злаки</b> (Цена: <?=$sonfig_site["buy_b_b"]; ?> сер/кг)</option>
<option value="3"><b>Бревна</b> (Цена: <?=$sonfig_site["buy_c_b"]; ?> сер/шт)</option>
<option value="4"><b>Руда</b> (Цена: <?=$sonfig_site["buy_d_b"]; ?> сер/кг)</option>
<option value="5"><b>Кирпичи</b> (Цена: <?=$sonfig_site["buy_f_b"]; ?> сер/шт)</option>
<option value="6"><b>Мука</b> (Цена: <?=$sonfig_site["buy_l_b"]; ?> сер/кг)</option>
<option value="7"><b>Доски</b> (Цена: <?=$sonfig_site["buy_h_b"]; ?> сер/шт)</option>
<option value="8"><b>Сталь</b> (Цена: <?=$sonfig_site["buy_i_b"]; ?> сер/шт)</option>
<option value="9"><b>Баранина</b> (Цена: <?=$sonfig_site["buy_u_b"]; ?> сер/кг)</option>
<option value="10"><b>Конина</b> (Цена: <?=$sonfig_site["buy_v_b"]; ?> сер/кг)</option>
</select>
<input name="sum" size="6" type="text" value="50" style="width: 40px;"/>	<br />
<center>
<input type="submit" class="btn_8" value="Купить" style="height: 30px;  margin-top:15px;" /></form>
</center>
</td>
</tr>
</table>




<table class="ta" width = "100%" align="center">
<tr>
<td align="center"><b><font color="#964D1F" size="+1">На складе</font></td>
<td align="center"><b><font color="#964D1F" size="+1">В лавке</font></td>
</tr>
<tr>
<td align="center">
Глины: <?=$user_data["a_b"];?> кг.
</td>
<td align="center">
Глины: <?=$trade["a_b"];?> кг. 
</td>
</tr>
<tr>
<td align="center">
Злаков: <?=$user_data["b_b"];?> кг.
</td>
<td align="center">
Злаков: <?=$trade["b_b"];?> кг. 
</td>
</tr>
<tr>
<td align="center">
Бревен: <?=$user_data["c_b"];?> шт.
</td>
<td align="center">
Бревен: <?=$trade["c_b"];?> шт.
<tr>
<td align="center">
Руды: <?=$user_data["d_b"];?> кг.
</td>
<td align="center">
Руды: <?=$trade["d_b"];?> кг. 
</td>
</tr>
<tr>
<td align="center">
Кирпичей: <?=$user_data["f_b"];?> шт.
</td>
<td align="center">
Кирпичей: <?=$trade["f_b"];?> шт. 
</td>
</tr>
<tr>
<td align="center">
Муки: <?=$user_data["l_b"];?> кг.
</td>
<td align="center">
Муки: <?=$trade["l_b"];?> кг.
</td>
</tr>
<tr>
<td align="center">
Досок: <?=$user_data["h_b"];?> шт.
</td>
<td align="center">
Досок: <?=$trade["h_b"];?> шт.
</td>
</tr>
<tr>
<td align="center">
Стали: <?=$user_data["i_b"];?> шт.
</td>
<td align="center">
Стали: <?=$trade["i_b"];?> шт.
</td>
</tr>
<tr>
<td align="center">
Баранины: <?=$user_data["u_b"];?> кг.
</td>
<td align="center">
Баранины: <?=$trade["u_b"];?> кг.
</td>
</tr>
<tr>
<td align="center">
Конины: <?=$user_data["v_b"];?> кг.
</td>
<td align="center">
Конины: <?=$trade["v_b"];?> кг.
</td>
</tr>
</table>
<br />

</div>
</div>


<div class="clr"></div>	</div> <div class="block3"></div>