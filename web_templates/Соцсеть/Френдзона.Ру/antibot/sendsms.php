<?php
/*=========================================================
	Appointment: Отправка сообщения пользователю на телефон
	File: sendsms.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================================*/

@session_start();
@ob_start();
@ob_implicit_flush(0);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

define('MOZG', true);
define('ROOT_DIR', substr(dirname(__FILE__), 0, -7));
define('ENGINE_DIR', ROOT_DIR.'/system');

@include ENGINE_DIR.'/data/config.php';


include ENGINE_DIR.'/classes/mysql.php';
include ENGINE_DIR.'/data/db.php';

//* Если есть данные сесcии *//

if(isset($_SESSION['user_id']) > 0){
	$logged = true;
	$logged_user_id = intval($_SESSION['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_active FROM `".PREFIX."_users` WHERE user_id = '".$logged_user_id."'");

//* Если есть данные о COOKIE то проверяем *//

} elseif(isset($_COOKIE['user_id']) > 0 AND $_COOKIE['password'] AND $_COOKIE['hid']){
	$cookie_user_id = intval($_COOKIE['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_active FROM `".PREFIX."_users` WHERE user_id = '".$cookie_user_id."'");
	
//* Если пароль и HID совпадает то пропускаем *//

	if($user_info['user_password'] == $_COOKIE['password'] AND $user_info['user_hid'] == $_COOKIE['password'].md5(md5($_IP))){
		$_SESSION['user_id'] = $user_info['user_id'];
		
//* Вставляем лог в базу данных *//

		$db->query("UPDATE `".PREFIX."_log` SET browser = '".$_BROWSER."', ip = '".$_IP."' WHERE uid = '".$user_info['user_id']."'");
		
//* Удаляем все ранние события *//

		$db->query("DELETE FROM `".PREFIX."_updates` WHERE for_user_id = '{$user_info['user_id']}'");
				
		$logged = true;
	} else {
		$user_info = array();
		$logged = false;
	}
		
} else {
	$user_info = array();
	$logged = false;
}

$number = $db->safesql(strip_tags($_POST['number']));
$number = preg_replace("/[^0-9\s]/", "", $number);
$number = '+'.$number;
$str = strlen($number);

function mozg_cache($prefix) {
	$filename = ENGINE_DIR.'/cache/'.$prefix.'.tmp';
	return @file_get_contents($filename);
}
function mozg_create_cache($prefix, $cache_text) {
	$filename = ENGINE_DIR.'/cache/'.$prefix.'.tmp';
	$fp = fopen($filename, 'wb+');
	fwrite($fp, $cache_text);
	fclose($fp);
	@chmod($filename, 0666);
}

//* Если вызвана страница проверки кода *//

if($_GET['act'] == 'check' AND $logged AND $user_info['user_active'] AND $config['active_mobile'] == 'yes'){
	
	$code = intval($_POST['code']);
	
	$row = $db->super_query("SELECT number FROM `".PREFIX."_codes` WHERE code = '{$code}' AND user_id = '{$user_info['user_id']}'");

	if($row['number']){
		
		$db->query("DELETE FROM `".PREFIX."_codes` WHERE user_id = '{$user_info['user_id']}'");
		
		$db->query("UPDATE `".PREFIX."_users` SET user_active = '0', user_rphone = '{$row['number']}' WHERE user_id = '{$user_info['user_id']}'");
		
//* Если юзер регался по реф ссылки, то начисляем рефералу 10 убм *//

		if($_COOKIE['ref_id']){
		
//* Проверям на накрутку убм, что юзер не сам регистрирует анкеты *//

			$check_ref = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_log` WHERE ip = '{$_IP}'");
			if(!$check_ref['cnt']){
				$ref_id = intval($_COOKIE['ref_id']);
								
//* Даём рефералу +10 убм *//

				$config['mix_ref'] = intval($config['mix_ref']);
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance+'{$config['mix_ref']}', user_rating = user_rating + '{$config['ref_rate']}' WHERE user_id = '{$ref_id}'");
								
//* Вставляем рефералу ID регистратора *//

				$db->query("INSERT INTO `".PREFIX."_invites` SET uid = '{$ref_id}', ruid = '{$user_info['user_id']}'");
			}
		}

		echo '/u'.$user_info['user_id'];
		
	} else
		echo 0;
	
	exit();
	
}

if($logged AND $user_info['user_active'] AND $str > 10 AND $config['active_mobile'] == 'yes'){

	$code = rand(0, 32313441);
	$sql_code = substr($code, 0, 7);
	
	$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_rphone = '{$number}'");
	
	if(!$row['cnt']){
		
		define('SMSPILOT_APIKEY', '1086RU75V0FN7L3E1NNP61UG60B5P024LLD1KG9785L7C9AT4KGL88GMLZDXLPJY');
		include ROOT_DIR.'/antibot/smspilot.php';
		
		$textsms = 'Код подтверждения: '.$sql_code;
		
		$cache_c = mozg_cache("user_{$user_info['user_id']}/mob");
		
		if($cache_c <= 1){
			
			if(sms($number, $textsms)){

				mozg_create_cache("user_{$user_info['user_id']}/mob", ($cache_c+1));
			
				$db->query("INSERT INTO `".PREFIX."_codes` SET code = '{$sql_code}', number = '{$number}', user_id = '{$user_info['user_id']}'");
			
				echo 1;
			
			} else
				echo 0;
			
		} else
			echo 5;
		
	} else
		echo 2;

} else
	echo 0;

?>