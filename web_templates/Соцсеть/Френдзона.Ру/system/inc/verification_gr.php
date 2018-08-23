<?php
/*========================================= 
	Appointment: Верификация сообществ
	File: verification_gr.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

echoheader();

//* Принятие заявки *//

if($_GET['act'] == 'ok' AND $_GET['id']){
	
	$public_id = intval($_GET['id']);
	
	$db->query("UPDATE `".PREFIX."_communities` SET verification = '1' WHERE id = '{$public_id}'");
	
	$db->query("DELETE FROM `".PREFIX."_verification_communities` WHERE public_id = '{$public_id}'");
	
	header("Location: ?mod=verification_gr");
	
}

//* Отклонение заявки *//

if($_GET['act'] == 'del' AND $_GET['id']){
	
	$public_id = intval($_GET['id']);
	
	$db->query("DELETE FROM `".PREFIX."_verification_communities` WHERE public_id = '{$public_id}'");
	
	header("Location: ?mod=verification_gr");
	
}

//* Выводим все заявки *//

if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT tb1.user_id, public_id, tb2.user_search_pref, tb3.title FROM `".PREFIX."_verification_communities` tb1, `".PREFIX."_users` tb2, `".PREFIX."_communities` tb3 WHERE tb1.user_id = tb2.user_id AND tb1.public_id = tb3.id LIMIT {$limit_page}, {$gcount}", 1);
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_verification_communities`");

foreach($sql_ as $row){
	
	$row['title'] = stripslashes($row['title']);
	
	$users .= <<<HTML
<div style="float:left;padding:5px;width:160px;text-align:center;border-bottom:1px dashed #ccc"><a href="/u{$row['user_id']}" target="_blank">{$row['user_search_pref']}</a></div>
<div style="float:left;padding:5px;width:263px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc"><a href="/public{$row['public_id']}" target="_blank">{$row['title']}</a></div>
<div style=";float:left;padding:5px;width:145px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc">[ <a href="?mod=verification_gr&act=ok&id={$row['public_id']}">принять</a> ] [ <a href="?mod=verification_gr&act=del&id={$row['public_id']}">отклонить</a> ]</div>
HTML;
	
}

echo <<<HTML
<div style="margin-top:10px"></div>
<div class="clr" ></div>
<div style="background:#f0f0f0;float:left;padding:5px;width:160px;text-align:center;font-weight:bold">Пользователь</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:263px;text-align:center;font-weight:bold;margin-left:1px">Группа</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:145px;text-align:center;font-weight:bold;margin-left:1px">Действия</div>
<div class="clr"></div>
{$users}
<div class="clr" style="margin-bottom:10px"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>