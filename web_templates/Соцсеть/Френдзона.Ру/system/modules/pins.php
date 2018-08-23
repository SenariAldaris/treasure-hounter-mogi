<?php
/*============================================ 
	Appointment: Пины
	File: pins.php 
    Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==============================================*/

if(!$logged) header('Location: /');

$user_id = $user_info['user_id'];
$act = $_GET['act'];

//* Категории *//

function sticker_category($type, $id){
	$arr = array(
		1 => 'Разное', 
		2 => 'Рисование', 
		3 => 'Психология, философия', 
		4 => 'Путешествия', 
		5 => 'Музыка', 
		6 => 'Это интересно', 
		7 => 'Недвойственность', 
		8 => 'НЛО и непознанное', 
		9 => 'Здоровье', 
		10 => 'Йога', 
		11 => 'Эзотерика', 
		12 => 'Магия', 
		13 => 'Гадание', 
		14 => 'Язычество', 
		15 => 'Иудаизм', 
		16 => 'Индуизм',
		17 => 'Ислам',
		18 => 'Христианство',
		19 => 'Буддизм',
		20 => 'Спорт',
		21 => 'Единоборства',
		22 => 'Атеизм и наука',
		23 => 'Астрология'
	);
	if($type == 'export') return $arr;
	else return $arr[$id];
}
	
