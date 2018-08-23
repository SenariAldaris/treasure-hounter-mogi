<?php
header("Content-Type: text/html; charset=UTF-8");
# Мобильная комерция x-bill.org ( API v.1.2 )

$mk_config = array();

$mk_config['usr'] = "о"; 	# Ваш логин на сайте x-bill.org
$mk_config['key'] = "3"; 	# Контрольная строка (указана в настройках проекта)
$mk_config['sid'] = "1"; 	# ID проекта

# Тут ничего менять не нужно!
$mk_config['api1'] = "http://api.x-bill.org/"; # Основной адрес.
$mk_config['api2'] = "http://api.x-bill.ru/"; # Дополнительный адрес на случай если первый не отвечает.

# Инициализации платежа
function mk_create_pay ($phone, $cost, $desc, $answer="", $arr=array()) {
	global $mk_config;
	$phone = preg_replace('/[^0-9]/', '', $phone);
	$cost = (float)str_replace(",", ".", $cost);
	$desc = $desc;
	$answer = $answer;
	$var = "";
	if (isset ($arr)) {
		$keys = array_keys ($arr);
		for($i=0; $i<count($keys); $i++){ $var .= "&{$keys[$i]}=".$arr[$keys[$i]]; }
	}
	$post = "phone={$phone}&cost={$cost}&desc={$desc}&answer={$answer}&sign=".mk_create_sign($phone)."&login={$mk_config['usr']}&sid={$mk_config['sid']}{$var}";

	$result = mk_send_data ($post, $mk_config['api1']."payment.php");
	if ($result == 'error') { $result = mk_send_data ($post, $mk_config['api2']."payment.php"); }
	if ($result == 'error') {
		return "0";
	}else{
		$result = mk_parse_result($result);
		return $result;
	}
}

# Узнаем статус платежа по ID
function mk_get_status($id) {
	global $mk_config;
	$post = "id={$id}&sign=".mk_create_sign()."&login={$mk_config['usr']}&sid={$mk_config['sid']}";
	$result = mk_send_data ($post, $mk_config['api1']."status.php");
	if ($result == 'error') { $result = mk_send_data ($post, $mk_config['api2']."status.php"); }
	if ($result == 'error') {
		return "0";
	}else{
		$result = mk_parse_result($result);
		return $result;
	}
}

# Запрашиваем баланс
function mk_get_balance($password = "", $sid = "", $dade_in = "", $date_to = "") {
	global $mk_config;
	$post = "login={$mk_config['usr']}&sid={$sid}&pass=".md5($password)."&date_in={$dade_in}&date_to={$date_to}";
	$result = mk_send_data ($post, $mk_config['api1']."balance.php");
	if ($result == 'error') { $result = mk_send_data ($post, $mk_config['api2']."balance.php"); }
	if ($result == 'error') {
		return "0";
	}else{
		$result = mk_parse_result($result);
		return $result;
	}
}

# Формируем подпись
function mk_create_sign ($phone=""){
	global $mk_config;
	return md5($mk_config['usr'].$mk_config['key'].$mk_config['sid'].$phone);
}

# Разбираем ответ от скрипта
function mk_parse_result ($result){
	$XML = trim($result);
	$returnVal = $XML;
	$emptyTag = '<(.*)/>';
	$fullTag = '<\\1></\\1>';
	$XML = preg_replace ("|$emptyTag|", $fullTag, $XML);
	$matches = array();
	if (preg_match_all('|<(.*)>(.*)</\\1>|Ums', trim($XML), $matches)) {
		if (count($matches[1]) > 0) $returnVal = array();
		foreach ($matches[1] as $index => $outerXML){
			$attribute = $outerXML;
			$value = mk_parse_result($matches[2][$index]);
			if (! isset($returnVal[$attribute])) $returnVal[$attribute] = array();
			$returnVal[$attribute][] = $value;
		}
	}
	if (is_array($returnVal)) foreach ($returnVal as $key => $value){ if (is_array($value) && count($value) == 1 && key($value) === 0){ $returnVal[$key] = $returnVal[$key][0]; } }
	return $returnVal;	
}

# Отпраляем POST запрос
function mk_send_data ($post, $url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	#curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); # Разрешить переадресацию
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 4); # Таймаут не менять! 
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	
	$result = curl_exec($ch);
	$status = curl_errno($ch);   
	curl_close($ch);   
	if ($status == 0 && !empty($result)) { return $result; }else{ return "error"; }
}
?>