<?php
/*========================================== 
	Appointment: Реклама от юзеров
	File: users_banners.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

$id = intval($_GET['id']);

//* Удаление *//

if($_GET['act'] == 'del'){
	
	$row = $db->super_query("SELECT approve, img, user_id, pos, rub_num, rub_ok FROM `".PREFIX."_users_banners` WHERE id = '{$id}'");

	$rNum = $row['rub_num'] - $row['rub_ok'];
	
	$db->query("UPDATE `".PREFIX."_users` SET balance_rub = balance_rub + '{$rNum}' WHERE user_id = '{$row['user_id']}'");
	
	$db->query("DELETE FROM `".PREFIX."_users_banners` WHERE id = '{$id}'");
	
	@unlink(ROOT_DIR.'/uploads/mybanners/'.$row['user_id'].'/ok/'.$row['img']);
	
	if($row['approve'] == 0){
		
//* Выводим след баннер на показ *//
		
		$rowN = $db->super_query("SELECT id FROM `".PREFIX."_users_banners` WHERE approve = 2 AND pos = '{$row['pos']}' ORDER by `date` ASC");
					
		$db->query("UPDATE `".PREFIX."_users_banners` SET approve = 0 WHERE id = '{$rowN['id']}'");

	}

msgbox('Информация', 'Реклама удалена.', '?mod=users_banners');
	
	exit();
	
}
	
//* Просмотр рекламы *//

