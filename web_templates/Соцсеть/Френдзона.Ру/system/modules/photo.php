<?php
/*========================================= 
	Appointment: Просмотр фотографии
	File: photo.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];

	switch($act){
	
//* Добавления комментария *//
		
		case "addcomm":
			NoAjaxQuery();
			$pid = intval($_POST['pid']);
			$comment = ajax_utf8(textFilter($_POST['comment']));
			$date = date('Y-m-d H:i:s', $server_time);
			$hash = md5($user_id.$server_time.$_IP.$user_info['user_email'].rand(0, 1000000000)).$comment.$pid;
			
			$check_photo = $db->super_query("SELECT album_id, user_id, photo_name FROM `".PREFIX."_photos` WHERE id = '{$pid}'");

//* Проверка есть ли запрашиваемый юзер в друзьях у юзера который смотрит стр *//
			
			if($user_info['user_id'] != $check_photo['user_id']){
				$check_friend = CheckFriends($check_photo['user_id']);
				
				$row_album = $db->super_query("SELECT privacy FROM `".PREFIX."_albums` WHERE aid = '{$check_photo['album_id']}'");
				$album_privacy = explode('|', $row_album['privacy']);
			}
				
//* ЧС *//
			
			$CheckBlackList = CheckBlackList($check_photo['user_id']);
			
//* Проверка на существование фотки и приватность *//
			
			if(!$CheckBlackList AND $check_photo AND $album_privacy[1] == 1 OR $album_privacy[1] == 2 AND $check_friend OR $user_info['user_id'] == $check_photo['user_id']){
				$db->query("INSERT INTO `".PREFIX."_photos_comments` (pid, user_id, text, date, hash, album_id, owner_id, photo_name) VALUES ('{$pid}', '{$user_id}', '{$comment}', '{$date}', '{$hash}', '{$check_photo['album_id']}', '{$check_photo['user_id']}', '{$check_photo['photo_name']}')");
				$id = $db->insert_id();
				$db->query("UPDATE `".PREFIX."_photos` SET comm_num = comm_num+1 WHERE id = '{$pid}'");
				$db->query("UPDATE `".PREFIX."_albums` SET comm_num = comm_num+1 WHERE aid = '{$check_photo['album_id']}'");

				$date = langdate('сегодня в H:i', $server_time);
				$tpl->load_template('photo_comment.tpl');
				$tpl->set('{author}', $user_info['user_search_pref']);
				$tpl->set('{comment}', stripslashes($comment));
				$tpl->set('{uid}', $user_id);
				$tpl->set('{hash}', $hash);
				$tpl->set('{id}', $id);
				
				if($user_info['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$user_id.'/50_'.$user_info['user_photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
				
				$tpl->set('{online}', $lang['online']);
				$tpl->set('{date}', langdate('сегодня в H:i', $server_time));
				$tpl->set('[owner]', '');
				$tpl->set('[/owner]', '');
				$tpl->compile('content');
				
//* Добавляем действие в ленту новостей "ответы" владельцу фотографии *//
				
				if($user_id != $check_photo['user_id']){
					$comment = str_replace("|", "&#124;", $comment);
					$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 8, action_text = '{$comment}|{$check_photo['photo_name']}|{$pid}|{$check_photo['album_id']}', obj_id = '{$id}', for_user_id = '{$check_photo['user_id']}', action_time = '{$server_time}'");

//* Вставляем событие в моментальные оповещания *//
					
					$row_userOW = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$check_photo['user_id']}'");
					$update_time = $server_time - 70;
									
					if($row_userOW['user_last_visit'] >= $update_time){
									
						$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$check_photo['user_id']}', from_user_id = '{$user_id}', type = '2', date = '{$server_time}', text = '{$comment}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/photo{$check_photo['user_id']}_{$pid}_{$check_photo['album_id']}'");
									
						mozg_create_cache("user_{$check_photo['user_id']}/updates", 1);
						
//* ИНАЧЕ Добавляем +1 юзеру для оповещания *//
					
					} else {
					
//* Добавляем +1 юзеру для оповещания *//
						
						$cntCacheNews = mozg_cache('user_'.$check_photo['user_id'].'/new_news');
						mozg_create_cache('user_'.$check_photo['user_id'].'/new_news', ($cntCacheNews+1));
					
					}
									
//* Отправка уведомления на E-mail *//
					
					if($config['news_mail_4'] == 'yes'){
						$rowUserEmail = $db->super_query("SELECT user_name, user_email, notify FROM `".PREFIX."_users` WHERE user_id = '".$check_photo['user_id']."'");
						$EMAIL_block_data = xfieldsdataload($rowUserEmail['notify']);
						if($rowUserEmail['user_email'] AND $EMAIL_block_data['n_comm_ph']){
							include_once ENGINE_DIR.'/classes/mail.php';
							$mail = new dle_mail($config);
							$rowMyInfo = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$user_id."'");
							$rowEmailTpl = $db->super_query("SELECT text FROM `".PREFIX."_mail_tpl` WHERE id = '4'");
							$rowEmailTpl['text'] = str_replace('{%user%}', $rowUserEmail['user_name'], $rowEmailTpl['text']);
							$rowEmailTpl['text'] = str_replace('{%user-friend%}', $rowMyInfo['user_search_pref'], $rowEmailTpl['text']);
							$rowEmailTpl['text'] = str_replace('{%rec-link%}', $config['home_url'].'photo'.$check_photo['user_id'].'_'.$vid.'_'.$check_photo['album_id'], $rowEmailTpl['text']);
							$mail->send($rowUserEmail['user_email'], 'Новый комментарий к Вашей фотографии', $rowEmailTpl['text']);
						}
					}
				}
				
