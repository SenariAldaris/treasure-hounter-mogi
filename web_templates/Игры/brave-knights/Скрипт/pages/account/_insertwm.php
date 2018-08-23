<div class="block1
"><div class="h-title1
">Пополнение WebMoney</div></div>

<div class="block2">
<BR />
<center>
<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Пополнение баланса";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
?>
<span style="color: #914A1F; font-family: 'Comic Sans MS', cursive; font-size: 13pt;text-shadow: #000 0 1px 1px;"><strong><font color = "#000">АКЦИЯ:</font> При первом пополнении баланса +50% в подарок.</strong></span>
<br>
Баланс пополняется мгновенно,сразу после оплаты.
<br>
<h3><small><font color=orange> <img title='WebMoney' src='/img/webmoney1.gif'></font><br>
<br>
Введите сумму:</font>
<script type="text/javascript">
function doPost(){
    var fee=0;
    var amount=parseFloat(document.getElementById("userAmount").value);
    document.getElementById("totalAmount").value=amount+amount*fee/100;
    document.forms[0].submit();
}
</script>
<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
 <input type="text" id="userAmount" class="wmbtn" style="font-famaly:Verdana, Helvetica, sans-serif!important;padding:0 10px;height:30px;font-size:12px!important;border:1px solid #000000!important;background:#EBEBEB!important;color:#000!important;" value="">
 
 <input type="hidden" name="LMI_PAYMENT_AMOUNT" id="totalAmount" />
 <input type="hidden" name="LMI_PAYMENT_DESC" value="Пополнение баланса от <?=$usname; ?>">
 <input type="hidden" name="LMI_PAYEE_PURSE" value="R529613529993"> 
 <input type="hidden" name="us_id" value="<?=$usid;?>">
<p> 
 <input type="button" value="оплатить"class="btn_8" onclick="javascript: doPost();">
</p>
</form>
</form>
</small></td></h3></center></div>
<div class="block3"></div>
<div class="clr"></div>	

