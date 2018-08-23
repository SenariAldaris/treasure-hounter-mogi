<?php
/*========================================= 
	Appointment: Общая статистика сайта
	File: stats.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
=========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

echoheader();
echohtmlstart('Общая статистика сайта');

$users = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users`");
$albums = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_albums`");
$attach = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_attach`");
$audio = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_audio`");
$groups = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities`");
$groups_wall = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities_wall`");
$invites = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_invites`");
$notes = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_notes`");
$messages = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_messages`");
$videos = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos`");
$users_ver = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users_param` WHERE verification = 1");
$groups_ver = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE verification = 1");

$gifts = $db->super_query("SELECT SUM(balance) AS all_balance FROM `".PREFIX."_gifts_req`");

$fGifts = 100 - $config['mix_users'];
$gifts_all_balance = $fGifts * $gifts['all_balance'] / 100;

$db->query("SHOW TABLE STATUS FROM `".DBNAME."`");
$mysql_size = 0;
while ($r = $db->get_array()){
	if(strpos($r['Name'], PREFIX."_") !== false) 
		$mysql_size += $r['Data_length'] + $r['Index_length'];
}
$db->free();
$mysql_size = formatsize($mysql_size);

/*=====================================================================================================
  function dirsize($directory){
	if(!is_dir($directory)) return - 1;
	$size = 0;
	if($DIR = opendir($directory)){
		while(($dirfile = readdir($DIR)) !== false){
			if(@is_link($directory.'/'.$dirfile) || $dirfile == '.' || $dirfile == '..') continue;
			if(@is_file($directory.'/'.$dirfile)) $size += filesize($directory . '/' . $dirfile);
			else if(@is_dir($directory.'/'.$dirfile)){
				$dirSize = dirsize($directory.'/'.$dirfile);
				if($dirSize >= 0) $size += $dirSize;
				else return - 1;
			}
		}
		closedir( $DIR );
	}
	return $size;
}

$cache_size = formatsize(dirsize("uploads"));
=======================================================================================================*/

echo <<<HTML

<div class="fllogall">Размер базы данных MySQL:</div>
 <div style="margin-bottom:10px">{$mysql_size}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Размер папки /uploads/:</div>
 <div style="margin-bottom:10px">{$cache_size}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Зарегистрировано пользователей:</div>
 <div style="margin-bottom:10px">{$users['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество созданных альбомов:</div>
 <div style="margin-bottom:10px">{$albums['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество прикрепленных фото:</div>
 <div style="margin-bottom:10px">{$attach['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество аудиозаписей:</div>
 <div style="margin-bottom:10px">{$audio['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество сообществ:</div>
 <div style="margin-bottom:10px">{$groups['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество записей на стенах сообществ:</div>
 <div style="margin-bottom:10px">{$groups_wall['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество приглашеных пользователей:</div>
 <div style="margin-bottom:10px">{$invites['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество заметок:</div>
 <div style="margin-bottom:10px">{$notes['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество видеозаписей:</div>
 <div style="margin-bottom:10px">{$videos['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество верифицированых пользователей:</div>
 <div style="margin-bottom:10px">{$users_ver['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество верифицированых групп:</div>
 <div style="margin-bottom:10px">{$groups_ver['cnt']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Общий заработок всех пользователей:</div>
 <div style="margin-bottom:10px">{$gifts['all_balance']}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Заработок с подарков % администрации:</div>
 <div style="margin-bottom:10px">{$gifts_all_balance}&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Количество личных сообщений:</div>
 <div style="margin-bottom:10px">{$messages['cnt']}&nbsp;</div>
<div class="mgcler"></div>

HTML;

echohtmlend();
?>
