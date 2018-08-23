<?php
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$user_id = $user_info['user_id'];
	$act = $_GET['act'];
	$metatags['title'] = $lang['settings'];

	switch($act){

//* Георгиевская лента *//
		
		case "georg_lent":
			NoAjaxQuery();
			$gl_status = $db->super_query("SELECT `georg_lent` FROM `".PREFIX."_users` WHERE `user_id` = {$user_id}");
			if ($gl_status['georg_lent']) {
				$db->query("UPDATE `".PREFIX."_users` SET `georg_lent` = 0 WHERE `user_id` = {$user_id}");
				die('Надеть Георгиевскую Ленту');
			} else {
				$db->query("UPDATE `".PREFIX."_users` SET `georg_lent` = 1 WHERE `user_id` = {$user_id}");
				die('Снять Георгиевскую Ленту');
			}
			break;

//* Изменение короткой ссылки *//
		
		case "short_link":
			NoAjaxQuery();
			$reserved = array('empty', 'exists', 'exists_by_yourself', 'uncorrect_link', 'system', 'templates', 'uploads', 'min', 'lang', 'backup', 'antibot', 'editmypage', 'friends', 'fave', 'notes', 'videos', 'news', 'messages', 'settings', 'support', 'restore', 'blog', 'blog', 'balance', 'loto', 'groups', 'audio', 'docs', 'mysocial', 'apps', 'mybanners');

			$short_link = $db->safesql(strtolower(ajax_utf8(textFilter($_POST['short_link']))));
			if (in_array($short_link, $reserved) || !preg_match('/^[a-zA-Z0-9_]+$/i', $short_link)) {
				die('uncorrect_link');
			}

			if ($short_link == '#delete#') {
				$db->query("UPDATE `" . PREFIX . "_users` SET `short_link` = 'empty' WHERE `user_id` = " . $user_id);
				die('/u' . $user_id);
			}

			$check_sl = $db->super_query("SELECT COUNT(*) as `slc`, `user_id` FROM `" . PREFIX . "_users` WHERE `short_link` = '{$short_link}'");
			$check_sl1 = $db->super_query("SELECT COUNT(*) as `slc` FROM `" . PREFIX . "_communities` WHERE `adres` = '{$short_link}'");
			if (!$check_sl['slc'] && !$check_sl1['slc']) {
				$db->query("UPDATE `" . PREFIX . "_users` SET `short_link` = LOWER('{$short_link}') WHERE `user_id` = " . $user_id);
				die('/' . $short_link);
			} else if ($check_sl['user_id'] == $user_id) {
				die('exists_by_yourself');
			} else {
				die('exists');
			}

			break;
		
//* Изменение пароля *//
		
		case "newpass":
			NoAjaxQuery();
			
			$_POST['old_pass'] = ajax_utf8($_POST['old_pass']);
			$_POST['new_pass'] = ajax_utf8($_POST['new_pass']);
			$_POST['new_pass2'] = ajax_utf8($_POST['new_pass2']);
			
			$old_pass = md5(md5(GetVar($_POST['old_pass'])));
			$new_pass = md5(md5(GetVar($_POST['new_pass'])));
			$new_pass2 = md5(md5(GetVar($_POST['new_pass2'])));
			
//* Выводим текущий пароль *//
			
			$row = $db->super_query("SELECT user_password FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($row['user_password'] == $old_pass){
				if($new_pass == $new_pass2)
					$db->query("UPDATE `".PREFIX."_users` SET user_password = '{$new_pass2}' WHERE user_id = '{$user_id}'");
				else
					echo '2';
			} else
				echo '1';
			
			die();
		break;
		
//* Изменение имени *//
		
		case "newname":
			NoAjaxQuery();
			$user_name = ajax_utf8(textFilter($_POST['name']));
			$user_lastname = ajax_utf8(textFilter(ucfirst($_POST['lastname'])));

//* Проверка имени *//
			
			if(isset($user_name)){
				if(strlen($user_name) >= 2){
					if(!preg_match("/^[a-zA-Zа-яА-Я]+$/iu", $user_name))
						$errors = 3;
				} else
					$errors = 2;
			} else
				$errors = 1;
				
//* Проверка фамилии *//
			
			if(isset($user_lastname)){
				if(strlen($user_lastname) >= 2){
					if(!preg_match("/^[a-zA-Zа-яА-Я]+$/iu", $user_lastname))
						$errors_lastname = 3;
				} else
					$errors_lastname = 2;
			} else
				$errors_lastname = 1;
			
			$row2 = $db->super_query("SELECT verification FROM `".PREFIX."_users_param` WHERE user_id = '{$user_id}'");
			
			if(!$errors AND !$row2['verification']){
				if(!$errors_lastname){
					$user_name = ucfirst($user_name);
					$user_lastname = ucfirst($user_lastname);
					
					$db->query("UPDATE `".PREFIX."_users` SET user_name = '{$user_name}', user_lastname = '{$user_lastname}', user_search_pref = '{$user_name} {$user_lastname}' WHERE user_id = '{$user_id}'");
					
					mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					mozg_clear_cache();
				} else
					echo $errors;
			} else
				echo $errors;
			
			die();
		break;
		
//* Сохранение настроек приватности *// 
				
		case "saveprivacy":
			NoAjaxQuery();
			
			$val_msg = intval($_POST['val_msg']);
			$val_wall1 = intval($_POST['val_wall1']);
			$val_wall2 = intval($_POST['val_wall2']);
			$val_wall3 = intval($_POST['val_wall3']);
			$val_info = intval($_POST['val_info']);
			$val_guests1 = intval($_POST['val_guests1']);
                        $val_guests2 = intval($_POST['val_guests2']);

			if($val_msg <= 0 OR $val_msg > 3) $val_msg = 1;
			if($val_wall1 <= 0 OR $val_wall1 > 3) $val_wall1 = 1;
			if($val_wall2 <= 0 OR $val_wall2 > 3) $val_wall2 = 1;
			if($val_wall3 <= 0 OR $val_wall3 > 3) $val_wall3 = 1;
			if($val_info <= 0 OR $val_info > 3) $val_info = 1;
			if($val_guests1 <= 0 OR $val_guests1 > 3) $val_guests1 = 1;
                        if($val_guests2 <= 0 OR $val_guests2 > 3) $val_guests2 = 1;

			$user_privacy = "val_msg|{$val_msg}||val_wall1|{$val_wall1}||val_wall2|{$val_wall2}||val_wall3|{$val_wall3}||val_info|{$val_info}||val_guests1|{$val_guests1}||val_guests2|{$val_guests2}||";
			
			$db->query("UPDATE `".PREFIX."_users` SET user_privacy = '{$user_privacy}' WHERE user_id = '{$user_id}'");
			
			mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
			
			die();
		break;
		
//* Приватность настройки *// 
			
		case "privacy":
		    $user_speedbar = $lang['set1'].' &raquo; '.$lang['set2'];
			$sql_ = $db->super_query("SELECT user_privacy FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$row = xfieldsdataload($sql_['user_privacy']);
			$tpl->load_template('settings/privacy.tpl');
			$tpl->set('{val_msg}', $row['val_msg']);
			$tpl->set('{val_msg_text}', strtr($row['val_msg'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Никто')));
			$tpl->set('{val_wall1}', $row['val_wall1']);
			$tpl->set('{val_wall1_text}', strtr($row['val_wall1'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_wall2}', $row['val_wall2']);
			$tpl->set('{val_wall2_text}', strtr($row['val_wall2'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_wall3}', $row['val_wall3']);
			$tpl->set('{val_wall3_text}', strtr($row['val_wall3'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
			$tpl->set('{val_info}', $row['val_info']);
			$tpl->set('{val_info_text}', strtr($row['val_info'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
            $tpl->set('{val_guests1}', $row['val_guests1']);
			$tpl->set('{val_guests1_text}', strtr($row['val_guests1'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Только я')));
            $tpl->set('{val_guests1}', $row['val_guests2']);
			$tpl->set('{val_guests2_text}', strtr($row['val_guests2'], array('1' => 'Все пользователи', '2' => 'Только друзья', '3' => 'Никто')));
			$tpl->compile('info');
		break;
		
		
//* Добавление в черный список *//
		
		case "addblacklist":
			NoAjaxQuery();
			$bad_user_id = intval($_POST['bad_user_id']);
			
//* Проверяем на существование юзера *//
			
			$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$bad_user_id}'");

//* Выводим свой блек лист для проверки *//
			
			$myRow = $db->super_query("SELECT user_blacklist FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$array_blacklist = explode('|', $myRow['user_blacklist']);

			if($row['cnt'] AND !in_array($bad_user_id, $array_blacklist) AND $user_id != $bad_user_id){
				$db->query("UPDATE `".PREFIX."_users` SET user_blacklist_num = user_blacklist_num+1, user_blacklist = '{$myRow['user_blacklist']}|{$bad_user_id}|' WHERE user_id = '{$user_id}'");
				
//* Если юзер есть в друзьях *//
				
				if(CheckFriends($bad_user_id)){
				
//* Удаляем друга из таблицы друзей *//
					
					$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$bad_user_id}' AND subscriptions = 0");
					
//* Удаляем у друга из таблицы *//
					
					$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$bad_user_id}' AND friend_id = '{$user_id}' AND subscriptions = 0");
					
//* Обновляем кол-друзей у юзера *//
					
					$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$user_id}'");
					
//* Обновляем у друга которого удаляем кол-во друзей *//
					
					$db->query("UPDATE `".PREFIX."_users` SET user_friends_num = user_friends_num-1 WHERE user_id = '{$bad_user_id}'");
					
//* Чистим кеш владельцу стр и тому кого удаляем из друзей *//
					
					mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
					mozg_clear_cache_file('user_'.$bad_user_id.'/profile_'.$bad_user_id);
					
//* Удаляем пользователя из кеш файл друзей *//
					
					$openMyList = mozg_cache("user_{$user_id}/friends");
					mozg_create_cache("user_{$user_id}/friends", str_replace("u{$bad_user_id}|", "", $openMyList));
					
					$openTakeList = mozg_cache("user_{$bad_user_id}/friends");
					mozg_create_cache("user_{$bad_user_id}/friends", str_replace("u{$user_id}|", "", $openTakeList));
				}
				
				$openMyList = mozg_cache("user_{$user_id}/blacklist");
				mozg_create_cache("user_{$user_id}/blacklist", $openMyList."|{$bad_user_id}|");
			}
			
			die();
		break;
		
//* Удаление из черного списка *//
		
		case "delblacklist":
			NoAjaxQuery();
			$bad_user_id = intval($_POST['bad_user_id']);
			
//* Проверяем на существование юзера *//
			
			$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$bad_user_id}'");

//* Выводим свой блек лист для проверки *//
			
			$myRow = $db->super_query("SELECT user_blacklist FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$array_blacklist = explode('|', $myRow['user_blacklist']);

			if($row['cnt'] AND in_array($bad_user_id, $array_blacklist) AND $user_id != $bad_user_id){
				$myRow['user_blacklist'] = str_replace("|{$bad_user_id}|", "", $myRow['user_blacklist']);
				$db->query("UPDATE `".PREFIX."_users` SET user_blacklist_num = user_blacklist_num-1, user_blacklist = '{$myRow['user_blacklist']}' WHERE user_id = '{$user_id}'");
				
				$openMyList = mozg_cache("user_{$user_id}/blacklist");
				mozg_create_cache("user_{$user_id}/blacklist", str_replace("|{$bad_user_id}|", "", $openMyList));
			}
			
			die();
		break;
		
//* Черный список *// 
		
		case "blacklist":
			$row = $db->super_query("SELECT user_blacklist, user_blacklist_num FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('settings/blacklist.tpl');
			$tpl->set('{cnt}', '<span id="badlistnum">'.$row['user_blacklist_num'].'</span> '.gram_record($row['user_blacklist_num'], 'fave'));
			if($row['user_blacklist_num']){
				$tpl->set('[yes-users]', '');
				$tpl->set('[/yes-users]', '');
			} else
				$tpl->set_block("'\\[yes-users\\](.*?)\\[/yes-users\\]'si","");
			$tpl->compile('info');
			
			if($row['user_blacklist_num'] AND $row['user_blacklist_num'] <= 100){
				$tpl->load_template('settings/baduser.tpl');
				$array_blacklist = explode('|', $row['user_blacklist']);
				foreach($array_blacklist as $user){
					if($user){
						$infoUser = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user}'");
						
						if($infoUser['user_photo'])
							$tpl->set('{ava}', '/uploads/users/'.$user.'/50_'.$infoUser['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						
						$tpl->set('{name}', $infoUser['user_search_pref']);
						$tpl->set('{user-id}', $user);
						
						$tpl->compile('content');
					}
				}
			} else
				msgbox('', $lang['settings_nobaduser'], 'info_2');
		break;
		
//* Дизайн страницы *//
		
		case "design":
			
			$tpl->load_template('settings/design.tpl');
			
			$row = $db->super_query("SELECT tb1.user_design, tb2.verification FROM `".PREFIX."_users` tb1, `".PREFIX."_users_param` tb2 WHERE tb1.user_id = '{$user_info['user_id']}' AND tb1.user_id = tb2.user_id");
			
			$data = xfieldsdataload($row['user_design']);

			$tpl->copy_template = str_replace("[instSelect-family-{$data['family']}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[instSelect-family-(.*?)\\]'si","");

			$tpl->copy_template = str_replace("[instSelect-size-{$data['size']}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[instSelect-size-(.*?)\\]'si","");

			$tpl->copy_template = str_replace("[instSelect-opacity-{$data['opacity']}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[instSelect-opacity-(.*?)\\]'si","");

			$tpl->copy_template = str_replace("[instSelect-pos-{$data['pos']}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[instSelect-pos-(.*?)\\]'si","");

			$tpl->copy_template = str_replace("[instSelect-color_head-{$data['color_head']}]", 'selected', $tpl->copy_template);
			$tpl->set_block("'\\[instSelect-color_head-(.*?)\\]'si","");
			
			if($data['background_repeat']) $tpl->set('{background_repeat}', 'background_repeat');
			else $tpl->set('{background_repeat}', '');

			$tpl->copy_template = str_replace("value={$data['color']}", "value={$data['color']} selected", $tpl->copy_template);
			
			if($row['verification']){
				$tpl->set('[ver]', '');
				$tpl->set('[/ver]', '');
			} else
				$tpl->set_block("'\\[ver\\](.*?)\\[/ver\\]'si","");

			$tpl->compile('content');
			
		break;
		
//* Загузка фона страницы *//
		
		case "upload":
			
//* Получаем данные о фотографии *//
			
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			
//* Оригинальное название для определения формата *//			
			
			$image_name = totranslit($_FILES['uploadfile']['name']); 
			
//* Имя фотографии *//			
			
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);
			
//* Размер файла *//			
			
			$image_size = $_FILES['uploadfile']['size'];

//* Формат файла *//
			
			$type = end(explode(".", $image_name)); 
			
//* Разришенные форматы *//
			
			$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');
	
			$max_file_size = 5000 * 1024;

//* Проверяем если, формат верный то пропускаем *//
			
			if(in_array(strtolower($type), $allowed_files)){
	
				if($image_size <= $max_file_size){
					
					$res_type = strtolower('.'.$type);
					$upDir = ROOT_DIR."/uploads/users/{$user_info['user_id']}/";
					
					if(move_uploaded_file($image_tmp, $upDir.$image_rename.$res_type)){
						
						$getrazm = getimagesize($upDir.$image_rename.$res_type);
						
//* Подключаем класс для фотографий *//
						
						include_once ENGINE_DIR.'/classes/images.php';
						
//* Создание оригинала *//
						
						$tmb = new thumbnail($upDir.$image_rename.$res_type);
						$tmb->size_auto("{$getrazm[0]}x{$getrazm[1]}");
						$tmb->jpeg_quality('30');
						$tmb->save($upDir.$image_rename.$res_type);
	
						$row = $db->super_query("SELECT user_design FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
						
						$data = xfieldsdataload($row['user_design']);
						
						echo $data['background'];
						
						if($data['background']){
							
							@unlink($upDir.$data['background']);
							
						}
						
						$user_design = str_replace("background|{$data['background']}||", '', $row['user_design']);
						$user_design = "background|{$image_rename}{$res_type}||{$user_design}";
						
						$db->query("UPDATE `".PREFIX."_users` SET user_design = '{$user_design}' WHERE user_id = '{$user_info['user_id']}'");
						
						mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
						
					}
					
				} else
					echo 1;
			}
			
			exit;
			
		break;
		
//* Загрузка логотипа страницы *//
		
		case "upload_logo":
			
//* Получаем данные о фотографии *//
			
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			
//* Оригинальное название для определения формата *//			
			
			$image_name = totranslit($_FILES['uploadfile']['name']); 
			
//* Имя фотографии *//			
			
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);
			
//* Размер файла *//			
			
			$image_size = $_FILES['uploadfile']['size'];

//* Формат файла *//
			
			$type = end(explode(".", $image_name));
			
//* Разришенные форматы *//
			
			$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');
	
			$max_file_size = 5000 * 1024;

// * Проверяем если, формат верный то пропускаем *//
			
			if(in_array(strtolower($type), $allowed_files)){
	
				if($image_size <= $max_file_size){
					
					$res_type = strtolower('.'.$type);
					$upDir = ROOT_DIR."/uploads/users/{$user_info['user_id']}/";
					
					if(move_uploaded_file($image_tmp, $upDir.$image_rename.$res_type)){
						
//* Подключаем класс для фотографий *//
						
						include_once ENGINE_DIR.'/classes/images.php';
						
//* Создание оригинала *//
						
						$tmb = new thumbnail($upDir.$image_rename.$res_type);
						$tmb->size_auto("65x47");
						$tmb->jpeg_quality('100');
						$tmb->save($upDir.$image_rename.$res_type);
	
						$row = $db->super_query("SELECT user_design FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
						
						$data = xfieldsdataload($row['user_design']);
						
						echo $data['logo'];
						
						if($data['logo']){
							
							@unlink($upDir.$data['logo']);
							
						}
						
						$user_design = str_replace("logo|{$data['logo']}||", '', $row['user_design']);
						$user_design = "logo|{$image_rename}{$res_type}||{$user_design}";
						
						$db->query("UPDATE `".PREFIX."_users` SET user_design = '{$user_design}' WHERE user_id = '{$user_info['user_id']}'");
						
						mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
						
					}
					
				} else
					echo 1;
			}
			
			exit;
			
		break;
		
//* Сохранение шрифтов *// 
		
		case "save_font":
			
			$family = intval($_POST['family']);
			$size = intval($_POST['size']);
			$opacity = intval($_POST['opacity']);
			$pos = intval($_POST['pos']);
			$background_repeat = intval($_POST['background_repeat']);
			$color_head = intval($_POST['color_head']);
			$color = $db->safesql(iconv_substr($_POST['color'], 0, 6, 'utf-8'));
			$color = str_replace('|', '', $color);
			
			if($family < 1 OR $family > 16) $family = 1;
			if($size < 1 OR $size > 5) $size = 1;
			if($opacity < 1 OR $opacity > 9) $opacity = 1;
			if($pos < 1 OR $pos > 2) $pos = 1;
			
			$row = $db->super_query("SELECT tb1.user_design, tb2.verification FROM `".PREFIX."_users` tb1, `".PREFIX."_users_param` tb2 WHERE tb1.user_id = '{$user_info['user_id']}' AND tb1.user_id = tb2.user_id");
			
			if($color_head == 8 AND $row['verification'] == 0) $color_head = 7;
			
			$data = xfieldsdataload($row['user_design']);
			
			$row['user_design'] = str_replace("family|{$data['family']}||", '', $row['user_design']);
			$row['user_design'] = str_replace("size|{$data['size']}||", '', $row['user_design']);
			$row['user_design'] = str_replace("opacity|{$data['opacity']}||", '', $row['user_design']);
			$row['user_design'] = str_replace("pos|{$data['pos']}||", '', $row['user_design']);
			$row['user_design'] = str_replace("color|{$data['color']}||", '', $row['user_design']);
			$row['user_design'] = str_replace("background_repeat|{$data['background_repeat']}||", '', $row['user_design']);
			$row['user_design'] = str_replace("color_head|{$data['color_head']}||", '', $row['user_design']);

			$new_family = strtr($family, array(
										1 => 'Tahoma',
										2 => 'Arial',
										3 => 'Verdana',
										4 => 'Times',
										5 => 'Times New Roman',
										6 => 'Georgia',
										7 => 'Trebuchet MS',
										8 => 'Sans',
										9 => 'Comic Sans MS',
										10 => 'Courier New',
										11 => 'Webdings',
										12 => 'Garamond',
										13 => 'Helvetica',
										14 => 'Impact',
										15 => 'Century Gothic',
										16 => 'Arial Narrow'
									)
								);
			
			$new_size = strtr($size, array(
										1 => '11',
										2 => '12',
										3 => '13',
										4 => '14',
										5 => '15'
									)
								);
			
			$new_opacity = strtr($opacity, array(
										1 => '100',
										2 => '95',
										3 => '90',
										4 => '80',
										5 => '70',
										6 => '60',
										7 => '50',
										8 => '40',
										9 => '30'
									)
								);

			$user_design = "color_head|{$color_head}||background_repeat|{$background_repeat}||family|{$new_family}||size|{$new_size}||opacity|{$new_opacity}||pos|{$pos}||color|{$color}||{$row['user_design']}";

			$db->query("UPDATE `".PREFIX."_users` SET user_design = '{$user_design}' WHERE user_id = '{$user_info['user_id']}'");
			
			mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
			
			exit;
			
		break;
		
//* Сброс настроек дизайна *//
		
		case "clear_design":
			
			$db->query("UPDATE `".PREFIX."_users` SET user_design = '' WHERE user_id = '{$user_info['user_id']}'");
			
			mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");
			
			exit;
			
		break;

//* Пересчет показателей *//
		
		case "conversion":
			
			$last_conver = mozg_cache("user_{$user_id}/conversion") + 86400;
			
			if($last_conver > $server_time){
				
				echo '1';
				
				exit;
				
			}

//* Пересчет новых сообщений *//
			
			$sql_msg = $db->super_query("SELECT im_user_id FROM `".PREFIX."_im` WHERE iuser_id = '{$user_id}'", 1);
			
			$allmsgnum = 0;
			
			if($sql_msg){
			
				foreach($sql_msg as $row_msg){
					
					$row_cnt = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_messages` WHERE folder = 'inbox' AND pm_read = 'no' AND for_user_id = '{$user_id}' AND from_user_id = '{$row_msg['im_user_id']}'");
					
					$db->query("UPDATE `".PREFIX."_im` SET msg_num = '{$row_cnt['cnt']}' WHERE iuser_id = '{$user_id}' AND im_user_id = '{$row_msg['im_user_id']}'");
					
					$allmsgnum = $allmsgnum + $row_cnt['cnt'];
					
				}
			
			}
			
//* Пересчет друзей *//
			
			$row_fr = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends_demands` WHERE for_user_id = '{$user_id}'");
			
//* Пересчет отметок на фото *//
			
			$row_ph = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_photos_mark` WHERE muser_id = '{$user_id}' AND mapprove = '0'");
			
//* Проверка по приглашению юзера *//
			
			$check = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_join` WHERE for_user_id = '{$user_id}'");
						
//* Обновляем в таблице юзеров *//
			
			$db->query("UPDATE `".PREFIX."_users` SET user_friends_demands = '{$row_fr['cnt']}', user_pm_num = '{$allmsgnum}', user_new_mark_photos = '{$row_ph['cnt']}', invties_pub_num = '{$check['cnt']}' WHERE user_id = '{$user_id}'");
			
			mozg_create_cache("user_{$user_id}/conversion", $server_time);

			exit;
			
		break;
		
//* Смена e-mail *//
		
		case "change_mail":
		
//* Отправляем письмо на обе почты *//
			
			include_once ENGINE_DIR.'/classes/mail.php';
			$mail = new dle_mail($config);
			
			$email = textFilter($_POST['email'], false, true);
			
//* Проверка E-mail *//
			
			if(preg_match('/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i', $email)) $ok_email = true;
			else $ok_email = false;
				
			$row = $db->super_query("SELECT user_email FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$check_email = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users`  WHERE user_email = '{$email}'");
			
			if($row['user_email'] AND $ok_email AND !$check_email['cnt']){
				
//* Удаляем все пред. заявки *//
				
				$db->query("DELETE FROM `".PREFIX."_restore` WHERE email = '{$email}'");
				
				$salt = "abchefghjkmnpqrstuvwxyz0123456789";
				for($i = 0; $i < 15; $i++){
					$rand_lost .= $salt{rand(0, 33)};
				}
				$hash = md5($server_time.$row['user_email'].rand(0, 100000).$rand_lost);
						
				$message = <<<HTML
Вы получили это письмо, так как зарегистрированы на сайте
{$config['home_url']} и хотите изменить основной почтовый адрес.
Вы желаете изменить почтовый адрес с текущего ({$row['user_email']}) на {$email}
Для того чтобы Ваш основной e-mail на сайте {$config['home_url']} был
изменен, Вам необходимо пройти по ссылке:
{$config['home_url']}index.php?go=settings&code1={$hash}

Внимание: не забудьте, что после изменения почтового адреса при входе
на сайт Вам нужно будет указывать новый адрес электронной почты.

Если Вы не посылали запрос на изменение почтового адреса,
проигнорируйте это письмо.С уважением,
Администрация {$config['home_url']}
HTML;
				$mail->send($row['user_email'], 'Изменение почтового адреса', $message);
				
//* Вставляем в базу данных код 1 *//
				
				$db->query("INSERT INTO `".PREFIX."_restore` SET email = '{$email}', hash = '{$hash}', ip = '{$_IP}'");
				
				$salt = "abchefghjkmnpqrstuvwxyz0123456789";
				for($i = 0; $i < 15; $i++){
					$rand_lost .= $salt{rand(0, 33)};
				}
				$hash = md5($server_time.$row['user_email'].rand(0, 300000).$rand_lost);
						
				$message = <<<HTML
Вы получили это письмо, так как зарегистрированы на сайте
{$config['home_url']} и хотите изменить основной почтовый адрес.
Вы желаете изменить почтовый адрес с текущего ({$row['user_email']}) на {$email}
Для того чтобы Ваш основной e-mail на сайте {$config['home_url']} был
изменен, Вам необходимо пройти по ссылке:
{$config['home_url']}index.php?go=settings&code2={$hash}

Внимание: не забудьте, что после изменения почтового адреса при входе
на сайт Вам нужно будет указывать новый адрес электронной почты.

Если Вы не посылали запрос на изменение почтового адреса,
проигнорируйте это письмо.С уважением,
Администрация {$config['home_url']}
HTML;
				$mail->send($email, 'Изменение почтового адреса', $message);
				
//* Вставляем в базу данных код 2 *//
				
				$db->query("INSERT INTO `".PREFIX."_restore` SET email = '{$email}', hash = '{$hash}', ip = '{$_IP}'");
			
			} else
				echo '1';
			
			exit;
			
		break;
                
                case "addobshenie":
                        
                        $text = ajax_utf8(textFilter($_POST['text']));
                        $row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
                        $obshenie = $db->super_query("SELECT id FROM `".PREFIX."_obshenie` WHERE user_id = '{$user_id}'");
                        
                        if(!$obshenie and $row['user_balance']>=10) {
                                $db->query("INSERT INTO `".PREFIX."_obshenie` (user_id,text,date) values('".$user_id."','".$text."','".$server_time."')");
                        } elseif($row['user_balance']<10) echo "n_money";
                        else echo "now_vip";
                        
                break;

//* Загрузка док 1 *//
		
		case "upload_doc":
		
//* Если нет папки альбома, то создаём её *//
			
			$up_dir = ROOT_DIR."/uploads/users/{$user_id}/";
			
//* Разришенные форматы *//
			
			$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');

//* Получаем данные о фотографии *//
			
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			
//* Оригинальное название для определения формата *//			
			
			$image_name = totranslit($_FILES['uploadfile']['name']); 
			
//* Имя фотографии *//			
			
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);
			
//* Размер файла *//			
			
			$image_size = $_FILES['uploadfile']['size'];
			
//* Формат файла *//			
			
			$type = end(explode(".", $image_name));
			
//* Проверяем если, формат верный то пропускаем *//
			
			if(in_array(strtolower($type), $allowed_files)){
				if($image_size < 5242880){
				
					$res_type = strtolower('.'.$type);
					
					if(move_uploaded_file($image_tmp, $up_dir.$image_rename.$res_type)){
					
//* Подключаем класс для фотографий *//
						
						include_once ENGINE_DIR.'/classes/images.php';
						
//* Создание оригинала *//
						
						$tmb = new thumbnail($up_dir.$image_rename.$res_type);
						$tmb->size_auto('1280');
						$tmb->jpeg_quality('100');
						$tmb->save($up_dir.$image_rename.$res_type);
						
						$row = $db->super_query("SELECT doc FROM `".PREFIX."_verification` WHERE user_id = '{$user_id}'");
						
						$res_type = $db->safesql($res_type);
						$image_rename = $db->safesql($image_rename);
						
						if($row['doc']){
							
							@unlink($up_dir.$row['doc']);
							
							$db->query("UPDATE `".PREFIX."_verification` SET doc = '{$image_rename}{$res_type}' WHERE user_id = '{$user_id}'");
							
						} else
							$db->query("INSERT INTO `".PREFIX."_verification` SET doc = '{$image_rename}{$res_type}', user_id = '{$user_id}'");
						
						echo "/uploads/users/{$user_id}/".$image_rename.$res_type;
					
					} else
						echo '3';
				} else
					echo '2';
			} else
				echo '1';
			
			exit;
			
		break;

//* Загрузка док 2 *//
		
		case "upload_doc_2":
		
//* Если нет папки альбома, то создаём её *//
			
			$up_dir = ROOT_DIR."/uploads/users/{$user_id}/";
			
//* Разришенные форматы *//
			
			$allowed_files = array('jpg', 'jpeg', 'jpe', 'png', 'gif');

//* Получаем данные о фотографии *//
			
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			
//* Оригинальное название для определения формата *//			
			
			$image_name = totranslit($_FILES['uploadfile']['name']);
			
//* Имя фотографии *//		
			
			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);

//* Размер файла *//
			
			$image_size = $_FILES['uploadfile']['size']; 
			
//* Формат файла *//			
			
			$type = end(explode(".", $image_name)); 
			
//* Проверяем если, формат верный то пропускаем *//
			
			if(in_array(strtolower($type), $allowed_files)){
				if($image_size < 5242880){
				
					$res_type = strtolower('.'.$type);
					
					if(move_uploaded_file($image_tmp, $up_dir.$image_rename.$res_type)){
					
//* Подключаем класс для фотографий *//
						
						include_once ENGINE_DIR.'/classes/images.php';
						
//* Создание оригинала *//
						
						$tmb = new thumbnail($up_dir.$image_rename.$res_type);
						$tmb->size_auto('1280');
						$tmb->jpeg_quality('100');
						$tmb->save($up_dir.$image_rename.$res_type);
						
						$row = $db->super_query("SELECT doc, doc2 FROM `".PREFIX."_verification` WHERE user_id = '{$user_id}'");
						
						$res_type = $db->safesql($res_type);
						$image_rename = $db->safesql($image_rename);
						
						if($row['doc2'] OR $row['doc']){
							
							@unlink($up_dir.$row['doc2']);
							
							$db->query("UPDATE `".PREFIX."_verification` SET doc2 = '{$image_rename}{$res_type}' WHERE user_id = '{$user_id}'");
							
						} else
							$db->query("INSERT INTO `".PREFIX."_verification` SET doc2 = '{$image_rename}{$res_type}', user_id = '{$user_id}'");
						
						echo "/uploads/users/{$user_id}/".$image_rename.$res_type;
					
					} else
						echo '3';
				} else
					echo '2';
			} else
				echo '1';
			
			exit;
			
		break;
		
//* Отправка заявки на верификацию *//
		
		case "verification":
		
			$skype = textFilter($_POST['skype'], false, true);

			$row = $db->super_query("SELECT doc, doc2, status FROM `".PREFIX."_verification` WHERE user_id = '{$user_id}'");
			
			if(isset($skype) AND !empty($skype) AND $row['doc'] AND $row['doc2'] AND $row['status'] != 1){
				
				$db->query("UPDATE `".PREFIX."_verification` SET status = '1', skype = '{$skype}', date = '{$server_time}' WHERE user_id = '{$user_id}'");
				
			}
			
			exit;
			
		break;
		
//* Отмена заявки *//
		
		case "verification_cancel":
			
			$row = $db->super_query("SELECT doc FROM `".PREFIX."_verification` WHERE user_id = '{$user_id}'");
			
			if($row['doc']){
				
				$up_dir = ROOT_DIR."/uploads/users/{$user_id}/";
				
				@unlink($up_dir.$row['doc']);
				
				$db->query("DELETE FROM `".PREFIX."_verification` WHERE user_id = '{$user_id}'");
				
			}
			
			exit;
			
		break;

//* Сохранение позиции блоков *//
		
		case "savblock":
			
			NoAjaxQuery();
			
			$arrlist = array('b_friends', 'b_friends_online', 'b_people', 'b_pages', 'b_video', 'b_audio', 'b_notes', 'b_albums', 'b_gifts', 'b_photo', 'b_wall');
			
			foreach($arrlist as $p){
				
				$rCache .= "{$p}|".intval($_POST[$p])."||";
				
			}
			
			$mydesign = intval($_POST['b_design']);
			if($mydesign < 0 OR $mydesign > 1) $mydesign = 0;
			
			$db->query("UPDATE `".PREFIX."_users` SET mydesign = '{$mydesign}' WHERE user_id = '{$user_info['user_id']}'");
			
			mozg_create_cache("user_{$user_id}/blocks", $rCache);
			
			exit();
			
		break;

//* Оповещения *//
		
		case "notify":
		
			$row = $db->super_query("SELECT notify FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");

			$tpl->load_template('settings/notify.tpl');
						
			$block_data = xfieldsdataload($row['notify']);
			
			$arrlist = array('n_friends', 'n_wall', 'n_comm', 'n_comm_ph', 'n_comm_note', 'n_gifts', 'n_rec', 'n_im');
			
			foreach($arrlist as $p){
				
				if($block_data[$p]) $tpl->set("{{$p}}", $p);
				else $tpl->set("{{$p}}", "0");
				
			}
			
			$tpl->compile('info');
			
		break;
		
//* Сохранение настроек оповещений *//
		
		case "save_notify":
			
			NoAjaxQuery();

			$arrlist = array('n_friends', 'n_wall', 'n_comm', 'n_comm_ph', 'n_comm_note', 'n_gifts', 'n_rec', 'n_im');
			
			foreach($arrlist as $p){
				
				$rCache .= "{$p}|".intval($_POST[$p])."||";
				
			}
			
			$rCache = $db->safesql($rCache);
			
			$db->query("UPDATE `".PREFIX."_users` SET notify = '{$rCache}' WHERE user_id = '{$user_id}'");
			
			exit();
			
		break;

//* Общие настройки *//
		
		default:

			$mobile_speedbar = 'Общие настройки';
			
			$row = $db->super_query("SELECT user_name, user_lastname, user_email, mydesign, short_link FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$row2 = $db->super_query("SELECT verification FROM `".PREFIX."_users_param` WHERE user_id = '{$user_id}'");
			
			$row_ver = $db->super_query("SELECT status FROM `".PREFIX."_verification` WHERE user_id = '{$user_id}'");
			
//* Загружаем вверх *//
			
			$tpl->load_template('settings/general.tpl');
			$tpl->set('{name}', $row['user_name']);
			$tpl->set('{lastname}', $row['user_lastname']);
			$tpl->set('{short-link}', $row['short_link']);
			$tpl->set('{id}', $user_id);

//* Завершения смены E-mail *//
			
			$tpl->set('{code-1}', 'no_display');
			$tpl->set('{code-2}', 'no_display');
			$tpl->set('{code-3}', 'no_display');
			
			$code1 = strip_data($_GET['code1']);
			$code2 = strip_data($_GET['code2']);
			
			if(strlen($code1) == 32){
				
				$code2 = '';
				
				$check_code1 = $db->super_query("SELECT email FROM `".PREFIX."_restore` WHERE hash = '{$code1}' AND ip = '{$_IP}'");

				if($check_code1['email']){
					
					$check_code2 = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_restore` WHERE hash != '{$code1}' AND email = '{$check_code1['email']}' AND ip = '{$_IP}'");
					
					if($check_code2['cnt'])
						$tpl->set('{code-1}', '');
					else {
						$tpl->set('{code-1}', 'no_display');
						$tpl->set('{code-3}', '');
						
//* Меняем *//
						
						$db->query("UPDATE `".PREFIX."_users` SET user_email = '{$check_code1['email']}' WHERE user_id = '{$user_id}'");							
						$row['user_email'] = $check_code1['email'];
							
					}
					
					$db->query("DELETE FROM `".PREFIX."_restore` WHERE hash = '{$code1}' AND ip = '{$_IP}'");
					
				}
			
			}
			
			if(strlen($code2) == 32){
			
				$check_code2 = $db->super_query("SELECT email FROM `".PREFIX."_restore` WHERE hash = '{$code2}' AND ip = '{$_IP}'");

				if($check_code2['email']){
				
					$check_code1 = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_restore` WHERE hash != '{$code2}' AND email = '{$check_code2['email']}' AND ip = '{$_IP}'");
					
					if($check_code1['cnt'])
						$tpl->set('{code-2}', '');
					else {
						$tpl->set('{code-2}', 'no_display');
						$tpl->set('{code-3}', '');
						
//* Меняем *//
						
						$db->query("UPDATE `".PREFIX."_users` SET user_email = '{$check_code2['email']}'  WHERE user_id = '{$user_id}'");						
						$row['user_email'] = $check_code2['email'];
						
					}
					
					$db->query("DELETE FROM `".PREFIX."_restore` WHERE hash = '{$code2}' AND ip = '{$_IP}'");
					
				}
			
			}
			
//* E-mail *//
			
			$substre = substr($row['user_email'], 0, 1);
			$epx1 = explode('@', $row['user_email']);
			$tpl->set('{email}', $substre.'*******@'.$epx1[1]);
			
			if($row2['verification'] == 1){
				$tpl->set('{block_verification}', 'no_display');
				$tpl->set('{block_verification_2}', 'no_display');
				$tpl->set('{block_verification_3}', '');
				$tpl->set_block("'\\[verification\\](.*?)\\[/verification\\]'si","");
			} elseif($row_ver['status'] == 1){
				$tpl->set('{block_verification}', '');
				$tpl->set('{block_verification_2}', 'no_display');
				$tpl->set('{block_verification_3}', 'no_display');
			} else {
				$tpl->set('{block_verification}', 'no_display');
				$tpl->set('{block_verification_2}', '');
				$tpl->set('{block_verification_3}', 'no_display');
			}
			
			$tpl->set('[verification]', '');
			$tpl->set('[/verification]', '');
			
//* Советуем подписаться *//
			
			$gr_list = $config['gr_list'];
			
			$sql_gr = $db->super_query("SELECT id, photo, title, ulist, traf, adres FROM `".PREFIX."_communities` WHERE id IN({$gr_list})", 1);
			
			foreach($sql_gr as $row_gr){
				
				$row_gr['title'] = stripslashes($row_gr['title']);
				$row_gr['traf'] = $row_gr['traf'].' '.gram_record($row_gr['traf'], 'groups_users');
				
				if($row_gr['photo']) $row_gr['photo'] = "/uploads/groups/{$row_gr['id']}/100_{$row_gr['photo']}";
				else $row_gr['photo'] = "{theme}/images/no_ava_groups_100.gif";
				
				if($row_gr['adres']) $row_gr['adres'] = $row_gr['adres'];
				else $row_gr['adres'] = 'public'.$row_gr['id'];
				
				if(stripos($row_gr['ulist'], "|{$user_id}|") === false) $grlink = '<a href="/groups" onClick="fastLOGIN('.$row_gr['id'].'); return false" id="gr'.$row_gr['id'].'"><div>Подписаться</div></a>';
				else $grlink = '<a href="/groups" onClick="fastEXIT('.$row_gr['id'].'); return false" id="gr'.$row_gr['id'].'"><div>Отписаться</div></a>';
						
				$pages .= <<<HTML
<div class="friends_onefriend width_100" style="border-top:1px solid #e0eaef">
 <a href="/{$row_gr['adres']}" onClick="Page.Go(this.href); return false"><div class="friends_ava"><img src="{$row_gr['photo']}" /></div></a>
 <div class="fl_l" style="width:200px">
  <a href="/{$row_gr['adres']}" onClick="Page.Go(this.href); return false"><b>{$row_gr['title']}</b></a><div class="friends_clr"></div>
  <span class="color777">{$row_gr['traf']}</span><div class="friends_clr"></div>
 </div>
 <div class="menuleft fl_r friends_m">
  <div id="exitlink{id}">{$grlink}</div>
 </div>
</div>			
HTML;
				
			}
			
			$tpl->set('{pages}', $pages);

//* Blocks *//
			
			$blcoCah = mozg_cache("user_{$user_id}/blocks");
			
			if(!$blcoCah){
				
				$arrlist = array('b_friends', 'b_friends_online', 'b_people', 'b_pages', 'b_video', 'b_audio', 'b_notes', 'b_albums', 'b_gifts', 'b_photo', 'b_wall');
			
				foreach($arrlist as $p){
					
					$rCache .= "{$p}|1||";
					
				}
				
				mozg_create_cache("user_{$user_id}/blocks", $rCache);
				
				$blcoCah = $rCache;
			
			}
			
			$block_data = xfieldsdataload($blcoCah);
			
			$arrlist = array('b_friends', 'b_friends_online', 'b_people', 'b_pages', 'b_video', 'b_audio', 'b_notes', 'b_albums', 'b_gifts', 'b_photo', 'b_wall');
			
			foreach($arrlist as $p){
				
				if(stripos($blcoCah, "b_wall") === false AND $p == 'b_wall') $block_data['b_wall'] = 1;
				
				if($block_data[$p]) $tpl->set("{{$p}}", $p);
				else $tpl->set("{{$p}}", "0");
				
			}
			
			if($row['mydesign']) $tpl->set('{b_design}', 'b_design');
			else $tpl->set('{b_design}', '0');
			
			$tpl->compile('info');
	}
	
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>
