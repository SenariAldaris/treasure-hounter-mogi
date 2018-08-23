<?php
/*========================================================================================= 
	Appointment: Загрузка картинок при прикриплении файлов со стены, заметок, или сообщений
	File: attach.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================================================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();

if($logged){
	$user_id = $user_info['user_id'];

//* Если нет папки альбома, то создаём её *//
	
	$album_dir = ROOT_DIR."/uploads/attach/{$user_id}/";
	if(!is_dir($album_dir)){ 
		@mkdir($album_dir, 0777);
		@chmod($album_dir, 0777);
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
		if($image_size < 5000000){
			$res_type = strtolower('.'.$type);

			if(move_uploaded_file($image_tmp, $album_dir.$image_rename.$res_type)){
			
//* Подключаем класс для фотографий *//
				
				include ENGINE_DIR.'/classes/images.php';
				
//* Создание оригинала *//
				
				$tmb = new thumbnail($album_dir.$image_rename.$res_type);
				$tmb->size_auto('770');
				$tmb->jpeg_quality('95');
				$tmb->save($album_dir.$image_rename.$res_type);

//* Создание маленькой копии *//
				
				$tmb = new thumbnail($album_dir.$image_rename.$res_type);
				$tmb->size_auto('140x100');
				$tmb->jpeg_quality('95');
				$tmb->save($album_dir.'c_'.$image_rename.$res_type);

//* Вставляем фотографию *//
				
				$db->query("INSERT INTO `".PREFIX."_attach` SET photo = '{$image_rename}{$res_type}', ouser_id = '{$user_id}', add_date = '{$server_time}'");
				$ins_id = $db->insert_id();

				$img_url = $config['home_url'].'uploads/attach/'.$user_id.'/c_'.$image_rename.$res_type;

//* Результат для ответа *//
				
				echo $image_rename.$res_type.'|||'.$img_url.'|||'.$user_id;
			} else
				echo 'big_size';
		} else
			echo 'big_size';
	} else
		echo 'bad_format';
} else
	echo 'no_log';
	
die();
?>