switch($act){

	case "add_box":
		NoAjaxQuery();
		$tpl->load_template('pins/add_box.tpl');
		foreach(sticker_category('export') as $id => $value){
			$options .= '<option value="'.$id.'">'.$value.'</option>';
		}
		$tpl->set('{category}', $options);
		$row = $db->super_query("SELECT user_id, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
		if($row['user_photo']) $tpl->set('{photo}', '/uploads/users/'.$row['user_id'].'/'.$row['user_photo']);
		else $tpl->set('{photo}', '/templates/Old/images/no_ava.gif');
		$tpl->compile('content');
		AjaxTpl();
		die();
	break;
	
	case "load_pins":
		NoAjaxQuery();
		
		$image_tmp = $_FILES['uploadfile']['tmp_name'];
		$image_name = totranslit($_FILES['uploadfile']['name']);
		$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);
		$image_size = $_FILES['uploadfile']['size'];
		$type = end(explode(".", $image_name));
		
		$max_size = 1024 * 5000;
		
		if($image_size <= $max_size){
			$allowed_files = explode(', ', 'jpg, jpeg, jpe, png, gif');
			if(in_array(strtolower($type), $allowed_files)){
				$res_type = strtolower('.'.$type);	
				$upDir = ROOT_DIR.'/uploads/pins/'.$user_id.'/';
				
				if(!is_dir($upDir)){ 
					@mkdir($upDir, 0777);
					@chmod($upDir, 0777);
				}
				
				$rImg = $upDir.$image_rename.$res_type;
				
				if(move_uploaded_file($image_tmp, $rImg)){
				
					include_once ENGINE_DIR.'/classes/images.php';
					
					$tmb = new thumbnail($rImg);
					$tmb->size_auto(600);
					$tmb->jpeg_quality(95);
					$tmb->save($upDir.'o_'.$image_rename.$res_type);
					
					$tmb = new thumbnail($rImg);
					$tmb->size_auto(200, 1);
					$tmb->jpeg_quality(97);
					$tmb->save($rImg);
					
					die($user_id.'|'.$image_rename.$res_type);
				}
			}
		}else
			die('size');
	
		die();
	break;
	
	case "create":
		NoAjaxQuery();
		
		$category = intval($_POST['category']);
		$descr = textFilter($_POST['descr']);
		$file = textFilter($_POST['file']);
		
		if(!$file) die();
		
		$db->query("INSERT INTO `".PREFIX."_pins` (uid, category, descr, date, sticker) VALUES ('{$user_id}', '{$category}', '{$descr}', '{$server_time}','{$file}')");
		$iid = $db->insert_id();
		$db->query("INSERT INTO `".PREFIX."_likes` (rid, type) VALUES ('{$iid}', 'pin')");
			AjaxTpl();
		die();
	break;
	
	case "view":
		NoAjaxQuery();
		
		$id = intval($_POST['id']);
		
		$row = $db->super_query("SELECT tb1.*, tb2.user_id, user_search_pref, user_photo, user_sex FROM `".PREFIX."_pins` tb1, `".PREFIX."_users` tb2 WHERE tb1.id = '{$id}' AND tb1.uid = tb2.user_id");
		
		if(!$row) die('err');
		
		$sql_comm = $db->super_query("SELECT tb1.*, tb2.user_id, user_photo, user_search_pref FROM `".PREFIX."_pins_comment` tb1, `".PREFIX."_users` tb2 WHERE tb1.pid = '{$id}' AND tb1.uid = tb2.user_id ORDER by `data` ASC LIMIT 0, 10", 1);

		if($sql_comm){
		
			$tpl->load_template('pins/comm.tpl');
			
			foreach($sql_comm as $row_comm){
				
				if($row_comm['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row_comm['user_id'].'/50_'.$row_comm['user_photo']);
				else $tpl->set('{ava}', '/templates/Old/images/no_ava_50.png');
				$tpl->set('{uid}', $row_comm['user_id']);
				$tpl->set('{name}', $row_comm['user_search_pref']);
				$tpl->set('{iid}', $row_comm['id']);
				$tpl->set('{text}', $row_comm['text']);
				megaDate($row_comm['data'], 1, 1);
				if($row_comm['uid'] == $user_id){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
				}else $tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				$tpl->compile('comment');
				
			}
			
		}else $tpl->result['comment'] = '';
		
		$tpl->load_template('pins/view.tpl');
		
//* Sticker *//
		
		$tpl->set('{photo}', '/uploads/pins/'.$row['uid'].'/o_'.$row['sticker']);
		$tpl->set('{descr}', $row['descr']);
		$tpl->set('{id}', $row['id']);
		megaDate($row['date'], 1, 1);
		if($row['user_sex'] == 1) $tpl->set('{sex}', 'добавил');
		else $tpl->set('{sex}', 'добавила');
		$tpl->set('{category}', sticker_category('no', $row['category']));
		
//* User *//
		
		if($user_id == $row['uid']) $tpl->set('{delete}', '<a href="/" onClick="pinsDelete(); return false;" style="color: #fff">удалить</a>');
		else $tpl->set('{delete}', '');
		
		$tpl->set('{uid}', $row['user_id']);
		if($row['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
		else $tpl->set('{ava}', '/templates/Old/images/no_ava_50.png');
		$tpl->set('{name}', $row['user_search_pref']);
		
//* My *//
		
		$my = $db->super_query("SELECT user_id, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
		$tpl->set('{my-id}', $row['user_id']);
		if($my['user_photo']) $tpl->set('{my-ava}', '/uploads/users/'.$my['user_id'].'/50_'.$my['user_photo']);
		else $tpl->set('{my-ava}', '/templates/Old/images/no_ava_50.png');
		
		$tpl->set('{comments}', $tpl->result['comment']);
		if($row['com_num'] > 10) $tpl->set('{comm_butt}', '<div class="likes_more" id="likes_more" onClick="show_more_comment('.$id.')">Показать больше комментариев</div>');
		else $tpl->set('{comm_butt}', '');
		$tpl->compile('content');
		
		AjaxTpl();
		die();
	break;
	
	case 'more_comment':
		NoAjaxQuery();
		
		$id = intval($_POST['id']);
		
		$limit_num = 10;
			
		if($_POST['page'] > 0) $page_cnt = intval($_POST['page']) * $limit_num;
		else $page_cnt = 0;
		
		$sql_comm = $db->super_query("SELECT tb1.*, tb2.user_id, user_photo, user_search_pref FROM `".PREFIX."_pins_comment` tb1, `".PREFIX."_users` tb2 WHERE tb1.pid = '{$id}' AND tb1.uid = tb2.user_id ORDER by `data` ASC LIMIT {$page_cnt}, {$limit_num}", 1);

		if($sql_comm){
		
			$tpl->load_template('pins/comm.tpl');
			
			foreach($sql_comm as $row_comm){
				
				if($row_comm['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row_comm['user_id'].'/50_'.$row_comm['user_photo']);
				else $tpl->set('{ava}', '/templates/Old/images/no_ava_50.png');
				$tpl->set('{uid}', $row_comm['uid']);
				$tpl->set('{name}', $row_comm['user_search_pref']);
				$tpl->set('{iid}', $row_comm['id']);
				$tpl->set('{text}', $row_comm['text']);
				megaDate($row_comm['data'], 1, 1);
				if($row_comm['uid'] == $user_id){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
				}else $tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				$tpl->compile('content');
				
				
			}
			AjaxTpl();
		}
		die();
	break;
	
	case 'comm_send':
		NoAjaxQuery();
		$id = intval($_POST['id']);
		$text = textFilter($_POST['text']);
		if(!empty($text) AND isset($text) AND $id){
			$db->query("UPDATE `".PREFIX."_pins` SET com_num = com_num+1 WHERE id = '{$id}'");
			$db->query("INSERT INTO `".PREFIX."_pins_comment` (pid, uid, text, data) VALUES ('{$id}', '{$user_id}', '{$text}', '{$server_time}')");
			$iid = $db->insert_id();
			$tpl->load_template('pins/comm.tpl');
			$row = $db->super_query("SELECT user_id, user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($row['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
			else $tpl->set('{ava}', '/templates/Old/images/no_ava_50.png');
			$tpl->set('{uid}', $row['user_id']);
			$tpl->set('{name}', $row['user_search_pref']);
			$tpl->set('{iid}', $iid);
			$tpl->set('{text}', $text);
			$tpl->set('[owner]', '');
			$tpl->set('[/owner]', '');
			megaDate($server_time, 1, 1);
			$tpl->compile('content');
			AjaxTpl();
		}
		die();
	break;
	
	case 'del_comm':
		NoAjaxQuery();
		$id = intval($_POST['id']);
		$row = $db->super_query("SELECT uid FROM `".PREFIX."_pins_comment` WHERE id = '{$id}'");
		if($row['uid'] == $user_id){
			$db->query("DELETE FROM `".PREFIX."_pins_comment` WHERE id = '{$id}'");
		}
		die();
	break;
	
	case 'share':
		NoAjaxQuery();
		
		$id = intval($_POST['id']);
		
		$row = $db->super_query("SELECT * FROM `".PREFIX."_pins` WHERE id = '{$id}'");
		
		$wall_text = '<div class="tell_info"><div class="img_sticww"></div></div><div class="profile_update_photo"><a href="" onClick="pins.view('.$id.'); return false"><img src="/uploads/pins/'.$row['uid'].'/'.$row['sticker'].'" style="margin-top:3px"></a></div>';
		
		$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$user_id}', for_user_id = '{$user_id}', text = '{$wall_text}', add_date = '{$server_time}', type = 'делится с вами стикером:'");
		$dbid = $db->insert_id();
		
		$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 1, action_text = '{$wall_text}', obj_id = '{$dbid}', action_time = '{$server_time}'");
		
		$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");
		
		mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
		mozg_clear_cache();
		msgbox('', $lang['no_upage'], 'info');
		echo 'ok';
		
		die();
	break;
	
	case 'delete_sticker':
		NoAjaxQuery();
		$id = intval($_POST['id']);
		
		$row = $db->super_query("SELECT uid, sticker FROM `".PREFIX."_pins` WHERE id = '{$id}'");
		
		
		if($row['uid'] != $user_id || !$row['uid']) die('err');
		
		$url_1 = ROOT_DIR . '/uploads/pins/'.$row['uid'].'/o_'.$row['sticker'];
		$url_2 = ROOT_DIR . '/uploads/pins/'.$row['uid'].'/'.$row['sticker'];
		
		@unlink($url_1);
		@unlink($url_2);
		
		$db->query("DELETE FROM `".PREFIX."_pins` WHERE id = '{$id}'");
		$db->query("DELETE FROM `".PREFIX."_pins_comment` WHERE pid = '{$id}'");
		$db->query("DELETE FROM `".PREFIX."_likes` WHERE rid = '{$id}' AND type = 'pin'");
		
		echo 'ok';
		
		die();
	break;

	default:
	
	$limit_num = 30;
			
	if($_GET['page_cnt'] > 0) $page_cnt = intval($_GET['page_cnt']) * $limit_num;
	else $page_cnt = 0;
	
	$query = $db->safesql(strip_data(urldecode($_POST['query'])));
	$query_search = strtr($query, array(' ' => '%'));
	
	$my = intval($_POST['my']);
	$doload = intval($_POST['doload']);
	
	$c_change = intval($_POST['c_change']);
	
	$cat = intval($_POST['cat']);
	if($cat) $where_cat = "AND category = {$cat}";
	else $where_cat = '';
	
	if($query AND !$my) {
		$where_sql = "AND tb1.descr LIKE '%{$query}%'";
	}elseif($my AND $query){
		$where_sql = "AND tb1.descr LIKE '%{$query}%' AND tb1.uid = '{$user_id}'";
	}elseif($my AND !$query){
		$where_sql = "AND tb1.uid = '{$user_id}'";
	}
	
	$sql_ = $db->super_query("SELECT tb1.*, tb2.user_id, user_search_pref, user_photo, user_sex FROM `".PREFIX."_pins` tb1, `".PREFIX."_users` tb2 WHERE tb1.uid = tb2.user_id {$where_sql} {$where_cat} ORDER by `date` DESC LIMIT {$page_cnt}, {$limit_num}", 1);
	
	if($sql_){
		$tpl->load_template('pins/pin.tpl');
		foreach($sql_ as $row){
		
//* Sticker *//
			
			$tpl->set('{photo}', '/uploads/pins/'.$row['uid'].'/'.$row['sticker']);
			$tpl->set('{descr}', $row['descr']);
			$tpl->set('{id}', $row['id']);
			megaDate($row['date'], 1, 1);
			if($row['user_sex'] == 1) $tpl->set('{sex}', 'добавил');
			else $tpl->set('{sex}', 'добавила');
			$tpl->set('{category}', sticker_category('no', $row['category']));
			
//* User *//
			
			$tpl->set('{uid}', $row['user_id']);
			if($row['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
			else $tpl->set('{ava}', '/templates/Old/images/no_ava_50.png');
			$tpl->set('{name}', $row['user_search_pref']);
			$tpl->compile('pins');
		}
	}else{
		if(!$doload || $c_change) $tpl->result['pins'] = '<div class="info_center"><br><br>Ни чего не найденно<br><br></div>';
	}
	if($query || $doload || $my || $c_change) {
		echo $tpl->result['pins'];
		die();
	}
	
	$tpl->load_template('pins/main.tpl');
	$tpl->set("{activetab-1}", 'activetab');
	
	if(!$query) $tpl->set("{query}", 'Начните вводить любое слово');
	else $tpl->set("{query}", $query);
	
	$tpl->set('{pins}', $tpl->result['pins']);
	
	foreach(sticker_category('export') as $id => $value){
		$options .= '<option value="'.$id.'">'.$value.'</option>';
	}
	$tpl->set('{category}', $options);
	navigation($page_cn, $limit_num, '/index.php'.$query.'&page_cnt=');
	$tpl->compile('content');
}

?>