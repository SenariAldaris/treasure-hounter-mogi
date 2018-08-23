<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$metatags['title'] = $lang['balance'];
	$mobile_speedbar = $lang['balance'];
	
	switch($act){
		
//* Страница приглашения друга *//
		
		case "invite":
			$tpl->load_template('balance/invite.tpl');
			$tpl->set('{uid}', $user_id);
			$tpl->compile('content');
		break;
		
//* Страница приглашённых друзей *//
		
		case "invited":
			$tpl->load_template('balance/invited.tpl');
			$tpl->compile('info');
			$sql_ = $db->super_query("SELECT tb1.ruid, tb2.user_name, user_search_pref, user_birthday, user_last_visit, user_photo, user_logged_mobile FROM `".PREFIX."_invites` tb1, `".PREFIX."_users` tb2 WHERE tb1.uid = '{$user_id}' AND tb1.ruid = tb2.user_id", 1);
			if($sql_){
				$tpl->load_template('balance/invitedUser.tpl');
				foreach($sql_ as $row){
					$user_country_city_name = explode('|', $row['user_country_city_name']);
					$tpl->set('{country}', $user_country_city_name[0]);

					if($user_country_city_name[1])
						$tpl->set('{city}', ', '.$user_country_city_name[1]);
					else
						$tpl->set('{city}', '');

					$tpl->set('{user-id}', $row['ruid']);
					$tpl->set('{name}', $row['user_search_pref']);
					
					if($row['user_photo'])
						$tpl->set('{ava}', '/uploads/users/'.$row['ruid'].'/100_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					
//* Возраст юзера *//
					
					$user_birthday = explode('-', $row['user_birthday']);
					$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
					
					OnlineTpl($row['user_last_visit'], $row['user_logged_mobile']);
					$tpl->compile('content');
				}
			} else
				msgbox('', '<br /><br />Вы еще никого не приглашали.<br /><br /><br />', 'info_2');
		break;
		
//* Загрузка подарка 256x256 *//
		
		case "upload":
		
			NoAjaxQuery();
			
//* Получаем данные о фотографии *//
			
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			
//* Оригинальное название для определения формата *//		
			
			$image_name = totranslit($_FILES['uploadfile']['name']);
			
//* Устанавливаем имя картинки *//
			
			if($_SESSION['temp_gif_name']) 
				$rName = $_SESSION['temp_gif_name'];
			else {
				$rName = $server_time;
				$_SESSION['temp_gif_name'] = $rName;
			}
			
//* Имя фотографии *//
			
			$image_rename = $rName;
			
//* Размер файла *//		
			
			$image_size = $_FILES['uploadfile']['size'];
			
//* Формат файла *//			
			
			$type = end(explode(".", $image_name));
			
//* Разришенные форматы *//
			
			$allowed_files = explode(', ', 'jpg, jpeg, jpe');
			
			$max_size = 1024 * 5000;
			
//* Проверяем если, формат верный то пропускаем *//
			
			if(in_array(strtolower($type), $allowed_files)){
				
//* Проверка размера *//
				
				if($image_size <= $max_size){
					
					$res_type = '.jpg';
					
					$upDir = ROOT_DIR."/uploads/gifts/{$user_id}/";
					
//* Если нет папок юзера, то создаём её *//
					
					if(!is_dir($upDir)){ 
						@mkdir($upDir, 0777);
						@chmod($upDir, 0777);
					}

					$rImg = $upDir.$image_rename.$res_type;
					
					if(move_uploaded_file($image_tmp, $rImg)){
						
//* Чистим от пред.временных подарков *//
						
						$fdir = opendir($upDir);
		
						while($file = readdir($fdir)){
							
							$epSF = explode('.', $file);
							
							if($file != '.' and $file != '..' and $file != '.htaccess' and $file != 'system' and $epSF[0] != $image_rename)
								@unlink($upDir.$file);
								
						}
					
						$paramIMG = getimagesize($rImg);
						
						if($paramIMG[0] == 256 AND $paramIMG[1] == 256){

							echo $user_id.'/'.$image_rename.$res_type;
							
						} else {
						
							@unlink($rImg);
							
							echo '3';
						
						}
					
					} else
						echo '4';
					
				} else
					echo '2';
				
			} else
				echo '1';
					
			exit();
			
		break;
		
//* Загрузка подарка 96x96 *//
		
		case "upload_2":
		
			NoAjaxQuery();
			
//* Получаем данные о фотографии *//
			
			$image_tmp = $_FILES['uploadfile']['tmp_name'];
			
//* Оригинальное название для определения формата *//			
			
			$image_name = totranslit($_FILES['uploadfile']['name']);
			
//* Устанавливаем имя картинки *//
			
			if($_SESSION['temp_gif_name']) 
				$rName = $_SESSION['temp_gif_name'];
			else {
				$rName = $server_time;
				$_SESSION['temp_gif_name'] = $rName;
			}
		
//* Имя фотографии *//
		
			$image_rename = $rName;
			
//* Размер файла *//			
			
			$image_size = $_FILES['uploadfile']['size'];
			
//* Формат файла *//			
			
			$type = end(explode(".", $image_name));
			
//* Разришенные форматы *//
			
			$allowed_files = explode(', ', 'png');
			
			$max_size = 1024 * 5000;
			
//* Проверяем если, формат верный то пропускаем *//
			
			if(in_array(strtolower($type), $allowed_files)){
				
//* Проверка размера *//
				
				if($image_size <= $max_size){
					
					$res_type = '.png';
					
					$upDir = ROOT_DIR."/uploads/gifts/{$user_id}/";
					
//* Если нет папок юзера, то создаём её *//
					
					if(!is_dir($upDir)){ 
						@mkdir($upDir, 0777);
						@chmod($upDir, 0777);
					}
					
					$rImg = $upDir.$image_rename.$res_type;
					
					if(move_uploaded_file($image_tmp, $rImg)){
						
//* Чистим от пред.временных подарков *//
						
						$fdir = opendir($upDir);
		
						while($file = readdir($fdir)){
							
							$epSF = explode('.', $file);
							
							if($file != '.' and $file != '..' and $file != '.htaccess' and $file != 'system' and $epSF[0] != $image_rename)
								@unlink($upDir.$file);
								
						}
						
						$paramIMG = getimagesize($rImg);
						
						if($paramIMG[0] == 96 AND $paramIMG[1] == 96){

							echo $user_id.'/'.$image_rename.$res_type;
							
						} else {
							
							@unlink($rImg);
							
							echo '3';
							
						}
							
					
					} else
						echo '4';
					
				} else
					echo '2';
				
			} else
				echo '1';
					
			exit();
			
		break;
		
//* Отправка подарка в базу *//
		
		case "sendb":
		
			NoAjaxQuery();
			
            $MyRow = $db->super_query("SELECT verification FROM `".PREFIX."_users_param` WHERE user_id = '{$user_id}'"); 
			
            If($myRow['verification']){ 
			
				$price = intval($_POST['price']);
				$cat = intval($_POST['cat']);
				if($cat <= 0) $cat = 1;
				
				$checkCat = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_gifts_cat` WHERE id = '{$cat}'");
				
//* Проверка этапов *//
				
				$sql_user = $db->super_query("SELECT tb1.user_id, user_search_pref, user_photo, user_birthday, user_country_city_name, user_last_visit, user_logged_mobile, tb2.verification FROM `".PREFIX."_users` tb1, `".PREFIX."_users_param` tb2 WHERE tb1.user_id = tb2.user_id AND user_delet = '0' AND user_ban = '0' ORDER by `verification` DESC, `user_rating` DESC LIMIT 0, 10", 1);
				$etap = 0;
				foreach($sql_user as $row_user){
					
					$etap++;
					
					if($row_user['user_id'] == $user_id) $rEtap = $etap;
					
				}
				
				if($rEtap == 1) $limit = $config['max_gifts_1'];
				elseif($rEtap == 2) $limit = $config['max_gifts_2'];
				elseif($rEtap == 3) $limit = $config['max_gifts_3'];
				elseif($rEtap == 4) $limit = $config['max_gifts_4'];
				elseif($rEtap == 5) $limit = $config['max_gifts_5'];
				elseif($rEtap == 6) $limit = $config['max_gifts_6'];
				elseif($rEtap == 7) $limit = $config['max_gifts_7'];
				elseif($rEtap == 8) $limit = $config['max_gifts_8'];
				elseif($rEtap == 9) $limit = $config['max_gifts_9'];
				elseif($rEtap == 10) $limit = $config['max_gifts_10'];
				else $limit = $config['max_gifts'];
				
				$limit = intval($limit);
				
				$myLimit = mozg_cache("user_{$user_id}/business_lim");
				
				$rlimit = intval($limit + $myLimit);
				
				$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_gifts_req` WHERE user_id = '{$user_id}'");
				
				if($price AND $row['cnt'] < $rlimit AND $checkCat['cnt']){
				
					$gift_name = $_SESSION['temp_gif_name'];
					
					$upDir = ROOT_DIR."/uploads/gifts/{$user_id}/";
					
					if(file_exists($upDir.$gift_name.'.jpg')){
						
						if(file_exists($upDir.$gift_name.'.png')){
							
//* Вставляем подарок в базу *//
							
							$gift_name = intval($gift_name);
							
							$db->super_query("INSERT INTO `".PREFIX."_gifts_req` SET user_id = '{$user_id}', gift = '{$gift_name}', price = '{$price}', approve = '1', cat = '{$cat}', balance = '0'");
							
							@copy($upDir.$gift_name.'.jpg', ROOT_DIR."/uploads/gifts/".$gift_name.'.jpg');
							@copy($upDir.$gift_name.'.png', ROOT_DIR."/uploads/gifts/".$gift_name.'.png');
							
							@unlink($upDir.$gift_name.'.jpg');
							@unlink($upDir.$gift_name.'.png');
							
							unset($_SESSION['temp_gif_name']);
							$_SESSION['temp_gif_name'] = '';
							
						} else
							echo '2';
						
					} else
						echo '2';
					
				} else
					echo '1';
				
			}
			
			exit();
			
		break;
//* Удаление подарка *//
		
		case "del":
		
			NoAjaxQuery();
			
			$id = intval($_GET['id']);
			
			$row = $db->super_query("SELECT send_num, gift, approve FROM `".PREFIX."_gifts_req` WHERE id = '{$id}' AND user_id = '{$user_id}'");
			
			if($row){
				
				if(!$row['approve']){
					
					$db->query("DELETE FROM `".PREFIX."_gifts_list` WHERE img = '{$row['gift']}'");
					
				}
				
//* Если небыло продаж, то удаляем подарок из папки *//
				
				if(!$row['send_num']){
					
					@unlink(ROOT_DIR."/uploads/gifts/{$row['gift']}.jpg");
					@unlink(ROOT_DIR."/uploads/gifts/{$row['gift']}.png");
					
				}
				
				$db->query("DELETE FROM `".PREFIX."_gifts_req` WHERE id = '{$id}'");
				
				
			}
			
			exit();
		
		break;
		
//* Мои подарки *//
		
		case "business":
			
			$myRow = $db->super_query("SELECT verification FROM `".PREFIX."_users_param` WHERE user_id = '{$user_id}'");
			
            If($myRow['verification']){ 
			
//* Выводим список загруженных подарков *//
				
				$sql_ = $db->super_query("SELECT tb1.id, gift, approve, send_num, price, balance, tb2.name FROM `".PREFIX."_gifts_req` tb1, `".PREFIX."_gifts_cat` tb2 WHERE tb1.user_id = '{$user_id}' AND tb2.id = tb1.cat ORDER by `id` DESC", 1);

				if($sql_){
					
					foreach($sql_ as $row){
						
						if($row['approve'] == 1) $status = '<font color="blue">на проверке</font>';
						else $status = '<font color="green">продается</font>';

						$mygifts .= <<<HTML
<div style="float:left;width:50%;height:110px;line-height:17px;color:#777" id="updelgift{$row['id']}">
<img src="/uploads/gifts/{$row['gift']}.png" style="float:left;margin-right:10px" width="96" height="96" />
<div style="margin-top:5px">Статус: &nbsp;{$status}</div>
<div>Количество продаж: &nbsp;<b>{$row['send_num']}</b></div>
<div>Ваш заработок: &nbsp;<b>{$row['balance']}</b> mix</div>
<div>Цена: &nbsp;<b>{$row['price']}</b> mix</div>
<div>Категория: &nbsp;<b>{$row['name']}</b></div>
<div><a href="/" onClick="$('#updelgift{$row['id']}').hide(); $.post('/index.php?go=balance&act=del&id={$row['id']}'); return false">Удалить подарок</a></div>
</div>
HTML;
					
					}
					
				}
				
//* Выводим категории *//
				
				$sql_cat = $db->super_query("SELECT id, name FROM `".PREFIX."_gifts_cat` ORDER by `name` DESC", 1);
				
				foreach($sql_cat as $row_cat){
					
					$cats .= "<option value='{$row_cat['id']}'>{$row_cat['name']}</option>";
					
				}
				
				$myGifts = $db->super_query("SELECT SUM(balance) AS all_balance FROM `".PREFIX."_gifts_req` WHERE user_id = '{$user_id}'");

				$myLimit = mozg_cache("user_{$user_id}/business_lim");

				$tpl->load_template('balance/business.tpl');
				
				$tpl->set('{business_rating}', (($myLimit + 1) * $config['business_rating']));
				
				if($myRow['verification'] AND $myLimit < $config['business_rating_limit']){
					$tpl->set('[ver]', '');
					$tpl->set('[/ver]', '');
				} else
					$tpl->set_block("'\\[ver\\](.*?)\\[/ver\\]'si","");

				$tpl->set('{my-gifts}', $mygifts);
				$tpl->set('{num}', $myGifts['all_balance']);
				$tpl->set('{cats}', $cats);
				if($sql_){
					$tpl->set('[gifts]', '');
					$tpl->set('[/gifts]', '');
				} else
					$tpl->set_block("'\\[gifts\\](.*?)\\[/gifts\\]'si","");
					
				$tpl->compile('content');
			
				mozg_clear_cache_file("user_{$user_id}/new_gifts");
			
			} else
			
             Msgbox('', '<br /><br />Продавать подарки могут только верифицированные пользователи. <a href="/settings" onClick="Page.Go(this.href); return false">Пройти верификацию</a><br /><br /><br />', 'info_2'); 
			
		break;

//* Страница оплаты *//
		
		case "payment":
			
			NoAjaxQuery();
			
			$owner = $db->super_query("SELECT balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('balance/payment.tpl');
			
			if($user_info['user_photo']) $tpl->set('{ava}', "/uploads/users/{$user_info['user_id']}/50_{$user_info['user_photo']}");
			else $tpl->set('{ava}', "{theme}/images/no_ava_50.png");

			$tpl->set('{rub}', deColNums($owner['balance_rub']));
			$tpl->set('{text-rub}', declOfNum($owner['balance_rub'], array('рубль', 'рубля', 'рублей')));
			$tpl->set('{user-id}', $user_info['user_id']);
			
			$tpl->compile('content');
			
			AjaxTpl();
			
			exit();
			
		break;

//* ROBOKASSA *//
		
		case "rk":
			
			NoAjaxQuery();
			
			$owner = $db->super_query("SELECT balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('balance/rk.tpl');
			
			if($user_info['user_photo']) $tpl->set('{ava}', "/uploads/users/{$user_info['user_id']}/50_{$user_info['user_photo']}");
			else $tpl->set('{ava}', "{theme}/images/no_ava_50.png");

			$tpl->set('{rub}', deColNums($owner['balance_rub']));
			$tpl->set('{text-rub}', declOfNum($owner['balance_rub'], array('рубль', 'рубля', 'рублей')));
			$tpl->set('{user-id}', $user_info['user_id']);
			
			$tpl->compile('content');
			
			AjaxTpl();
			
			exit();
			
		break;
		
//* Страница покупки голосов *//
		
		case "payment_2":
			
			NoAjaxQuery();
			
			$owner = $db->super_query("SELECT user_balance, balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('balance/payment_2.tpl');
			
			if($user_info['user_photo']) $tpl->set('{ava}', "/uploads/users/{$user_info['user_id']}/50_{$user_info['user_photo']}");
			else $tpl->set('{ava}', "{theme}/images/no_ava_50.png");

			$tpl->set('{balance}', $owner['user_balance']);
			$tpl->set('{rub}', deColNums($owner['balance_rub']));
			$tpl->set('{cost}', $config['cost_balance']);

			$tpl->compile('content');
			
			AjaxTpl();
			
			exit();
			
		break;
		
//* Завершение покупки голосов *//
		
		case "ok_payment":
			
			NoAjaxQuery();
			
			$num = intval($_POST['num']);
			if($num <= 0) $num = 0;
			
			$resCost = $num * $config['cost_balance'];

//* Выводим тек. баланс юзера (руб.) *//
			
			$owner = $db->super_query("SELECT balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			if($owner['balance_rub'] >= $resCost){
				
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$num}', balance_rub = balance_rub - '{$resCost}' WHERE user_id = '{$user_id}'");

//* START / Записываем в историю *//
				
				$db->query("INSERT INTO `".PREFIX."_users_logs` SET user_id = '{$user_info['user_id']}', browser = '{$_BROWSER}', ip = '{$_IP}', act = '7', date = '{$server_time}', spent = '{$resCost}', for_user_id = '{$user_id}'");

			} else
				echo '1';
			
			exit();
			
		break;

//* Увеличение лимита *//
		
		case "addlimit":
			
			NoAjaxQuery();
			
			$row = $db->super_query("SELECT user_rating FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$myRow = $db->super_query("SELECT verification FROM `".PREFIX."_users_param` WHERE user_id = '{$user_id}'");
			
			if($myRow['verification']){
			
				$myLimit = mozg_cache("user_{$user_id}/business_lim");
				$myLimit = $myLimit + 1;
				$num = $myLimit * $config['business_rating'];

				if($row['user_rating'] >= $num AND $myLimit <= $config['business_rating_limit']){
				
					echo $row['user_rating'];
					
//* Отнимаем рейтинг у юзера *//
					
					$db->query("UPDATE `".PREFIX."_users` SET user_rating = user_rating - '{$num}' WHERE user_id = '{$user_id}'");

//* Добавляем лимит *//
					
					mozg_create_cache("user_{$user_id}/business_lim", $myLimit);
					
					mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				
				} else
					echo 1;
			
			}
			
			exit();
			
		break;

//* Страница покупки рублей *//
		
		case "payment_3":
			
			NoAjaxQuery();
			
			$owner = $db->super_query("SELECT user_balance, balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('balance/payment_3.tpl');
			
			if($user_info['user_photo']) $tpl->set('{ava}', "/uploads/users/{$user_info['user_id']}/50_{$user_info['user_photo']}");
			else $tpl->set('{ava}', "{theme}/images/no_ava_50.png");

			$tpl->set('{balance}', $owner['user_balance']);
			$tpl->set('{rub}', deColNums($owner['balance_rub']));
			$tpl->set('{cost}', $config['cost_balance2']);

			$tpl->compile('content');
			
			AjaxTpl();
			
			exit();
			
		break;
			
//* Завершение покупки голосов *//
		
		case "ok_payment_3":
			
			NoAjaxQuery();
			
			$num = intval($_POST['num']);
			if($num <= 0) $num = 0;
			
			$resCost = $num * $config['cost_balance2'];

//* Выводим тек. баланс юзера (руб.) *//
			
			$owner = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			if($owner['user_balance'] >= $resCost){
				
				$db->query("UPDATE `".PREFIX."_users` SET balance_rub = balance_rub + '{$num}', user_balance = user_balance - '{$resCost}' WHERE user_id = '{$user_id}'");

//* START / Записываем в историю *//
				
				$db->query("INSERT INTO `".PREFIX."_users_logs` SET user_id = '{$user_info['user_id']}', browser = '{$_BROWSER}', ip = '{$_IP}', act = '4', date = '{$server_time}', spent = '{$resCost}', for_user_id = '{$user_id}'");

			} else
				echo '1';
			
			exit();
			
		break;

//* Окно перевода микс *//
		
		case "transmitbox":
			
			NoAjaxQuery();
			
			$uid = intval($_POST['uid']);
			
			$owner = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('balance/transmitbox.tpl');
			
			if($user_info['user_photo']) $tpl->set('{ava}', "/uploads/users/{$user_info['user_id']}/50_{$user_info['user_photo']}");
			else $tpl->set('{ava}', "{theme}/images/no_ava_50.png");
			
			$tpl->set('{balance}', $owner['user_balance']);
			$tpl->set('{cost}', $config['cost_transmit']);
			$tpl->set('{user-id}', $uid);
			
			$tpl->compile('content');
			
			AjaxTpl();
			
			exit();
			
		break;
		
//* Делаем перевод *//
		
		case "get_transmit":
		
			NoAjaxQuery();
			
			$uid = intval($_POST['uid']);
			$num_mix = intval($_POST['num_mix']);
			if($num_mix <= 0) $num_mix = 0;
			
//* Выводим баланс *//
			
			$owner = $db->super_query("SELECT user_balance, balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
//* Проверка *//
			
			if($owner['balance_rub'] >= $config['cost_transmit'] AND $owner['user_balance'] >= $num_mix){
			
//* Списываем со счета юзера *//
				
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance - '{$num_mix}', balance_rub = balance_rub - '{$config['cost_transmit']}' WHERE user_id = '{$user_id}'");
			
//* Начисляем юзеру *//
				
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$num_mix}' WHERE user_id = '{$uid}'");
			
//* START / Записываем в историю отправителю *//
				
				$db->query("INSERT INTO `".PREFIX."_users_logs` SET user_id = '{$user_info['user_id']}', browser = '{$_BROWSER}', ip = '{$_IP}', act = '9', date = '{$server_time}', spent = '{$num_mix}', for_user_id = '{$uid}'");

//* Вставляем событие в моментальные оповещания *//
										
						$check = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$uid}'");
						$update_time = $server_time - 70;
						
						if($check['user_last_visit'] >= $update_time){
							if($check['user_sex'] == 2) 
							$action_update_text = "перевела Вам {$num_mix} голосов.";
					                                else $action_update_text = "перевел Вам {$num_mix} голосов.";
							
							$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$uid}', from_user_id = '{$user_id}', type = '14', date = '{$server_time}', text = '{$action_update_text}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}',  lnk = '/balance/main.tpl'");
						
							mozg_create_cache("user_{$uid}/updates", 1);
						
						}
				
			} else
				echo 1;
			
			exit();
		
		break;

		default:
		
//* Вывод текущего счета *//
			
			$owner = $db->super_query("SELECT user_balance, balance_rub, user_rating FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$tpl->load_template('balance/main.tpl');
            $tpl->set('{uid}', $user_id);
			$tpl->set('{ubm}', deColNums($owner['user_balance']));
			$tpl->set('{rub}', deColNums($owner['balance_rub']));
			$tpl->set('{text-rub}', declOfNum($owner['balance_rub'], array('рубль', 'рубля', 'рублей')));
			
			$rowFirst = $db->super_query("SELECT user_id, user_rating FROM `".PREFIX."_users` WHERE user_delet = 0 AND user_ban = 0 ORDER by `user_rating` DESC");
			
			if($owner['user_rating'] >= $config['money_rating'] AND $rowFirst['user_id'] == $user_id) $tpl->set('{msg}', 'Функция в разработке!');
			else $tpl->set('{msg}', 'Чтоб выводить деньги нужно быть на первом месте в поиске и иметь рейтинг выше '.$config['money_rating']);
			
			$tpl->compile('content');

	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>