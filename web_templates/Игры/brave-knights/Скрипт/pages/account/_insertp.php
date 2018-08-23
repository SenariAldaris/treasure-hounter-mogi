<div class="block1
"><div class="h-title1
">Пополнение баланса</div></div>

<div class="block2">
<BR />
<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Пополнение баланса";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
?>
<div style="margin-top: -5px;" class="bgmainb2">
<center>

<span style="color: #914A1F; font-family: 'Comic Sans MS', cursive; font-size: 13pt;text-shadow: #000 0 1px 1px;"><strong><font color = "#000">АКЦИЯ:</font> При первом пополнении баланса +50% в подарок.</strong></span>
<BR />
<br>
<font color=orange> <img title='Free Kassa' src='/img/Payeer1.gif'></font><br>
<br>
<center>Курс игровой валюты: 1 рубль (<?=$config->VAL; ?>) = <?=$sonfig_site["ser_per_wmr"]; ?> серебра.
<p>Ввод средств  с помощью различных платежных 
систем: Yandex Деньги, банковских карт, SMS, терминалов, денежных переводов и т.д.</p>
<p>Оплата и зачисление серебра на баланс производится в автоматическом режиме.</p> 
<p>Введите сумму в РУБЛЯХ, которую вы хотите пополнить на баланс. <BR />
После пополнения вам будет зачислено серебро.<br /></p></center>
<center><a href="https://payeer.com/?partner=1115613" target="_blank"><b><font color="#737373">Создание счета в </font><font color="blue">Payeer</b></font></a></center>


<BR />
<BR />
<?
/// db_payeer_insert
if(isset($_POST["sum"])){

$sum = round(floatval($_POST["sum"]),2);


# Заносим в БД
$db->Query("INSERT INTO ".$pref."_payeer_insert (user_id, user, sum, date_add) VALUES ('".$_SESSION["user_id"]."','".$_SESSION["user"]."','$sum','".time()."')");

$desc = base64_encode($_SERVER["HTTP_HOST"]." - USER ".$_SESSION["user"]);
$m_shop = $config->shopID;
$m_orderid = $db->LastInsert();
$m_amount = number_format($sum, 2, ".", "");
$m_curr = "RUB";
$m_desc = $desc;
$m_key = $config->secretW;

$arHash = array(
 $m_shop,
 $m_orderid,
 $m_amount,
 $m_curr,
 $m_desc,
 $m_key
);
$sign = strtoupper(hash('sha256', implode(":", $arHash)));

?>
<center>
<form method="GET" action="//payeer.com/api/merchant/m.php">
	<input type="hidden" name="m_shop" value="<?=$config->shopID; ?>">
	<input type="hidden" name="m_orderid" value="<?=$m_orderid; ?>">
	<input type="hidden" name="m_amount" value="<?=number_format($sum, 2, ".", "")?>">
	<input type="hidden" name="m_curr" value="RUB">
	<input type="hidden" name="m_desc" value="<?=$desc; ?>">
	<input type="hidden" name="m_sign" value="<?=$sign; ?>">
	<input type="submit" name="m_process" value="Оплатить и получить серебро" />
</form>
</center>
</div></div>
<div class="block3"></div>
<div class="clr"></div>	

<?PHP

return;
}
?>
<script type="text/javascript">
var min = 0.01;
var ser_pr = 100;
function calculate(st_q) {
    
	var sum_insert = parseFloat(st_q);
	$('#res_sum').html( (sum_insert * ser_pr).toFixed(0) );
	
	
}
	
</script>
<center>
<div id="error3"></div>
<form method="POST" action="">
    <input type="hidden" name="m" value="<?=$fk_merchant_id?>">
Введите сумму [<?=$config->VAL; ?>]:  
<input type="text" value="100" name="sum" size="7" id="psevdo" onchange="calculate(this.value)" onkeyup="calculate(this.value)" onfocusout="calculate(this.value)" onactivate="calculate(this.value)" ondeactivate="calculate(this.value)"> 

    Вы получите <span id="res_sum">100</span> Серебра
	<BR /><BR />
    <input type="submit" id="submit" value="Пополнить" class="btn_8"></center>
</form>
<script type="text/javascript">
calculate(100);
</script>
<center>
</div>

</center>


</div>
<div class="block3"></div>
<div class="clr"></div>	


