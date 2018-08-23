<?php
/*========================================= 
	Appointment: Логи посещений
	File: logs.php
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

$ip = $db->safesql(strip_tags($_GET['ip']));
$browser_get = $db->safesql(strip_tags($_GET['browser']));
$uid = intval($_GET['id']);
if(!$uid) $uid = '';

if($ip){
	$where_sql .= "AND tb1.ip = '".$ip."' ";
	$pref .= 'IP '.$ip;
}

if($uid){
	$where_sql .= "AND tb1.uid = '".$uid."' ";
}

if($browser_get){
	$where_sql .= "AND tb1.browser LIKE '%".$browser_get."%' ";
	$pref .= ', Браузер: '.$browser_get;
}

if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT tb1.*, tb2.user_search_pref, user_last_visit, user_rphone, user_active FROM `".PREFIX."_log` tb1, `".PREFIX."_users` tb2 WHERE tb1.uid = tb2.user_id {$where_sql} ORDER by `uid` DESC LIMIT {$limit_page}, {$gcount}", 1);

$where_sql = str_replace('tb1.', '', $where_sql);
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_log` WHERE ip != '' {$where_sql}");

foreach($sql_ as $row){
	$row['user_last_visit'] = langdate('j M Y в H:i', $row['user_last_visit']);
	
//* Chrome *//
	
	if(stripos($row['browser'], 'Chrome') !== false){
		$browser = explode('Chrom', $row['browser']);
		$browser2 = explode(' ', 'Chrom'.str_replace('/', ' ', $browser[1]));
		$browser[0] = $browser2[0].' '.$browser2[1];
		
//* Opera *//
	
	} elseif(stripos($row['browser'], 'Opera') !== false){
		$browser2 = explode('/', $row['browser']);
		$browser3 = end(explode('/', $row['browser']));
		$browser[0] = $browser2[0].' '.$browser3;
		
//* Firefox *//
	
	} elseif(stripos($row['browser'], 'Firefox') !== false){
		$browser3 = end(explode('/', $row['browser']));
		$browser[0] = 'Firefox '.$browser3;
		
//* Safari *//
	
	} elseif(stripos($row['browser'], 'Safari') !== false){
		$browser3 = end(explode('Version/', $row['browser']));
		$browser4 = explode(' ', $browser3);
		$browser[0] = 'Safari '.$browser4[0];
	}

	$users .= <<<HTML
<div style="background:#fff;float:left;padding:5px;width:140px;text-align:center;border-bottom:1px dashed #ccc;height:37px"><a href="/u{$row['uid']}" target="_blank">{$row['user_search_pref']}</a></div>
<div style="background:#fff;float:left;padding:5px;width:95px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc;height:37px"><a href="?mod=logs&ip={$row['ip']}">{$row['ip']}</a></div>
<div style="background:#fff;float:left;padding:5px;width:100px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc;height:37px">{$row['user_last_visit']}</div>
<div style="background:#fff;float:left;padding:5px;width:130px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc;border-bottom:1px dashed #ccc;height:37px" ><a href="?mod=logs&browser={$row['browser']}" title="{$row['browser']}">{$browser[0]}</a></div>
<div style="background:#fff;float:left;padding:5px;width:80px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc;border-bottom:1px dashed #ccc;height:37px" >{$row['user_rphone']}&nbsp;</div>
HTML;

}

echohtmlstart('Логи посещений: '.$pref);

echo <<<HTML
Поиск по ID пользователя: &nbsp; 
<input type="text" class="inpu" id="uid" style="margin-bottom:10px" value="{$uid}" />
<input type="submit" class="inp" style="margin-bottom:10px;margin-top:0px" onClick="window.location.href = '?mod=logs&id='+document.getElementById('uid').value" />
<div class="clr"></div>

<div style="background:#f0f0f0;float:left;padding:5px;width:140px;text-align:center;font-weight:bold;margin-top:-5px;height:37px">Пользователь</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:95px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px;height:37px">IP</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:100px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px;height:37px">Посещение</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:130px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px;height:37px">Браузер</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:80px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px;height:37px">Телефон</div>
<div class="clr"></div>
{$users}
<div class="clr" style="margin-bottom:10px"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>