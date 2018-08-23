<?php
/*========================================== 
	Appointment: Розыгрыши
	File: nonsense.php 
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
	
	switch($act){
	
//* Участие в "Фортуна" *//
		
		case "login_one":
			
			NoAjaxQuery();
			
			$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
			
			$check = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_nonsense_users` WHERE user_id = '{$user_id}' AND type = 1");
			
			if($row['user_balance'] >= $config['nonsense_one_cost'] AND !$check['cnt']){
				
//* Составлям выигр. номер *//
				
				$rowLastNumber = $db->super_query("SELECT users_num FROM `".PREFIX."_nonsense` WHERE type = 1");
				$generatePriNnum = $rowLastNumber['users_num'] + 1;
				
//* Вставляем в базу *//
				
				$db->query("INSERT INTO `".PREFIX."_nonsense_users` SET user_id = '{$user_id}', type = 1, prize_number = '{$generatePriNnum}'");
				
//* Если это первый розыгрыш *//
				
				if(!$rowLastNumber['users_num']){
					
					$rDate = date("Y-m-d {$config['nonsense_one_time']}:00", $server_time);
					$rDate = strtotime($rDate);
	
					$lastdate = ", lastdate = '{$rDate}'";
					
				}
				
//* Обновляем кол-во людей и призовой фонд *//
				
				$db->query("UPDATE `".PREFIX."_nonsense` SET users_num = users_num + 1, prize = prize + '{$config['nonsense_one_cost']}' {$lastdate} WHERE type = 1");
				
//* Отчисляем голоса *//
				
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance - '{$config['nonsense_one_cost']}' WHERE user_id = '{$user_id}'");
				
				echo 'Ваш выигрышный номер в системе <b>'.$generatePriNnum.'</b>';
				
			} else
				echo 1;
			
			exit();
			
		break;
		
//* Лото "Фортуна" *//
		
		case "one":
			
//* Выводим инфу *//
			
			$row = $db->super_query("SELECT users_num, prize, prev_prize, lastdate, winner_uid,	winner_number FROM `".PREFIX."_nonsense` WHERE type = 1");
			
//* Розыгрываем *//
			
			$tDate = $row['lastdate'] + 86400;
			$serData = date("Y-m-d H:i:s", $server_time);
			$serData = strtotime($serData);

			if($serData >= $tDate AND $row['users_num']){
				
//* Генерируем число выиграшное *//
				
				$prizeNumber = rand(1, $row['users_num']);
				
//* Выводим ID победителя *//
				
				$rowUse = $db->super_query("SELECT user_id FROM `".PREFIX."_nonsense_users` WHERE prize_number = '{$prizeNumber}'");
				
//* Записываем новую дату розыгрыша *//
				
				$nDate = date("Y-m-d {$config['nonsense_one_time']}:00", $server_time);
				$nDate = strtotime($nDate);
				
//* Обновляем новую дату розыгрыша *//
				
				$db->query("UPDATE `".PREFIX."_nonsense` SET users_num = 0, prize = 0, prev_prize = '{$row['prize']}', lastdate = '{$nDate}', winner_uid = '{$rowUse['user_id']}', winner_number = '{$prizeNumber}' WHERE type = 1");
				
//* Удаляем участников *//
				
				$db->query("DELETE FROM `".PREFIX."_nonsense_users` WHERE type = 1");

//* Начисляем выигрыш *//
				
				$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$row['prize']}' WHERE user_id = '{$rowUse['user_id']}'");
				
				$row['users_num'] = 0;
				$row['prev_prize'] = $row['prize'];
				$row['prize'] = 0;
				$row['users_num'] = 0;
				$row['winner_uid'] = $rowUse['user_id'];
				$row['winner_number'] = $prizeNumber;
				
			}
			
//* Выводим инфу о победителе *//
			
			$rowPrizer = $db->super_query("SELECT user_search_pref, user_country_city_name, user_birthday, user_photo FROM `".PREFIX."_users` WHERE user_id = '{$row['winner_uid']}'");
			
			$tpl->load_template('nonsense/one.tpl');
			
			$tpl->set('{pob_name}', $rowPrizer['user_search_pref']);
			$tpl->set('{winner_uid}', $row['winner_uid']);
			
			$expData = explode('|', $rowPrizer['user_country_city_name']);
			$country = $expData[0];
			if($expData[1]) $country .= ', '.$expData[1];	
			$tpl->set('{country-cuty}', $country);
			
//* Возраст юзера *//
			
			$user_birthday = explode('-', $rowPrizer['user_birthday']);
			$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
			
			if($rowPrizer['user_photo']) $tpl->set('{ava}', '/uploads/users/'.$row['winner_uid'].'/182_'.$rowPrizer['user_photo']);
			else $tpl->set('{ava}', "{theme}/images/100_no_ava.png");
									
			$tpl->set('{users_num}', $row['users_num']);
			$tpl->set('{winner_number}', $row['winner_number']);
			$tpl->set('{prize}', $row['prize']);
			$tpl->set('{prev_prize}', $row['prev_prize']);
			$tpl->set('{nonsense_one_cost}', $config['nonsense_one_cost']);
			$tpl->set('{nonsense_one_time}', $config['nonsense_one_time']);
		
//* Проверка юзер играет или нет *//
			
			$check = $db->super_query("SELECT prize_number FROM `".PREFIX."_nonsense_users` WHERE user_id = '{$user_id}' AND type = 1");
			
			if($check['prize_number']){
				
				$tpl->set_block("'\\[game\\](.*?)\\[/game\\]'si","");
				$tpl->set('{mynumber}', $check['prize_number']);
				
			} else {
				
				$tpl->set('[game]', '');
				$tpl->set('[/game]', '');

			}
			
			if(!$rowPrizer['user_search_pref']){
				
				$tpl->set_block("'\\[first-game\\](.*?)\\[/first-game\\]'si","");
				
			} else {
				
				$tpl->set('[first-game]', '');
				$tpl->set('[/first-game]', '');
				
			}
			
			$tpl->set('{next-game}', date('m/d/Y H:i', $tDate));
			$tpl->set('{tek-date}', date('m/d/Y H:i', $server_time));

			$tpl->compile('content');
			
		break;
		
//* Покупка билета *// 
		
		case "bilet_buy":
		
			NoAjaxQuery();
			
			$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");

			if($row['user_balance'] >= $config['nonsense_two_cost']){
			
				$selected_numbers = explode('|', $_POST['selected_numbers']);
				
				$prev_num = 0;
				
				foreach($selected_numbers as $number){

					$number = intval($number);

					if($number >= 1 AND $number <= 45){
						
						$expNumb = explode('|'.$number.'|', $_POST['selected_numbers']);
						$numbCheck = count($expNumb);
						
						$prev_num = $prev_num + $numbCheck;
						
						$rNumsList .= '|'.$number.'|';
						
					}
					
				}

//* Проверка на то, что нет повторных чисел *//
				
				if($prev_num == 12){
					
					$rNumsList = $db->safesql($rNumsList);
					
//* Вставляем в базу *//
					
					$db->query("INSERT INTO `".PREFIX."_nonsense_users` SET type = 2, user_id = '{$user_id}', prize_number = '{$rNumsList}', date = '{$server_time}', status = 1");
					
//* Проверка это первая игра или нет *//
					
					$rowCheck = $db->super_query("SELECT users_num FROM `".PREFIX."_nonsense` WHERE type = 2");
					
					if(!$rowCheck['users_num']){
					
						$rDate = date("Y-m-d {$config['nonsense_two_time']}:00", $server_time);
						$rDate = strtotime($rDate);
		
						$lastdate = ", lastdate = '{$rDate}'";
					
					}
					
//* Обновляем кол-во билетов *//
					
					$db->query("UPDATE `".PREFIX."_nonsense` SET users_num = users_num + 1 {$lastdate} WHERE type = 2");
					
//* Снимаем цену билета с баланса юзера *//
					
					$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance - '{$config['nonsense_two_cost']}' WHERE user_id = '{$user_id}'");
					
//* Выводим и записываем в кеш билет *//
					
					$cacheUsers = mozg_cache("system/nonsense");
					
					$cacheData = $cacheUsers."{$user_id}:{$rNumsList}/";
					
					mozg_create_cache("system/nonsense", $cacheData);
					
				} else
				
					echo 2;
			} else
			
				echo 1;
			
			exit();
		
		break;
		
//* Страница покупки билета *//
		
		case "bilet_box":
		
			NoAjaxQuery();
			
			$tpl->load_template('nonsense/bilet.tpl');
			$tpl->compile('content');

			AjaxTpl();
			
			exit();
		
		break;
		
//* Лото "6 из 45" *//
		
		case "two":
		
//* Выводим инфу *//
			
			$row = $db->super_query("SELECT users_num, lastdate, prev_prize, winner_number FROM `".PREFIX."_nonsense` WHERE type = 2");

//* Крутим барабан :) *//
			
			$tDate = $row['lastdate'] + 86400;
			$serData = date("Y-m-d H:i:s", $server_time);
			$serData = strtotime($serData);

			if($serData >= $tDate AND $row['users_num']){

				$ar_rang = array();
				$ar_rand = range(1, 45);
				shuffle($ar_rand);

//* Выводим билеты *//
				
				$cacheUsers = mozg_cache("system/nonsense");
				$forArr = explode('/', $cacheUsers);
				
				$us2 = 0;
				$us3 = 0;
				$us4 = 0;
				$us5 = 0;
				$us6 = 0;
								
				foreach($forArr as $usBile){

					$forArrNew = explode(':', $usBile);

					if($forArrNew[1]){
						
						$numArr = array();

						if(stripos($forArrNew[1], '|'.$ar_rand[0].'|') !== false) $numArr[] = 0; # Проверяем 1 выгрышное число
						if(stripos($forArrNew[1], '|'.$ar_rand[1].'|') !== false) $numArr[] = 0; # Проверяем 2 выгрышное число
						if(stripos($forArrNew[1], '|'.$ar_rand[2].'|') !== false) $numArr[] = 0; # Проверяем 3 выгрышное число
						if(stripos($forArrNew[1], '|'.$ar_rand[3].'|') !== false) $numArr[] = 0; # Проверяем 4 выгрышное число
						if(stripos($forArrNew[1], '|'.$ar_rand[4].'|') !== false) $numArr[] = 0; # Проверяем 5 выгрышное число
						if(stripos($forArrNew[1], '|'.$ar_rand[5].'|') !== false) $numArr[] = 0; # Проверяем 6 выгрышное число
						
						$rNumsOk = count($numArr);
						
						$pobidUserId = intval($forArrNew[0]);
						
						if($rNumsOk == 2){
							
							$us2++;
							
//* Начисляем победителю приз *//
							
							$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$config['nonsense_two_prize_2']}' WHERE user_id = '{$pobidUserId}'");
							
						} elseif($rNumsOk == 3){
							
							$us3++;
							
//* Начисляем победителю приз *//
							
							$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$config['nonsense_two_prize_3']}' WHERE user_id = '{$pobidUserId}'");
							
						} elseif($rNumsOk == 4){
							
							$us4++;
							
//* Начисляем победителю приз *//
							
							$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$config['nonsense_two_prize_4']}' WHERE user_id = '{$pobidUserId}'");
							
						} elseif($rNumsOk == 5){
							
							$us5++;
							
//* Начисляем победителю приз *//
							
							$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$config['nonsense_two_prize_5']}' WHERE user_id = '{$pobidUserId}'");
							
						} elseif($rNumsOk == 6){
							
							$us6++;
							
//* Вставляем в таблицу логов джекпот *//
							
							$bonues = $db->safesql($config['nonsense_two_prize_6']);
							$db->query("INSERT INTO `".PREFIX."_nonsense_joker` SET user_id = '{$pobidUserId}', prize = '{$bonues}', date = '{$tDate}'");
							
						}

					}
					
				}
				
//* Записываем новую дату розыгрыша *//
				
				$nDate = date("Y-m-d {$config['nonsense_two_time']}:00", $server_time);
				$nDate = strtotime($nDate);

				$winner_number = '|'.$ar_rand[0].'||'.$ar_rand[1].'||'.$ar_rand[2].'||'.$ar_rand[3].'||'.$ar_rand[4].'||'.$ar_rand[5].'|';
						
				$prev_prize = $us2.'|'.$us3.'|'.$us4.'|'.$us5.'|'.$us6;
				
//* Записываем выигр. числа *//
				
				$db->query("UPDATE `".PREFIX."_nonsense` SET winner_number = '{$winner_number}', lastdate = '{$nDate}', users_num = '0', prev_prize = '{$prev_prize}' WHERE type = 2");
				
//* Чистим купленные билеты из кеша *//
				
				mozg_clear_cache_file("system/nonsense");
				
				$row['winner_number'] = $winner_number;
				$row['prev_prize'] = $prev_prize;
				$row['users_num'] = 0;
				$row['lastdate'] = $nDate;
				
//* Обновляем данные у всех купленных билетов *//
				
				$db->query("UPDATE `".PREFIX."_nonsense_users` SET status = 0, finish_number = '{$winner_number}' WHERE status = 1");
				
			}
			
			$tpl->load_template('nonsense/two.tpl');
			
			$tpl->set('{users_num}', $row['users_num']);
			$tpl->set('{nonsense_two_cost}', $config['nonsense_two_cost']);
			$tpl->set('{nonsense_two_time}', $config['nonsense_two_time']);
			$tpl->set('{nonsense_two_prize_2}', $config['nonsense_two_prize_2']);
			$tpl->set('{nonsense_two_prize_3}', $config['nonsense_two_prize_3']);
			$tpl->set('{nonsense_two_prize_4}', $config['nonsense_two_prize_4']);
			$tpl->set('{nonsense_two_prize_5}', $config['nonsense_two_prize_5']);
			$tpl->set('{nonsense_two_prize_6}', $config['nonsense_two_prize_6']);
			
			$expNumberWinner = explode('|', $row['winner_number']);
			
			$tpl->set('{num1}', $expNumberWinner[1]);
			$tpl->set('{num2}', $expNumberWinner[3]);
			$tpl->set('{num3}', $expNumberWinner[5]);
			$tpl->set('{num4}', $expNumberWinner[7]);
			$tpl->set('{num5}', $expNumberWinner[9]);
			$tpl->set('{num6}', $expNumberWinner[11]);
			
			if(!$row['winner_number']){
				
				$tpl->set_block("'\\[game\\](.*?)\\[/game\\]'si","");
				
			} else {
				
				$tpl->set('[game]', '');
				$tpl->set('[/game]', '');

			}
			
			$epxPrizers = explode('|', $row['prev_prize']);
			$checkPrizers = str_replace('|', '', $row['prev_prize']);
			
			if($epxPrizers[0]) $tpl->set('{prizers-2}', '<b>'.$epxPrizers[0]." ".declOfNum($epxPrizers[0], array('билет</b>', 'билета</b>','билетов</b>')).' 2 из 45<br />');
			else $tpl->set('{prizers-2}', '');
			
			if($epxPrizers[1]) $tpl->set('{prizers-3}', '<b>'.$epxPrizers[1]." ".declOfNum($epxPrizers[1], array('билет</b>', 'билета</b>','билетов</b>')).' 3 из 45<br />');
			else $tpl->set('{prizers-3}', '');
			
			if($epxPrizers[2]) $tpl->set('{prizers-4}', '<b>'.$epxPrizers[2]." ".declOfNum($epxPrizers[2], array('билет</b>', 'билета</b>','билетов</b>')).' 4 из 45<br />');
			else $tpl->set('{prizers-4}', '');
			
			if($epxPrizers[3]) $tpl->set('{prizers-5}', '<b>'.$epxPrizers[3]." ".declOfNum($epxPrizers[3], array('билет</b>', 'билета</b>','билетов</b>')).' 5 из 45<br />');
			else $tpl->set('{prizers-5}', '');
			
			if($epxPrizers[4]) $tpl->set('{prizers-6}', '<b>'.$epxPrizers[4]." ".declOfNum($epxPrizers[4], array('билет</b>', 'билета</b>','билетов</b>')).' 6 из 45<br />');
			else $tpl->set('{prizers-6}', '');

			if($checkPrizers == '0000') $tpl->set('{none}', '<span class="online">Никто не победил.</span>');
			else $tpl->set('{none}', '');
			
//* Выводим купленные билеты *//
			
			$sql_ = $db->super_query("SELECT id, prize_number, date, status, finish_number FROM `".PREFIX."_nonsense_users` WHERE user_id = '{$user_id}' AND type = 2 AND status = 1 ORDER by `date` DESC", 1);
			if(!$sql_)
				$sql_ = $db->super_query("SELECT id, prize_number, date, status, finish_number FROM `".PREFIX."_nonsense_users` WHERE user_id = '{$user_id}' AND type = 2 AND date > '".($row['lastdate'] - 86400)."' ORDER by `date` DESC", 1);

			foreach($sql_ as $row_bil){

				$expNum = explode('|', $row_bil['prize_number']);
				
				$forSelDate = langdate('j F Y в H:i', $row_bil['date']);
				
				$rwbd = $row_bil['date'] + ( 86400 * 2 );
				
				if($row_bil['status']){
						
					$played = 'style="background:#e2e6ef"';
						
				} else {
					
					$played = '';
					
				}
				
				if(stripos($row_bil['finish_number'], '|'.$expNum[1].'|') !== false) $numCheck1 = 'style="background:#c5eccf"'; else $numCheck1 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[3].'|') !== false) $numCheck2 = 'style="background:#c5eccf"'; else $numCheck2 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[5].'|') !== false) $numCheck3 = 'style="background:#c5eccf"'; else $numCheck3 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[7].'|') !== false) $numCheck4 = 'style="background:#c5eccf"'; else $numCheck4 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[9].'|') !== false) $numCheck5 = 'style="background:#c5eccf"'; else $numCheck5 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[11].'|') !== false) $numCheck6 = 'style="background:#c5eccf"'; else $numCheck6 = '';
				
				$row_bil['finish_number'] = str_replace('|', ' &nbsp;', $row_bil['finish_number']);
				if(!$row_bil['finish_number']) $row_bil['finish_number'] = '<i>Разыгрывается..</i>';
				
				$my_bilets .= "<div class=\"nonsense_one_bilet\" id=\"{$row_bil['id']}\" {$played}>
<div class=\"nonsense_bilet_n\">№{$row_bil['id']}</div>
<div class=\"nonsense_bilet_number\" {$numCheck1}>{$expNum[1]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck2}>{$expNum[3]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck3}>{$expNum[5]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck4}>{$expNum[7]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck5}>{$expNum[9]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck6}>{$expNum[11]}</div>
<div class=\"clear\"></div>
<div class=\"fl_l online\"><small>Выигрышные числа: <b>{$row_bil['finish_number']}</b></small></div>
<div class=\"fl_r online\"><small>Дата покупки: {$forSelDate}</small></div>
<div class=\"clear\"></div>
</div><div class=\"clear\"></div>";
				
			}
			
			$tpl->set('{my-bilets}', $my_bilets);
			
			$numBil = count($sql_);
			
			$tpl->set('[prev]', '');
			$tpl->set('[/prev]', '');
			
			$tpl->set('{next-game}', date('m/d/Y H:i', $tDate));
			$tpl->set('{tek-date}', date('m/d/Y H:i', $server_time));

			$tpl->compile('content');
		
		break;
		
//* Показ пред. билетов *//
		
		case "page_bilet":
		
			NoAjaxQuery();
			
			$last_id = intval($_POST['last_id']);
			
//* Выводим купленные билеты *//
			
			$sql_ = $db->super_query("SELECT id, prize_number, date, finish_number, status FROM `".PREFIX."_nonsense_users` WHERE user_id = '{$user_id}' AND type = 2 AND id < '{$last_id}' ORDER by `date` DESC LIMIT 0, 15", 1);
			
			foreach($sql_ as $row_bil){

				$expNum = explode('|', $row_bil['prize_number']);
				
				$forSelDate = langdate('j F Y в H:i', $row_bil['date']);
				
				if($row_bil['status']){
						
					$played = 'style="background:#e2e6ef"';
						
				} else {
					
					$played = '';
					
				}
				
				if(stripos($row_bil['finish_number'], '|'.$expNum[1].'|') !== false) $numCheck1 = 'style="background:#c5eccf"'; else $numCheck1 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[3].'|') !== false) $numCheck2 = 'style="background:#c5eccf"'; else $numCheck2 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[5].'|') !== false) $numCheck3 = 'style="background:#c5eccf"'; else $numCheck3 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[7].'|') !== false) $numCheck4 = 'style="background:#c5eccf"'; else $numCheck4 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[9].'|') !== false) $numCheck5 = 'style="background:#c5eccf"'; else $numCheck5 = '';
				if(stripos($row_bil['finish_number'], '|'.$expNum[11].'|') !== false) $numCheck6 = 'style="background:#c5eccf"'; else $numCheck6 = '';
				
				$row_bil['finish_number'] = str_replace('|', ' &nbsp;', $row_bil['finish_number']);
				
				$my_bilets .= "<div class=\"nonsense_one_bilet\" id=\"{$row_bil['id']}\" {$played}>
<div class=\"nonsense_bilet_n\">№{$row_bil['id']}</div>
<div class=\"nonsense_bilet_number\" {$numCheck1}>{$expNum[1]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck2}>{$expNum[3]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck3}>{$expNum[5]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck4}>{$expNum[7]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck5}>{$expNum[9]}</div>
<div class=\"nonsense_bilet_number\" {$numCheck6}>{$expNum[11]}</div>
<div class=\"clear\"></div>
<div class=\"fl_l online\"><small>Выигрышные числа: <b>{$row_bil['finish_number']}</b></small></div>
<div class=\"fl_r online\"><small>Дата покупки: {$forSelDate}</small></div>
<div class=\"clear\"></div>
</div><div class=\"clear\"></div>";
				
			}
			
			echo $my_bilets;
			
			exit();
			
		break;

//* Страница выбора *//
		
		default:
			
			$row = $db->super_query("SELECT lastdate FROM `".PREFIX."_nonsense` WHERE type = 1");
			$tDate = $row['lastdate'] + 86400;
			
			$row1 = $db->super_query("SELECT lastdate FROM `".PREFIX."_nonsense` WHERE type = 2");
			$tDate1 = $row1['lastdate'] + 86400;
			
			$tpl->load_template('nonsense/main.tpl');
			$tpl->set('{next-game}', date('m/d/Y H:i', $tDate));
			$tpl->set('{next-game-2}', date('m/d/Y H:i', $tDate1));
			$tpl->set('{tek-date}', date('m/d/Y H:i', $server_time));
			$tpl->compile('content');
		
	}
	
	$tpl->clear();
	$db->free();
	
} else {

	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
	
}
?>