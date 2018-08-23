<?php
/*========================================== 
	Appointment: Игры
	File: apps.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

//* Загрузка постера *//

if($_GET['act'] == 'upload'){

//* Получаем данные о файле *//

	$image_tmp = $_FILES['uploadfile']['tmp_name'];
	
//* Оригинальное название для определения формата *//	
	
	$image_name = totranslit($_FILES['uploadfile']['name']);
	
//* Имя файла *//	
	
	$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);
	
//* Размер файла *//	
	
	$image_size = $_FILES['uploadfile']['size'];
	
//* Формат файла *//	
	
	$type = end(explode(".", $image_name));
	
	$max_size = 1024 * 5000;
	
	$id = intval($_GET['id']);
	if (!$id) {
		die();
	}
	
//* Проверка размера *//
	
	if($image_size <= $max_size){
		
//* Разришенные форматы *//
		
		$allowed_files = explode(', ', 'jpg, jpeg, jpe, png, gif');
		
//* Проверяем если, формат верный то пропускаем *//
		
		if(in_array(strtolower($type), $allowed_files)){
				
			$res_type = strtolower('.'.$type);
			
			$rowCheck = $db->super_query("SELECT poster FROM `".PREFIX."_games_ver` WHERE id = '{$id}'");
			
			$upDir = ROOT_DIR.'/uploads/apps/for_ver/'.$id.'/';
			
			$rImg = $upDir.$image_rename.$res_type;
			
			if(move_uploaded_file($image_tmp, $rImg)){
				
//* Подключаем класс для фотографий *//
					
					include_once ENGINE_DIR.'/classes/images.php';
					
//* Создание маленькой копии *//
					
					$tmb = new thumbnail($rImg);
					$tmb->size_auto('75x75');
					$tmb->jpeg_quality('100');
					$tmb->save($rImg);
					
//* Если редактируем постер *//
					
					$db->query("UPDATE `".PREFIX."_games_ver` SET poster = '{$image_rename}{$res_type}' WHERE id = '{$id}'");
					$db->query("UPDATE `".PREFIX."_games_ver_files` SET file = '{$image_rename}{$res_type}' WHERE game_id = '{$id}' AND type = 'poster'");
					
					@unlink($upDir.$rowCheck['poster']);
					
					echo $id.'/'.$image_rename.$res_type;
					
			}
			
		} else
			echo 2;
		
	} else
		echo 1;
	
	exit();
	
};

//* Загрузка игры SWF *//

if($_GET['act'] == 'upload_swf'){

//* Получаем данные о файле *//
	
	$image_tmp = $_FILES['uploadfile']['tmp_name'];
	
//* Оригинальное название для определения формата *//	
	
	$image_name = totranslit($_FILES['uploadfile']['name']);
	
//* Имя файла *//	
	
	$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);
	
//* Размер файла *//	
	
	$image_size = $_FILES['uploadfile']['size'];
	
//* Формат файла *//	
	
	$type = end(explode(".", $image_name));
	
	$max_size = ( 1024 * 5000 ) * 20;
	
	$id = intval($_GET['id']);
	if (!$id) {
		die();
	}
	
//* Проверка размера *//
	
	if($image_size <= $max_size){

//* Проверяем если, формат верный то пропускаем *//
		
		if(strtolower($type) == 'swf'){
				
			$res_type = strtolower('.'.$type);
			
			$rowCheck = $db->super_query("SELECT flash FROM `".PREFIX."_games_ver` WHERE id = '{$id}'");
			
			$upDir = ROOT_DIR.'/uploads/apps/for_ver/'.$id.'/';
			
			$rImg = $upDir.$image_rename.$res_type;
			
			if(move_uploaded_file($image_tmp, $rImg)){
				
//* Если редактируем игру *//
					
					$db->query("UPDATE `".PREFIX."_games_ver` SET flash = '{$image_rename}{$res_type}' WHERE id = '{$id}'");
					$db->query("UPDATE `".PREFIX."_games_ver_files` SET file = '{$image_rename}{$res_type}' WHERE game_id = '{$id}' AND type = 'swf'");
					
					@unlink($upDir.$rowCheck['flash']);

			}
			
		} else
			echo 2;
		
	} else
		echo 1;
	
	exit();
	
}

