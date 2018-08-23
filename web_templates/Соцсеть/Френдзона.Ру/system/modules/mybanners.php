<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){

	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
		
//* Покупка рекламы *//

		case "buy":
			
			NoAjaxQuery();
				
			$pos = intval($_POST['pos']);
			if($pos < 0 OR $pos > 5) $pos = 1;
			
			$link = textFilter($_POST['link'], false, true);
			$title = textFilter($_POST['title'], false, true);
			$descr = textFilter($_POST['descr'], false, true);
			$img = textFilter($_POST['img'], false, true);
			if(!$img) $img = 'none';
			$transitions = intval($_POST['transitions']);
			
			$cat = intval($_POST['cat']);
			$redemption = intval($_POST['redemption']);
			if($redemption < 1) $redemption = 1;
			
			$rowPEREB = $db->super_query("SELECT redemption FROM `".PREFIX."_users_banners` WHERE pos = 5 AND approve = 0");
			if($rowPEREB['redemption']){
				
				$config['cost_banner_right_3'] = $rowPEREB['redemption'];
				
			}
			
			if($pos == 1) $cost = $config['cost_banner_top'];
			elseif($pos == 2) $cost = $config['cost_banner_bottom'];
			elseif($pos == 3) $cost = $config['cost_banner_right_1'];
			elseif($pos == 4) $cost = $config['cost_banner_right_2'];
			elseif($pos == 5) $cost = $config['cost_banner_right_3'];
			else $cost = $config['cost_banner_top'];
			
			$rCost = $transitions * $cost;
			if($rCost < 0) $rCost = 0;
			
			if($pos != 5) $redemption = '';

//* Выводим текст баланс юзера *//
			
			$row = $db->super_query("SELECT balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
//* Если у юзера есть на балансе *//
			
			if($row['balance_rub'] >= $rCost AND $rCost > 0){
				
				$checkImg = ROOT_DIR.'/uploads/mybanners/'.$user_id.'/'.$img;
				
				if(file_exists($checkImg)){
				
//* Вставляем в базу данных на проверку *//
					
					$db->query("INSERT INTO `".PREFIX."_users_banners` SET user_id = '{$user_id}', pos = '{$pos}', title = '{$title}', descr = '{$descr}', transitions = '{$transitions}', rub_num = '{$rCost}', date = '{$server_time}', approve = 1, img = '{$img}', link = '{$link}', cat = '{$cat}', redemption = '{$redemption}'");
					
//* Снимаем с баланса *//
					
					$db->query("UPDATE `".PREFIX."_users` SET balance_rub = balance_rub - '{$rCost}' WHERE user_id = '{$user_id}'");
					
					@copy($checkImg, ROOT_DIR.'/uploads/mybanners/'.$user_id.'/ok/'.$img);
					@unlink($checkImg);
				
				} else
					echo 2;
				
			} else
				echo 1;

			exit();
			
		break;
		
//* Загрузка изображения *//
		
		case "upload":
		
			NoAjaxQuery();
			
//* Куда грузить *//
			
			$upDir = ROOT_DIR.'/uploads/mybanners/'.$user_id.'/';
			
//* Создаем папку для юзера, если её нету *//
			
			if(!is_dir($upDir)){ 
				@mkdir($upDir, 0777);
				@chmod($upDir, 0777);
				@mkdir($upDir.'/ok/', 0777);
				@chmod($upDir.'/ok/', 0777);
			}
			
//* Чистим пред загруж баннер *//
			
			$fdir = opendir($upDir);
	
			while($file = readdir($fdir)){
				
				@unlink($upDir.$file);
			
			}
			
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
				if($image_size < 1024000){
				
					$res_type = strtolower('.'.$type);
					
					if(move_uploaded_file($image_tmp, $upDir.$image_rename.$res_type)){

//* Подключаем класс для фотографий *//
						
						include ENGINE_DIR.'/classes/images.php';
						
						$rImg = $upDir.$image_rename.$res_type;
						
						echo $image_rename.$res_type;

					} else
						echo 2;
				} else
					echo 1;
			}
	
			exit();
			
		break;

//* Записываем переход в статистику *//
		
		case "log":
			
			NoAjaxQuery();
			
			$id = intval($_POST['id']);
			
//* Проверка, что реклама есть *//
			
			$row = $db->super_query("SELECT transitions, transitions_ok, approve, rub_num, pos FROM `".PREFIX."_users_banners` WHERE id = '{$id}'");
			
//* Проверка в логах *//
			
			$check = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_banners_stats` WHERE user_id = '{$user_id}' AND banner_id = '{$id}'");

if($user_id == 3) $check['cnt'] = 0;			

//* Пишем в статистику *//
			
			if($row AND $row['approve'] == 0 AND !$check['cnt']){
				
//* Новое кол-во переходов *//
				
				$transitions_ok = $row['transitions_ok'] + 1;
				
//* Узнаем цену за переход *//
				
				$rub_ok = $row['rub_num'] / $row['transitions'];
				
//* Если это уже последний переход, то ставим статус прорекламировано *//
				
				if($row['transitions'] == $transitions_ok){
					
					$sql_approv = ", approve = 3";
					
//* Выводим след баннер на показ *//
					
					$rowN = $db->super_query("SELECT id FROM `".PREFIX."_users_banners` WHERE approve = 2 AND pos = '{$row['pos']}' ORDER by `date` ASC");
					
					$db->query("UPDATE `".PREFIX."_users_banners` SET approve = 0 WHERE id = '{$rowN['id']}'");
					
				}
				
//* Обновляем данные для статистики *//
				
				$db->query("UPDATE `".PREFIX."_users_banners` SET transitions_ok = '{$transitions_ok}', rub_ok = rub_ok + '{$rub_ok}' {$sql_approv} WHERE id = '{$id}'");
				
				$db->query("INSERT INTO `".PREFIX."_banners_stats` SET user_id = '{$user_id}', banner_id = '{$id}'");
				
			}
			
			
			exit();
			
		break;
		
//* Сохранение настроек *//
		
		case "save_sett":
			
			NoAjaxQuery();
			
			$cat = intval($_POST['cat']);
			
			$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_banners_cat` WHERE id = '{$cat}'");
			
			if($row OR $cat == 0){
			
				$db->query("UPDATE `".PREFIX."_users` SET banner_cat = '{$cat}' WHERE user_id = '{$user_id}'");
			
			}
			
			exit();
			
		break;
		
		default:
		
//* Страница покупки рекламы *//
			
//* Выводим свои баннеры *//
			
			$sql_ = $db->super_query("SELECT title, id, transitions, transitions_ok, rub_num, rub_ok, date, approve, pos FROM `".PREFIX."_users_banners` WHERE user_id = '{$user_id}' ORDER by `date` DESC LIMIT 0,50", 1);
			
			if($sql_){
			
				$tpl->load_template('mybanners/mybanner.tpl');
				foreach($sql_ as $row){
					
					$tpl->set('{title}', stripslashes($row['title']));
					megaDate($row['date']);
					$tpl->set('{transitions}', $row['transitions']);
					$tpl->set('{transitions_ok}', $row['transitions_ok']);
					$tpl->set('{rub_num}', $row['rub_num']);
					$tpl->set('{rub_ok}', $row['rub_ok']);
					
					if($row['pos'] == 1) $tpl->set('{pos}', 'Верх 1020х150');
					elseif($row['pos'] == 2) $tpl->set('{pos}', 'Низ 560х175');
					elseif($row['pos'] == 3) $tpl->set('{pos}', 'Справа №1 65х90');
					elseif($row['pos'] == 4) $tpl->set('{pos}', 'Справа №2 65х90');
					elseif($row['pos'] == 5) $tpl->set('{pos}', 'Справа №3 65х90');
					else $tpl->set('{pos}', 'Верх 1020х150');
					
					if($row['approve'] == 1) $tpl->set('{status}', '<font color="blue">Проверяется</font>');
					elseif($row['approve'] == 2) $tpl->set('{status}', '<font color="DarkGoldenrod">В очереди</font>');
					elseif($row['approve'] == 3) $tpl->set('{status}', '<font color="MediumPurple">Прорекламировали</font>');
					elseif($row['approve'] == 4) $tpl->set('{status}', '<font color="MediumPurple">Перекупили</font>');
					else $tpl->set('{status}', '<font color="Green">Рекламируется</font>');
					
					$tpl->compile('banners');
					
				}
			
			} else {
				
				$tpl->result['banners'] = '<div class="info_center margin_top_10">Вы не покупали рекламу.</div>';
				
			}
			
			$tpl->load_template('mybanners/main.tpl');
			
			$rowPEREB = $db->super_query("SELECT redemption FROM `".PREFIX."_users_banners` WHERE pos = 5 AND approve = 0");
			if($rowPEREB['redemption']){
				
				$config['cost_banner_right_3'] = $rowPEREB['redemption'];
				
			}
			
			$tpl->set('{cost_banner_top}', $config['cost_banner_top']);
			$tpl->set('{cost_banner_bottom}', $config['cost_banner_bottom']);
			$tpl->set('{cost_banner_right_1}', $config['cost_banner_right_1']);
			$tpl->set('{cost_banner_right_2}', $config['cost_banner_right_2']);
			$tpl->set('{cost_banner_right_3}', $config['cost_banner_right_3']);
			$tpl->set('{banners}', $tpl->result['banners']);
			
//* Категории *//
			
			$sql_cat = $db->super_query("SELECT * FROM `".PREFIX."_banners_cat` ORDER by `name` DESC", 1);
			
			foreach($sql_cat as $row_cat){
				
				$cats .= '<option value="'.$row_cat['id'].'">'.$row_cat['name'].'</option>';
				
			}
			
			$tpl->set('{cat}', $cats);
			
			$tpl->set('{cat-2}', installationSelected($user_info['banner_cat'], $cats));

			
			$tpl->compile('content');
			
	}
	
	$tpl->clear();
	$db->free();
	
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>