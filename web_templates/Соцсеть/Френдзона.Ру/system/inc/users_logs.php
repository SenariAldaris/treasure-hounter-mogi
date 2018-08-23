<?php
/*========================================== 
	Appointment: История пользователя
	File: users_logs.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

function megaDateNoTpl($date, $func = false, $full = false){
	global $server_time;

	if(date('Y-m-d', $date) == date('Y-m-d', $server_time))
		return $date = langdate('сегодня в H:i', $date);
	elseif(date('Y-m-d', $date) == date('Y-m-d', ($server_time-84600)))
		return $date = langdate('вчера в H:i', $date);
	else
		if($func == 'no_year')
			return $date = langdate('j M в H:i', $date);
		else
			if($full)
				return $date = langdate('j F Y в H:i', $date);
			else
				return $date = langdate('j M Y в H:i', $date);
}
	
$id = intval($_GET['id']);

//* Выводим данные о юзере *//

$row = $db->super_query("SELECT user_search_pref, logs_num, user_doc_num FROM `".PREFIX."_users` WHERE user_id = '{$id}'");

if($row){

	echoheader(1098);
	
	echohtmlstart('<a href="/u'.$id.'" target="_blank">'.$row['user_search_pref'].'</a>');

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 20;
	$limit_page = ($page-1)*$gcount;

	$sort = intval($_GET['sort']);
	
	if($sort == 1) $where_sql = "AND act = 1";
	elseif($sort == 2) $where_sql = "AND act = 2";
	elseif($sort == 3) $where_sql = "AND act = 3";
	elseif($sort == 4) $where_sql = "AND act = 4";
	elseif($sort == 5) $where_sql = "AND act = 5";
	elseif($sort == 6) $where_sql = "AND act = 6";
	elseif($sort == 7) $where_sql = "AND act = 7";
	elseif($sort == 8) $where_sql = "AND act = 8";
	elseif($sort == 9) $where_sql = "AND act = 9";
	else $where_sql = "";
	
//* Выводим логи *//
	
	$sql_ = $db->super_query("SELECT ip, browser, date, act, spent, for_user_id, earnings, rub_num, unban FROM `".PREFIX."_users_logs` WHERE user_id = '{$id}' {$where_sql} ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}", 1);
	
	$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users_logs` WHERE user_id = '{$id}' {$where_sql}");
	
	$row_1 = $db->super_query("SELECT SUM(earnings) AS sum FROM `".PREFIX."_users_logs` WHERE user_id = '{$id}'");
	$row_1['sum'] = round($row_1['sum']);

	foreach($sql_ as $rowLog){
		
//* Chrome *//
		
		if(stripos($rowLog['browser'], 'Chrome') !== false){
			$browser = explode('Chrom', $rowLog['browser']);
			$browser2 = explode(' ', 'Chrom'.str_replace('/', ' ', $browser[1]));
			$browser[0] = $browser2[0].' '.$browser2[1];
			
//* Opera *//
		
		} elseif(stripos($rowLog['browser'], 'Opera') !== false){
			$browser2 = explode('/', $rowLog['browser']);
			$browser3 = end(explode('/', $rowLog['browser']));
			$browser[0] = $browser2[0].' '.$browser3;
			
//* Firefox *//
		
		} elseif(stripos($rowLog['browser'], 'Firefox') !== false){
			$browser3 = end(explode('/', $rowLog['browser']));
			$browser[0] = 'Firefox '.$browser3;
			
//* Safari *//
		
		} elseif(stripos($rowLog['browser'], 'Safari') !== false){
			$browser3 = end(explode('Version/', $rowLog['browser']));
			$browser4 = explode(' ', $browser3);
			$browser[0] = 'Safari '.$browser4[0];
		}
	
//* Определяем действие *//
		
		if($rowLog['act'] == 1) $act = 'Авторизация';
		elseif($rowLog['act'] == 2) $act = 'Отправка подарка';
		elseif($rowLog['act'] == 3) $act = 'Повышение рейтинга';
		elseif($rowLog['act'] == 4) $act = 'Обмен mix на рубли';
		elseif($rowLog['act'] == 5) $act = 'Заработок с подарка';
		elseif($rowLog['act'] == 6) $act = 'Поплнение рублей по СМС';
		elseif($rowLog['act'] == 7) $act = 'Обмен рублей на mix';
		elseif($rowLog['act'] == 8) $act = 'Заблокирован';
		elseif($rowLog['act'] == 9) $act = 'Перевод mix';
		else $act = '';
		
//* Если это действие "1", то считаем сколько страниц заходило с таким IP *//
		
		if($rowLog['act'] == 1){
			
			$rowIP = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users_logs` WHERE ip = '{$rowLog['ip']}' AND user_id != '{$id}' AND act = 1");
			
			if(!$rowIP['cnt']) $rowIP['cnt'] = '';
			else $rowIP['cnt'] = '&nbsp;( <a title="Авторизаций с этого IP"><b>'.$rowIP['cnt'].'</a></b> )';
				
		} else {
			
			$rowIP['cnt'] = '';

		}
		
