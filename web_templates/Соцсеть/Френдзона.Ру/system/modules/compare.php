<?php
/*========================================= 
	Appointment: Фото дуэли
	File: compare.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$user_speedbar = $lang['blog_descr'];	

	function like_list($unit='0', $type='0', $sort, $limit) {
	  global $db, $user_info;

		$like_query="	select user_id, user_name, user_search_pref, user_country_city_name, user_photo, like_status";
		$like_query.="  from `".PREFIX."_compare` ";

		if($unit == 0){

			$like_query.="  LEFT JOIN `".PREFIX."_users` ON like_user_id=user_id ";
			$like_query.="  WHERE like_authoruser_id='".$user_info['user_id']."' ";

			if($type == 1)   
				$like_query.="  AND like_status='1' ";

		}else{

			$like_query.="  LEFT JOIN `".PREFIX."_users` ON like_authoruser_id=user_id ";
			$like_query.="  WHERE like_user_id='".$user_info['user_id']."' ";

		}

		$like_query.="  ORDER by $sort ";
		$like_query.="  LIMIT $limit ";

	  return $db->super_query($like_query,1);
	}


	switch($act){
		
//* Страница добавления *// 
		
		case "choose":
				$tpl->load_template('compare/head.tpl');
				$out = $_GET['out'];
				if($out == 1){
					$tpl->set('{activetab-3}', 'activetab');
				} elseif ($out == 2){
					$tpl->set('{activetab-4}', 'activetab');
				} else {
					$tpl->set('{activetab-2}', 'activetab');
				}
					$count1 = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_authoruser_id='".$user_info['user_id']."'");
				$count2 = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_user_id='".$user_info['user_id']."'");
				$count3 = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_authoruser_id='".$user_info['user_id']."' AND like_status='1'");

                 				$tpl->set('{cnt-1}', $count1['cnt']);
				$tpl->set('{cnt-2}', $count2['cnt']);
				$tpl->set('{cnt-3}', $count3['cnt']);
				$tpl->set_block("'\\[main\\](.*?)\\[/main\\]'si","");
				$tpl->compile('content');
					
				if($out == '1'){
					$likes = like_list(1,0,"like_date DESC",500);
				} elseif($out == '2'){
					$likes = like_list(0,1,"like_date DESC",500);
				} else {
					$likes = like_list(0,0,"like_date DESC",500);
				}
				$tpl->load_template('compare/chooseUser.tpl');

				foreach($likes as $row){
					if($out == 1){
						if($row['like_status'] == 1){
							$tpl->set('[status]', '');
							$tpl->set('[/status]', '');
						}else{
							$tpl->set_block("'\\[status\\](.*?)\\[/status\\]'si","");
							$row['user_search_pref'] = '<a>&nbsp;&nbsp;&nbsp;Аноним</a>';
							$row['user_country_city_name'] = '';
						}
					}else{

						$tpl->set('[status]', '');
						$tpl->set('[/status]', '');
					}
				
					$user_country_city_name = explode('|', $row['user_country_city_name']);
					$tpl->set('{country}', $user_country_city_name[0]);
					
					if($user_country_city_name[1])
						$tpl->set('{city}', ', '.$user_country_city_name[1]);
					else
						$tpl->set('{city}', '');

					$tpl->set('{user-id}', $row['user_id']);
					$tpl->set('{name}', $row['user_search_pref']);
					
					if($row['user_photo'])
						$tpl->set('{ava}', '/uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '/images/100_no_ava.png');
					
//* Возраст юзера *//
					
					$user_birthday = explode('-', $row['user_birthday']);
					$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
					
					OnlineTpl($row['user_last_visit']);
					$tpl->compile('content');
				}
				
		break;
		
//* Страница добавления *// 
		
		case "send":
		
			$rid = intval($_POST['rid']);
			if($rid > 0){
			
				$total = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_user_id='".$rid."' AND like_authoruser_id='".$user_info['user_id']."'");
				if($total['cnt'] == 0){

					$status = '0';
					$a_total = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_authoruser_id='".$rid."' AND like_user_id='".$user_info['user_id']."'");

					if($a_total['cnt'] != 0){
						$status = '1';
						$db->super_query("UPDATE `".PREFIX."_compare` SET like_status='$status' WHERE like_authoruser_id='".$rid."' AND like_user_id='".$user_info['user_id']."' LIMIT 1");
					}

					$db->super_query("INSERT INTO `".PREFIX."_compare` (like_user_id, like_authoruser_id, like_date, like_status) VALUES ('".$rid."', '".$user_info['user_id']."', '".time()."', '".$status."')");

				}
				
			}
		
			$tpl->load_template('compare/result.tpl');
		
			$online_datetime = time() - 6400 * 365;
			$where = "user_id != 0  AND user_photo != '' AND user_last_visit > '".$online_datetime."' ";
		
			$sex_info = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '".$user_info['user_id']."'", 0);
			if($sex_info['user_sex'] == 1)
				$where .= " AND user_sex='2' "; 
			else
				$where .= " AND user_sex='1' "; 
			
//* WHERE user_id = new_profiles.profile_user_id AND ".$where." GROUP BY user_id ORDER BY rand() LIMIT 2 *//
			
			$user1 = $db->super_query("SELECT user_id, user_name, user_photo FROM `".PREFIX."_users` WHERE ".$where." ORDER BY rand() LIMIT 1", 0);
			$user2 = $db->super_query("SELECT user_id, user_name, user_photo FROM `".PREFIX."_users` WHERE ".$where." ORDER BY rand() LIMIT 1", 0);
			
			$tpl->set('{user1-id}', $user1['user_id']);
			$tpl->set('{user1-ava}', './uploads/users/'.$user1['user_id'].'/'.$user1['user_photo']);
			$tpl->set('{user1-name}', $user1['user_name']);
			
			$tpl->set('{user2-id}', $user2['user_id']);
			$tpl->set('{user2-ava}', './uploads/users/'.$user2['user_id'].'/'.$user2['user_photo']);
			$tpl->set('{user2-name}', $user2['user_name']);
			
			$tpl->set_block("'\\[ajax\\](.*?)\\[/ajax\\]'si","");
			
			$tpl->compile('content');
			
			AjaxTpl();
			die();
			
		break;
		
		
		default:
		
			$row = like_list(0,0,"like_id DESC",4);
			$tpl->load_template('compare/compare_box.tpl');
			foreach($row as $row_friends_online){
				$tpl->set('[status]', '');
				$tpl->set('[/status]', '');
			
				$tpl->set('{user-id}', $row_friends_online['user_id']);
				$tpl->set('{name}', $row_friends_online['user_name']);
				if($row_friends_online['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_friends_online['user_id'].'/50_'.$row_friends_online['user_photo']);
				else
					$tpl->set('{ava}', '/images/no_ava_50.png');
				$tpl->compile('mylikeList');
			}
			
			$row = like_list(1,0,"like_date DESC",4);
			$tpl->load_template('compare/compare_box.tpl');
			foreach($row as $row_friends_online){
				if($row_friends_online['like_status'] == 1){
					$tpl->set('[status]', '');
					$tpl->set('[/status]', '');
				}else{
					$tpl->set_block("'\\[status\\](.*?)\\[/status\\]'si","");
					$row_friends_online['user_name'] = 'Аноним';
				}
			
				$tpl->set('{user-id}', $row_friends_online['user_id']);
				$tpl->set('{name}', $row_friends_online['user_name']);
				if($row_friends_online['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_friends_online['user_id'].'/50_'.$row_friends_online['user_photo']);
				else
					$tpl->set('{ava}', '/images/no_ava_50.png');
				$tpl->compile('outlikeList');
			}
			
			$row = like_list(0,1,"like_date DESC",4);
			$tpl->load_template('compare/compare_box.tpl');
			foreach($row as $row_friends_online){
				$tpl->set('[status]', '');
				$tpl->set('[/status]', '');
				
				$tpl->set('{user-id}', $row_friends_online['user_id']);
				$tpl->set('{name}', $row_friends_online['user_name']);
				if($row_friends_online['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row_friends_online['user_id'].'/50_'.$row_friends_online['user_photo']);
				else
					$tpl->set('{ava}', '/images/no_ava_50.png');
				$tpl->compile('oklikeList');
			}
		
		
			$tpl->load_template('compare/head_new.tpl');

				$tpl->set('{activetab-1}', 'activetab');
				$tpl->set('[main]', '');
				$tpl->set('[/main]', '');
				
				$count1 = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_authoruser_id='".$user_info['user_id']."'");
				$count2 = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_user_id='".$user_info['user_id']."'");
				$count3 = $db->super_query("SELECT COUNT(like_id) AS cnt FROM `".PREFIX."_compare` WHERE like_authoruser_id='".$user_info['user_id']."' AND like_status='1'");

				$tpl->set('{cnt-1}', $count1['cnt']);
				$tpl->set('{cnt-2}', $count2['cnt']);
				$tpl->set('{cnt-3}', $count3['cnt']);

				$tpl->set('{mylikeList}', $tpl->result['mylikeList']);
				$tpl->set('{outlikeList}', $tpl->result['outlikeList']);
				$tpl->set('{oklikeList}', $tpl->result['oklikeList']);
			
			$tpl->compile('content');

			$tpl->load_template('compare/result.tpl');
			
				$online_datetime = time() - 6400 * 365;
				$where = "user_id != 0  AND user_photo != '' AND user_last_visit > '".$online_datetime."' ";
			
				$sex_info = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '".$user_info['user_id']."'", 0);
				if($sex_info['user_sex'] == 1)
					$where .= " AND user_sex='2' "; 
				else
					$where .= " AND user_sex='1' "; 

				$user1 = $db->super_query("SELECT user_id, user_name, user_photo FROM `".PREFIX."_users` WHERE ".$where." ORDER BY rand() LIMIT 1", 0);
				$user2 = $db->super_query("SELECT user_id, user_name, user_photo FROM `".PREFIX."_users` WHERE ".$where." ORDER BY rand() LIMIT 1", 0);
				
				$tpl->set('{user1-id}', $user1['user_id']);
				$tpl->set('{user1-ava}', './uploads/users/'.$user1['user_id'].'/'.$user1['user_photo']);
				$tpl->set('{user1-name}', $user1['user_name']);
				
				$tpl->set('{user2-id}', $user2['user_id']);
				$tpl->set('{user2-ava}', './uploads/users/'.$user2['user_id'].'/'.$user2['user_photo']);
				$tpl->set('{user2-name}', $user2['user_name']);
				
				$tpl->set('[ajax]', '');
				$tpl->set('[/ajax]', '');

			$tpl->compile('content');

	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>