//* Чистим кеш кол-во комментов *//
				
				mozg_mass_clear_cache_file("user_{$check_photo['user_id']}/albums_{$check_photo['user_id']}_comm|user_{$check_photo['user_id']}/albums_{$check_photo['user_id']}_comm_all|user_{$check_photo['user_id']}/albums_{$check_photo['user_id']}_comm_friends");

				AjaxTpl();
			} else
				echo 'err_privacy';
		break;
		
//* Удаление комментария *//
		
		case "del_comm":
			NoAjaxQuery();
			$hash = $db->safesql(substr($_POST['hash'], 0, 32));
			$check_comment = $db->super_query("SELECT id, pid, album_id, owner_id FROM `".PREFIX."_photos_comments` WHERE hash = '{$hash}'");
			if($check_comment){
				$db->query("DELETE FROM `".PREFIX."_photos_comments` WHERE hash = '{$hash}'");
				$db->query("DELETE FROM `".PREFIX."_news` WHERE obj_id = '{$check_comment['id']}' AND action_type = 8");
				$db->query("UPDATE `".PREFIX."_photos` SET comm_num = comm_num-1 WHERE id = '{$check_comment['pid']}'");
				$db->query("UPDATE `".PREFIX."_albums` SET comm_num = comm_num-1 WHERE aid = '{$check_comment['album_id']}'");
				
//* Чистим кеш кол-во комментов *//
				
				mozg_mass_clear_cache_file("user_{$check_comment['owner_id']}/albums_{$check_comment['owner_id']}_comm|user_{$check_comment['owner_id']}/albums_{$check_comment['owner_id']}_comm_all|user_{$check_comment['owner_id']}/albums_{$check_comment['owner_id']}_comm_friends");
			}
			die();
		break;
		
//* Помещение фотографии на свою страницу *//
		
		case "crop":
			NoAjaxQuery();
			$pid = intval($_POST['pid']);
			$i_left = intval($_POST['i_left']);
			$i_top = intval($_POST['i_top']);
			$i_width = intval($_POST['i_width']);
			$i_height = intval($_POST['i_height']);
			$check_photo = $db->super_query("SELECT photo_name, album_id FROM `".PREFIX."_photos` WHERE id = '{$pid}' AND user_id = '{$user_id}'");
			if($check_photo AND $i_width >= 100 AND $i_height >= 100 AND $i_left >= 0 AND $i_height >= 0){
				$imgInfo = explode('.', $check_photo['photo_name']);
				$newName = substr(md5($server_time.$check_photo['check_photo']), 0, 15).".".$imgInfo[1];
				$newDir = ROOT_DIR."/uploads/users/{$user_id}/";
				
				include ENGINE_DIR.'/classes/images.php';
				
//* Создаём оригинал *//
				
				$tmb = new thumbnail(ROOT_DIR."/uploads/users/{$user_id}/albums/{$check_photo['album_id']}/{$check_photo['photo_name']}");
				$tmb->size_auto($i_width."x".$i_height, 0, "{$i_left}|{$i_top}");
				$tmb->jpeg_quality(90);
				$tmb->save($newDir."o_{$newName}");
				
//* Создание главной фотографии *//
				
				$tmb = new thumbnail($newDir."o_{$newName}");
				$tmb->size_auto(200, 1);
				$tmb->jpeg_quality(100);
				$tmb->save($newDir.$newName);
				
//* Создание уменьшеной копии 50х50 *//
				
				$tmb = new thumbnail($newDir."o_{$newName}");
				$tmb->size_auto('50x50');
				$tmb->jpeg_quality(100);
				$tmb->save($newDir.'50_'.$newName);
				
//* Создание уменьшеной копии 100х100 *//
				
				$tmb = new thumbnail($newDir."o_{$newName}");
				$tmb->size_auto('100x100');
				$tmb->jpeg_quality(100);
				$tmb->save($newDir.'100_'.$newName);

//* Добавляем на стену *//
				
				$row = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
				if($row['user_sex'] == 2)
					$sex_text = 'обновила';
				else
					$sex_text = 'обновил';
						
				$wall_text = "<div class=\"profile_update_photo\"><a href=\"\" onClick=\"Photo.Profile(\'{$user_id}\', \'{$newName}\'); return false\"><img src=\"/uploads/users/{$user_id}/o_{$newName}\" style=\"margin-top:3px\"></a></div>";
						
				$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '{$wall_text}', add_date = '{$server_time}', type = '{$sex_text} фотографию на странице:'");
				$dbid = $db->insert_id();
						
				$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");
						
//* Добавляем в ленту новостей *//
				
				$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '{$wall_text}', obj_id = '{$dbid}', action_time = '{$server_time}'");
						
//* Обновляем имя фотки в базу данных *//
				
				$db->query("UPDATE `".PREFIX."_users` SET user_photo = '{$newName}', user_wall_id = '{$dbid}' WHERE user_id = '{$user_id}'");
				
				mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				mozg_clear_cache();
			}
			die();
		break;
		