//* Дата *//
		
		$date = megaDateNoTpl($rowLog['date']);
		if($rowLog['unban']) $unban = megaDateNoTpl($rowLog['unban']);
		else $unban = '';
		
		if(!$rowLog['spent']) $rowLog['spent'] = '';
		if(!$rowLog['earnings']) $rowLog['earnings'] = '';
		if(!$rowLog['rub_num']) $rowLog['rub_num'] = '';
		
		$result .= <<<HTML
<div style="float:left;padding:7px;width:160px;text-align:center;border-bottom:2px dashed #ddd">{$act}</div>
<div style="float:left;padding:7px;width:130px;text-align:center;margin-left:1px;border-bottom:2px dashed #ddd">&nbsp;<a href="?mod=logs&ip={$rowLog['ip']}">{$rowLog['ip']}</a> {$rowIP['cnt']}</div>
<div style="float:left;padding:7px;width:139px;text-align:center;margin-left:1px;border-bottom:2px dashed #ddd">&nbsp;<a href="?mod=logs&browser={$rowLog['browser']}" title="{$rowLog['browser']}">{$browser[0]}</a></div>
<div style="float:left;padding:7px;width:115px;text-align:center;margin-left:1px;border-bottom:2px dashed #ddd">&nbsp;{$date}</div>
<div style="float:left;padding:7px;width:130px;text-align:center;margin-left:1px;border-bottom:2px dashed #ddd">&nbsp;<a href="/u{$rowLog['for_user_id']}" title="Посмотреть на какой ID потрачен" target="_blank">{$rowLog['spent']}</a></div>
<div style="float:left;padding:7px;width:95px;text-align:center;margin-left:1px;border-bottom:2px dashed #ddd">&nbsp;<a href="/u{$rowLog['for_user_id']}" title="Посмотреть кто отправил" target="_blank">{$rowLog['earnings']}</a></div>
<div style="float:left;padding:7px;width:85px;text-align:center;margin-left:1px;border-bottom:2px dashed #ddd">&nbsp;<a href="/u{$rowLog['for_user_id']}" title="Посмотреть кто отправил" target="_blank">{$rowLog['rub_num']}</a></div>
<div style="float:left;padding:7px;width:125px;text-align:center;margin-left:1px;border-bottom:2px dashed #ddd">&nbsp;{$unban}</div>
<div class="clr"></div>
HTML;
		
	}
	
	$selsorlist = installationSelected($sort, '<option value="0">Все действия:</option><option value="1">Авторизация</option><option value="2">Отправка подарка</option><option value="3">Повышение рейтинга</option><option value="4">Обмен mix на рубли</option><option value="5">Заработок с подарка</option><option value="6">Поплнение рублей по СМС</option><option value="7">Обмен рублей на mix</option><option value="8">Заблокирован</option><option value="9">Перевод mix</option>');
	
	echo <<<HTML
<form method="GET" action="">
<input type="hidden" name="mod" value="users_logs" />
<input type="hidden" name="id" value="{$id}" />
<div class="fllogall">Всего успешных авторизаций на сайт:</div>
 <div style="margin-bottom:10px"><b>{$row['logs_num']}</b>&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Всего загрузил документов:</div>
 <div style="margin-bottom:10px"><b>{$row['user_doc_num']}</b>&nbsp;</div>
<div class="mgcler"></div>

<div class="fllogall">Сортировка:</div>
 <div style="margin-bottom:10px">
 <select name="sort" class="inpu">{$selsorlist}</select>
 <br />
 <input type="submit" class="inp" style="margin-left:282px;margin-top:0px" value="Сортировать"  />
 </div>
<div class="mgcler"></div>

<div class="fllogall">Заработано с подарков:</div>
 <div style="margin-bottom:10px"><b>{$row_1['sum']}</b> mix&nbsp;</div>
<div class="mgcler"></div>

<div style="background:#f0f0f0;float:left;padding:7px;width:160px;text-align:center;font-weight:bold;margin-top:-5px">Действие</div>
<div style="background:#f0f0f0;float:left;padding:7px;width:130px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">IP</div>
<div style="background:#f0f0f0;float:left;padding:7px;width:139px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Браузер</div>
<div style="background:#f0f0f0;float:left;padding:7px;width:115px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Дата действия</div>
<div style="background:#f0f0f0;float:left;padding:7px;width:130px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Потрачено mix / руб</div>
<div style="background:#f0f0f0;float:left;padding:7px;width:95px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Заработано mix</div>
<div style="background:#f0f0f0;float:left;padding:7px;width:85px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Получено руб.</div>
<div style="background:#f0f0f0;float:left;padding:7px;width:125px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Дата разблокировки</div>
<div class="clr"></div>
</form>
{$result}
<div class="clr" style="margin-bottom:10px"></div>
HTML;

	$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

	echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

	echohtmlend();
	
} else
	msgbox('Информация', 'Пользователь не найден.', '?mod=users');
?>