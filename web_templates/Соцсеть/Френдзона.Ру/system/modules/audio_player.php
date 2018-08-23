<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();
	
if($logged){

	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
			
		//################### Трансляция в статус ###################//
		case "translate":
			
			$aid = intval($_POST['aid']);
			
			//Выводим песню
			$row = $db->super_query("SELECT artist, name FROM `".PREFIX."_audio` WHERE aid = '{$aid}'");

			if($row){
				
				//Выводим пред. статус
				$checkPrevStatus = mozg_cache("user_{$user_id}/old_status");
				$checkExp = explode('<audio', $checkPrevStatus);
				
				if(!$checkPrevStatus AND !$checkExp[1]){
				
					$myRow = $db->super_query("SELECT user_status FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
					
					//Если ест пред статус, то сохраняем его в кеш, для воостановления
					if($myRow['user_status']){

						mozg_create_cache("user_{$user_id}/old_status", $myRow['user_status']);
						
					}
				
				}
				
				$artist = $db->safesql($row['artist']);
				$name = $db->safesql($row['name']);
				
				$newStatus = '<div class="staticpl_translatl" onClick="gStatus.open()"><div class="statipl_music"></div>'.$artist.' &ndash; '.$name.'</div><audio'.$aid;
				
				//Обновляем статус
				$db->query("UPDATE `".PREFIX."_users` SET user_status = '{$newStatus}' WHERE user_id = '{$user_id}'");
				
				//Чистим кеш
				mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				
			}
			
		break;
		
		//################### Выключение трансляции ###################//
		case "notranslate":
			
			//Выводим пред. статус
			$checkPrevStatus = mozg_cache("user_{$user_id}/old_status");
			$checkExp = explode('<audio', $checkPrevStatus);
			
			if(!$checkExp[1]) $newStatus = $db->safesql($checkPrevStatus);
			else $newStatus = '';
			
			//Обновляем статус
			$db->query("UPDATE `".PREFIX."_users` SET user_status = '{$newStatus}' WHERE user_id = '{$user_id}'");

			//Чистим кеш
			mozg_create_cache("user_{$user_id}/old_status", "");
			mozg_clear_cache_file("user_{$user_id}/profile_{$user_id}");
				
		break;
		
		//################### Загрузка плей листа ###################//
		default:
			
			//Если поиск
			$query = textFilter(ajax_utf8(strip_data(urldecode($_POST['query']))));
			$query = strtr($query, array(' ' => '%')); //Замеянем пробелы на проценты чтоб тоиск был точнее
			$doload = intval($_POST['doload']);
			$aid = intval($_POST['aid']);
			
			$get_user_id = intval($_POST['get_user_id']);
			if($get_user_id == $user_id OR !$get_user_id) $get_user_id = $user_id;

			if(isset($query) AND !empty($query)){
				
				$sql_query = "WHERE MATCH (name, artist) AGAINST ('%{$query}%') OR artist LIKE '%{$query}%' OR name LIKE '%{$query}%'";
				$search = true;
				
			} elseif($aid){
				
				$sql_query = "WHERE aid = '{$aid}'";
				$search = true;

			} else {
				
				$sql_query = "WHERE auser_id = '{$get_user_id}'";
				$search = false;

			}

			//Выводим из БД
			$limit_select = 20;
			if($_POST['page_cnt'] > 0) $page_cnt = intval($_POST['page_cnt']) * $limit_select;
			else $page_cnt = 0;
			
			$sql_ = $db->super_query("SELECT aid, url, artist, name FROM `".PREFIX."_audio` {$sql_query} ORDER by `adate` DESC LIMIT {$page_cnt}, {$limit_select}", 1);
			
			//Если есть отвеот из БД
			if($sql_){
				
				$jid = $page_cnt;
				
				$tpl->load_template('audio_player/track.tpl');
				foreach($sql_ as $row){
				
					$jid++;
					$tpl->set('{jid}', $jid);
					$tpl->set('{aid}', $row['aid']);
					
					$tpl->set('{aid}', $row['aid']);
					$tpl->set('{url}', $row['url']);
					$tpl->set('{artist}', stripslashes($row['artist']));
					$tpl->set('{name}', stripslashes($row['name']));
					
					if($get_user_id == $user_id AND !$search){
					
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
						
					} else {
					
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					
					}
					
					$tpl->compile('audios');
					
				}
				
				if(!$page_cnt AND !$doload){
				
					$tpl->load_template('audio_player/player.tpl');
					
					$tpl->set('{audios}', $tpl->result['audios']);
					$tpl->set('{user-id}', $user_id);
					
					if($aid) $tpl->set('{auto-play}', '1');
					else $tpl->set('{auto-play}', '');
					
					if($jid == $limit_select) $tpl->set('{jQbut}', '');
					else $tpl->set('{jQbut}', 'no_display');
					
					$tpl->compile('content');
				
				} else
					$tpl->result['content'] = $tpl->result['audios'];
			
			} else
				if($doload AND !$page_cnt){
					
					$query = str_replace('%', ' ', $query);
					
					$tpl->result['content'] = '<div class="info_center" style="padding-top:145px;padding-bottom:125px">По запросу <b>'.$query.'</b> не найдено ни одной аудиозаписи.</div>';
					
				} else 
				
					if(!$page_cnt)
						$tpl->result['content'] = '<div class="info_center" style="padding-top:125px;padding-bottom:125px"><center><img src="/templates/'.$config['temp'].'/images/snone.png" style="marign-bottom:60px;margin-top:-80px" /></center><div>Здесь Вы можете хранить Ваши аудиозаписи.<br />Для того, чтобы загрузить Вашу первую аудиозапись, <a href="/audio17" onClick="audio.addBox(1); return false;">нажмите здесь</a>.</div></div>';
				
			AjaxTpl();
			
	}
	
	$tpl->clear();
	$db->free();

}

exit();
?>