//* Показ всех комментариев *//
		
		case "all_comm":
			NoAjaxQuery();
			$pid = intval($_POST['pid']);
			$num = intval($_POST['num']);
			if($num > 7){
					$limit = $num-3;
					$sql_comm = $db->super_query("SELECT tb1.user_id,text,date,id,hash,pid, tb2.user_search_pref, user_photo, user_last_visit, user_logged_mobile FROM `".PREFIX."_photos_comments` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.pid = '{$pid}' ORDER by `date` ASC LIMIT 0, {$limit}", 1);
					
					$tpl->load_template('photo_comment.tpl');
					foreach($sql_comm as $row_comm){
						$tpl->set('{comment}', stripslashes($row_comm['text']));
						$tpl->set('{uid}', $row_comm['user_id']);
						$tpl->set('{id}', $row_comm['id']);
						$tpl->set('{hash}', $row_comm['hash']);
						$tpl->set('{author}', $row_comm['user_search_pref']);
						
						if($row_comm['user_photo'])
							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comm['user_id'].'/50_'.$row_comm['user_photo']);
						else
							$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						

						OnlineTpl($row_comm['user_last_visit'], $row_comm['user_logged_mobile']);
						megaDate(strtotime($row_comm['date']));
							
						$row_photo = $db->super_query("SELECT user_id FROM `".PREFIX."_photos` WHERE id = '{$row_comm['pid']}'");
						
						if($row_comm['user_id'] == $user_info['user_id'] OR $row_photo['user_id'] == $user_info['user_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
						} else
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					
						$tpl->compile('content');
					}
				AjaxTpl();
			}
		break;
		
//* Просмотр простой фотографии не из альбома *//
		
		case "profile":
			$uid = intval($_POST['uid']);
			
			if($_POST['type'])
				$photo = ROOT_DIR."/uploads/attach/{$uid}/c_{$_POST['photo']}";
			else
				$photo = ROOT_DIR."/uploads/users/{$uid}/o_{$_POST['photo']}";
			
			if(file_exists($photo)){
				$tpl->load_template('photos/photo_profile.tpl');
				$tpl->set('{uid}', $uid);
				if($_POST['type'])
					$tpl->set('{photo}', "/uploads/attach/{$uid}/{$_POST['photo']}");
				else
					$tpl->set('{photo}', "/uploads/users/{$uid}/o_{$_POST['photo']}");
				$tpl->set('{close-link}', $_POST['close_link']);
				$tpl->compile('content');
				AjaxTpl();
			} else
				echo 'no_photo';
		break;
		
