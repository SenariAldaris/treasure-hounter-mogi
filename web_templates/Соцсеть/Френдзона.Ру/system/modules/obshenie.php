<?php
/* 
	Appointment: Погода
	File: tv.php 
 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	$metatags['title'] = $lang['apps'];
	
	switch($act){
		case "addobshenie":
			
			$text = ajax_utf8(textFilter($_POST['text']));
			$row = $db->super_query("SELECT user_balance, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$obshenie = $db->super_query("SELECT id FROM `".PREFIX."_obshenie` WHERE user_id = '{$user_id}'");
			
			if(!$obshenie and $row['user_balance']>=50) {
				$db->query("INSERT INTO `".PREFIX."_obshenie` (user_id,text,date) values('".$user_id."','".$text."','".$server_time."')");
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance-50 WHERE user_id = '{$user_id}'");
			} elseif($row['user_balance']<50) echo "n_money";
			else echo "now_vip";
			 die();
		break;
		default:
		
		
			//################### Погода ###################//
			$obshenie = $db->super_query("SELECT id FROM `".PREFIX."_obshenie` WHERE user_id = '{$user_id}'");
			$row = $db->super_query("SELECT user_balance, user_search_pref, user_vip FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			$tpl->load_template('obshenie/main.tpl');
			
              if($row['user_vip']==1) 
			$tpl->set('{vip_status}','<div class="textvip" style=" width: 46px;"><div class="img_vip_obze"></div>vip</div>');
		   else $tpl->set('{vip_status}', '');
			//Аватарка
			if($user_info['user_photo']){
				$tpl->set('{ava_bze}', $config['home_url'].'uploads/users/'.$user_info['user_id'].'/100_'.$avaPREFver.$user_info['user_photo']);
				$tpl->set('{display-ava}', 'style="display:block;"');
			} else {
				$tpl->set('{ava_bze}', '{theme}/images/no_ava.png');
				$tpl->set('{display-ava}', 'style="display:none;"');
			}
			$user_name_lastname_exp = explode(' ', $row['user_search_pref']);
						$tpl->set('{name}', $user_name_lastname_exp[0]);
			$tpl->set('{lastname}', $user_name_lastname_exp[1]);
		    if($obshenie) $tpl->set('{obshenie_offline}','<div class="obzes-yes">Вы уже находитесь в блоке "Хочу общаться"</div>');
			else $tpl->set('{obshenie_offline}','<button onclick="settings.addobshenie(); return false" id="obshenieokd">Купить</button>');
			 if($obshenie) $tpl->set('{obshenie_status}','');
			else $tpl->set('{obshenie_status}','Вы не находитесь в блоке');
			$tpl->compile('content');
	}
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>
