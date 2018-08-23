<?php

if(!defined('MOZG'))

	die('И че ты тут забыл??');

if($ajax == 'yes')

	NoAjaxQuery();

$user_id = $user_info['user_id'];

$key = '0PFXXTE349BMNFSV9801DZ843VUAA482';

$act = $_GET['act'];

if($logged){

	switch($act){

		//Создание приложения
		case "create":

			$metatags['title'] = 'Создание приложения';

			$tpl->load_template('apps/editapp/create.tpl');

			$tpl->compile('content');

		break;

		//Создание приложения
		case "do_create":

			$title = strip_tags($_POST['title']);

			$desc = strip_tags($_POST['desc']);
			
			$category = $_POST['category'];

			$secret = md5($key.'_'.rand(99,9999)); // Генерируем секретный ключ

			$db->query("SET NAMES 'utf8'"); // Я почему то не смог нормально записать)

			$db->query("INSERT INTO `".PREFIX."_apps` (`id`,`title`,`desc`,`secret`,`user_id`, `category`) VALUES ('','".$title."','".$desc."','".$secret."','".$user_id."','".$category."') "); 

			$dbid = $db->insert_id();

			echo $dbid;

			die();

		break;

		//Вкладка info
		case "info":

			$metatags['title'] = 'Редактирование приложения';

			$id = intval($_GET['id']);

			$row = $db->super_query("SELECT `id`, `title`, `desc`, `img`,`secret`,`user_id`,`admins` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");

			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){

				if($row['img'] == ''){

					$img = '/uploads/apps/no.gif';

				} else $img = '/uploads/apps/'.$row['id'].'/100_'.$row['img'];

				$tpl->set('{id}', $row['id']);

				$tpl->set('{title}', $row['title']);

				$tpl->set('{img}', $img);

				$tpl->set('{desc}', $row['desc']);

				$tpl->set('{hash}', md5($id.'_'.$key));

				$tpl->load_template('apps/editapp/info.tpl');

				$tpl->compile('content');

			} else {

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			} 
		break;

		// Сохранение страницы info
		case "save_info":

			NoAjaxQuery();

			$id = intval($_POST['app']);

			$app_hash = $_POST['app_hash'];

			$title = strip_tags($_POST['app_title']);

			$desc = $_POST['app_desc'];

			if($app_hash == md5($id.'_'.$key)){

				if($title == '') die("name");

				elseif($desc == '') die("desc");

				$db->query("SET NAMES 'utf8'"); // Я почему то не смог нормально записать)

				$db->query("UPDATE `".PREFIX."_apps` SET `title`='{$title}', `desc`='{$desc}' WHERE `id`='{$id}'");

				echo 'ok';

			} else {

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			}
			
		die();

		break;


		//Вкладка настройки
		case "options":

			$metatags['title'] = 'Редактирование приложения';

			$id = intval($_GET['id']);

			$row = $db->super_query("SELECT `id`, `title`, `desc`, `img`,`status`,`secret`,`width`,`height`,`url`,`user_id`,`admins`,`type` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");

			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){

				// Немного убого, но я ленив)
				if($row['status'] == 1){

					$option = '<option value="1" selected="selected">Приложение включено и видно всем</option><option value="-1" >Приложение отключено</option>';

				}else{

					$option = '<option value="1" >Приложение включено и видно всем</option><option value="-1" selected="selected">Приложение отключено</option>';

				}

				if($row['type'] == 1){

					$type = '<option value="1" selected="selected">Iframe</option><option value="2">Flash</option>';

					$tpl->set('{sflash}', 'none');

					$tpl->set('{siframe}', 'table');

				}else{

					$type = '<option value="1">Iframe</option><option value="2" selected="selected">Flash</option>';

					$tpl->set('{sflash}', 'table');

					$tpl->set('{siframe}', 'none');

				}

           		$tpl->set('{id}', $row['id']);

           		$tpl->set('{url}', $row['url']);

				$tpl->set('{title}', $row['title']);

				$tpl->set('{desc}', $row['desc']);

				$tpl->set('{height}', $row['height']);

				$tpl->set('{width}', $row['width']);

				$tpl->set('{img}', '/uploads/apps/'.$row['id'].'/100_'.$row['img']);

				$tpl->set('{status}', $row['status']);

				$tpl->set('{option}', $option);

				$tpl->set('{type}', $type);

				$tpl->set('{secret}', $row['secret']);

				$tpl->set('{hash}', md5($id.'_'.$key));

				$tpl->load_template('apps/editapp/options.tpl');

				$tpl->compile('content');

			}else{

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			}

		break;

		// Сохранение страницы info
		case "save_options":

			NoAjaxQuery();

			$id = intval($_POST['app']);

			$app_hash = $_POST['app_hash'];

			$secret = $_POST['app_secret'];

			$url = $_POST['app_url'];

			$status = intval($_POST['app_status']);

			$width = intval($_POST['app_width']);

			$height = intval($_POST['app_height']);

			$type = intval($_POST['app_type']);

			if($secret == '') die("secret2");

			elseif($url == '' and $type == '1') die("iframe_url");

			elseif($width == '' and $type == '1') die("iframe_width");

			elseif($height == '' and $type == '1') die("iframe_height");

			if($app_hash == md5($id.'_'.$key)){

				$db->query("UPDATE `".PREFIX."_apps` SET `secret`='{$secret}', `status`='{$status}', `url`='{$url}', `width`='{$width}', `height`='{$height}', `type`='{$type}' WHERE `id`='{$id}'");

				echo 'ok';

			} else {

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			}

		die();

		break;

		//Окно загрузки swf
		case "load_flash":

			NoAjaxQuery();

			$tpl->set('{id}', intval($_GET['id']));

			$tpl->load_template('/apps/editapp/load_flash.tpl');

			$tpl->compile('content');

			AjaxTpl();

			die();

		break;

		case 'flash':

			NoAjaxQuery();

			$id = intval($_GET['id']);

			$flash_tmp = $_FILES['uploadfile']['tmp_name'];

			$flash_name = totranslit($_FILES['uploadfile']['name']); // оригинальное название для оприделения формата

			$flash_rename = substr(md5($server_time+rand(1,100000)), 0, 15); // имя фотографии

			$flash_size = $_FILES['uploadfile']['size']; // размер файла

			$type = end(explode(".", $flash_name)); // формат файла

			$flash_size1 = getimagesize($flash_tmp);

			//Проверям если, формат верный то пропускаем
			if(strtolower($type) == 'swf'){

				$res_type = '.'.$type;

				$wid = $flash_size1[0];

				$hel = $flash_size1[1];

				$db->query("UPDATE `".PREFIX."_apps` SET `flash`='{$flash_rename}{$res_type}', `width`='{$wid}', `height`= '{$hel}' WHERE `id`='{$id}'");

				$flash_dir = ROOT_DIR.'/uploads/apps/'.$id.'/';

				if(!is_dir($flash_dir)){

					@mkdir($flash_dir, 0777);

					@chmod($flash_dir, 0777);

				}

				move_uploaded_file($flash_tmp, $flash_dir.$flash_rename.'.swf');

				echo 'ok'.$wid . $hel;

			} else	echo 'bad_format';

			die();

		break;

		//Вкладка платежи
		case "payments":

			$metatags['title'] = 'Редактирование приложения';

			$id = intval($_GET['id']);

			$row = $db->super_query("SELECT `id`,`user_id`,`balance`,`admins` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");

			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){

				$row1 = $db->super_query("SELECT `id`, `votes`, `from`, `whom`,`date`,`application_id` FROM `".PREFIX."_apps_transactions` WHERE `id`='{$id}' ORDER BY id DESC LIMIT 20",1);

				$tpl->load_template('apps/editapp/table.tpl');

				foreach($row1  as $rowsd){

					$users = $db->super_query("SELECT `user_name`, `user_lastname` FROM `".PREFIX."_users` WHERE `user_id`='{$rowsd[from]}'");

					if(date('Y-m-d', $rowsd['date']) == date('Y-m-d', $server_time)) $dateTell = langdate('сегодня в H:i', $rowsd['date']);	else $dateTell = langdate('j F Y в H:i', $rowsd['date']);

					$tpl->set('{name}', $users['user_name'].' '.$users['user_lastname']);

					$tpl->set('{from}', $rowsd['from']);

					$tpl->set('{whom}', $rowsd['whom']);

					$tpl->set('{date}', $dateTell);

					$tpl->set('{application_id}', $rowsd['application_id']);

					$tpl->set('{id}', $rowsd['id']);

					$tpl->set('{votes}', $rowsd['votes']);

					$tpl->compile('payments');

				}

					$tpl->set('{id}', $id);

					$tpl->set('{balance}', $row['balance']);

					$tpl->load_template('apps/editapp/payments.tpl');

					$tpl->set('{payments}', $tpl->result['payments']);

					$tpl->compile('content');

			}else{

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			} 

		break;

		//Вкладка Администраторы
		case "admins":

			$metatags['title'] = 'Редактирование приложения';

			$id = intval($_GET['id']);

			$row = $db->super_query("SELECT `id`,`user_id`,`admins` FROM `".PREFIX."_apps` WHERE `id`='{$id}'");

			$array_admin = explode('|', $row['admins']);

			if(in_array($user_id, $array_admin) or $user_id == $row['user_id'] ){

				$array_admins = explode('|', $row['admins']);

				$tpl->load_template('apps/editapp/admin_all.tpl');

				foreach($array_admins as $user){

					if($user){

						$infoUser = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user}'");

						if($infoUser['user_photo'])

							$tpl->set('{img}', '/uploads/users/'.$user.'/50_'.$infoUser['user_photo']);

						else

							$tpl->set('{img}', '/images/no_ava_50.png');
						
						$tpl->set('{name}', $infoUser['user_search_pref']);

						$tpl->set('{uid}', $user);

						$tpl->compile('all');

					}

				}

				$users = $db->super_query("SELECT user_search_pref, user_photo FROM `".PREFIX."_users` WHERE `user_id`='{$row[user_id]}'");

				$tpl->set('{id}', $id);

				if($users['user_photo'])

					$tpl->set('{img}', '/uploads/users/'.$row['user_id'].'/50_'.$users['user_photo']);

				else

					$tpl->set('{img}', '/images/no_ava_50.png');

				$tpl->set('{name}', $users['user_search_pref']);

				$tpl->set('{uid}', $row['user_id']);

				$tpl->set('{hash}', md5($id.'_'.$key));

				$tpl->set('{all}', $tpl->result['all']);

				$tpl->load_template('apps/editapp/admins.tpl');

				$tpl->compile('content');

			}else{

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			} 

		break;

		case 'save_admin':

			$id = intval($_POST['id']);

			$app_hash = $_POST['hash'];

			$addr = intval($_POST['addr']);

			if($app_hash == md5($id.'_'.$key)){

				//Проверяем на существование юзера
				$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` WHERE user_id = '{$addr}'");

				if(!$row['cnt']) die('not_user');

				$myRow = $db->super_query("SELECT admins,user_id FROM `".PREFIX."_apps` WHERE id = '{$id}'");

				$array_admin = explode('|', $myRow['admins']);

				if(!in_array($addr, $array_admin) AND $user_id != $addr AND $myRow['user_id'] != $addr){

					$db->query("UPDATE `".PREFIX."_apps` SET admins_num = admins_num+1, admins = '{$myRow['admins']}|{$addr}|' WHERE id = '{$id}'");

					echo 'ok';

				} else echo "not";

			} else {

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			}

			die();

    	break;

    	case 'del_admin':

			$id = intval($_POST['id']);

			$app_hash = $_POST['hash'];

			$addr = intval($_POST['addr']);

			if($app_hash == md5($id.'_'.$key)){

				$myRow = $db->super_query("SELECT admins,user_id FROM `".PREFIX."_apps` WHERE id = '{$id}'");

				$array_admin = explode('|', $myRow['admins']);

				if($myRow['user_id'] == $addr) die("general");

				if(in_array($addr, $array_admin) AND $user_id != $addr){

					$myRow['admins'] = str_replace("|{$addr}|", "", $myRow['admins']);

					$db->query("UPDATE `".PREFIX."_apps` SET admins_num = admins_num-1, admins = '{$myRow['admins']}' WHERE id = '{$id}'");

					echo 'ok';

				} else echo "not";
			
			} else {

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			}

			die();

    	break;

		case "del_admin_form":

			$id = intval($_POST['id']);

			$addr = intval($_POST['addr']);

			$app_hash = $_POST['hash'];

			if($app_hash == md5($id.'_'.$key)){

    			$app = $db->super_query("SELECT `title` FROM `".PREFIX."_apps` WHERE id = '{$id}'");

    			$users = $db->super_query("SELECT `user_name`, `user_lastname` FROM `".PREFIX."_users` WHERE user_id = '{$addr}'");

    			$tpl->set('{id}', $id);

				$tpl->set('{title}', $app['title']);

				$tpl->set('{uid}', $addr);

				$tpl->set('{name}', $users['user_name']. ' '. $users['user_lastname']);

  				$tpl->load_template('apps/editapp/del_admin_form.tpl');

   				$tpl->compile('content');

   			} else {

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			}

			AjaxTpl();

  			die();

 			$tpl->clear();

  			$db->free();

  		break;

  		case "search_admin":

    		$row = $db->super_query("SELECT user_photo, user_id FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");

  			$tpl->load_template('apps/editapp/add_admin.tpl');

   			if($row['user_photo']){

    			$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);

   			} else {

    			$tpl->set('{ava}', '/images/no_ava.gif');

   			}

   			$tpl->compile('content');

			AjaxTpl();

  			die();

 			$tpl->clear();

  			$db->free();

  		break;

  		case "checkAdmin":

   			NoAjaxQuery();

   			$id = intval($_POST['id']);

   			$row = $db->super_query("SELECT user_photo, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$id}'");

   			if($row) echo $row['user_search_pref']."|".$row['user_photo'];

   			die();

  		break;

		//Удаление приложения
		case "deleteapp":

			$id = intval($_POST['app']);

			$app_hash = $_POST['app_hash'];

			if($app_hash == md5($id.'_'.$key)){

				$app = $db->super_query("SELECT `title` FROM `".PREFIX."_apps` WHERE id = '{$id}'");

				if($app['user_id'] == $user_id){

					$db->query("DELETE FROM `".PREFIX."_apps` WHERE `id`='{$id}'");

					echo "ok";

				} else echo "not";

			} else {

				$tpl->load_template('apps/editapp/error.tpl');

				$tpl->compile('content');

			}

		break;

		//Окно загрузки фотографий
		case "load_photo":

			NoAjaxQuery();

			$tpl->set('{id}', intval($_GET['id']));

			$tpl->load_template('/apps/editapp/load_photo.tpl');

			$tpl->compile('content');

			AjaxTpl();

			die();

		break;

		//Функция загрузки фото
		case "upload":

			NoAjaxQuery();

			include APPLICATION_DIR.'/classes/images.php';

			$id = intval($_GET['id']);

			$uploaddir = ROOT_DIR.'/uploads/apps/';
			
			//Если нет папок юзера, то создаём её
			if(!is_dir($uploaddir.$id)){ 

				@mkdir($uploaddir.$id, 0777 );

				@chmod($uploaddir.$id, 0777 );

			}

			//Разришенные форматы
			$allowed_files = array('jpg', 'png', 'gif');

			//Получаем данные о фотографии
			$image_tmp = $_FILES['uploadfile']['tmp_name'];

			$image_name = totranslit($_FILES['uploadfile']['name']); // оригинальное название для оприделения формата

			$image_rename = substr(md5($server_time+rand(1,100000)), 0, 15); // имя фотографии

			$image_size = $_FILES['uploadfile']['size']; // размер файла

			$type = end(explode(".", $image_name)); // формат файла

			if(in_array($type, $allowed_files)){

				if($image_size < 5000000){

					$res_type = '.'.$type;

					$uploaddir = ROOT_DIR.'/uploads/apps/'.$id.'/'; // Директория куда загружать

					if(move_uploaded_file($image_tmp, $uploaddir.$image_rename.$res_type)) {

						//Создание уменьшеной копии 100х100
						$tmb = new thumbnail($uploaddir.$image_rename.$res_type);

						$tmb->size_auto('100x100');

						$tmb->jpeg_quality(97);

						$tmb->save($uploaddir.'100_'.$image_rename.$res_type);

						$image_rename = $db->safesql($image_rename);

						$res_type = $db->safesql($res_type);

						$db->query("UPDATE `".PREFIX."_apps` SET `img`='{$image_rename}{$res_type}' WHERE `id`='{$id}'");

						echo $config['home_url'].'uploads/apps/'.$id.'/100_'.$image_rename.$res_type;

					} else

						echo 'bad';

				} else

					echo 'big_size';

			} else

				echo 'bad_format';

		break;

	}

	$db->free();

	$tpl->clear();

} else {

	$user_speedbar = 'Информация';

	msgbox('', $lang['not_logged'], 'info');

}

?>