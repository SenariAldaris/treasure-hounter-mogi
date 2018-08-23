<?php


if(!defined('MOZG'))
	die('Hacking attempt!');

//* Проверяем была ли нажата кнопка, если нет, то делаем редирект на главную *//

if(!$logged){
	NoAjaxQuery();
	
//* Код безопасности *//
	
	$session_sec_code = $_SESSION['sec_code'];
	$sec_code = $_POST['sec_code'];
	
//* Проверка hash *//

			$hash = $db->safesql(strip_data($_POST['hash']));
			
			$row = $db->super_query("SELECT email FROM `".PREFIX."_restore` WHERE hash = '{$hash}' AND ip = '{$_IP}'");
			
//* Если код введенный юзером совпадает, то пропускаем, иначе выводим ошибку *//
	
	
	if($sec_code == $session_sec_code){
	
//* Входные POST данные *//
		
		$user_name = ajax_utf8(textFilter($_POST['name'], false, true));
		$user_lastname = ajax_utf8(textFilter($_POST['lastname'], false, true));
		$user_email = ajax_utf8(textFilter($_POST['email'], false, true));
		
		$user_name = ucfirst($user_name);
		$user_lastname = ucfirst($user_lastname);
		
		$user_sex = intval($_POST['sex']);
		if($user_sex < 0 OR $user_sex > 2) $user_sex = 0;
		
		$user_day = intval($_POST['day']);
		if($user_day < 0 OR $user_day > 31) $user_day = 0;
		
		$user_month = intval($_POST['month']);
		if($user_month < 0 OR $user_month > 12) $user_month = 0;
		
		$user_year = intval($_POST['year']);
		if($user_year < 1930 OR $user_year > 2007) $user_year = 0;
		
		$user_country = intval($_POST['country']);
		if($user_country < 0 OR $user_country > 10) $user_country = 0;
		
		$user_city = intval($_POST['city']);
		if($user_city < 0 OR $user_city > 1587) $user_city = 0;
		
		$_POST['password_first'] = ajax_utf8($_POST['password_first']);
		$_POST['password_second'] = ajax_utf8($_POST['password_second']);
		
		$password_first = GetVar($_POST['password_first']);
		$password_second = GetVar($_POST['password_second']);
		$user_birthday = $user_year.'-'.$user_month.'-'.$user_day;

		$errors = array();
		
//* Проверка имени *//
		
		if(preg_match("/^[a-zA-Zа-яА-Я]+$/iu", $user_name) AND strlen($user_name) >= 2) $errors[] = 0;
		
//* Проверка фамилии *//
		
		if(preg_match("/^[a-zA-Zа-яА-Я]+$/iu", $user_lastname) AND strlen($user_lastname) >= 2) $errors[] = 0;

//* Проверка E-mail *//
		
		if(preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $user_email)) $errors[] = 0;

//* Проверка паролей *//
		
		if(strlen($password_first) >= 6 AND $password_first == $password_second) $errors[] = 0;

		$allEr = count($errors);

//* Если нет ошибок то пропускаем и добавляем в базу *//
		
		if($allEr == 4){
			$check_email = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_email = '{$user_email}'");
			if(!$check_email['cnt']){
					$hid = $md5_pass.md5(md5($_IP));
					$md5_pass = md5(md5($password_first));
					$user_group = '5';
					$user_search_pref = $user_name.' '.$user_lastname;
				
				if($user_country > 0 or $user_city > 0){
					$country_info = $db->super_query("SELECT name FROM `".PREFIX."_country` WHERE id = '".$user_country."'");
					$city_info = $db->super_query("SELECT name FROM `".PREFIX."_city` WHERE id = '".$user_city."'");
					
					$user_country_city_name = $country_info['name'].'|'.$city_info['name'];
				}
				
				$user_search_pref = $user_name.' '.$user_lastname;
				

					$row['email'] = $db->safesql($row['email']);
					
					if($config['user_design'] == 2) $user_design = 'pos|2||';
					
				$db->query("INSERT INTO `".PREFIX."_users` SET user_email = '{$user_email}', user_password = '{$md5_pass}', user_sex = '{$user_sex}', user_day = '{$user_day}', user_month = '{$user_month}' ,user_year = '{$user_year}', user_country = '{$user_country}', user_city = '{$user_city}', user_name = '{$user_name}', user_lastname = '{$user_lastname}', user_reg_date = '{$server_time}', user_lastdate = '{$server_time}', user_group = '{$user_group}', user_search_pref = '{$user_search_pref}', user_privacy = 'val_msg|1||val_wall1|1||val_wall2|1||val_wall3|1||val_guests1|1||val_info|1||', user_active = '1', user_design = '{$user_design}', new_reg = '1'");
				$id = $db->insert_id();
				//Создание альбома
				//$aname = 'Фотографии с моей страницы';
				//$adescr = '';
				//$alhash = md5(md5($server_time).$aname.$adescr.md5($id).md5($user_email).$_IP);
				//$date_create = date('Y-m-d H:i:s', $server_time);
				//$db->query("INSERT INTO `".PREFIX."_albums` (user_id, name, descr, ahash, adate, position, privacy, editablea) VALUES ('{$id}', 'Фотографии с моей страницы', '', '{$alhash}', '{$date_create}', '0', '1|1', '0')");
				//$db->query("UPDATE `".PREFIX."_users` SET user_albums_num = user_albums_num+1 WHERE user_id = '{$id}'");
				

//* Устанавливаем в сессию ID юзера *//
				
				$_SESSION['user_id'] = intval($id);
				
//* Если юзер добавился в базу, то входим на сайт *//

					if($id){
					
//* Записываем COOKIE *//
						
						set_cookie("user_id", $id, 365);
						set_cookie("password", md5(md5($password_first)), 365);
						set_cookie("hid", $hid, 365);
				
//* Создаём папку юзера в кеше *//
				
				mozg_create_folder_cache("user_{$id}");
				
//* Директория юзеров *//
				
				$uploaddir = ROOT_DIR.'/uploads/users/';
	
				@mkdir($uploaddir.$id, 0777);
				@chmod($uploaddir.$id, 0777);
				@mkdir($uploaddir.$id.'/albums', 0777);
				@chmod($uploaddir.$id.'/albums', 0777);

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
								
								$db->query("INSERT INTO `".PREFIX."_invites` SET uid = '{$ref_id}', ruid = '{$id}'");
							}
						}
				
//* Вставляем лог в базу данных *//
						
						$db->query("INSERT INTO `".PREFIX."_log` SET uid = '{$id}', browser = '{$_BROWSER}', ip = '{$_IP}'");
				
//* Удаляем ссылку регистрации на этот e-mail *//
						
						$db->query("DELETE FROM `".PREFIX."_restore` WHERE email = '{$row['email']}'");

						$db->query("INSERT INTO `".PREFIX."_users_param` SET user_id = '{$id}'");
						
					}

				echo 'ok|'.$id;
			} else
				echo 'err_mail|';
		} else
			echo 'no_val';
	}
	die();
}
?>