<?php
/*========================================= 
	Appointment: Авторизация пользователей
	File: login.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
=========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');
	
$_IP = $db->safesql($_SERVER['REMOTE_ADDR']);
$_BROWSER = $db->safesql($_SERVER['HTTP_USER_AGENT']);

$check_refere = clean_url($_SERVER['HTTP_REFERER']);
$new_conurl = clean_url($config['home_url']);

//* Если делаем выход *//

if(isset($_GET['act']) AND $_GET['act'] == 'logout'){
	set_cookie("user_id", "", 0);
	set_cookie("password", "", 0);
	set_cookie("hid", "", 0);
	unset($_SESSION['user_id']);
	@session_destroy();
	@session_unset();
	$logged = false;
	$user_info = array();
	header('Location: /');
	die();
}

//* Если есть данные сесcии *//

if(isset($_SESSION['user_id']) > 0){
	$logged = true;
	$logged_user_id = intval($_SESSION['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_email, user_group, user_friends_demands, user_pm_num, user_support, user_lastupdate, user_photo, user_msg_type, user_delet, user_ban_date, user_new_mark_photos, user_search_pref, user_status, user_active, user_design, new_reg, mydesign, user_balance, balance_rub, banner_cat, invties_pub_num, short_link, user_vip FROM `".PREFIX."_users` WHERE user_id = '".$logged_user_id."'");

//* Если есть данные о сесcии, но нет инфы о юзере, то выкидываем его *//
	
	if(!$user_info['user_id'])
		header('Location: /index.php?act=logout');

//* Если юзер нажимает "Главная" и он зашел не с моб. версии то скидываем на его стр *//
	
	$host_site = $_SERVER['QUERY_STRING'];
	if($logged AND !$host_site AND $config['temp'] != 'mobile') {
		if ($user_info['short_link'] != null && $user_info['short_link'] != 'empty') {
			$link = '/' . $user_info['short_link'];
		} else {
			$link = '/u' . $user_info['user_id'];
		}
		header('Location: '.$link);
	}

//* Если есть данные о COOKIE то проверяем *//

} elseif(isset($_COOKIE['user_id']) > 0 AND $_COOKIE['password'] AND $_COOKIE['hid']){
	$cookie_user_id = intval($_COOKIE['user_id']);
	$user_info = $db->super_query("SELECT user_id, user_email, user_group, user_password, user_hid, user_friends_demands, user_pm_num, user_support, user_lastupdate, user_photo, user_msg_type, user_delet, user_ban_date, user_new_mark_photos, user_search_pref, user_status, user_active, user_design, new_reg, mydesign, user_balance, balance_rub, banner_cat, invties_pub_num FROM `".PREFIX."_users` WHERE user_id = '".$cookie_user_id."'");
	
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
	
//* Если юзер нажимает "Главная" и он зашел не с моб. версии то скидываем на его стр *//
	
	$host_site = $_SERVER['QUERY_STRING'];
	if($logged AND !$host_site AND $config['temp'] != 'mobile') {
		if ($user_info['short_link'] != null && $user_info['short_link'] != 'empty') {
			$link = '/' . $user_info['short_link'];
		} else {
			$link = '/u' . $user_info['user_id'];
		}
		header('Location: '.$link);
	}
	
} else {
	$user_info = array();
	$logged = false;
}

//* Если данные поступили через пост и пользователь не авторизован *//

if(isset($_POST['log_in']) AND !$logged AND $check_refere == $new_conurl){

//* Приготавливаем данные *//
	
	$email = textFilter(strip_tags($_POST['email']));

	$password = md5(md5(GetVar($_POST['password'])));
	
//* Проверяем правильность e-mail *//
	
	if(!preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $email)){
		msgbox('', $lang['not_loggin'].'<br /><a href="/restore">Забыли пароль?</a>', 'info_red');
	} else {
	
//* Считаем кол-во символов в пароле и e-mail *//
		
		if(isset($email) AND !empty($email)){
			$check_user = $db->super_query("SELECT user_id FROM `".PREFIX."_users` WHERE user_email = '".$email."' AND user_password = '".$password."'");
				
//* Если есть юзер то пропускаем *//
			
			if($check_user){
			
//* Hash ID *//
				
				$hid = $password.md5(md5($_IP));
					
//* Обновляем хэш входа *//
				
				$db->query("UPDATE `".PREFIX."_users` SET user_hid = '".$hid."' WHERE user_id = '".$check_user['user_id']."'");
					
//* Удаляем все ранние события *//
				
				$db->query("DELETE FROM `".PREFIX."_updates` WHERE for_user_id = '{$check_user['user_id']}'");
	
//* Устанавливаем в сессию ID юзера *//
				
				$_SESSION['user_id'] = intval($check_user['user_id']);
					
//* Записываем COOKIE *//
				
				set_cookie("user_id", intval($check_user['user_id']), 365);
				set_cookie("password", $password, 365);
				set_cookie("hid", $hid, 365);

//* Вставляем лог в базу данных *//
				
				$db->query("UPDATE `".PREFIX."_log` SET browser = '".$_BROWSER."', ip = '".$_IP."' WHERE uid = '".$check_user['user_id']."'");

//* START / Записываем в историю *//
				
				$db->query("INSERT INTO `".PREFIX."_users_logs` SET user_id = '{$check_user['user_id']}', browser = '{$_BROWSER}', ip = '{$_IP}', act = '1', date = '{$server_time}'");
				
				$db->query("UPDATE `".PREFIX."_users` SET logs_num = logs_num + 1 WHERE user_id = '{$check_user['user_id']}'");
				
//* END / Записываем в историю *//
				
				if($config['temp'] != 'mobile')
					header('Location: /news');
				else
					header('Location: /');
			} else
				msgbox('', $lang['not_loggin'].'<br /><br /><a href="/restore">Забыли пароль?</a>', 'info_red');
		} else
			msgbox('', $lang['not_loggin'].'<br /><br /><a href="/restore">Забыли пароль?</a>', 'info_red');
	}
}

if ($logged) {
	$friends = mozg_cache('user_' . $user_info['user_id'] . '/friends');
	if ($friends == null) {
		$friends = $db->super_query("SELECT friend_id FROM `".PREFIX."_friends` WHERE user_id = {$user_info['user_id']} AND subscriptions = 0", 1);
		foreach ($friends as $item) {
			$friends_s .= 'u' . $item['friend_id'] . '|';
		}
		mozg_create_cache('user_' . $user_info['user_id'] . '/friends', $friends_s);
	}
}

?>
