<?php
/*========================================= 
	Appointment: Мисс сайта
	File: miss.php 
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
	$metatags['title'] = 'Мисс сайта';
	switch($act){
	
//* Управление пользователями *//
		
		case "admin":
		NoAjaxQuery();
		$type = intval($_GET['type']);       
        $id = intval($_POST['id']); 	
	    $row = $db->super_query("SELECT user_group FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");	
        if($row['user_group']==1){
       
//* Отчистка всех участников конкурса *//
	   
		if($type==1){ 
		$db->query("DELETE FROM `".PREFIX."_miss` WHERE 1");
		}
		
//* Оннулирование рейтинга участнице *//		
		
		if($type==2){ 
        $db->query("UPDATE `".PREFIX."_miss` SET rate = 0, list = '' WHERE user_id = '{$id}'");
		}
		
//* Изменение рейтинга *//	
		
		if($type==3){
		$rate = intval($_POST['rate']); 
        $db->query("UPDATE `".PREFIX."_miss` SET rate = '".$rate."' WHERE user_id = '{$id}'");
		}    
		echo 'ok'; 	
		}else echo 'err_group'; 		
		
		die();
		break; 
         		
//* Регистрация на конкурсе *//
		
		case "reg":
		NoAjaxQuery();
	    $row = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");	
        if($row['user_sex']==2){
        $r = $db->super_query("SELECT id FROM `".PREFIX."_miss` WHERE user_id = '{$user_id}'");
      	if(!$r['id']){
		$db->query("INSERT INTO `".PREFIX."_miss` SET user_id = '{$user_id}', rate = '1', list = '|{$user_id}|'");
		echo 'ok';
        }else {echo 'err_reg';}		
		
		}else echo 'err_sex'; 		
		die();
		break;
		
		
//* Голосование за пользователя *//
		
		case "vote":
		NoAjaxQuery();
		$type = intval($_POST['type']);       
        $id = intval($_POST['id']); 	
        $row = $db->super_query("SELECT list FROM `".PREFIX."_miss` WHERE user_id = '{$id}'");		
		if($row AND stripos($row['list'], "|{$user_id}|") === false){
        $ulist = $row['list']."|{$user_id}|";
		if($type==1){
		$db->query("UPDATE `".PREFIX."_miss` SET rate = rate+1, list = '{$ulist}' WHERE user_id = '{$id}'");
		}
		if($type==2){
		$db->query("UPDATE `".PREFIX."_miss` SET rate = rate-1, list = '{$ulist}' WHERE user_id = '{$id}'");
		}
		
						$check2 = $db->super_query("SELECT user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
						$update_time = $server_time - 70;
		
						if($check2['user_last_visit'] >= $update_time){
							
						
								$msg_lnk = '/miss/'.$user_id;
							
							$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$id}', from_user_id = '{$user_id}', type = '30', date = '{$server_time}', text = 'За вас проголосовали', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '{$msg_lnk}'");
										
							mozg_create_cache("user_{$id}/updates", 1);

						}

		
		echo 'ok';
		} else echo 'err_vote';
		die();
		break;
		
//* Страница пользователя *//
		
		case "page":
		$id = intval($_GET['id']);       
	    $row_main = $db->super_query("SELECT id, rate FROM `".PREFIX."_miss` WHERE user_id = '{$id}'");
      	if($row_main['id']){
		$user_speedbar = 'Страница участницы';
		$row = $db->super_query("SELECT user_photo, user_id, user_search_pref FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
		 $tpl->load_template('miss/page.tpl');
		 $tpl->set('{user-id}', $row['user_id']);
		
	     $tpl->set('{name}', $row['user_search_pref']);

		if($row_main['rate']>=99) $tpl->set('{rate-ava}','99'); 
		else $tpl->set('{rate-ava}',$row_main['rate']); 
		$tpl->set('{rate}', $row_main['rate']);
			
					if($row['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					
						$tpl->compile('content'); 	
	
		} else {$user_speedbar = 'Не зарегистрирована';		msgbox('', '<br><br>Эта девушка не учавствует в конкурсе<br><br>', 'info_2');
}
	break;
		
//* Топ пользователей *//
		
		case "top":
		$user_speedbar = 'Топ участниц';
		
//* Вверх *//
			
		   $sex = $db->super_query("SELECT user_sex FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");	
		   if($sex['user_sex']==2){
			$tpl->set('[female]', '');
			$tpl->set('[/female]', '');
			}else 
			$tpl->set_block("'\\[female\\](.*?)\\[/female\\]'si","");
              $tpl->set('{user-id}', $user_id);
			
			$tpl->load_template('miss/head.tpl');
			$tpl->compile('info');
		 
		      $_sql = $db->super_query("SELECT SQL_CALC_FOUND_ROWS tb1.user_id, id, rate, tb2.user_photo, user_search_pref FROM `".PREFIX."_miss` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id ORDER by `rate` DESC LIMIT 0, 100", 1);
	          if($_sql){
			  $tpl->load_template('miss/top.tpl');
				foreach($_sql as $row){

					$tpl->set('{user-id}', $row['user_id']);
					$tpl->set('{name}', $row['user_search_pref']);
					$tpl->set('{rate}', $row['rate']);
					
					if($row['user_photo'])
						$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/182_'.$row['user_photo']);
					else
						$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					
					
					$tpl->compile('content');
				}
		}else msgbox('', '<br><br>Никто не учавствует в конкурсе<br><br>', 'info_2');

		
		break;
		

		
		
		
		
    }
	$db->free();
	$tpl->clear();
	
    }
?>