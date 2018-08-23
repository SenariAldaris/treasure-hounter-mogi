<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$user_id = $user_info['user_id'];
	$pid = intval($_GET['pid']);
	$mobile_speedbar = 'Сообщество';
	
	if(preg_match("/^[a-zA-Z0-9_-]+$/", $_GET['get_adres'])) $get_adres = $db->safesql($_GET['get_adres']);
	
	$sql_where = "id = '".$pid."'";
	
	if($pid){
		$get_adres = '';
		$sql_where = "id = '".$pid."'";
	}
	if($get_adres){
		$pid = '';
		$sql_where = "adres = '".$get_adres."'";
	} else
	
	echo $get_adres;

//* Если страница вызвана через "к предыдущим записям" *//
	
	$limit_select = 10;
	if($_POST['page_cnt'] > 0)
		$page_cnt = intval($_POST['page_cnt'])*$limit_select;
	else
		$page_cnt = 0;

	if($page_cnt){
		$row = $db->super_query("SELECT admin FROM `".PREFIX."_communities` WHERE id = '{$pid}'");
		$row['id'] = $pid;
	} else
		$row = $db->super_query("SELECT id, verification, design, title, descr, traf, ulist, photo, date, admin, feedback, comments, real_admin, rec_num, del, ban, adres, audio_num, forum_num, discussion, status_text, web, cover, cover_pos , videos_num FROM `".PREFIX."_communities` WHERE ".$sql_where."");
	
	if($row['verification']) $verification = ' <a  class=\'hint--bottom\' data-hint=\'Данная отметка означает, что сообщество ' . $row['title'] . ' было подтверждено администрацией.\'> <div class=\'block_vefirw\'><span class=\'otmessqq\'></span></div></a>';

	if($row['del'] == 1){
		$user_speedbar = 'Страница удалена';
		msgbox('', '<br /><br />Сообщество удалено администрацией.<br /><br /><br />', 'info_2');
	} elseif($row['ban'] == 1){
		$user_speedbar = 'Страница заблокирована';
		msgbox('', '<br /><br />Сообщество заблокировано администрацией.<br /><br /><br />', 'info_2');
	} elseif($row){
		$metatags['title'] = stripslashes($row['title']);
		$user_speedbar = stripslashes($row['title']).$verification;
		
		if(stripos($row['admin'], "u{$user_id}|") !== false)
			$public_admin = true;
		else
			$public_admin = false;

//* Стена *//
		
//* Если страница вывзана через "к предыдущим записям" *//
		
		if($page_cnt)
			NoAjaxQuery();
		
		include ENGINE_DIR.'/classes/wall.public.php';
		$wall = new wall();
		$wall->query("SELECT tb1.id, text, public_id, add_date, fasts_num, attach, likes_num, likes_users, tell_uid, public, tell_date, tell_num, tell_comm, fixed_w, tb2.title, photo, comments, adres FROM `".PREFIX."_communities_wall` tb1, `".PREFIX."_communities` tb2 WHERE tb1.public_id = '{$row['id']}' AND tb1.public_id = tb2.id AND fast_comm_id = 0 ORDER by `fixed_w` DESC, `add_date` DESC LIMIT {$page_cnt}, {$limit_select}");
		$wall->template('groups/record.tpl');
		
//* Если страница вывзана через "к предыдущим записям" *//
		
		if($page_cnt)
			$wall->compile('content');
		else
			$wall->compile('wall');
		$wall->select($public_admin, $server_time);
		
//* Если страница вывзана через "к предыдущим записям" *//
		
		if($page_cnt){
			AjaxTpl();
			exit;
		}
		
//* Аватарка *//
							
			if($user_info['user_photo']){
				$tpl->set('{ava3}', $config['home_url'].'uploads/users/'.$user_info['user_id'].'/50_'.$avaPREFver.$user_info['user_photo']);
				$tpl->set('{display-ava}', 'style="display:block;"');
			} else {
				$tpl->set('{ava3}', '/templates/Old/images/'.$noAvaPrf);
				$tpl->set('{display-ava}', 'style="display:none;"');
			}
		$tpl->load_template('public/main.tpl');
		$rowd = xfieldsdataload($row['privacy']);
		$tpl->set('{val_wall1_wall}', $rowd['val_wall1']);
		$tpl->set('{val_wall1_text_wall}', strtr($rowd['val_wall1'], array('1' => 'Выключена', '2' => 'Открытая', '3' => 'Закрытая')));
		$tpl->set('{val_intog}', $rowd['val_intog']);
		$tpl->set('{val_intog_text}', strtr($rowd['val_intog'], array('1' => 'Открытая', '2' => 'Закрытая')));
		$tpl->set('{val_board}', $rowd['val_board']);
		$tpl->set('{val_boards_text}', strtr($rowd['val_board'], array('1' => 'Выключены', '2' => 'Открытые', '3' => 'Ограниченные')));
		$tpl->set('{title}', stripslashes($row['title']));

		if($row['photo']){
		
//* FOR MOBILE VERSION 1.0 *//
			
			if($config['temp'] == 'mobile')
			
				$row['photo'] = '50_'.$row['photo'];
			
			$tpl->set('{photo}', "/uploads/groups/{$row['id']}/{$row['photo']}");
			$tpl->set('{display-ava}', '');
		} else {
		
//* FOR MOBILE VERSION 1.0 *//
			
			if($config['temp'] == 'mobile')
			
				$tpl->set('{photo}', "{theme}/images/no_ava_50.png");
			
			else
			
				$tpl->set('{photo}', "{theme}/images/no_ava_groups.png");
			
			$tpl->set('{display-ava}', 'no_display');
		}
					
        if($row['photo']){
			$tpl->set('{photo_groups}', "/uploads/groups/{$row['id']}/50_{$row['photo']}");
			$tpl->set('{display-ava}', '');
			} else {
				$tpl->set('{photo_groups}', "{theme}/images/no_ava_50_groups.png");
				$tpl->set('{display-ava}', 'no_display');
		}
		if($row['descr'])
			$tpl->set('{descr-css}', '');
		else 
			$tpl->set('{descr-css}', 'no_display');
		
		$tpl->set('{edit-descr}', myBrRn(stripslashes($row['descr'])));
		
//* Кнопка Показать полностью *//
		
		$expBR = explode('<br />', $row['descr']);
		$textLength = count($expBR);
		$strTXT = strlen($row['descr']);
		if($textLength > 9 OR $strTXT > 600)
			$row['descr'] = '<div class="wall_strlen" id="hide_wall_rec'.$row['id'].'">'.$row['descr'].'</div><div class="wall_strlen_full" onMouseDown="wall.FullText('.$row['id'].', this.id)" id="hide_wall_rec_lnk'.$row['id'].'">Показать полностью..</div>';
				
		$tpl->set('{descr}', stripslashes($row['descr']));
		
		$tpl->set('{num}', '<span id="traf">'.$row['traf'].'</span> '.gram_record($row['traf'], 'subscribers'));
		if($row['traf']){
			$tpl->set('{num-2}', '<a href="/public'.$row['id'].'" onClick="groups.all_people(\''.$row['id'].'\'); return false">'.gram_record($row['traf'], 'subscribers2').'</a>');
			$tpl->set('{no-users}', '');
		} else {
			$tpl->set('{num-2}', '<span class="color777">Вы будете первым.</span>');
			$tpl->set('{no-users}', 'no_display');
		}
		
//* Права админа *//
		
		if($public_admin){
			$tpl->set('[admin]', '');
			$tpl->set('[/admin]', '');
			$tpl->set_block("'\\[not-admin\\](.*?)\\[/not-admin\\]'si","");
		} else {
			$tpl->set('[not-admin]', '');
			$tpl->set('[/not-admin]', '');
			$tpl->set_block("'\\[admin\\](.*?)\\[/admin\\]'si","");
		}
		
//* Проверка подписан юзер или нет *//
		
		if(stripos($row['ulist'], "|{$user_id}|") !== false)
			$tpl->set('{yes}', 'no_display');
		else
			$tpl->set('{no}', 'no_display');
			
//* Контакты *//
		
		if($row['feedback']){
			$tpl->set('[yes]', '');
			$tpl->set('[/yes]', '');
			$tpl->set_block("'\\[no\\](.*?)\\[/no\\]'si","");
			$tpl->set('{num-feedback}', '<span id="fnumu">'.$row['feedback'].'</span> '.gram_record($row['feedback'], 'feedback'));
			$sql_feedbackusers = $db->super_query("SELECT tb1.fuser_id, office, tb2.user_search_pref, user_photo, short_link FROM `".PREFIX."_communities_feedback` tb1, `".PREFIX."_users` tb2 WHERE tb1.cid = '{$row['id']}' AND tb1.fuser_id = tb2.user_id ORDER by `fdate` ASC LIMIT 0, 5", 1);
			foreach($sql_feedbackusers as $row_feedbackusers){
				if($row_feedbackusers['user_photo']) $ava = "/uploads/users/{$row_feedbackusers['fuser_id']}/50_{$row_feedbackusers['user_photo']}";
				else $ava = "{theme}/images/no_ava_50.png";
				
				$row_feedbackusers['office'] = stripslashes($row_feedbackusers['office']);
				
				if ($row_feedbackusers['short_link'] != null && $row_feedbackusers['short_link'] != 'empty') {
					$link = '/' . $row_feedbackusers['short_link'];
				} else {
					$link = '/u' . $row_feedbackusers['fuser_id'];
				}

				$feedback_users .= "<div class=\"onesubscription onesubscriptio2n\" id=\"fb{$row_feedbackusers['fuser_id']}\"><a href=\"{$link}\" onClick=\"Page.Go(this.href); return false\"><img src=\"{$ava}\" alt=\"\" /><div class=\"onesubscriptiontitle\">{$row_feedbackusers['user_search_pref']}</div></a><div class=\"nesubscriptstatus\">{$row_feedbackusers['office']}</div></div>";
			}
			$tpl->set('{feedback-users}', $feedback_users);
			$tpl->set('[feedback]', '');
			$tpl->set('[/feedback]', '');
		} else {
			$tpl->set('[no]', '');
			$tpl->set('[/no]', '');
			$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");
			$tpl->set('{feedback-users}', '');
			if($public_admin){
				$tpl->set('[feedback]', '');
				$tpl->set('[/feedback]', '');
			} else
				$tpl->set_block("'\\[feedback\\](.*?)\\[/feedback\\]'si","");
		}
		
//* Выводим подписчиков *//
		
		$sql_users = $db->super_query("SELECT tb1.user_id, tb2.user_name, user_country_city_name, user_lastname, user_photo, short_link FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.friend_id = '{$row['id']}' AND tb1.user_id = tb2.user_id AND tb1.subscriptions = 2 ORDER by rand() LIMIT 0, 12", 1);
		foreach($sql_users as $row_users){
			if($row_users['user_photo']) $ava = "/uploads/users/{$row_users['user_id']}/50_{$row_users['user_photo']}";
			else $ava = "{theme}/images/no_ava_50.png";			
			
			if($row_users['user_photo']) $ava2 = "/uploads/users/{$row_users['user_id']}/100_{$row_users['user_photo']}";
			else $ava2 = "{theme}/images/no_ava_100.png";

			if ($row_users['short_link'] != null && $row_users['short_link'] != 'empty') {
				$link = '/' . $row_users['short_link'];
			} else {
				$link = '/u' . $row_users['user_id'];
			}

					$user_country_city_name = explode('|', $row_users['user_country_city_name']);
				$tpl->set('{country}', $user_country_city_name[0]);
				if($user_country_city_name[1])
					$tpl->set('{city}', ', '.$user_country_city_name[1]);
				else
					$tpl->set('{city}', '');

									$user_birthday = explode('-', $row_users['user_birthday']);
				$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
				
			$users .= "<div class=\"bubbleInfo\" id=\"subUser{$row_users['user_id']}\"><a href=\"{$link}\"  onClick=\"Page.Go(this.href); return false\"><img  class=\"trigger\" src=\"{$ava}\"/></a><div class=\"popup\"><a href=\"{$link}\"  onClick=\"Page.Go(this.href); return false\"> <img  class=\"trigger\" src=\"{$ava2}\" />  </a> <div class=\"name_tooltips\"><div class=\"name_tooltips_top\">{$row_users['user_name']} {$row_users['user_lastname']}</div><div class=\"inf_toopl\">{$country}{$city} </div><div class=\"inf_toopl_god\"> {$age}</div></div><div class=\"bottoms\">   </div></div><div class=\"clear\">   </div></div>";
		}
												if($row_users['user_photo'])
						$tpl->set('{ava2}', $config['home_url'].'uploads/users/'.$row_users['friend_id'].'/100_'.$row_users['user_photo']);
					else
						$tpl->set('{ava2}', '{theme}/images/no_ava_100.png');
						
		$tpl->set('{users}', $users); 
		
		$tpl->set('{id}', $row['id']);
		megaDate(strtotime($row['date']), 1, 1);
		
//* Комментарии включены *//
		
		if($row['comments'])
			$tpl->set('{settings-comments}', 'comments');
		else
			$tpl->set('{settings-comments}', 'none');
			
//* Выводим админов при ред. страницы *//
		
		if($public_admin){
			$admins_arr = str_replace('|', '', explode('u', $row['admin']));
			foreach($admins_arr as $admin_id){
				if($admin_id){
					$row_admin = $db->super_query("SELECT user_search_pref, user_photo, short_link FROM `".PREFIX."_users` WHERE user_id = '{$admin_id}'");
					if($row_admin['user_photo']) $ava_admin = "/uploads/users/{$admin_id}/50_{$row_admin['user_photo']}";
					else $ava_admin = "{theme}/images/no_ava_50.png";
					if($admin_id != $row['real_admin']) $admin_del_href = "<a href=\"/\" onClick=\"groups.deladmin('{$row['id']}', '{$admin_id}'); return false\"><small>Удалить</small></a>";

					if ($row_admin['short_link'] != null && $row_admin['short_link'] != 'empty') {
						$link = '/' . $row_admin['short_link'];
					} else {
						$link = '/u' . $admin_id;
					}

					$adminO .= "<div class=\"public_oneadmin\" id=\"admin{$admin_id}\"><a href=\"{$link}\" onClick=\"Page.Go(this.href); return false\"><img src=\"{$ava_admin}\" align=\"left\" width=\"32\" /></a><a href=\"{$link}\" onClick=\"Page.Go(this.href); return false\">{$row_admin['user_search_pref']}</a><br />{$admin_del_href}</div>";		
				}
			}
			
			$tpl->set('{admins}', $adminO);
		}

		$tpl->set('{records}', $tpl->result['wall']);
		
//* Стена *//
		
		if($row['rec_num'] > 10)
			$tpl->set('{wall-page-display}', '');
		else
			$tpl->set('{wall-page-display}', 'no_display');
			
		if($row['rec_num'])
			$tpl->set('{rec-num}', '<span id="rec_num">'.$row['rec_num'].'</span> '.gram_record($row['rec_num'], 'rec'));
		else {
			$tpl->set('{rec-num}', '<span id="rec_num">Нет записей</span>');
			if($public_admin)
				$tpl->set('{records}', '<div class="wall_none" style="border-top:0px">Новостей пока нет.</div>');
			else
				$tpl->set('{records}', '<div class="wall_none">Новостей пока нет.</div>');
		}
			
		if($user_privacy_loting['val_wall1'] == 1){
			$tpl->set_block("'\\[wall_privacy\\](.*?)\\[/wall_privacy\\]'si","");
		} else {
			$tpl->set('[wall_privacy]', '');
			$tpl->set('[/wall_privacy]', '');
		}
		
		if($user_privacy_loting['val_board'] == 1){
			$tpl->set_block("'\\[board_privacy\\](.*?)\\[/board_privacy\\]'si","");
		} else {
			$tpl->set('[board_privacy]', '');
			$tpl->set('[/board_privacy]', '');
		}
		
		if($user_privacy_loting['val_board'] == 3 and $public_admin == false){
			$tpl->set_block("'\\[topic_privacy\\](.*?)\\[/topic_privacy\\]'si","");
		} else {
			$tpl->set('[topic_privacy]', '');
			$tpl->set('[/topic_privacy]', '');
		}
		
		if($user_privacy_loting['val_wall1'] == 3 and $public_admin == false) {
			$tpl->set_block("'\\[wall_privacy_admin\\](.*?)\\[/wall_privacy_admin\\]'si","");
		} else {
			$tpl->set('[wall_privacy_admin]', '');
			$tpl->set('[/wall_privacy_admin]', '');
		}
		
//* Выводим информцию о том кто смотрит страницу для себя *//
		
		$tpl->set('{viewer-id}', $user_id);
			
		if(!$row['adres']) $row['adres'] = 'public'.$row['id'];
		$tpl->set('{adres}', $row['adres']);

//* Аудиозаписи *//
		
		if($row['audio_num']){
			$sql_audios = $db->super_query("SELECT url, artist, name FROM `".PREFIX."_communities_audio` WHERE public_id = '{$row['id']}' ORDER by `adate` DESC LIMIT 0, 3", 1, "groups/audio{$row['id']}");
			$jid = 0;
			foreach($sql_audios as $row_audios){
				$jid++;
				
				$row_audios['artist'] = stripslashes($row_audios['artist']);
				$row_audios['name'] = stripslashes($row_audios['name']);
				
				$audios .= "<div class=\"audio_onetrack\" style=\"width:575px;background:none\"><div class=\"audio_playic cursor_pointer fl_l\" onClick=\"music.newStartPlay('{$jid}')\" id=\"icPlay_{$jid}\"></div><span id=\"music_{$jid}\" data=\"{$row_audios['url']}\"><a href=\"/?go=search&query={$row_audios['artist']}&type=5\" onClick=\"Page.Go(this.href); return false\"><b><span id=\"artis{aid}\">{$row_audios['artist']}</span></b></a> &ndash; <span id=\"name{aid}\">{$row_audios['name']}</span></span><div id=\"play_time{$jid}\" class=\"color777 fl_r no_display\" style=\"margin-top:2px;margin-right:5px\"></div> <div class=\"clear\"></div><div class=\"player_mini_mbar fl_l no_display\" id=\"ppbarPro{$jid}\" style=\"width:570px;margin-left: 1px;\"></div> </div>";
				
			}
			
			$tpl->set('{audios}', $audios);
			$tpl->set('{audio-num}', $row['audio_num']);
			$tpl->set('[audios]', '');
			$tpl->set('[/audios]', '');
			$tpl->set('[yesaudio]', '');
			$tpl->set('[/yesaudio]', '');
			$tpl->set_block("'\\[noaudio\\](.*?)\\[/noaudio\\]'si","");
			
		} else {
		
			$tpl->set('{audios}', '');
			$tpl->set('[noaudio]', '');
			$tpl->set('[/noaudio]', '');
			$tpl->set_block("'\\[yesaudio\\](.*?)\\[/yesaudio\\]'si","");
			
			if($row_users){
				$tpl->set('[audios]', '');
				$tpl->set('[/audios]', '');
			} else
				$tpl->set_block("'\\[audios\\](.*?)\\[/audios\\]'si","");
			
		}

//* Обсуждения *//
		
		if($row['discussion']){
		
			$tpl->set('{settings-discussion}', 'discussion');
			$tpl->set('[discussion]', '');
			$tpl->set('[/discussion]', '');
			
		} else {
		
			$tpl->set('{settings-discussion}', 'none');
			$tpl->set_block("'\\[discussion\\](.*?)\\[/discussion\\]'si","");
			
		}
			
		if(!$row['forum_num']) $row['forum_num'] = '';
		$tpl->set('{forum-num}', $row['forum_num']);
		
		if($row['forum_num'] AND $row['discussion']){
			
			$sql_forum = $db->super_query("SELECT fid, title, lastuser_id, lastdate, msg_num FROM `".PREFIX."_communities_forum` WHERE public_id = '{$row['id']}' ORDER by `fixed` DESC, `lastdate` DESC, `fdate` DESC LIMIT 0, 5", 1, "groups_forum/forum{$row['id']}");
			
			foreach($sql_forum as $row_forum){
				
				$row_last_user = $db->super_query("SELECT user_search_pref, short_link FROM `".PREFIX."_users` WHERE user_id = '{$row_forum['lastuser_id']}'");
				$last_userX = explode(' ', $row_last_user['user_search_pref']);
				$row_last_user['user_search_pref'] = gramatikName($last_userX[0]).' '.gramatikName($last_userX[1]);
	
				$row_forum['title'] = stripslashes($row_forum['title']);
				
				$msg_num = $row_forum['msg_num'].' '.gram_record($row_forum['msg_num'], 'msg');

				$last_date = megaDateNoTpl($row_forum['lastdate']);

				if ($row_last_user['short_link'] != null && $row_last_user['short_link'] != 'empty') {
					$link = '/' . $row_last_user['short_link'];
				} else {
					$link = '/u' . $row_forum['lastuser_id'];
				}

				$thems .= "<div class=\"forum_bg\"><div class=\"forum_title cursor_pointer\" onClick=\"Page.Go('/forum{$row['id']}?act=view&id={$row_forum['fid']}'); return false\">{$row_forum['title']}</div><div class=\"forum_bottom\">{$msg_num}. Последнее от <a href=\"{$link}\" onClick=\"Page.Go(this.href); return false\">{$row_last_user['user_search_pref']}</a>, {$last_date}</div></div>";
				
			}
			
			$tpl->set('{thems}', $thems);
		
		} else 
			$tpl->set('{thems}', '<div class="wall_none">В сообществе ещё нет тем.</div>');

//* Статус *//
		
		$tpl->set('{status-text}', stripslashes($row['status_text']));
			
		if($row['status_text']){
		
			$tpl->set('[status]', '');
			$tpl->set('[/status]', '');
			$tpl->set_block("'\\[no-status\\](.*?)\\[/no-status\\]'si","");
			
		} else {
		
			$tpl->set_block("'\\[status\\](.*?)\\[/status\\]'si","");
			$tpl->set('[no-status]', '');
			$tpl->set('[/no-status]', '');
			
		}

		if($row['verification'])
			$tpl->set_block("'\\[ver\\](.*?)\\[/ver\\]'si","");
		else {
			$tpl->set('[ver]', '');
			$tpl->set('[/ver]', '');
		}
		
//* Дизайн страницы *//
		
		$data_design = xfieldsdataload($row['design']);
		
		if($data_design['background'])
			if($data_design['background_repeat'])
				$tpl->set('{background}', "html, body{background:url('/uploads/groups/{$row['id']}/{$data_design['background']}') no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:100%;}");
			else
				$tpl->set('{background}', "html, body{background:url('/uploads/groups/{$row['id']}/{$data_design['background']}') fixed;}");
		else
			$tpl->set('{background}', '');
			
		if($data_design['background_repeat']) $tpl->set('{background_repeat}', 'background_repeat');
		else $tpl->set('{background_repeat}', 'none');
		
		if($verification)
			$tpl->set('{verification}', $verification);
		else
			$tpl->set('{verification}', '');
		
		$tpl->set('{web}', $row['web']);
		
		if($row['web']){

			$tpl->set('[web]', '');
			$tpl->set('[/web]', '');
			
		} else
			
			$tpl->set_block("'\\[web\\](.*?)\\[/web\\]'si","");
		
//* Обложка *//
		
		if($row['photo']){
			
			$avaImgIsinfo = getimagesize(ROOT_DIR."/uploads/groups/{$row['id']}/{$row['photo']}");
				
			if($avaImgIsinfo[1] < 200){
					
				$rForme = 230 - $avaImgIsinfo[1];
					
				$ava_marg_top = 'style="margin-top:-'.$rForme.'px"';
					
			}
			
			$tpl->set('{cover-param-7}', $ava_marg_top);
				
		} else
			$tpl->set('{cover-param-7}', "");
			
			if($row['cover']){
				
			$imgIsinfo = getimagesize(ROOT_DIR."/uploads/groups/{$row['id']}/{$row['cover']}");
				
			$tpl->set('{cover}', "/uploads/groups/{$row['id']}/{$row['cover']}");
			$tpl->set('{cover-height}', $imgIsinfo[1]);
			$tpl->set('{cover-param}', '');		
			$tpl->set('{cover-param-2}', '<style type="text/css" media="all">.cover_newpos {background: url("") repeat scroll 0 0 rgba(0, 0, 0, 0.7);margin-left: 3px;}</style>');
			$tpl->set('{cover-param-2}', 'no_display');
			$tpl->set('{cover-param-3}', 'style="position:absolute;z-index:2;display:block;margin-left:397px"');
			$tpl->set('{cover-param-4}', 'style="cursor:default"');
			$tpl->set('{cover-param-5}', 'style="top:-'.$row['cover_pos'].'px;position:relative"');
			$tpl->set('{cover-pos}', $row['cover_pos']);
			$tpl->set('[cover]', '');
			$tpl->set('[/cover]', '');
			$tpl->set_block("'\\[no-cover\\](.*?)\\[/no-cover\\]'si","");

		} else {
				
			$tpl->set('{cover}', "");
			$tpl->set('{cover-param}', 'no_display');
			$tpl->set('{cover-param-2}', '');
			$tpl->set('{cover-param-3}', '');
			$tpl->set('{cover-param-4}', '');
			$tpl->set('{cover-param-5}', '');
			$tpl->set('{cover-pos}', '');
			$tpl->set('[no-cover]', '');
			$tpl->set('[/no-cover]', '');
			$tpl->set_block("'\\[cover\\](.*?)\\[/cover\\]'si","");
				
		}	

//* Видеозаписи *//
		
		if($row['videos_num']){
			
			$sql_videos = $db->super_query("SELECT id, title, photo, add_date, comm_num, owner_user_id FROM `".PREFIX."_videos` WHERE public_id = '{$row['id']}' ORDER by `add_date` DESC LIMIT 0, 6", 1, "groups/video{$row['id']}");
			
			foreach($sql_videos as $row_video){
				
				$row_video['title'] = stripslashes($row_video['title']);
				$date_video = megaDateNoTpl(strtotime($row_video['add_date']));
				$comm_num = $row_video['comm_num'].' '.gram_record($row_video['comm_num'], 'comments');
				
				$videos .= "
				
     <section class=\"portfolio-container\">
                <ul class=\"portfolio-items\">
                    <li class=\"img_item\">
                        <div class=\"caption\">
                            <h3>{$row_video['title']}</h3>
                          <a class=\"pcv_button\" href=\"/video{$row_video['owner_user_id']}_{$row_video['id']}\" onClick=\"videos.show({$row_video['id']}, this.href, '/{$row['adres']}'); return false\">Смотреть</a>
                        </div>
                        <img src=\"{$row_video['photo']}\" />
                    </li>
                </ul>
            </section>

				";
				
			}
			
			$tpl->set('{videos}', $videos);
			$tpl->set('{videos-num}', $row['videos_num']);
			$tpl->set('[videos]', '');
			$tpl->set('[/videos]', '');
			$tpl->set('[yesvideo]', '');
			$tpl->set('[/yesvideo]', '');
			$tpl->set_block("'\\[novideo\\](.*?)\\[/novideo\\]'si","");
			
		} else {
			$tpl->set('{videos}', '');
			$tpl->set('[novideo]', '');
			$tpl->set('[/novideo]', '');
			$tpl->set_block("'\\[yesvideo\\](.*?)\\[/yesvideo\\]'si","");
			
			if($row_users){
			
				$tpl->set('[videos]', '');
				$tpl->set('[/videos]', '');
				
			} else
				$tpl->set_block("'\\[videos\\](.*?)\\[/videos\\]'si","");
			
		}
		
//* Альбомы *//

			$albums_count = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_albums` WHERE pid = '{$row['id']}'", false);
			$albums_count_system = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_albums` WHERE pid = '{$row['id']}' ", false);
			
			$sql_albums = $db->super_query("SELECT SQL_CALC_FOUND_ROWS aid, name, adate, photo_num, cover, descr FROM `".PREFIX."_communities_albums` WHERE pid = '{$row['id']}' and system != '1' ORDER by `position` ASC LIMIT 0, 4", 1);
			if($sql_albums){
				foreach($sql_albums as $row_albums){
					$row_albums['name'] = stripslashes($row_albums['name']);
					$album_date = megaDateNoTpl(strtotime($row_albums['adate']));
					$albums_photonums = gram_record($row_albums['photo_num'], 'photos');
					if($row_albums['cover']) $album_cover = "/uploads/groups/{$row['id']}/albums/{$row_albums['aid']}/{$row_albums['cover']}";
					else $album_cover = '{theme}/images/no_cover.png';
					if($row_albums['descr']) $descrs = 'page_album_title_wrap_descr';
					else $descrs = '';
					$albums .= "<a href=\"/albums-{$row['id']}\" onClick=\"Page.Go(this.href); return false\" style=\"text-decoration:none\"><div class=\"profile_albums\"><img src=\"{$album_cover}\" /><div class=\"profile_title_album\">{$row_albums['name']}</div>{$row_albums['photo_num']} {$albums_photonums}<br />Обновлён {$album_date}<div class=\"clear\"></div></div></a>";
				}
			}
			$tpl->set('{albums}', $albums);
      $tpl->set ('{public-id}', $row['id']);
			$cnt = $albums_count['cnt'];
			$tpl->set('{albums-num}', $cnt.' '.gram_record($cnt,'albums'));
			if($cnt){
				$tpl->set('[albums]', '');
				$tpl->set('[/albums]', '');
			} else
				$tpl->set_block("'\\[albums\\](.*?)\\[/albums\\]'si","");
		
         $tpl->compile('content');
	} else {
		$user_speedbar = $lang['no_infooo'];
		msgbox('', $lang['no_upage'], 'info');
	}
	
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>
