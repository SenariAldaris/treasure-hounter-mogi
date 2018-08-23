<?php
/*========================================== 
	Appointment: Подписки
	File: subscriptions.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
		
//* Добавление юзера в подписки *// 
		
		case "add":
			$for_user_id = intval($_POST['for_user_id']);
			
//* Проверка на существование юзера в подписках *//
			
			$check = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$for_user_id}' AND subscriptions = 1");
			
//* ЧС *//
			
			$CheckBlackList = CheckBlackList($check['user_id']);
				
			if(!$CheckBlackList AND !$check AND $for_user_id != $user_id){
				$db->query("INSERT INTO `".PREFIX."_friends` SET user_id = '{$user_id}', friend_id = '{$for_user_id}', friends_date = NOW(), subscriptions = 1");
				$db->query("UPDATE `".PREFIX."_users` SET user_subscriptions_num = user_subscriptions_num+1 WHERE user_id = '{$user_id}'");
				
//* Вставляем событие в моментальные оповещания *//
							   
				$row_owner = $db->super_query("SELECT user_last_visit, user_sex FROM `".PREFIX."_users` WHERE user_id = '{$for_user_id}'");
				$update_time = $server_time - 70;
						
				if($row_owner['user_last_visit'] >= $update_time){
					
					$myRow = $db->super_query("SELECT user_sex, short_link FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
					
					if($myRow['user_sex'] == 1)
						$action_update_text = 'подписался на Ваши обновления.';
					else
						$action_update_text = 'подписалась на Ваши обновления.';


					if ($myRow['short_link'] != null && $myRow['short_link'] != 'empty') {
						$link = '/' . $myRow['short_link'];
					} else {
						$link = '/u' . $user_info['user_id'];
					}
							
					$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$for_user_id}', from_user_id = '{$user_info['user_id']}', type = '13', date = '{$server_time}', text = '{$action_update_text}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '{$link}'");
						
					mozg_create_cache("user_{$for_user_id}/updates", 1);
						
				}

//* Чистим кеш *//
				
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('subscr_user_'.$user_id);
				mozg_clear_cache_file('user_'.$del_user_id.'/subscr_num');
			}
		break;
		
//* Удаление юзера из подписок *// 
		
		case "del":
			$del_user_id = intval($_POST['del_user_id']);
			
//* Проверка на существование юзера в подписках *//
			
			$check = $db->super_query("SELECT user_id FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$del_user_id}' AND subscriptions = 1");
			if($check){
				$db->query("DELETE FROM `".PREFIX."_friends` WHERE user_id = '{$user_id}' AND friend_id = '{$del_user_id}' AND subscriptions = 1");
				$db->query("UPDATE `".PREFIX."_users` SET user_subscriptions_num = user_subscriptions_num-1 WHERE user_id = '{$user_id}'");
				
//* Чистим кеш *//
				
				mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
				mozg_clear_cache_file('subscr_user_'.$user_id);
				mozg_clear_cache_file('user_'.$del_user_id.'/subscr_num');
			}
		break;
		
//* Выводим список подписчиков *//
		
		case "all_user_subscr":
			
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 24;
			$limit_page = ($page-1)*$gcount;
			
			$for_user_id = intval($_POST['uid']);

			$sql_ = $db->super_query("SELECT tb1.friend_id, tb1.user_id, tb2.user_search_pref, user_photo, user_country_city_name, user_status FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.friend_id = '{$for_user_id}' AND tb2.user_id = tb1.user_id AND tb1.subscriptions = 1 ORDER by `friends_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
			
			$row_cnt_user_subcsr = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_friends` WHERE friend_id = '{$for_user_id}' AND subscriptions = 1", false, "user_{$id}/subscr_num");
			
			if($sql_){
			
				$tpl->load_template('profile_subscription_box_top.tpl');
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{subcr-num}', $row_cnt_user_subcsr['cnt'].' '.gram_record($row_cnt_user_subcsr['cnt'], 'subscr'));
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');
						
				$tpl->load_template('profile_friends.tpl');
				foreach($sql_ as $row){
				
					if($row['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
						
					$friend_info_online = explode(' ', $row['user_search_pref']);
					
					$tpl->set('{user-id}', $row['user_id']);
					$tpl->set('{name}', $friend_info_online[0]);
					$tpl->set('{last-name}', $friend_info_online[1]);
					
					$tpl->compile('content');
					
				}
				
				box_navigation($gcount, $row_cnt_user_subcsr['cnt'], $for_user_id, 'showUserSubcsr', $row_cnt_user_subcsr['cnt']);
				
			}
			
			AjaxTpl();
			
		break;

		default:
		
//* Показ всех подпискок юзера *//
			
			if($_POST['page'] > 0) $page = intval($_POST['page']); else $page = 1;
			$gcount = 24;
			$limit_page = ($page-1)*$gcount;
			$for_user_id = intval($_POST['for_user_id']);
			$subscr_num = intval($_POST['subscr_num']);
			
			$sql_ = $db->super_query("SELECT tb1.friend_id, tb2.user_search_pref, user_photo, user_country_city_name, user_status, short_link FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$for_user_id}' AND tb1.friend_id = tb2.user_id AND tb1.subscriptions = 1 ORDER by `friends_date` DESC LIMIT {$limit_page}, {$gcount}", 1);
			
			if($sql_){
				$tpl->load_template('profile_subscription_box_top.tpl');
				$tpl->set('[top]', '');
				$tpl->set('[/top]', '');
				$tpl->set('{subcr-num}', $subscr_num.' '.gram_record($subscr_num, 'subscr'));
				$tpl->set_block("'\\[bottom\\](.*?)\\[/bottom\\]'si","");
				$tpl->compile('content');
						
				$tpl->load_template('profile_friends.tpl');
				foreach($sql_ as $row){
					if($row['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['friend_id'].'/50_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
					$friend_info_online = explode(' ', $row['user_search_pref']);
					$tpl->set('{user-id}', $row['friend_id']);
					$tpl->set('{name}', $friend_info_online[0]);
					$tpl->set('{last-name}', $friend_info_online[1]);

					if ($row['short_link'] != null && $row['short_link'] != 'empty') {
						$link = '/' . $row['short_link'];
					} else {
						$link = '/u' . $row['friend_id'];
					}
					$tpl->set('{link}', $link);

					$tpl->compile('content');
				}
				box_navigation($gcount, $subscr_num, $for_user_id, 'subscriptions.all', $subscr_num);
			}
			AjaxTpl();
	}
	$tpl->clear();
	$db->free();
} else 
	echo 'no_log';

die();
?>
