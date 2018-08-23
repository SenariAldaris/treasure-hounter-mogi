<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Кредитный отдел";
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a WHERE id = '$usid'");
$user_a = $db->FetchArray();
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_b = $db->FetchArray();
$min_cr = 100; // Минимальная сумма кредита
$max_cr = 100000; // Максимальная сумма кредита
$percent = 0.2; // Процентная ставка на кредит 0.2 это 20%

?>
<div class="block1
"><div class="h-title1
">Кредитование</div></div>

<div class="block2">	
<?

if($user_b['credit'] > 0) {
echo '<center><font color="red"><b>У Вас уже имеется не погашеный кредит, погасите этот кредит и сможете взять другой<b></font></center>';
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_b = $db->FetchArray();
?>
<center><h3>Погасить кредит</h3></center><br>
<center>Сумма вашего кредита: <font color="red"><?=$user_b['credit']; ?> </font> серебра</center>
<br>
<center>До занесения в черный список осталось: <?
$tt = $user_b['date_add'] + (60*60*24*30);

$ttt = ($tt - time()) / 86400;
echo intval($ttt).' - Дней';
?><br></center><br>
<font color="red"><b>Для погашения кредита вам необходимо пополнить баланс на сумму равную кредиту, После пополнения, сумма автоматически спишется в счет погашения кредита, остальная часть отправится вам на баланс для покупок!<b></font>
<?
echo '</div>
<div class="block3"></div>
<div class="clr"></div>			
';
return;

}
if(isset($_POST['summa'])) {
$sum = intval($_POST['summa']);
$summ = $sum + ($sum * $percent);
$time = time();
$pen = time() + (60*60*24*30);
if($sum >= $min_cr) {
	if($sum <= $max_cr) {
		if($user_b['credit'] == 0) {
			$db->Query("UPDATE db_users_b SET money_b = money_b + '$sum', credit = credit + '$summ', credit_only = '$summ', date_add = '$time', date_peny = '$pen', credit_all = credit_all + '$summ' WHERE id = '$usid'");
			echo "<center><font color = '#914A1F'><b>Вы успешно получили кредит на сумму ".$sum."серебра, к возврату ".$summ." серебра</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>У вас уже имеется не погашенный кредит! Для начала погасите первый и затем возмите второй!</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>Сумма кредита должна быть не больше 100000 серебра</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>Сумма кредита должна быть не менее 100 серебра</b></font></center><BR />";
}
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_b = $db->FetchArray();
?>
<br>
<center><h3>Взять кредит</h3></center>
Вы можете взять кредит на срок 30 дней и на сумму от 100 до 100000 серебра, на счет для покупок!<br>Внимание!!! Деньги, взятые в кредит можно потратить на образование или открытие своего бизнеса!
Возвращать кредит можно только пополнением баланса. <br>
Процентная ставка 20%<br>
В случаее не возврата кредита в срок, Вы будете занесены в черный список.<br>
Ваш аккаунт будет автоматически заблокирован без возврата ваших личных средств!
<br>
<?PHP
$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
# Заглушка от халявщиков
if($user_data["insert_sum"] <= 25){

?>

<BR /><BR />
<center><font color="red"><b>Доступ к кредиту получают пользователи, которые суммарно пополнили счет более чем на 250 Руб.<b></font></center><BR />
<BR />
</div>

	

<div class="clr"></div>	<div class="block3"></div>

<?PHP

return;
}

?>

<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td><b>Сумма:</b></td>
    <td align="center"><input type="text" name="summa" /></td>
  </tr>


  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="Взять" class="btn_8"/></td>
  </tr>
</table>
</form>


</div>
<div class="block3"></div>
<div class="clr"></div>	