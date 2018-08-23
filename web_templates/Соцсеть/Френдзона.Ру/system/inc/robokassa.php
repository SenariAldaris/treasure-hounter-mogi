<?php

if(!defined('MOZG'))
	die('Hacking attempt!');

$uid = intval($_GET['id']);
if($uid <= 0) $uid = '';

if($uid){
	$sql_where = "AND tb1.user_id = '{$uid}'";
	$sql_where_a = "WHERE  user_id = '{$uid}'";
}

if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT tb1.payment_user, payment_id, payment_cont, payment_money, tb2.user_search_pref, balance_rub FROM `".PREFIX."_payments` tb1, `".PREFIX."_users` tb2 WHERE tb1.payment_user = tb2.user_id {$sql_where} ORDER by `payment_id` DESC LIMIT {$limit_page}, {$gcount}", 1);
	
$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_payments` {$sql_where_a}");

if($sql_){

	foreach($sql_ as $row){
		
		$row['date'] = langdate('j F Y', strtotime($row['date']));
		
		$res .= <<<HTML
<div style="float:left;padding:5px;width:160px;text-align:center;border-bottom:1px dashed #ddd">{$row['user_search_pref']}</div>
<div style="float:left;padding:5px;width:110px;text-align:center;margin-left:1px;border-bottom:1px dashed #ddd">{$row['payment_id']}</div>
<div style="float:left;padding:5px;width:70px;text-align:center;margin-left:1px;border-bottom:1px dashed #ddd">{$row['payment_money']}</div>
<div style="float:left;padding:5px;width:98px;text-align:center;margin-left:1px;border-bottom:1px dashed #ddd">{$row['balance_rub']}</div>
<div style="float:left;padding:5px;width:108px;text-align:center;margin-left:1px;border-bottom:1px dashed #ddd">{$row['payment_cont']}</div>
HTML;

	}

} else
	$res = '<center><br /><br /><br /><br /><br />Пока что нет счетов</center>';

	
echoheader();

echo <<<HTML
Поиск по ID пользователя: &nbsp; 
<input type="text" class="inpu" id="uid" style="margin-bottom:10px" value="{$uid}" />
<input type="submit" class="inp" style="margin-bottom:10px;margin-top:0px" onClick="window.location.href = '?mod=sms&id='+document.getElementById('uid').value" />
<div class="clr"></div>
HTML;

echohtmlstart('Отчеты по робокассе ('.$numRows['cnt'].')');

echo <<<HTML
<div style="background:#f0f0f0;float:left;padding:5px;width:160px;text-align:center;font-weight:bold;margin-top:-5px">Пользователь</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:110px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Номер</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:70px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Сумма</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:98px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Общий баланс</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:108px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Статус</div>
{$res}
<div class="clr" style="margin-top:70px"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);
echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>