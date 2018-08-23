<?php
/* 
	
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
    $user_speedbar = 'Общий чат';
	$metatags['title'] = 'Общий чат';
	switch($act){
		
		
case "comadd":
			NoAjaxQuery();
			$textpin = ajax_utf8(textFilter($_POST['comtext']));
			

				
				
			//ќбновл¤ем данные в теме
			
				$row = $db->super_query("SELECT SQL_CALC_FOUND_ROWS * FROM `".PREFIX."_chat` WHERE user_id = '{$user_id}' ORDER by `id` DESC");	
				$tm = time()-20;
				$total_msg = count($db->super_query("SELECT id FROM `".PREFIX."_chat` WHERE user_id='".$user_id."' AND date > '".$tm."' AND date < '".time()."'",1));
					
				if($row['text'] == $textpin || $total_msg > 2) {
				$tpl->result['content'] .= '‘луд';
				$tpl->compile('content');
				} else {
				$db->query("INSERT INTO `".PREFIX."_chat` SET user_id = '{$user_id}', text = '{$textpin}', date = '{$server_time}'");
			
				$tpl->compile('content');
				}
				AjaxTpl();
			
			exit();
		break;
		
		
		case "delcom":
			NoAjaxQuery();
			$cid = intval($_POST['cid']);
		
			$db->query("DELETE FROM `".PREFIX."_chat` WHERE id = '{$cid}'");
			
			die();
		break;
		
		
		//################### ќбновление окна сообщений каждые 2 сек ###################//
		case "update":
			NoAjaxQuery();
			
			
			
			
			$tpl->load_template('chat/msg.tpl');
			
			
				$count = count($db->super_query("SELECT * FROM `".PREFIX."_chat`",1));
				if ($count >= 50) {
				$limit = $count - 50;
				} else {
				$limit = 0;
				}
				$row = $db->super_query("SELECT * FROM `".PREFIX."_chat` ORDER by `date` ASC LIMIT {$limit},{$count}",1);
				if($row) {
                     foreach($row as $row_com){ 
					$sql_us = $db->super_query("SELECT user_id, user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$row_com['user_id']}'");
					
					
						
							if(date('Y-m-d', $row_com['date']) == date('Y-m-d', $server_time))
								$date = langdate('сегодн¤ в H:i', $row_com['date']);
							elseif(date('Y-m-d', $row_com['date']) == date('Y-m-d', ($server_time-84600)))
								$date = langdate('вчера в H:i', $row_com['date']);
							else
								$date = langdate('j F Y в H:i', $row_com['date']);
					
					if ($row_com['user_id']== $user_id) {
					$delcom = '<div class=\'wall_delete\' onmouseover="myhtml.title('.$row_com['id'].', ”удалить отзыв, wall_del_)" onclick="chatz.del('.$row_com['id'].'); return false" id=\'wall_del_'.$row_com['id'].'\'></div>';
					} else {
					$delcom = '';
					}
					if($sql_us['user_photo'])
					$avau = '/uploads/users/'.$sql_us['user_id'].'/50_'.$sql_us['user_photo'].'';
				else
					$avau = 'templates/Old/images/no_ava_50.png';
					$tm = time()-2;
					if($row_com['date'] > $tm AND $row_com['user_id'] != $user_id) {
					$newcom = '#617e9c';
					$new = 'newcom';
					$tpl->set('{op}',  'var uved = $("#new1")[0];uved.play();');
					} else {
					$newcom = '#fff';
					$new = '';
					$tpl->set('{op}',  '');
					} 
						$text = $row_com['text'];
						$text = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $text);
					$text = replase_smile($text);
					
                        $workcom .= '<div class=\'fotocom\' style=\'margin-bottom:5px;\' id=\'comment_'.$row_com['id'].'\'><div class=\'ava_mini\' style=\'float:left;width:60px\'><a href=\'/u'.$row_com['user_id'].'\' onclick="Page.Go(this.href); return false"><img src=\''.$avau.'\' style=\'border-radius: 5px;\'></a></div>
						<div id=\''.$new.'\' style=\'float:left;width:440px;background: '.$newcom.';border-bottom: solid 1px #c9c9c9;border-right: solid 1px #c9c9c9;-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;padding: 10px;margin-bottom: 5px;\'>
						<div id=\''.$new.'\' style=\'margin-left: -18px;width: 0;height: 0;border-top: 10px solid transparent;border-bottom: 10px solid transparent;border-right: 8px solid #fff;float:left;\'></div>
						<div class=\'fl_r\'>'.$delcom.'</div>
<div class=\'walltext\' style=\'margin-top:2px\'>'.$text.'</div>
</div>
<div style=\'margin-bottom:5px;margin-left:80px;\'><div class=\'infowalltext\'>'.$date.' от <a class=\'cursor_pointer\' onclick="chatz.otvet('.$sql_us['user_search_pref'].'); return false">'.$sql_us['user_search_pref'].'</a></div></div>
<div class=\'clear\'></div>
</div>'; 
                    }
                       $tpl->set('{comms}',  $workcom);
					} else { $tpl->set('{comms}',  '<span style=\'color: #a7adb1;font-weight: 400;font-size: 14px;text-shadow: 0 1px 0 rgba(255,255,255,0.3);\'>Вставь первое сообщение</span>');}
				
				
				$tpl->compile('info');
				
				AjaxTpl();
				
				
			die();
		break;

		
		
		default:
		
			$tpl->load_template('chat/main.tpl');
			
				if($logged){
				$tpl->set('[logged]', '');
				$tpl->set('[/logged]', '');
				$tpl->set_block("'\\[not-logged\\](.*?)\\[/not-logged\\]'si","");
			} else {
				$tpl->set('[not-logged]', '');
				$tpl->set('[/not-logged]', '');
				$tpl->set_block("'\\[logged\\](.*?)\\[/logged\\]'si","");
			}
				
				$count = count($db->super_query("SELECT * FROM `".PREFIX."_chat`",1));
				if ($count >= 50) {
				$limit = $count - 50;
				} else {
				$limit = 0;
				}
				$row = $db->super_query("SELECT * FROM `".PREFIX."_chat` ORDER by `date` ASC LIMIT {$limit},{$count}",1);
				if($row) {
                     foreach($row as $row_com){ 
					$sql_us = $db->super_query("SELECT user_id, user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$row_com['user_id']}'");
					
					
						
							if(date('Y-m-d', $row_com['date']) == date('Y-m-d', $server_time))
								$date = langdate('сегодн¤ в H:i', $row_com['date']);
							elseif(date('Y-m-d', $row_com['date']) == date('Y-m-d', ($server_time-84600)))
								$date = langdate('вчера в H:i', $row_com['date']);
							else
								$date = langdate('j F Y в H:i', $row_com['date']);
					
					if ($row_com['user_id']== $user_id) {
					$delcom = '<div class=\'wall_delete\' onmouseover="myhtml.title('.$row_com['id'].', ”далить отзыв, wall_del_)" onclick="chatz.del('.$row_com['id'].'); return false" id=\'wall_del_'.$row_com['id'].'\'></div>';
					} else {
					$delcom = '';
					}
					if($sql_us['user_photo'])
					$avau = '/uploads/users/'.$sql_us['user_id'].'/50_'.$sql_us['user_photo'].'';
				else
					$avau = 'templates/Old/images/no_ava_50.png';
					$text = $row_com['text'];
					$text = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $text);
					$text = replase_smile($text);
                        $workcom .= '<div class=\'fotocom\' style=\'margin-bottom:5px;\' id=\'comment_'.$row_com['id'].'\'><div class=\'ava_mini\' style=\'float:left;width:60px\'><a href=\'/u'.$row_com['user_id'].'\' onclick="Page.Go(this.href); return false"><img src=\''.$avau.'\' style=\'border-radius: 5px;\'></a></div>
						<div style=\'float:left;width:440px;background: #fff;border-bottom: solid 1px #c9c9c9;border-right: solid 1px #c9c9c9;-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;padding: 10px;margin-bottom: 5px;\'>
						<div style=\'margin-left: -18px;width: 0;height: 0;border-top: 10px solid transparent;border-bottom: 10px solid transparent;border-right: 8px solid #fff;float:left;\'></div>
						<div class=\'fl_r\'>'.$delcom.'</div>
<div class=\'walltext\' style=\'margin-top:2px\'>'.$text.'</div>
</div>
<div style=\'margin-bottom:5px;margin-left:80px;\'><div class=\'infowalltext\'>'.$date.' от <a class=\'cursor_pointer\' onclick="chatz.otvet('.$sql_us['user_search_pref'].'); return false">'.$sql_us['user_search_pref'].'</a></div></div>
<div class=\'clear\'></div>
</div>'; 
                    }
                       $tpl->set('{comms}',  $workcom);
					} else { $tpl->set('{comms}',  '<span style=\'color: #a7adb1;font-weight: 400;font-size: 14px;text-shadow: 0 1px 0 rgba(255,255,255,0.3);\'>Вставь первое сообщение</span>');}
				
				
				$tpl->compile('info');
				
				$tpl->load_template('chat/form.tpl');
				$sql_us = $db->super_query("SELECT user_id, user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
				 $tpl->set('{myid}',  $user_id);
				if($sql_us['user_photo'])
					$tpl->set('{myava}', '/uploads/users/'.$sql_us['user_id'].'/50_'.$sql_us['user_photo'].'');
				else
					$tpl->set('{myava}', 'templates/Old/images/no_ava_50.png');
				
			$tpl->compile('content');

	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>