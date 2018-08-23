<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Демострация работы XML-интерфейса "проверка кода"</title>
<style type="text/css">
html,body{margin:20px 0px 0px 20px;color:#495056;}
fieldset{padding:10px;width:800px;min-height:60px;height:auto;}
legend{color:#808080;}
span.success{color:#008000;}
span.warning{color:#ff0000;}
</style>
</head>
<body>

<?php
// если переменная uniquecode не передана
if(!isset($_GET["uniquecode"])) {
?>
<p>Переменная <strong>uniquecode</strong> не была задана!</p>
<?php }
else {
$_GET["uniquecode"] = substr(preg_replace("/[^A-Z0-9]/", "", $_GET["uniquecode"]), 0, 16);

// если переменная uniquecode пустая
if(empty($_GET["uniquecode"])) {
?>
<span class="warning">Ошибка: переменная <strong>uniquecode</strong> не должна быть пустой!</span>
<?php }<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
html,body{margin:20px 0px 0px 20px;color:#495056;}
fieldset{padding:10px;width:800px;min-height:60px;height:auto;}
legend{color:#808080;}
span.success{color:#008000;}
span.warning{color:#ff0000;}
</style>
</head>
<body>

<?php
// если переменная uniquecode не передана
if(!isset($_GET["uniquecode"])) {
	//<p>Переменная <strong>uniquecode</strong> не была задана!</p>
?>

<?php }
else {
$_GET["uniquecode"] = substr(preg_replace("/[^A-Z0-9]/", "", $_GET["uniquecode"]), 0, 16);

// если переменная uniquecode пустая
if(empty($_GET["uniquecode"])) {
	//<span class="warning">Ошибка: переменная <strong>uniquecode</strong> не должна быть пустой!</span>
?>

<?php }
// если количество символов меньше 16
elseif(strlen($_GET["uniquecode"]) != 16) {
	//<span class="warning">Ошибка: переменная <strong>uniquecode</strong> должно содержать 16 символов!</span>
?>

<?php  }
else {
require_once $_SERVER["DOCUMENT_ROOT"]."/t/main.php";

$obj = new check_code;
$sign = md5($id_seller.":".$_GET["uniquecode"].":".$pass_DS);
$answer = @$obj -> answer_check_code($id_seller, $_GET["uniquecode"], $sign);

$xml_data = @new SimpleXMLElement($answer);

if(!@$xml_data) {
$echosss =  "<span class=\"warning\">Не удается разобрать XML-ответ!</span>\r\n"; }
else {

// проверяем возвращаемый код(retval). В случае успеха выполняем необходимые действия
/* рекомедуется проверять все полученные параметры ответа, особое внимание стоит обратить на inv.
Настоятельно рекомендуем сохранять это значение в своей базе и каждый раз проверять его на уникальность, чтобы избежать повторного начисления */
if($xml_data -> retval == 0 && $xml_data -> unique_code == $_GET["uniquecode"]) {
$echosss =  "<br /><fieldset>
<legend>Детали платежа</legend>
<strong>уникальный номер оплаченного счета</strong>: ".$xml_data -> inv."<br />
<strong>дата и время платежа</strong>: ".$xml_data -> date_pay."<br />
<strong>идентификатор оплаченного товара</strong>: ".$xml_data -> id_goods."<br />
<strong>сумма, зачисленная на ваш счет</strong>: ".$xml_data -> amount."<br />
<strong>тип валюты, зачисленный на ваш счет</strong>: ".$xml_data -> type_curr."<br />\r\n";
if(!empty($xml_data -> unit_goods) && !empty($xml_data -> cnt_goods)) {
	$inv = $xml_data -> inv;
	$unit_goods = $xml_data -> unit_goods;
$date_pay = $xml_data -> date_pay;
$cnt_goods = $xml_data -> cnt_goods;
$id_goods = $xml_data -> id_goods;
	require_once $_SERVER["DOCUMENT_ROOT"]."/config.php";
$money_shop = mysql_query("SELECT * FROM `money_shop` WHERE `inv`='$inv'",$db);
$money_shop_count = mysql_num_rows($money_shop);
$money_shop_arr = mysql_fetch_assoc($money_shop);
$token = $_COOKIE['token']; 
$uid = $_COOKIE['uid'];
if($money_shop_count == "0"){

mysql_query("UPDATE `users_shop` set `money` = money + $cnt_goods where `token` = '$token'");
$result2 = mysql_query("INSERT INTO `money_shop` (`inv`, `uid`,`unit_goods`,`date_pay`,`cnt_goods`,`id_goods`) VALUES('$inv','$uid','$unit_goods','$date_pay','$cnt_goods','$id_goods')") or die(mysql_error());
} 
$echosss =  "<strong>единица оплачиваемого товара</strong>: ".$xml_data -> unit_goods."<br />
<strong>количество единиц оплачиваемого товара</strong>: ".$xml_data -> cnt_goods."\r\n"; }
$echosss =  "</fieldset>\r\n"; }
else {$echosss =  "<br /><span class=\"warning\">Платеж не найден!</span>\r\n"; } } } }
?>
 
</body>
</html>