//* Загрузка скрин *//

if($_GET['act'] == 'upload_scrin'){

//* Получаем данные о файле *//
	
	$image_tmp = $_FILES['uploadfile']['tmp_name'];
	
//* Оригинальное название для определения формата *//	
	
	$image_name = totranslit($_FILES['uploadfile']['name']);
	
//* Имя файла *//	
	
	$image_rename = substr(md5($server_time+rand(1,100000)), 0, 20);
	
//* Размер файла *//	
	
	$image_size = $_FILES['uploadfile']['size'];
	
//* Формат файла *//	
	
	$type = end(explode(".", $image_name)); 
	
	$max_size = 1024 * 5000;
	
	$id = intval($_GET['id']);
	if (!$id) {
		die();
	}
	
//* Проверка размера *//
	
	if($image_size <= $max_size){
		
//* Разришенные форматы *//
		
		$allowed_files = explode(', ', 'jpg, jpeg, jpe, png, gif');
		
// * Проверяем если, формат верный то пропускаем *//

		if(in_array(strtolower($type), $allowed_files)){
				
			$res_type = strtolower('.'.$type);
			
			$rowCheck = $db->super_query("SELECT id FROM `".PREFIX."_games` WHERE id = '{$id}'");
			
			$upDir = ROOT_DIR.'/uploads/apps/for_ver/'.$id.'/';
			
			$rImg = $upDir.$image_rename.$res_type;
			
//* Читаем хеш *//
			
			$app_hash = $db->safesql($_SESSION['apps_hash']);
			
//* Считаем кол-во загруженных скринов *//
			
			$cnRow = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_games_ver_files` WHERE game_id = '{$id}' AND type = 'scrin'");
			
			if($cnRow['cnt'] <= 3){
			
				if(move_uploaded_file($image_tmp, $rImg)){
					
//* Подключаем класс для фотографий *//
						
						include_once ENGINE_DIR.'/classes/images.php';
						
//* Создание 607х376 *//
						
						$tmb = new thumbnail($rImg);
						$tmb->size_auto('607x376');
						$tmb->jpeg_quality('100');
						$tmb->save($rImg);
						
//* Создание 145х90 *//
						
						$tmb = new thumbnail($rImg);
						$tmb->size_auto('145x90');
						$tmb->jpeg_quality('100');
						$tmb->save($upDir.'m'.$image_rename.$res_type);
						
						$rowHash = $db->super_query("SELECT hash FROM `".PREFIX."_games_ver_files` WHERE game_id = '{$id}'");
						
//* Вставляем в базу *//

						$db->query("INSERT INTO `".PREFIX."_games_ver_files` SET file = '{$image_rename}{$res_type}', type = 'scrin', user_id = '{$user_info['user_id']}', game_id = '{$id}'");
						
						echo $id.'/m'.$image_rename.$res_type;
						
				}
			
			} else
				echo 3;
			
		} else
			echo 2;
		
	} else
		echo 1;
	
	exit();
	
};

//* Удаление файла *//

if($_GET['act'] == 'del'){
	
	$file = $db->safesql(strip_tags($_POST['file']));
	
	$row = $db->super_query("SELECT file, game_id FROM `".PREFIX."_games_ver_files` WHERE file = '{$file}'");
	
	if($row['file']){
		
		$upDir = ROOT_DIR.'/uploads/apps/for_ver/'.$id.'/';
		
		@unlink($upDir.$row['file']);
		@unlink($upDir.'m'.$row['file']);
		
		$db->query("DELETE FROM `".PREFIX."_games_ver_files` WHERE file = '{$file}'");
		
	}
	
	exit();
	
}

//* Удаление игры *//

if($_GET['act'] == 'del_game'){
	
	$id = intval($_GET['id']);
	
	$row = $db->super_query("SELECT traf FROM `".PREFIX."_games_ver` WHERE id = '{$id}'");
	
	if($row){
	
//* Выводим все файлы и удаляеи их *//
		
		$sql_ = $db->super_query("SELECT file, type FROM `".PREFIX."_games_ver_files` WHERE game_id = '{$id}'", 1);
		
		foreach($sql_ as $row_f){
			
			@unlink(ROOT_DIR.'/uploads/apps/for_ver/'.$id.'/'.$row_f['file']);
			
			if($row_f['type'] == 'scrin')
				@unlink(ROOT_DIR.'/uploads/apps/for_ver/'.$id.'/m'.$row_f['file']);
		
		}
		
		@rmdir(ROOT_DIR.'/uploads/apps/for_ver/'.$id.'/');
		
//* Удаляем все файлы к игре *//
		
		$db->query("DELETE FROM `".PREFIX."_games_ver_files` WHERE game_id = '{$id}'");
		
//* Удаляем саму игру *//
		
		$db->query("DELETE FROM `".PREFIX."_games_ver` WHERE id = '{$id}'");
		
		msgbox('Ошибка', 'Игра удалена', '?mod=apps_ver');;
		
	} else
		msgbox('Ошибка', 'Игра не найдена', '?mod=apps_ver');;
	
	exit();
}

//* Сохраняем отред. данные *//

if(isset($_POST['edtisave'])){
	
	$title = textFilter($_POST['title'], false, true);
	$descr = textFilter($_POST['descr']);
	$width = intval($_POST['width']);
	$height = intval($_POST['height']);
	
	$id = intval($_GET['id']);
	
	if(isset($title) AND !empty($title)){
		
		$db->query("UPDATE `".PREFIX."_games_ver` SET title = '{$title}', descr = '{$descr}', width = '{$width}', height = '{$height}' WHERE id = '{$id}'");
		
		msgbox('Информация', 'Изменения сохранены', '?mod=apps_ver');
		
	} else
		msgbox('Ошибка', 'Заполните все поля', '?mod=apps_ver');
		
	exit();
	
}

//* Одобрение игры и публикация *//

if ($_GET['act'] == 'approve') {
	$id = intval($_GET['id']);
	$game = $db->super_query("SELECT poster, title, descr, flash, width, height FROM `".PREFIX."_games_ver` WHERE id = {$id}");
	if ($game) {
		$db->query("INSERT INTO `".PREFIX."_games` (poster, title, descr, flash, width, height, date) VALUES ('{$game['poster']}', '{$game['title']}', '{$game['descr']}', '{$game['flash']}', '{$game['width']}', '{$game['height']}', '" . time() . "')");
		$new_id = $db->insert_id();

		$game_dir = ROOT_DIR . '/uploads/apps/' . $new_id . '/';
		@mkdir($game_dir);

		$game_files = $db->super_query("SELECT file, type FROM `".PREFIX."_games_ver_files` WHERE game_id = {$id}", 1);
		foreach ($game_files as $item) {
			$old_loc = ROOT_DIR . '/uploads/apps/for_ver/' . $id . '/' . $item['file'];
			$new_loc = $game_dir . $item['file'];

			@rename($old_loc, $new_loc);
			if ($item['type'] == 'scrin') {
				@rename(ROOT_DIR . '/uploads/apps/for_ver/' . $id . '/m' . $item['file'], $game_dir . 'm' . $item['file']);
			}

			$db->query("INSERT INTO `".PREFIX."_games_files` (game_id, user_id, file, type) VALUES ('{$new_id}', '{$user_info['user_id']}', '{$item['file']}', '{$item['type']}')");
		}
		$db->query("DELETE FROM `".PREFIX."_games_ver_files` WHERE game_id = {$id}");
		@rmdir(ROOT_DIR . '/uploads/apps/for_ver/' . $id . '/');

		$db->query("DELETE FROM `".PREFIX."_games_ver` WHERE id = {$id}");

		msgbox('Информация', 'Игра одобрена', '?mod=apps_ver');
	} else {
		msgbox('Ошибка', 'Игра не найдена', '?mod=apps_ver');
	}

	die();
}

//* Редактирование игры *//

if($_GET['act'] == 'edit'){
	
	$id = intval($_GET['id']);
	
	$row = $db->super_query("SELECT id, title, descr, poster, width, height FROM `".PREFIX."_games_ver` WHERE id = '{$id}'");
	
	if($row){
		
		$row['title'] = stripslashes($row['title']);
		$row['descr'] = stripslashes(myBrRn($row['descr']));
		
//* Выводим скрины *//
		
		$sql_scr = $db->super_query("SELECT file, hash FROM `".PREFIX."_games_ver_files` WHERE game_id = '{$id}' AND type = 'scrin'", 1);
		
		if($sql_scr){
		
			foreach($sql_scr as $row_scr){
				
				$exps = explode('.', $row_scr['file']);
				
				$imgs .= <<<HTML
<img id="{$exps[0]}" onClick="del('{$row_scr['file']}')" src="/uploads/apps/for_ver/{$id}/m{$row_scr['file']}" title="Удалить" style="cursor:pointer;margin-top:8px;margin-bottom:8px;margin-left:2px;margin-right:2px" />
HTML;
				
			}
		
		}
		
		if($row['poster']) $poster = "/uploads/apps/for_ver/{$row['id']}/{$row['poster']}";
		else $poster = '/uploads/no_app.gif';
		
		echoheader();

		echohtmlstart('Редактирование игры');
			
echo <<<HTML
<script type="text/javascript" src="/system/inc/js/jquery.js"></script>
<script type="text/javascript" src="/system/inc/js/upload.photo.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	aj1 = new AjaxUpload('upload', {
		action: '?mod=apps_ver&act=upload&id={$row['id']}',
		name: 'uploadfile',
		accept: 'image/*',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
				alert('Неверный формат файла');
				return false;
			}
			$('#upload').hide();
			$('#prog_poster').show();
		},
		onComplete: function (file, row){
			if(row == 1){
				alert('Файл привышает 5 МБ');
			} else {
				$('#r_poster').attr('src', '/uploads/apps/for_ver/'+row).show();
			}
			$('#upload').show();
			$('#prog_poster').hide();
		}
	});
	aj2 = new AjaxUpload('upload_2', {
		action: '?mod=apps_ver&act=upload_swf&id={$row['id']}',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(swf)$/.test(ext))) {
				alert('Неверный формат файла');
				return false;
			}
			$('#upload_2').hide();
			$('#prog_flash').show();
		},
		onComplete: function (file, row){
			if(row == 1){
				alert('Файл привышает 100 МБ');
			} else {
				$('#ok_swf').text('Файл загружен!').css('color', 'green');
			}
			$('#upload_2').show();
			$('#prog_flash').hide();
		}
	});
	aj3 = new AjaxUpload('upload_3', {
		action: '?mod=apps_ver&act=upload_scrin&id={$row['id']}',
		name: 'uploadfile',
		accept: 'image/*',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|png|jpeg|gif|jpe)$/.test(ext))) {
				alert('Неверный формат файла');
				return false;
			}
			$('#upload_3').hide();
			$('#prog_scrins').show();
		},
		onComplete: function (file, row){
			if(row == 1){
				alert('Файл привышает 5 МБ');
			} else if(row == 3){
				alert('Максимальное кол-во скринов: 4');
			} else {
				file = row.split('/m');
				fid = file[1].split('.');
				$('#scrins').append('<img id="'+fid[0]+'" onClick="del(\''+file[1]+'\')" src="/uploads/apps/for_ver/'+row+'" title="Удалить" style="cursor:pointer;margin-top:8px;margin-bottom:8px;margin-left:2px;margin-right:2px" />');
			}
			$('#upload_3').show();
			$('#prog_scrins').hide();
		}
	});
});
function del(f){
	fid = f.split('.');
	$('#'+fid[0]).remove();
	$.post('?mod=apps_ver&act=del', {file: f});
}
</script>

<style type="text/css" media="all">
.inpu{width:350px;}
textarea{width:450px;height:100px;}
</style>

<form action="" method="POST">

<div class="fllogall" style="width:180px">Название:</div>
 <input type="text" name="title" class="inpu" value="{$row['title']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Описание:</div>
 <textarea type="text" name="descr" class="inpu">{$row['descr']}</textarea>
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Постер 75х75:</div>
 <input type="submit" value="Выбрать файл" class="inp" id="upload" style="margin-top:0px" /><br />
 <div id="prog_poster" style="display:none;margin-top:-11px;background:url('/system/inc/images/progress_grad.gif');width:94px;height:18px;border:1px solid #006699;margin-left:182px"></div>
 <div style="margin-left:182px"><small>Файл не должен превышать 5 Mб.</small></div>
 <img src="{$poster}" id="r_poster" style="margin-left:182px" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Flash игра .swf:</div>
 <input type="submit" value="Выбрать файл" class="inp" id="upload_2" style="margin-top:0px" /><br />
 <div id="prog_flash" style="display:none;margin-top:-11px;background:url('/system/inc/images/progress_grad.gif');width:94px;height:18px;border:1px solid #006699;margin-left:182px"></div>
 <div style="margin-left:180px"><small id="ok_swf">Файл не должен превышать 100 Mб.</small></div>
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Ширина flash игры (px):</div>
 <input type="text" name="width" class="inpu" value="{$row['width']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Высота flash игры (px):</div>
 <input type="text" name="height" class="inpu" value="{$row['height']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:180px">Скриншоты 607х376:</div>
 <input type="submit" value="Выбрать файл" class="inp" id="upload_3" style="margin-top:0px" /><br />
 <div id="prog_scrins" style="display:none;margin-top:-11px;background:url('/system/inc/images/progress_grad.gif');width:94px;height:18px;border:1px solid #006699;margin-left:182px"></div>
 <div style="margin-left:180px"><small>Файл не должен превышать 5 Mб.</small></div>
 <center><span id="scrins">{$imgs}</span></center>
<div class="mgcler"></div>


<div class="fllogall" style="width:180px">&nbsp;</div>
 <input type="submit" value="Сохранить" class="inp" name="edtisave" style="margin-top:0px" />
 <input type="submit" value="Одобрить" class="inp" style="margin-top:0px" onClick="location.href='?mod=apps_ver&act=approve&id={$row['id']}'; return false" />
 <input type="submit" value="Назад" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />
</form>
HTML;

		echohtmlend();
		
	} else
		msgbox('Ошибка', 'Игра не найдена', '?mod=apps_ver');
		
	exit();
	
}

//* Устанавливаем в сессию временный хеш *//

$apps_hash = md5($server_time+rand(0, $server_time));
$_SESSION['apps_hash'] = $apps_hash;

echoheader();

//* Выводим игры *//

if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

//* Считаем кол-во игр в базе *//

$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_games_ver` {$sql_where}");

$sql_l = $db->super_query("SELECT id, poster, title FROM `".PREFIX."_games_ver` {$sql_where} LIMIT {$limit_page}, {$gcount}", 1);

if($sql_l){

	foreach($sql_l as $row){
		
		if($row['poster']) $poster = "/uploads/apps/for_ver/{$row['id']}/{$row['poster']}";
		else $poster = '/uploads/no_app.gif';
		
		$row['title'] = stripslashes($row['title']);
		
		$games .= <<<HTML
<div style="clear:both;height:10px"></div>
<img src="{$poster}" style="float:left;margin-right:10px" />
<a href="/">{$row['title']}</a>
<div><a href="?mod=apps_ver&act=edit&id={$row['id']}">редактировать</a>&nbsp; | &nbsp;<a href="?mod=apps_ver&act=del_game&id={$row['id']}">удалить</a></div>
<div style="clear:both;height:10px"></div>
<div style="clear:both;height:1px;border-top:1px solid #f0f0f0"></div>
HTML;
		
	}

} else
	$games = '<center><b>Нет игр!</b></center>';

echohtmlstart('Список игр от пользователей ('.$numRows['cnt'].')');

echo <<<HTML
{$games}
<div class="clr" style="height:10px"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>
