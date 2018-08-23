<?php
/* 
	Appointment: Подарки от юзеров
	File: gifts_user.php
	Author: f0rt1 
	Engine: Vee Engine
	Copyright: NiceWeb Group (с) 2011
	e-mail: niceweb@i.ua
	URL: http://www.niceweb.in.ua/
	ICQ: 427-825-959
	Данный код защищен авторскими правами
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

//Одобрение подарка
if($_GET['act'] == 'ok'){
	
	$id = intval($_GET['id']);
	
	$row = $db->super_query("SELECT gift, user_id, price, approve, cat FROM `".PREFIX."_gifts_req` WHERE id = '{$id}'");
	
	if($row AND $row['approve'] == 1){
		
		//Вставляем в таблицу подарков
		$db->query("INSERT INTO `".PREFIX."_gifts_list` SET img = '{$row['gift']}', price = '{$row['price']}', user_id = '{$row['user_id']}', cat = '{$row['cat']}'");
		
		//Обновляем статус модерации
		$db->query("UPDATE `".PREFIX."_gifts_req` SET approve = '0' WHERE id = '{$id}'");
		
		header("Location: ?mod=gifts_user&status=1");
	
	} else
		msgbox('Ошибка', 'Подарок не найден.', '?mod=gifts_user');
	
	exit();
	
}

//Отклонение подарка
if($_GET['act'] == 'del'){
	
	$id = intval($_GET['id']);
	
	$row = $db->super_query("SELECT send_num, gift FROM `".PREFIX."_gifts_req` WHERE id = '{$id}'");
	
	if($row){
		
		//Если небыло продаж, то удаляем подарок из папки
		if(!$row['send_num']){
			
			@unlink(ROOT_DIR."/uploads/gifts/{$row['gift']}.jpg");
			@unlink(ROOT_DIR."/uploads/gifts/{$row['gift']}.png");
			
		}
		
		//Удаляем
		$db->query("DELETE FROM `".PREFIX."_gifts_req` WHERE id = '{$id}'");
		
		header("Location: ?mod=gifts_user&status=1");
	
	} else
		msgbox('Ошибка', 'Подарок не найден.', '?mod=gifts_user');
	
	exit();
	
}

//Снятие с продажи
if($_GET['act'] == 'del_bazar'){
	
	$id = intval($_GET['id']);
	
	$row = $db->super_query("SELECT gift, user_id, approve FROM `".PREFIX."_gifts_req` WHERE id = '{$id}'");
	
	if($row AND $row['approve'] == 0){
		
		//Вставляем в таблицу подарков
		$db->query("DELETE FROM `".PREFIX."_gifts_list` WHERE img = '{$row['gift']}' AND user_id = '{$row['user_id']}'");
		
		//Обновляем статус модерации
		$db->query("UPDATE `".PREFIX."_gifts_req` SET approve = '1' WHERE id = '{$id}'");
		
		msgbox('Информация', 'Подарок успешно снят с продажи.', '?mod=gifts_user');
	
	} else
		msgbox('Ошибка', 'Подарок не найден.', '?mod=gifts_user');
	
	exit();
	
}

//Добавление категории
if(isset($_POST['addcat'])){

	$name = textFilter($_POST['name']);
	
	if(isset($name) AND !empty($name)){
		
		$db->query("INSERT INTO `".PREFIX."_gifts_cat` SET name = '{$name}'");
		
		msgbox('Инфомрация', 'Категория успешно добавлена.', '?mod=gifts_user');
	
	} else	
		msgbox('Ошибка', 'Введите название категории.', '?mod=gifts_user');
		
	exit();
	
}

//Удаление категории
if($_GET['act'] == 'del_cat'){
	
	$id = intval($_GET['id']);
	
	$db->query("DELETE FROM `".PREFIX."_gifts_cat` WHERE id = '{$id}'");
	
	msgbox('Информация', 'Категория удалена.', '?mod=gifts_user');
	
	exit();
	
}

echoheader();

//Выводим список загруженных подарков
if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

if($_GET['status'] == 1){
	$sql_status = "AND approve = '1'";
	$sql_cnt = "WHERE approve = '1'";
	$lnk = '<a href="?mod=gifts_user">Показать все подарки</a>';
} else {
	$sql_status = "";
	$lnk = '<a href="?mod=gifts_user&status=1">Показать которые на проверке</a>';
	$sql_cnt = '';
}

$sql_ = $db->super_query("SELECT tb1.id, tb1.user_id, gift, approve, send_num, price, balance, tb2.name, tb3.user_search_pref FROM `".PREFIX."_gifts_req` tb1, `".PREFIX."_gifts_cat` tb2, `".PREFIX."_users` tb3 WHERE tb1.user_id = tb3.user_id AND tb2.id = tb1.cat {$sql_status} ORDER by `id` DESC LIMIT {$limit_page}, {$gcount}", 1);

$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_gifts_req` {$sql_cnt}");

if($sql_){
				
	foreach($sql_ as $row){
					
		if($row['approve'] == 1){
		
			$status = '<font color="blue">на проверке</font>';
			$link = '<div style="float:right"><a href="?mod=gifts_user&act=ok&id='.$row['id'].'" style="color:green"><b>Отправить на продажу</b></a></div>';
			$link2 = '<div style="float:right"><a href="?mod=gifts_user&act=del&id='.$row['id'].'" style="color:blue"><b>Удалить</b></a></div>';
			$link3  = '';
			
		} else {
		
			$status = '<font color="green">продается</font>';
			$link  = '';
			$link2  = '';
			$link3  = '<div style="float:right"><a href="?mod=gifts_user&act=del_bazar&id='.$row['id'].'" style="color:black"><b>Убрать с продажи</b></a></div>';
		}
		
		$gifts .= <<<HTML
<div style="float:left;width:100%;height:130px;line-height:17px;color:#777">
<a href="/uploads/gifts/{$row['gift']}.jpg" target="_blank"><img src="/uploads/gifts/{$row['gift']}.png" style="float:left;margin-right:10px;background:#f0f0f0" width="96" height="96" /></a>
<div style="margin-top:5px"></div>
{$link}
<div>Автор: &nbsp;<a href="/u{$row['user_id']}" target="_blank">{$row['user_search_pref']}</a></div>
{$link2}
<div>Статус: &nbsp;{$status}</div>
{$link3}
<div>Количество продаж: &nbsp;<b>{$row['send_num']}</b></div>
<div>Заработок автор: &nbsp;<b>{$row['balance']}</b> mix</div>
<div>Цена: &nbsp;<b>{$row['price']}</b> mix</div>
<div>Категория: &nbsp;<b>{$row['name']}</b></div>
</div>
HTML;
				
	}
				
}

//Выводим категории
$sql_cats = $db->super_query("SELECT id, name FROM `".PREFIX."_gifts_cat` ORDER by `name` DESC", 1);
$i = 0;
foreach($sql_cats as $row_cats){
	
	$i++;
	
	$cats .= '<b>'.$i.'. '.$row_cats['name'].'</b>&nbsp;&nbsp;[ <a href="?mod=gifts_user&act=del_cat&id='.$row_cats['id'].'">удалить</a> ]<br />';
	
}

echohtmlstart('Добавление новой категории');

echo <<<HTML
Название: &nbsp; 
<form method="POST" action="">
<input type="text" class="inpu" style="margin-bottom:10px" name="name" />
<input type="submit" class="inp" style="margin-bottom:10px;margin-top:0px" name="addcat" value="Добавить" />
<div class="clr"></div>
</form>
HTML;

echohtmlstart('Категории');

echo '<div style="margin-bottom:20px">'.$cats.'</div>';

echohtmlstart('Список подарков ('.$numRows['cnt'].')');

echo $gifts."<div class=\"clr\"></div>{$lnk}";

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);
echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>