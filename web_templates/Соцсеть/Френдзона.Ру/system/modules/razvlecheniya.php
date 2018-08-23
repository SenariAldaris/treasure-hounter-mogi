<?php
/*========================================== 
	Appointment: Вип
	File: vip.php 
    Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$metatags['title'] = $lang['apps'];
	
	switch($act){
				 case "addvip":
				 
         $row = $db->super_query("SELECT user_vip,user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
         $owner = $db->super_query("SELECT user_balance, user_vip, balance_rub, user_rating FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'"); 
          if($owner['user_vip']!=1 and $owner['user_balance']>=100) {
          $db->query("UPDATE `".PREFIX."_users` SET user_vip = 1, user_balance = user_balance-100 WHERE user_id = '{$user_id}'");
          } elseif($owner['user_balance']<100) echo "n_money";
          else echo "now_vip";
		  die();
                break;
				
	default:

			
case "vip":

//* VIP *//
			
			$tpl->load_template('razvlecheniya/main.tpl');
			$owner = $db->super_query("SELECT user_balance, balance_rub, user_rating FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->set('{ubm}', deColNums($owner['user_balance']));
				if($user_info['user_vip']==1) 
			$tpl->set('{vip_status}','<div class="vip-yes">У вас установлен VIP Статус</div>');
		   else $tpl->set('{vip_status}', 'У вас не установлен VIP-статус ');
		   				if($user_info['user_vip']==1) 
			$tpl->set('{vip_kupit}','');
		   else $tpl->set('{vip_kupit}', '<button onclick="settings.addvip(); return false" href="#" id="vipokd">Купить</button>');
			$tpl->compile('content');
			
			                break;

	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>