//* Поворот фотографии *//
		
		case "rotation":
			$id = intval($_POST['id']);
			$row = $db->super_query("SELECT photo_name, album_id, user_id FROM `".PREFIX."_photos` WHERE id = '".$id."'");
			
			if($row['photo_name'] AND $_POST['pos'] == 'left' OR $_POST['pos'] == 'right' AND $user_id == $row['user_id']){
				$filename = ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name'];

				if($_POST['pos'] == 'right') $degrees = -90;
				if($_POST['pos'] == 'left') $degrees = 90;

				$source = imagecreatefromjpeg($filename);
				$rotate = imagerotate($source, $degrees, 0);

				imagejpeg($rotate, ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name'], 93);

//* Подключаем класс для фотографий *//
				
				include ENGINE_DIR.'/classes/images.php';
				
//* Создание маленькой копии *//
				
				$tmb = new thumbnail(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name']);
				$tmb->size_auto('140x100');
				$tmb->jpeg_quality('100');
				$tmb->save(ROOT_DIR.'/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/c_'.$row['photo_name']);
								
				echo '/uploads/users/'.$user_id.'/albums/'.$row['album_id'].'/'.$row['photo_name'];
			}
		break;
		
//* Ставим лайк *//
		
		case "like":
			
			$pid = intval($_POST['pid']);
			
//* Проверка на существование записи *//
			
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_photos` WHERE id = '{$pid}'");
			if($row){
			
//* Проверка на то что этот юзер ставил уже мне нрав или нет *//
				
				$likes_users = explode('|', str_replace('u', '', $row['likes_users']));
				
				if(!in_array($user_id, $likes_users)){
				
					$db->query("INSERT INTO `".PREFIX."_photos_like` SET pid = '{$pid}', uid = '{$user_id}', date = '{$server_time}'");

					$db->query("UPDATE `".PREFIX."_photos` SET likes_num = likes_num+1, likes_users = '|u{$user_id}|{$row['likes_users']}' WHERE id = '{$pid}'");
	
				}
				
			}
			
			exit;
			
		break;
		
//* Убераем лайк *//
			
		case "dislike":
			
			$pid = intval($_POST['pid']);
			
//* Проверка на существование записи *//
			
			$row = $db->super_query("SELECT likes_users FROM `".PREFIX."_photos` WHERE id = '{$pid}'");
			if($row){
			
//* Проверка на то что этот юзер ставил уже мне нрав или нет *//
				
				$likes_users = explode('|', str_replace('u', '', $row['likes_users']));
				
				if(in_array($user_id, $likes_users)){
				
					$db->query("DELETE FROM `".PREFIX."_photos_like` WHERE pid = '{$pid}' AND uid = '{$user_id}'");
					
					$newListLikesUsers = strtr($row['likes_users'], array('|u'.$user_id.'|' => ''));
					
					$db->query("UPDATE `".PREFIX."_photos` SET likes_num = likes_num-1, likes_users = '{$newListLikesUsers}' WHERE id = '{$pid}'");
	
				}
				
			}
			
			exit;
			
		break;

		default:
		
//* Просмотр фотографии *//
			
			NoAjaxQuery();
			$user_id = intval($_POST['uid']);
			$photo_id = intval($_POST['pid']);
			$fuser = intval($_POST['fuser']);
			$section = $_POST['section'];

//* ЧС *//
			
			$CheckBlackList = CheckBlackList($user_id);
			if(!$CheckBlackList){
			
//* Получаем ID альбома *//
				
				$check_album = $db->super_query("SELECT album_id FROM `".PREFIX."_photos` WHERE id = '{$photo_id}'");

//* Если фотография вызвана не со стены *//
				
				if(!$fuser AND $check_album){
				
//* Проверяем на наличии файла к позициям только для этих фоток *//
					
					$check_pos = mozg_cache('user_'.$user_id.'/position_photos_album_'.$check_album['album_id']);
		 
//* Если нету, то вызываем функцию генерации *//
					
					if(!$check_pos){
						GenerateAlbumPhotosPosition($user_id, $check_album['album_id']);
						$check_pos = mozg_cache('user_'.$user_id.'/position_photos_album_'.$check_album['album_id']);
					}
						
					$position = xfieldsdataload($check_pos);
				}

				$row = $db->super_query("SELECT tb1.id, photo_name, likes_num, likes_users, user_photo, comm_num, descr, date, position, rating_num, rating_all, rating_max, tb2.user_id, user_search_pref, user_country_city_name, short_link FROM `".PREFIX."_photos` tb1, `".PREFIX."_users` tb2 WHERE id = '{$photo_id}' AND tb1.user_id = tb2.user_id");
                
				if($row){
				
//* Вывод названия альбома, приватность из базы данных *//
					
					$info_album = $db->super_query("SELECT name, photo_num, aid, photo_num, cover,  privacy FROM `".PREFIX."_albums` WHERE aid = '{$check_album['album_id']}'");
					$album_privacy = explode('|', $info_album['privacy']);
					
//* Проверка есть ли запрашиваемый юзер в друзьях у юзера который смотрит стр *//
					
					if($user_info['user_id'] != $row['user_id'])
						$check_friend = CheckFriends($row['user_id']);

//* Приватность *//
					
					if($album_privacy[0] == 1 OR $album_privacy[0] == 2 AND $check_friend OR $user_info['user_id'] == $row['user_id']){
				
//* Если фотография вызвана не со стены *//
						
						if(!$fuser){
							$exp_photo_num = count(explode('||', $check_pos));
							$row_album['photo_num'] = $exp_photo_num-1;
						}

//* Выводим комментарии если они есть *//
						
						if($row['comm_num'] > 0){

							$tpl->load_template('photo_comment.tpl');
								
							if($row['comm_num'] > 7)
								$limit_comm = $row['comm_num']-3;
							else
								$limit_comm = 0;
								
							$sql_comm = $db->super_query("SELECT tb1.user_id,text,date,id,hash, tb2.user_search_pref, user_photo, user_last_visit, user_logged_mobile FROM `".PREFIX."_photos_comments` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id AND tb1.pid = '{$photo_id}' ORDER by `date` ASC LIMIT {$limit_comm}, {$row['comm_num']}", 1);
							foreach($sql_comm as $row_comm){
								$tpl->set('{comment}', stripslashes($row_comm['text']));
								$tpl->set('{uid}', $row_comm['user_id']);
								$tpl->set('{id}', $row_comm['id']);
								$tpl->set('{hash}', $row_comm['hash']);
								$tpl->set('{author}', $row_comm['user_search_pref']);
									
								if($row_comm['user_photo'])
									$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_comm['user_id'].'/50_'.$row_comm['user_photo']);
								else
									$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
										
								OnlineTpl($row_comm['user_last_visit'], $row_comm['user_logged_mobile']);
								megaDate(strtotime($row_comm['date']));
									
								if($row_comm['user_id'] == $user_info['user_id'] OR $row['user_id'] == $user_info['user_id']){
									$tpl->set('[owner]', '');
									$tpl->set('[/owner]', '');
								} else 
									$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
							
								$tpl->compile('comments');
							}
						}

//* Сама фотография *//
						
						$tpl->load_template('photo_view.tpl');
						$tpl->set('{photo}', $config['home_url'].'uploads/users/'.$row['user_id'].'/albums/'.$check_album['album_id'].'/'.$row['photo_name'].'?'.$server_time);
						$sizephoto = getimagesize(ROOT_DIR.'/uploads/users/'.$row['user_id'].'/albums/'.$check_album['album_id'].'/'.$row['photo_name']);
						$tpl->set('{height}', $sizephoto[1]);
						$tpl->set('{descr}', stripslashes($row['descr']));
						$tpl->set('{photo-num}', $row_album['photo_num']);
						$tpl->set('{id}', $row['id']);
						$tpl->set('{aid}', $check_album['album_id']);
						$tpl->set('{album-name}', stripslashes($info_album['name']));
						$tpl->set('{uid}', $row['user_id']);
                        $tpl->set('{photo-num}', $info_album['photo_num'].' '.gram_record($info_album['photo_num'], 'photos'));
							if($info_album['cover'])
									$tpl->set('{cover}', $config['home_url'].'uploads/users/'.$user_id.'/albums/'.$info_album['aid'].'/c_'.$info_album['cover']);
								else
									$tpl->set('{cover}', '{theme}/images/no_cover.png');
						
//* Аватарка *//
						
			if($user_info['user_photo']){
				$tpl->set('{ava_comsw}', $config['home_url'].'uploads/users/'.$user_info['user_id'].'/50_'.$avaPREFver.$user_info['user_photo']);
				$tpl->set('{display-ava}', 'style="display:block;"');
			} else {
				$tpl->set('{ava}', '/templates/Old/images/'.$noAvaPrf);
				$tpl->set('{ava_comsw}', '/templates/Old/images/no_ava.gif');
				$tpl->set('{display-ava}', 'style="display:none;"');
			}
			
//* Аватарка *//
												
			if($row['user_photo']){
				$tpl->set('{ava_autor}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$avaPREFver.$row['user_photo']);
			} else {
				$tpl->set('{ava_autor}', '/templates/Old/images/no_ava.gif');
			}
						
//* Составляем адрес строки который будет после закрытия и определяем секцию *//
						
						if($section == 'all_comments'){
							$tpl->set('{close-link}', '/albums/comments/'.$row['user_id']);
							$tpl->set('{section}', '_sec=all_comments');
						} elseif($section == 'album_comments'){
							$tpl->set('{close-link}', '/albums/view/'.$check_album['album_id'].'/comments/');
							$tpl->set('{section}', '_'.$check_album['album_id'].'_sec=album_comments');
						} elseif($section == 'user_page'){
							if ($row['short_link'] != null && $row['short_link'] != 'empty') {
								$link = '/' . $row['short_link'];
							} else {
								$link = '/u' . $row['user_id'];
							}
							$tpl->set('{close-link}', $link);
							$tpl->set('{section}', '_sec=user_page');
						} elseif($section == 'wall'){
							$sl = $db->super_query("SELECT short_link FROM `".PREFIX."_users` WHERE `user_id` = '{$fuser}'");
							if ($sl['short_link'] != null && $sl['short_link'] != 'empty') {
								$link = '/' . $sl['short_link'];
							} else {
								$link = '/u' . $fuser;
							}
							$tpl->set('{close-link}', $link);
							$tpl->set('{section}', '_sec=wall/fuser='.$fuser);
						} elseif($section == 'notes'){
							$tpl->set('{close-link}', '/notes/view/'.$fuser);
							$tpl->set('{section}', '_sec=notes/id='.$fuser);
						} elseif($section == 'loaded'){
							$tpl->set('{close-link}', '/albums/add/'.$check_album['album_id']);
							$tpl->set('{section}', '_sec=loaded');
						} elseif($section == 'news'){
							$fuser = 1;
							$tpl->set('{close-link}', '/news');
							$tpl->set('{section}', '_sec=news');
						} elseif($section == 'msg'){
							$tpl->set('{close-link}', '/messages/show/'.$fuser);
							$tpl->set('{section}', '_sec=msg');
						} elseif($section == 'newphotos'){
							$tpl->set('{close-link}', '/albums/newphotos');
							$tpl->set('{section}', '_'.$check_album['album_id'].'_sec=newphotos');
						} else {
							$tpl->set('{close-link}', '/albums/view/'.$check_album['album_id']);
							$tpl->set('{section}', '_'.$check_album['album_id']);
						}
							
						if(!$fuser){
							$tpl->set('[all]', '');
							$tpl->set('[/all]', '');
							$tpl->set_block("'\\[wall\\](.*?)\\[/wall\\]'si","");
						} else {
							$tpl->set('[wall]', '');
							$tpl->set('[/wall]', '');
							$tpl->set_block("'\\[all\\](.*?)\\[/all\\]'si","");
						}
											
						$tpl->set('{jid}', $row['position']);
						$tpl->set('{comm_num}', ($row['comm_num']-3).' '.gram_record(($row['comm_num']-3), 'comments'));
						$tpl->set('{num}', $row['comm_num']);

						$tpl->set('{author}', $row['user_search_pref']);
						$author_info = explode('|', $row['user_country_city_name']);
															
						if($author_info[0]) $tpl->set('{author-info}', $author_info[0]); 
						else $tpl->set('{author-info}', '');
						if($author_info[1]) $tpl->set('{author-info}', $author_info[0].', '.$author_info[1].'<br />');
                         foreach($sql_ as $row){
						 
//* Аватарка *//
						
			if($row['user_photo']){
				$tpl->set('{ava_author}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$avaPREFver.$row['user_photo']);
				$tpl->set('{display-ava}', 'style="display:block;"');
			} else {
				$tpl->set('{ava_author}', '/templates/Old/images/no_ava.gif'.$noAvaPrf);
				$tpl->set('{display-ava}', 'style="display:none;"');
			}
			}
						megaDate(strtotime($row['date']), 1, 1);

						if($user_id == $user_info['user_id']){
							$tpl->set('[owner]', '');
							$tpl->set('[/owner]', '');
							$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
						} else {
							$tpl->set('[not-owner]', '');
							$tpl->set('[/not-owner]', '');
							$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
						}

				if($row['comm_num'] > 0){
				$tpl->set_block("'\\[sinfos\\](.*?)\\[/sinfos\\]'si","");
			} else 
				$tpl->set('[sinfos]', '');
				$tpl->set('[/sinfos]', '');
				
				if($row['descr']){
				$tpl->set('[no-descr]', '');
				$tpl->set('[/no-descr]', '');
			} else 
			$tpl->set_block("'\\[no-descr\\](.*?)\\[/no-descr\\]'si","");

						$tpl->set('{comments}', $tpl->result['comments']);
						
//* Показываем стрелочки если фотографий больше одной и фотография вызвана не со стены *//
						
						if($row_album['photo_num'] > 1 && !$fuser){
							
//* Если фотография вызвана из альбома "все фотографии" или вызвана со страницы юзера *//
							
							if($row['position'] == $row_album['photo_num'])
								$next_photo = $position[1];
							else
								$next_photo = $position[($row['position']+1)];
									
							if($row['position'] == 1)
								$prev_photo = $position[($row['position']+$row_album['photo_num']-1)];
							else
								$prev_photo = $position[($row['position']-1)];

							$tpl->set('{next-id}', $next_photo);
							$tpl->set('{prev-id}', $prev_photo);
						} else {
							$tpl->set('{next-id}', $row['id']);
							$tpl->set('{prev-id}', $row['id']);
						}

						if($row['comm_num'] < 8){
							$tpl->set_block("'\\[all-comm\\](.*?)\\[/all-comm\\]'si","");
						} else {
							$tpl->set('[all-comm]', '');
							$tpl->set('[/all-comm]', '');
						}
							
//* Приватность комментариев *//
						
						if($album_privacy[1] == 1 OR $album_privacy[1] == 2 AND $check_friend OR $user_info['user_id'] == $row['user_id']){
							$tpl->set('[add-comm]', '');
							$tpl->set('[/add-comm]', '');
						} else
							$tpl->set_block("'\\[add-comm\\](.*?)\\[/add-comm\\]'si","");
							
//* Выводим отмеченных людей на фото если они есть *//
						
						$sql_mark = $db->super_query("SELECT muser_id, mphoto_name, msettings_pos, mmark_user_id, mapprove, short_link FROM `".PREFIX."_photos_mark` tb1, `".PREFIX."_users` tb2 WHERE tb1.mphoto_id = '".$photo_id."' AND tb2.user_id = tb1.muser_id ORDER by `mdate` ASC", 1, 'photos_mark/p'.$photo_id);
						if($sql_mark){
							$cnt_mark = 0;
							$mark_peoples .= '<div class="fl_l" id="peopleOnPhotoText'.$photo_id.'" style="margin-right:5px">На этой фотографии:</div>';
							foreach($sql_mark as $row_mark){
								$cnt_mark++;
								
								if($cnt_mark != 1) $comma = ', ';
								else $comma = '';

								if($row_mark['muser_id'] AND $row_mark['mphoto_name'] == ''){
									if($row['user_id'] == $user_info['user_id'] OR $user_info['user_id'] == $row_mark['muser_id'] OR $user_info['user_id'] == $row_mark['mmark_user_id'])
										$del_mark_link = '<div class="fl_l"><img src="/templates/Old/images/hide_lef.gif" class="distin_del_user" title="Удалить отметку" onclick="Distinguish.DeletUser('.$row_mark['muser_id'].', '.$photo_id.')"/></div>';
									else
										$del_mark_link = '';
										
									$row_user = $db->super_query("SELECT user_search_pref FROM `".PREFIX."_users` WHERE user_id = '".$row_mark['muser_id']."'");
									
									if($row_mark['mapprove'] OR $row['user_id'] == $user_info['user_id'] OR $user_info['user_id'] == $row_mark['mmark_user_id'] OR $row_mark['muser_id'] == $user_info['user_id']){
										if ($row_mark['short_link'] != null && $row_mark['short_link'] != 'empty') {
											$link = '/' . $row_mark['short_link'];
										} else {
											$link = '/u' . $row_mark['muser_id'];
										}
										$user_link = '<a href="'.$link.'" id="selected_us_'.$row_mark['muser_id'].$photo_id.'" onclick="Page.Go(this.href); return false" onmouseover="Distinguish.ShowTag('.$row_mark['msettings_pos'].', '.$photo_id.')" onmouseout="Distinguish.HideTag('.$photo_id.')" class="one_dis_user'.$photo_id.'">';
										$user_link_end = '</a>';
									} else {
										$user_link = '<span style="color:#000" id="selected_us_'.$row_mark['muser_id'].$photo_id.'" onmouseover="Distinguish.ShowTag('.$row_mark['msettings_pos'].', '.$photo_id.')" onmouseout="Distinguish.HideTag('.$photo_id.')" class="one_dis_user'.$photo_id.'">';
										$user_link_end = '</span>';
									}
									
									$mark_peoples .= '<span id="selectedDivIser'.$row_mark['muser_id'].$photo_id.'"><div class="fl_l" style="margin-right:4px">'.$comma.'</div><div class="fl_l"> '.$user_link.$row_user['user_search_pref'].$user_link_end.'</div>'.$del_mark_link.'</span>';
								} else {
									if($row['user_id'] == $user_info['user_id'] OR $user_info['user_id'] == $row_mark['mmark_user_id'])
										$del_mark_link = '<div class="fl_l"><img src="/templates/Old/images/hide_lef.gif" class="distin_del_user" title="Удалить отметку" onclick="Distinguish.DeletUser('.$row_mark['muser_id'].', '.$photo_id.', \''.$row_mark['mphoto_name'].'\')"/></div>';
									else
										$del_mark_link = '';
										
									$mark_peoples .= '<span id="selectedDivIser'.$row_mark['muser_id'].$photo_id.'"><div class="fl_l" style="margin-right:4px">'.$comma.'</div><div class="fl_l"><span style="color:#000" id="selected_us_'.$row_mark['muser_id'].$photo_id.'" onmouseover="Distinguish.ShowTag('.$row_mark['msettings_pos'].', '.$photo_id.')" onmouseout="Distinguish.HideTag('.$photo_id.')" class="one_dis_user'.$photo_id.'">'.$row_mark['mphoto_name'].'</span></div>'.$del_mark_link.'</span>';
								}
								
//* Если человек отмечен но не подтвердил *//
								
								if(!$row_mark['mapprove'] AND $row_mark['muser_id'] == $user_info['user_id']){
									$row_mmark_user_id = $db->super_query("SELECT user_search_pref, user_sex FROM `".PREFIX."_users` WHERE user_id = '".$row_mark['mmark_user_id']."'");
									if($row_mmark_user_id['user_sex'] == 1) $approve_mark_gram_text = 'отметил';
									else $approve_mark_gram_text = 'отметила';
									$approve_mark = $row_mmark_user_id['user_search_pref'];
									$approve_mark_user_id = $row_mark['mmark_user_id'];
									$approve_mark_del_link = 'Distinguish.DeletUser('.$row_mark['muser_id'].', '.$photo_id.', \''.$row_mark['mphoto_name'].'\')';
								} else {
									$approve_mark = '';
									$approve_mark_gram_text = '';
									$approve_mark_user_id = '';
								}
							}
						}
						$tpl->set('{mark-peoples}', $mark_peoples);
						if($approve_mark){
							$tpl->set('{mark-user-name}', $approve_mark);
							$tpl->set('{mark-gram-text}', $approve_mark_gram_text);
							$tpl->set('{mark-user-id}', $approve_mark_user_id);
							$tpl->set('{mark-del-link}', $approve_mark_del_link);
							$tpl->set('[mark-block]', '');
							$tpl->set('[/mark-block]', '');
						} else
							$tpl->set_block("'\\[mark-block\\](.*?)\\[/mark-block\\]'si","");
					
					if($row['likes_num']) $tpl->set('{likes-num}', $row['likes_num']);
						else $tpl->set('{likes-num}', '');
						if(stripos($row['likes_users'], "|u{$user_info['user_id']}|") !== false){
							$tpl->set('{likes-func}', 'dislike');
							$tpl->set('{likes-color}', '#bad4eb');
						} else {
							$tpl->set('{likes-func}', 'like');
							$tpl->set('{likes-color}', '#a1c4e4');
						}
					
					
//* Проверка ставил человек на это фото уже оценку или нет *//
						
						$check = $db->super_query("SELECT rating FROM `".PREFIX."_photos_rating` WHERE user_id = '{$user_info['user_id']}' AND photo_id = '{$photo_id}'");
						if($check['rating']){
						
							$tpl->set('{rate-check}', 'no_display');
							$tpl->set('{rate-check-2}', '');
							if($check['rating'] == 1) $tpl->set('{ok-rate}', '<div class="rating rating3" style="background:url(\'{theme}/images/rating3.png\')">'.$check['rating'].'</div>');
							else if($check['rating'] == 8) $tpl->set('{ok-rate}', '<div class="rating rating3"  style="background:url(\'{theme}/images/rating2.png\')">7+</div>');
							else $tpl->set('{ok-rate}', '<div class="rating rating3">'.$check['rating'].'</div>');
							 
						} else {
						
							$tpl->set('{rate-check-2}', 'no_display');
							$tpl->set('{rate-check}', '');
							
						}
			
						$tpl->set('{rate-all}', $row['rating_all']);
						$tpl->set('{rate-max}', $row['rating_max']);
						$rate = $row['rating_num'] / $row['rating_all'];
						$rate = round($rate, 2);
						if($rate > 7) $rate = '7+';
						$tpl->set('{rate}', $rate);

						$tpl->compile('content');
							
						AjaxTpl();
							
						if($config['gzip'] == 'yes')
							GzipOut();
					} else
						echo 'err_privacy';
				} else
					echo 'no_photo';
			} else
				echo 'err_privacy';
	}
	$tpl->clear();
	$db->free();
} else
	echo 'no_photo';

die();
?>
