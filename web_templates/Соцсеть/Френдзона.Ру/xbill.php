<?php
header('Content-Type: text/html; charset=UTF-8');
if (
    isset ($_GET['order']) && 
    isset ($_GET['phone']) && 
    isset ($_GET['order_status']) && 
    isset ($_GET['merchant_price']) && 
    isset ($_GET['paytouser']) && 
    isset ($_GET['time']) && 
    isset ($_GET['sign'])
    ) {
    $secret_key = "";
     
    $order_id = $_GET['order_id'];
    $order = $_GET['order'];
    $phone = $_GET['phone'];
    $order_status = $_GET['order_status'];
    $merchant_price = $_GET['merchant_price'];
    $paytouser = $_GET['paytouser'];
    $time = date("d.m.Y H:i:s", $_GET['time']);
    $sign = $_GET['sign'];
     
    $truesign = md5($order.$phone.$merchant_price.$secret_key);
    if ($sign == $truesign) {
        if ($order_status == 'success') {
			$lnk = mysql_connect("127.0.0.1","пользователь","пароль"); // Указать логин и пароль к БД
			mysql_select_db("база", $lnk); // BDTABLE - указать название таблицы
			mysql_query("SET NAMES utf8");
			
			$user_id = $_GET['user_id'];
			# Узнаем баланс пользователя:
			$sql = "SELECT `balance_rub` FROM `vii_users` WHERE `user_id` = '{$user_id}' LIMIT 0,1";
			$res = mysql_query($sql);
			$temp = array();
			while ($row=mysql_fetch_array($res)) { 	array_push($temp, $row); }
			# Если пользователь не найден то останавливаем скрипт
			if (!isset ($temp[0]['balance_rub'])) { echo "error: Пользователь не найден"; die; }
			# Новый баланс пользователя:
			$newbalance = round($merchant_price + $temp[0]['balance_rub']);
			# Записываем новый баланс:
			$sql = "UPDATE `vii_users` SET `balance_rub` = '{$newbalance}' WHERE `user_id` = '{$user_id}'";
			$res = mysql_query($sql);
			# mysql нам больше не нужна закрываем соединение
			mysql_close($lnk);
			echo "ok";
		}
    }else{
        echo "error(sign)";
        die;
    }
}else{
    echo "error(count(".count($_GET)."))";
    die;
}
?>