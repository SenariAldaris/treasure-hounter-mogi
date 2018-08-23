<?php
/*========================================= 
	Appointment: Гости пользователя
	File: guests.php 
    Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');


//* Если страница вызвана через AJAX то включаем защиту, чтоб не могли обращаться напрямую к странице *//

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$metatags['title'] = 'Посетители';

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 20;
	$limit_page = ($page-1)*$gcount;
				
	switch($act){
		
//* Чистим счетчик гостей *//
		
		case "clear":
			$user_id = intval($user_info['user_id']);
                        $sql_guests = $db->super_query("SELECT SQL_CALC_FOUND_ROWS see_guests FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			if($sql_guests){

				$db->query("UPDATE LOW_PRIORITY `".PREFIX."_users` SET see_guests = '' WHERE user_id = '{$user_id}'");	
                                mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);
                                echo '<div class="err_yellow" id="guest_clear" style="font-weight:normal;">Список очищен!</div>';
					} else { 
					msgbox('', $lang['no_requests_online'], 'info_2');
					}
		break;
		

			default:
					

//* Просмотр всех друзей *// 
							
				$get_user_id = intval($_GET['user_id']);
				if(!$get_user_id)
					$get_user_id = intval($user_info['user_id']);
					
				$sql_guests = $db->super_query("SELECT SQL_CALC_FOUND_ROWS user_name, see_guests FROM `".PREFIX."_users` WHERE user_id = '{$get_user_id}'");
			        if($sql_guests){
                                        $gram_name = gramatikName($sql_guests['user_name']);
                                        $tpl->load_template('guests/head.tpl');
                                        $tpl->set('{name}', $gram_name);
					$tpl->set('{user-id}', $get_user_id);
					if($get_user_id == $user_info['user_id']){
						$tpl->set('[owner]', '');
						$tpl->set('[/owner]', '');
						$tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");
					} else {
						$tpl->set('[not-owner]', '');
						$tpl->set('[/not-owner]', '');
						$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
					}
	$guests_num = count(array_unique(explode('|',$sql_guests['see_guests']))) - 1;
	
//* Если есть гости, то выводим *//
				
				if($guests_num){
				$tpl->set_block("'\\[no-guests\\](.*?)\\[/no-guests\\]'si","");
			} else {
				$tpl->set('[no-guests]', '');
				$tpl->set('[/no-guests]', '');
			}
					$tpl->compile('info');
					
				$guests_num = count(array_unique(explode('|',$sql_guests['see_guests']))) - 1;
	
				$guests_arr = array_unique(explode('|',$sql_guests['see_guests']));
                                foreach($guests_arr as $guest_id) {		
				$sql_ = $db->super_query("SELECT SQL_CALC_FOUND_ROWS user_id, user_country_city_name, user_search_pref, user_birthday, user_photo, user_last_visit FROM `".PREFIX."_users` WHERE user_id = '{$guest_id}' ORDER by rand() DESC LIMIT {$limit_page}, {$gcount}", 1);

						if($sql_){
							$tpl->load_template('guests/guests.tpl');
							foreach($sql_ as $row){
								$user_country_city_name = explode('|', $row['user_country_city_name']);
								$tpl->set('{country}', $user_country_city_name[0]);
									
								if($user_country_city_name[1])
									$tpl->set('{city}', ', '.$user_country_city_name[1]);
								else
									$tpl->set('{city}', '');
										
								$tpl->set('{user-id}', $row['user_id']);
								$tpl->set('{name}', $row['user_search_pref']);
									
								if($row['user_photo'])
									$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);
								else
									$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
								
								if($row['user_last_visit'] >= $online_time)
									$tpl->set('{online}', $lang['online']);
								else
									$tpl->set('{online}', '');
								
	
								
								
//* Вставляем событие в моментальные оповещания *//
								
			$row_owner = $db->super_query("SELECT  tb1.user_last_visit, tb2.title FROM `".PREFIX."_users` tb1, `".PREFIX."_communities` tb2 WHERE tb1.user_id = '{$user_id}' ORDER BY tb2.id DESC");
			$update_time = $server_time - 70;
			if($row_owner['user_last_visit'] >= $update_time){
				$db->query("INSERT INTO `".PREFIX."_updates` SET for_user_id = '{$for_user_id}', from_user_id = '{$user_info['user_id']}', type = '16', date = '{$server_time}', text = '{$action_update_text}', user_photo = '{$user_info['user_photo']}', user_search_pref = '{$user_info['user_search_pref']}', lnk = '/guests'");
				mozg_create_cache("user_{$for_user_id}/updates", 1);
			}
								
//* Возраст юзера *//
								
								$user_birthday = explode('-', $row['user_birthday']);
								$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
	
								if($row['user_id'] == $user_info['user_id'])
									$tpl->set_block("'\\[viewer\\](.*?)\\[/viewer\\]'si","");
								else {
									$tpl->set('[viewer]', '');
									$tpl->set('[/viewer]', '');
                                                                 if($get_user_id == $user_info['user_id']){
					                        $tpl->set('[owner]', '');
					                        $tpl->set('[/owner]', '');
					                        $tpl->set_block("'\\[not-owner\\](.*?)\\[/not-owner\\]'si","");

                                                                 } else {
					                        $tpl->set('[not-owner]', '');
					                        $tpl->set('[/not-owner]', '');
					                        $tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				                                }

								}

								
								$tpl->compile('content');

							} 	
								
						}				


					}
                                        }

					break;

		
	

	}
	$db->free();
	$tpl->clear();
} else {
	$user_speedbar = 'Информация';
	msgbox('', $lang['not_logged'], 'info');
}
?>
