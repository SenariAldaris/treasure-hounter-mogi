<div class="block1
"><div class="h-title1
">Пополнение баланса</div></div>

<div class="block2">	

<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Пополнение баланса";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];


$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();


$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();


?>

<center>

<span style="color: #914A1F; font-family: 'Comic Sans MS', cursive; font-size: 13pt;text-shadow: #000 0 1px 1px;"><strong><font color = "#000">АКЦИЯ:</font> При первом пополнении баланса +50% в подарок.</strong></span>
<b>Пополнение через QIWI <font color ="red">(Минимум 30 рублей)</font></b><br>(деньги поступят на счет в течении 24 часов)<br><br>
<img src="/img/qiwi1.gif" style="width: 203px; height: 103;"> <br><br></center>

1. В разделе «Перевод», выбирите «QIWI Яйца», далее «Купить».
<br>
2. Отмечайте «Купить», укажите сумму и «Оплатить».
<br>
3. Полученный код ваучера и сумму пополнения укажите ниже.
<br>
<?php
if(isset($_POST["sum"])){
	$err = "";
	$err .= $_POST["sum"]==NULL?"Вы не ввели сумму пополнения<br />":"";
	$err .= $_POST["vaycher"]==NULL?"Вы не ввели ваучер (код Qiwi-яйца) <br />":"";
	$err .= (intval($_POST["sum"]))< 30?"Минимум для пополнения Qiwi-яйцом 30руб!<br />":"";
	
	if($err == NULL){

		$db->Query("INSERT INTO ".$pref."_qiwi_insert (user, user_id, vaycher, sum) VALUES ('$usname', '$usid', '".$_POST["vaycher"]."', '".$_POST['sum']."')");
		
		echo "<font color='#914A1F'><br><br><br>Пополнение прошло успешно! Ожидайте зачисление средств.</font>";
		$advok = true;
	}else{
		echo "<br /><b>Ошибка:</b><br />".$err;
	}
}		
	if(!$advok)
		echo"<form action='/account/wm_insert/' method='post' style='padding:5px; margin-top:10px;' >
				
			<p>Сумма пополнения в рублях: <input name='sum' type='text' class='input' value='".htmlspecialchars($_POST["sum"])."' maxlength='6' size='5'/></p>

			<p>Ваучер: <input name='vaycher' type='text' class='input' value='".htmlspecialchars($_POST["vaycher"])."' maxlength='30' size='40' /> <input name='kod0' type='submit' value='Заказать' class='btn_7' style='margin-top:4px;height: 30px;' /></p>
													
		</form>";
		?>

</div>
<div class="block3"></div>
<div class="clr"></div>		