if($_GET['act'] == 'view'){

//* Сохраняем *//
	
	if(isset($_POST['save'])){
		
		$pos = intval($_POST['pos']);
		if($pos < 0 OR $pos > 5) $pos = 1;
			
		$link = textFilter($_POST['link'], false, true);
		$title = textFilter($_POST['title'], false, true);
		$descr = textFilter($_POST['descr'], false, true);
		$transitions = intval($_POST['transitions']);
		$approve = intval($_POST['approve']);
		$cat = intval($_POST['cat']);
		$rub_num = textFilter($_POST['rub_num'], false, true);
		
//* Если отправляем на рекламу, то проверяем *//
		
		if($approve == 0 AND $pos != 5){
			
			$check = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users_banners` WHERE approve = 0 AND pos = '{$pos}'");
			
			if($check['cnt']){
			
				$approve = 2;
			
			}
					
		}
		
		if($pos == 5){
			
			$rowPEREB = $db->super_query("SELECT redemption, rub_num, rub_ok, user_id FROM `".PREFIX."_users_banners` WHERE pos = 5 AND approve = 0");
			
			if($rowPEREB){
			
				$ab = $rowPEREB['rub_num'] - $rowPEREB['rub_ok'];
				
				$db->query("UPDATE `".PREFIX."_users` SET balance_rub = balance_rub + '{$ab}' WHERE user_id = '{$rowPEREB['user_id']}'");
				
				$db->query("UPDATE `".PREFIX."_users_banners` SET approve = 4 WHERE pos = 5 AND approve = 0");
			
			}
			
		}
		
		$db->query("UPDATE `".PREFIX."_users_banners` SET title = '{$title}', pos = '{$pos}', descr = '{$descr}', link = '{$link}', transitions = '{$transitions}', rub_num = '{$rub_num}', approve = '{$approve}', cat = '{$cat}' WHERE id = '{$id}'");
		
		msgbox('Информация', 'Реклама успешно отредактировано.', '?mod=users_banners');

		exit();
		
	}
	
	$row = $db->super_query("SELECT tb1.user_id, pos, img, title, descr, link, cat, transitions, transitions_ok, rub_ok, rub_num, approve, tb2.user_search_pref FROM `".PREFIX."_users_banners` tb1, `".PREFIX."_users` tb2 WHERE tb1.id = '{$id}' AND tb1.user_id = tb2.user_id");
	
	if(!$row){
		
		msgbox('Информация', 'Реклама не найдена.', '?mod=users_banners');
		
		exit();
		
	}
	
	echoheader();

	echohtmlstart('Просмотр рекламы');

	$row['title'] = stripslashes($row['title']);
	$row['descr'] = stripslashes($row['descr']);
	
	$dataImg = getimagesize(ROOT_DIR.'/uploads/mybanners/'.$row['user_id'].'/ok/'.$row['img']);
	
	$img = '/uploads/mybanners/'.$row['user_id'].'/ok/'.$row['img'];
	
	$selsorlist = installationSelected($row['pos'], '  <option value="1">Верх (880х150)</option><option value="2">Низ (880х150)</option><option value="3">Справа №1 (65x90)</option><option value="4">Справа №2 (65x90)</option><option value="5">Справа №3 (65x90)</option>');
	
	$selsorlist_2 = installationSelected($row['approve'], '<option value="0">Рекламируется</option><option value="1">Проверяется</option><option value="2">В очереди</option><option value="3">Прорекламировали</option><option value="4">Перекупили</option>');
	
	$sql_cats = $db->super_query("SELECT id, name FROM `".PREFIX."_banners_cat` ORDER by `name` DESC", 1);
	
	foreach($sql_cats as $row_cats){

		$cats .= '<option value="'.$row_cats['id'].'">'.$row_cats['name'].'</option>';
		
	}
	
	$selsorlist_3 = installationSelected($row['cat'], $cats);
	
	echo <<<HTML
<style type="text/css" media="all">
.inpu{width:437px;}
textarea{width:430px;height:100px;}
</style>

<form action="" method="POST">

<div class="fllogall" style="width:150px">Покупатель:</div>
 <div style="margin-bottom:8px"><a href="/u{$row['user_id']}" target="_blank">{$row['user_search_pref']}</a></div>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Категория:</div>
 <select name="cat" class="inpu" style="width:250px">
  <option value="0">Любая</option>
  {$selsorlist_3}
 </select>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Расположение рекламы:</div>
 <select name="pos" class="inpu" style="width:250px">
  {$selsorlist}
 </select>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Заголовок:</div>
 <input type="text" name="title" class="inpu" value="{$row['title']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Ссылка:</div>
 <input type="text" name="link" class="inpu" value="{$row['link']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Описание:</div>
 <textarea name="descr" class="inpu">{$row['descr']}</textarea>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Изображение:</div>
 <img src="{$img}" style="max-width:445px;" /><br />
 <div style="margin-left:153px;margin-bottom:5px">Разрешение: {$dataImg[0]}x{$dataImg[1]}</div>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Сколько переходов:</div>
 <input type="text" name="transitions" class="inpu" value="{$row['transitions']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">К оплате (руб.):</div>
 <input type="text" name="rub_num" class="inpu" value="{$row['rub_num']}" />
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Статус:</div>
 <select name="approve" class="inpu" style="width:250px">
  {$selsorlist_2}
 </select>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Перешло:</div>
 <div style="margin-bottom:8px">{$row['transitions_ok']}</div>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">Потрачено:</div>
 <div style="margin-bottom:8px"><b>{$row['rub_ok']}</b> руб.</div>
<div class="mgcler"></div>

<div class="fllogall" style="width:150px">&nbsp;</div>
 <input type="submit" value="Сохранить" class="inp" name="save" style="margin-top:0px" />
 <input type="submit" value="Назад" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />
 <a href="?mod=users_banners&act=del&id={$id}" style="margin-left:5px">Удалить</a>

</form>
HTML;

	echohtmlend();
	
	exit();
	
}

//* Добавление категории *//

if(isset($_POST['addcat'])){

	$name = textFilter($_POST['name']);
	
	if(isset($name) AND !empty($name)){
		
		$db->query("INSERT INTO `".PREFIX."_banners_cat` SET name = '{$name}'");
		
		msgbox('Инфомрация', 'Категория успешно добавлена.', '?mod=users_banners');
	
	} else	
		msgbox('Ошибка', 'Введите название категории.', '?mod=users_banners');
		
	exit();
	
}

//* Удаление категории *//

if($_GET['act'] == 'del_cat'){
	
	$id = intval($_GET['id']);
	
	$db->query("DELETE FROM `".PREFIX."_banners_cat` WHERE id = '{$id}'");
	
	msgbox('Информация', 'Категория удалена.', '?mod=users_banners');
	
	exit();
	
}

echoheader();

//* Выводим категории *//

$sql_cats = $db->super_query("SELECT id, name FROM `".PREFIX."_banners_cat` ORDER by `name` DESC", 1);
$i = 0;
foreach($sql_cats as $row_cats){
	
	$i++;
	
	$cats .= '<b>'.$i.'. '.$row_cats['name'].'</b>&nbsp;&nbsp;[ <a href="?mod=users_banners&act=del_cat&id='.$row_cats['id'].'">удалить</a> ]<br />';
	
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

//* Выводим все заявки *//

if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1) * $gcount;

$sql_ = $db->super_query("SELECT id, title, approve FROM `".PREFIX."_users_banners` ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users_banners`");

foreach($sql_ as $row){
	
	$row['title'] = stripslashes($row['title']);
	
	if($row['approve'] == 1) $status = '<font color="blue">Проверяется</font>';
	elseif($row['approve'] == 2) $status = '<font color="DarkGoldenrod">В очереди</font>';
	elseif($row['approve'] == 3) $status = '<font color="MediumPurple">Прорекламировали</font>';
	elseif($row['approve'] == 4) $status = '<font color="MediumPurple">Перекупили</font>';
	else $status = '<font color="Green">Рекламируется</font>';
					
	$users .= <<<HTML
<div style="float:left;padding:5px;width:277px;text-align:left;border-bottom:1px dashed #ccc">{$row['title']}</div>
<div style=";float:left;padding:5px;width:145px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc">{$status}</div>
<div style=";float:left;padding:5px;width:145px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc">[ <a href="?mod=users_banners&act=view&id={$row['id']}">посмотреть</a> ]</div>
HTML;
	
}

echo <<<HTML
<div style="margin-top:10px"></div>
<div class="clr" ></div>
<div style="background:#f0f0f0;float:left;padding:5px;width:277px;text-align:center;font-weight:bold">Заголовок</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:145px;text-align:center;font-weight:bold;margin-left:1px">Статус</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:145px;text-align:center;font-weight:bold;margin-left:1px">Действия</div>
<div class="clr"></div>
{$users}<div class="clr" style="height:10px"></div>
{$lnk}
<div class="clr" style="margin-bottom:10px"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>