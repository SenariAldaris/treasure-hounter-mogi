<?php
/*========================================== 
	Appointment: Поиск
	File: search.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG')){
	die('Hacking attempt!');
}
if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$metatags['title'] = $lang['search'];

	$mobile_speedbar = 'Поиск';

	$_SERVER['QUERY_STRING'] = strip_tags($_SERVER['QUERY_STRING']);

	$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);
	$user_id = $user_info['user_id'];

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
	$gcount = 21;
	$limit_page =($page-1)*$gcount;
    
	$query = $db->safesql(ajax_utf8(strip_data(urldecode($_GET['query']))));
	if($_GET['n']) $query = $db->safesql(strip_data(urldecode($_GET['query'])));
	
//* Заменяем пробелы на проценты чтоб поиск был точнее *//
	
	$query = strtr($query, array(' ' => '%')); 
	
	$type = intval($_GET['type']) ? intval($_GET['type']) : 1;
	$sex = intval($_GET['sex']);
	$day = intval($_GET['day']);
	$month = intval($_GET['month']);
	$year = intval($_GET['year']);
	$country = intval($_GET['country']);
	$city = intval($_GET['city']);
	$online = intval($_GET['online']);
	$user_photo = intval($_GET['user_photo']);
	$sp = intval($_GET['sp']);
	
	$online_time_2 = $server_time - $config['online_time_2'];
	
//* Задаём параметры сортировки *//
	
	if($sex) $sql_sort .= "AND user_sex = '{$sex}'";
	if($day) $sql_sort .= "AND user_day = '{$day}'";
	if($month) $sql_sort .= "AND user_month = '{$month}'";
	if($year) $sql_sort .= "AND user_year = '{$year}'";
	if($country) $sql_sort .= "AND user_country = '{$country}'";
	if($city) $sql_sort .= "AND user_city = '{$city}'";
	if($online) $sql_sort .= "AND user_last_visit >= '{$online_time_2}'";
	if($user_photo) $sql_sort .= "AND user_photo != ''";
	if($sp) $sql_sort .= "AND SUBSTRING(user_sp, 1, 1) regexp '[[:<:]]({$sp})[[:>:]]'";
	if($query OR $sql_sort) $where_sql_gen = "AND user_search_pref LIKE '%{$query}%' AND user_delet = '0' AND user_ban = '0'";
	if(!$where_sql_gen) $where_sql_gen = "AND user_delet = '0' AND user_ban = '0'";

//* Делаем SQL Запрос в базу данных на вывод данных *//
	
//* Если критерий поиск "по людям" *//
	
	if($type == 1){
		    $user_speedbar = 'Поиск пользователей';
		$sql_query = "SELECT tb1.user_id, user_name, user_lastname, user_search_pref, user_photo, user_birthday, user_country_city_name, user_country, user_last_visit, user_logged_mobile, tb2.verification, short_link FROM `".PREFIX."_users` tb1, `".PREFIX."_users_param` tb2 WHERE tb1.user_id = tb2.user_id {$where_sql_gen} {$sql_sort} ORDER by `verification`, `user_vip` DESC, `user_rating` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` tb1, `".PREFIX."_users_param` tb2 WHERE tb1.user_id = tb2.user_id {$where_sql_gen} {$sql_sort}";
		
//* Если критерий поиск "по видеозаписям" *//		
		
	} elseif($type == 2 AND $config['video_mod'] == 'yes' AND $config['video_mod_search'] == 'yes'){ 
		$sql_query = "SELECT id, photo, title, add_date, comm_num, owner_user_id FROM `".PREFIX."_videos` WHERE title LIKE '%{$query}%' AND privacy = 1 ORDER by `add_date` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_videos` WHERE title LIKE '%{$query}%' AND privacy = 1";
		
//* Если критерий поиск "по заметкам" *//		
		
	} elseif($type == 3){ 
		$sql_query = "SELECT ".PREFIX."_notes.id, title, full_text, owner_user_id, date, comm_num, ".PREFIX."_users.user_photo, user_search_pref FROM ".PREFIX."_notes LEFT JOIN ".PREFIX."_users ON ".PREFIX."_notes.owner_user_id = ".PREFIX."_users.user_id WHERE title LIKE '%{$query}%' OR full_text LIKE '%{$query}%' ORDER by `date` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_notes` WHERE title LIKE '%{$query}%' OR full_text LIKE '%{$query}%'";
		
//* Если критерий поиск "по сообществам" *//		
		
	} elseif($type == 4){ 
		$sql_query = "SELECT id, title, photo, traf, adres FROM `".PREFIX."_communities` WHERE title LIKE '%{$query}%' AND del = '0' AND ban = '0' ORDER by `fixed` ASC, `traf` DESC, `photo` ASC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_communities` WHERE title LIKE '%{$query}%' AND del = '0' AND ban = '0'";
		
//* Если критерий поиск "по аудиозаписям" *//		
		
	} elseif($type == 5 AND $config['audio_mod'] == 'yes' AND $config['audio_mod_search'] == 'yes'){ 
		$sql_query = "SELECT ".PREFIX."_audio.aid, url, artist, name, auser_id, ".PREFIX."_users.user_search_pref FROM ".PREFIX."_audio LEFT JOIN ".PREFIX."_users ON ".PREFIX."_audio.auser_id = ".PREFIX."_users.user_id WHERE MATCH (name, artist) AGAINST ('%{$query}%') OR artist LIKE '%{$query}%' OR name LIKE '%{$query}%' ORDER by `adate` DESC LIMIT {$limit_page}, {$gcount}";
		$sql_count = "SELECT COUNT(*) AS cnt FROM `".PREFIX."_audio` WHERE MATCH (name, artist) AGAINST ('%{$query}%') OR artist LIKE '%{$query}%' OR name LIKE '%{$query}%'";
	} else {
		$sql_query = false;
		$sql_count = false;
	}
	
	if($sql_query)
		$sql_ = $db->super_query($sql_query, 1);
	
//* Считаем кол-во ответов из базы данных *//
	
	if($sql_count AND $sql_)
		$count = $db->super_query($sql_count);

//* Head поиска *//
	
	$tpl->load_template('search/head.tpl');
     
	if($query)
		$tpl->set('{query}', stripslashes(stripslashes(strtr($query, array('%' => ' ')))));
	else
		$tpl->set('{query}', 'Начните вводить любое слово или имя');

	if ($type == 1) {
		$tpl->set('{block_id}', '.friends_onefriend');
	} else if ($type == 2) {
		$tpl->set('{block_id}', '.onevideo');
	} else if ($type == 3) {
		$tpl->set('{block_id}', '.note_search');
	} else if ($type == 4) {
		$tpl->set('{block_id}', '.friends_onefriend');
	} else if ($type == 5) {
		$tpl->set('{block_id}', '.audio_onetrack');
	}
	
	$_GET['query'] = $db->safesql(ajax_utf8(strip_data(urldecode($_GET['query']))));
	if($_GET['n']) $_GET['query'] = $db->safesql(strip_data(urldecode($_GET['query'])));
   
	$tpl->set('{query-people}', str_replace(array('&type=2', '&type=3', '&type=4', '&type=5'), '&type=1', $_SERVER['QUERY_STRING']));
	$tpl->set('{query-videos}', '&type=2&query='.$_GET['query']);
	$tpl->set('{query-notes}', '&type=3&query='.$_GET['query']);
	$tpl->set('{query-groups}', '&type=4&query='.$_GET['query']);
	$tpl->set('{query-audios}', '&type=5&query='.$_GET['query']);

	if($online) $tpl->set('{checked-online}', 'online');
	else $tpl->set('{checked-online}', '0');
		
	if($user_photo) $tpl->set('{checked-user-photo}', 'user_photo');
	else $tpl->set('{checked-user-photo}', '0');
	
	$tpl->set("{activetab-{$type}}", 'activetab');
	$tpl->set("{type}", $type);
	
	$tpl->set('{sex}', installationSelected($sex, '<option value="1">Мужской</option><option value="2">Женский</option>'));
	$tpl->set('{day}', installationSelected($day, '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'));
	$tpl->set('{month}', installationSelected($month, '<option value="1">Января</option><option value="2">Февраля</option><option value="3">Марта</option><option value="4">Апреля</option><option value="5">Мая</option><option value="6">Июня</option><option value="7">Июля</option><option value="8">Августа</option><option value="9">Сентября</option><option value="10">Октября</option><option value="11">Ноября</option><option value="12">Декабря</option>'));
	$tpl->set('{year}', installationSelected($year, '<option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option>'));
			
	if ($_POST['ajax'] == 'yes' && $page != 1) {
		if ($type == 1) {
			$tpl->load_template('search/result_people.tpl');
			foreach ($sql_ as $item) {
				if ($item['short_link'] != null && $item['short_link'] != 'empty') {
					$link = '/' . $item['short_link'];
				} else {
					$link = '/u' . $item['user_id'];
				}
				$tpl->set('{link}', $link);
				$tpl->set('{user-id}', $item['user_id']);
				$tpl->set('{name}', $item['user_search_pref']);

				if ($item['user_photo']) {
					$tpl->set('{ava}', $config['home_url'] . 'uploads/users/' . $item['user_id'] . '/182_' . $item['user_photo']);
				} else {
					$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
				}

				$birthday = explode('-', $item['user_birthday']);
				$tpl->set('{age}', user_age($birthday[0], $birthday[1], $birthday[2]));

				$tpl->set('{kubok}', '');
				$tpl->set('{money}', '');

				$loc = explode('|', $item['user_country_city_name']);
				$tpl->set('{country}', $loc[0]);
				if ($loc[1]) {
					$tpl->set('{city}', ', ' . $loc[1]);
				} else {
					$tpl->set('{city}', '');
				}

				if($item['verification']) $tpl->set('{verification}', '<img style="margin-left:5px" src="{theme}/images/verifi.png" />');
				else $tpl->set('{verification}', '');
				
				OnlineTpl($item['user_last_visit'], $item['user_logged_mobile']);
				

				if($item['user_id'] == 7) $tpl->set('{group}', '<font color="#f87d7d">Модератор</font>');
				else $tpl->set('{group}', '');

				$tpl->compile('content');
			}
		} else if ($type == 2) {
			$tpl->load_template('search/result_video.tpl');
			foreach($sql_ as $row) {
				$tpl->set('{photo}', $row['photo']);
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{user-id}', $row['owner_user_id']);
				$tpl->set('{id}', $row['id']);
				$tpl->set('{close-link}', '/index.php?'.$query_string.'&page='.$page);
				$tpl->set('{comm}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				megaDate(strtotime($row['add_date']), 1, 1);
				$tpl->compile('content');
			}
		} else if ($type == 3) {
			$tpl->load_template('search/result_note.tpl');
			foreach($sql_ as $row) {
				if($row['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['owner_user_id'].'/50_'.$row['user_photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
				
				$tpl->set('{user-id}', $row['owner_user_id']);
				$tpl->set('{short-text}', stripslashes(strip_tags(iconv_substr($row['full_text'], 0, 200, 'utf-8'))).'...');
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{name}', $row['user_search_pref']);
				$tpl->set('{note-id}', $row['id']);
				megaDate(strtotime($row['date']), 1, 1);
				if($row['comm_num'])
					$tpl->set('{comm-num}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				else
					$tpl->set('{comm-num}', $lang['note_no_comments']);
				$tpl->compile('content');
			}
		} else if ($type == 4) {
			$tpl->load_template('search/result_groups.tpl');
			foreach($sql_ as $row) {
				if($row['photo'])
					$tpl->set('{ava}', '/uploads/groups/'.$row['id'].'/182_'.$row['photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_groups_100.gif');
				
				$tpl->set('{public-id}', $row['id']);
				$tpl->set('{name}', stripslashes($row['title']));
				$tpl->set('{note-id}', $row['id']);
				$tpl->set('{traf}', $row['traf'].' '.gram_record($row['traf'], 'groups_users'));
				if($row['adres']) $tpl->set('{adres}', $row['adres']);
				else $tpl->set('{adres}', 'public'.$row['id']);
				$tpl->compile('content');
			}
		} else if ($type == 5) {
			$tpl->load_template('search/result_audio.tpl');
			$jid = 0 + $limit_page;
			foreach($sql_ as $row) {
				$jid++;
				$tpl->set('{jid}', $jid);
				$tpl->set('{aid}', $row['aid']);
				$tpl->set('{url}', $row['url']);
				$tpl->set('{artist}', stripslashes($row['artist']));
				$tpl->set('{name}', stripslashes($row['name']));
				$tpl->set('{author-n}', iconv_substr($row['user_search_pref'], 0, 1, 'utf-8'));
				$expName = explode(' ', $row['user_search_pref']);
				$tpl->set('{author-f}', $expName[1]);
				$tpl->set('{author-id}', $row['auser_id']);
				$tpl->compile('content');
			}
		} else {
			$tpl->set_block("'\\[search_js\\](.*?)\\[/search_js\\]'si","");
		}

		AjaxTpl();
		die();
	}

	if($count['cnt']){
		$tpl->set('[yes]', '');
		$tpl->set('[/yes]', '');

//* FOR MOBILE VERSION 1.0 *//
		
		if($online == 1){
		
			$tpl->set_block("'\\[no-online\\](.*?)\\[/no-online\\]'si","");
			$tpl->set('[online]', '');
			$tpl->set('[/online]', '');
		
		} else {
			
			$tpl->set_block("'\\[online\\](.*?)\\[/online\\]'si","");
			$tpl->set('[no-online]', '');
			$tpl->set('[/no-online]', '');
			
		}
		
//* Если критерий поиск "по людям" *//	
		
		if($type == 1)
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'fave'));
			
//* Если критерий поиск "по видеозаписям" *//			
			
		elseif($type == 2 AND $config['video_mod'] == 'yes') 
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'videos'));
			
//* Если критерий поиск "по заметкам" *//			
			
		elseif($type == 3)
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'notes'));
			
//* Если критерий поиск "по сообществам" *//			
			
		elseif($type == 4) 
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'se_groups'));
			
//* Если критерий поиск "по аудиозаписям" *//			
			
		elseif($type == 5)
			$tpl->set('{count}', $count['cnt'].' '.gram_record($count['cnt'], 'audio'));
	} else 
		$tpl->set_block("'\\[yes\\](.*?)\\[/yes\\]'si","");
		

	$tpl->set('[search_js]', '');
	$tpl->set('[/search_js]', '');

	if($type == 1){
		$tpl->set('[search-tab]', '');
		$tpl->set('[/search-tab]', '');
	} else {
		$tpl->set_block("'\\[search-tab\\](.*?)\\[/search-tab\\]'si","");
	}
	
//* Загружаем Страны *//
	
	$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true, "country", true);
	foreach($sql_country as $row_country)
		$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
			
	$tpl->set('{country}', installationSelected($country, $all_country));
	
//* Загружаем Города  *//
	
	if($type == 1){
		$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$country}' ORDER by `name` ASC", true, "country_city_".$country, true);
		foreach($sql_city as $row2) 
			$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';

		$tpl->set('{city}', installationSelected($city, $all_city));
	}
	
	$tpl->compile('info');
	
//* Загружаем шаблон на вывод если он есть одного юзера и выводим *//
	
	if($sql_){
	
//* Если критерий поиск "по людям" *//
		
		if($type == 1){
			$sqlFirst = $db->super_query("SELECT user_id, user_rating FROM `".PREFIX."_users` WHERE user_delet = 0 AND user_ban = 0 ORDER by `user_rating` DESC LIMIT 0, 3", 1);
			
			$iFirst = 0;
			
			foreach($sqlFirst as $rowFirst){
				
				$iFirst++;
				
				if($iFirst == 1){
					$userId_1 = $rowFirst['user_id'];
					$userRating_1 = $rowFirst['user_rating'];
				} elseif($iFirst == 2)
					$userId_2 = $rowFirst['user_id'];
				elseif($iFirst == 3)
					$userId_3 = $rowFirst['user_id'];
				else {
					$userId_1 = '';
					$userId_2 = '';
					$userId_3 = '';
				}
			}

			$tpl->load_template('search/result_people.tpl');
			foreach($sql_ as $row){
				
				if($userId_1 == $row['user_id']){
					
					if($userRating_1 >= $config['money_rating']) $opacity = '1';
					else $opacity = '0.5';
					
					$tpl->set('{money}', '<img src="{theme}/images/mon.png" style="margin-bottom:-3px;opacity:'.$opacity.'" />');
					
				} else 
					$tpl->set('{money}', '');
				
				if($userId_1 == $row['user_id']){
					
					if($row['user_country'] == 4)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/be.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 2)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ua.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 1)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ru.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 10)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/usa.gif" style="margin-right:-30px" />');
					else
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ru.gif" style="margin-right:-30px" />');
				
				} elseif($userId_2 == $row['user_id']){
				
					if($row['user_country'] == 4)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/be.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 2)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ua.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 1)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ru.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 10)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/usa.gif" style="margin-right:-30px" />');
					else
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ru.gif" style="margin-right:-30px" />');
					
				} elseif($userId_3 == $row['user_id']){
				
					if($row['user_country'] == 4)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/be.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 2)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ua.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 1)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ru.gif" style="margin-right:-30px" />');
					elseif($row['user_country'] == 10)
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/usa.gif" style="margin-right:-30px" />');
					else
						$tpl->set('{kubok}', '<img src="{theme}/images/icons/ru.gif" style="margin-right:-30px" />');

				} else 
					$tpl->set('{kubok}', '');
				
				$tpl->set('{user-id}', $row['user_id']);
				$tpl->set('{name}', $row['user_name']);
				$tpl->set('{fname}', $row['user_lastname']);
				if ($row['short_link'] != null && $row['short_link'] != 'empty') {
					$link = '/' . $row['short_link'];
				} else {
					$link = '/u' . $row['user_id'];
				}
				$tpl->set('{link}', $link);
				if($row['user_photo']) 
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/182_'.$row['user_photo']);
				else 
					$tpl->set('{ava}', '{theme}/images/100_no_ava.png');
					
//* Возраст юзера *//
				
				$user_birthday = explode('-', $row['user_birthday']);
				$tpl->set('{age}', user_age($user_birthday[0], $user_birthday[1], $user_birthday[2]));
				
				$user_country_city_name = explode('|', $row['user_country_city_name']);
				$tpl->set('{country}', $user_country_city_name[0]);
				if($user_country_city_name[1])
					$tpl->set('{city}', ', '.$user_country_city_name[1]);
				else
					$tpl->set('{city}', '');
					
				if($row['user_id'] != $user_id){
					$tpl->set('[owner]', '');
					$tpl->set('[/owner]', '');
				} else
					$tpl->set_block("'\\[owner\\](.*?)\\[/owner\\]'si","");
				
				if($row['verification']) $tpl->set('{verification}', '<img src="{theme}/images/verifi.png" style="margin-left: 3px; margin-bottom: -3px;">');
				else $tpl->set('{verification}', '');
				
				OnlineTpl($row['user_last_visit'], $row['user_logged_mobile']);

				if($row['user_id'] == 7) $tpl->set('{group}', '<font color="#f87d7d">Модератор</font>');
				else $tpl->set('{group}', '');

				$tpl->compile('content');
			}

//* Если критерий поиск "по видеозаписям" *//
		
		} elseif($type == 2){
			$tpl->load_template('search/result_video.tpl');
			foreach($sql_ as $row){
				$tpl->set('{photo}', $row['photo']);
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{user-id}', $row['owner_user_id']);
				$tpl->set('{id}', $row['id']);
				$tpl->set('{close-link}', '/index.php?'.$query_string.'&page='.$page);
				$tpl->set('{comm}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				megaDate(strtotime($row['add_date']), 1, 1);
				$tpl->compile('content');
			}
			
//* Если критерий поиск "по заметкам" *//
		
		} elseif($type == 3){
			$tpl->load_template('search/result_note.tpl');
			foreach($sql_ as $row){
				if($row['user_photo'])
					$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['owner_user_id'].'/50_'.$row['user_photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_50.png');
				
				$tpl->set('{user-id}', $row['owner_user_id']);
				$tpl->set('{short-text}', stripslashes(strip_tags(iconv_substr($row['full_text'], 0, 200, 'utf-8'))).'...');
				$tpl->set('{title}', stripslashes($row['title']));
				$tpl->set('{name}', $row['user_search_pref']);
				$tpl->set('{note-id}', $row['id']);
				megaDate(strtotime($row['date']), 1, 1);
				if($row['comm_num'])
					$tpl->set('{comm-num}', $row['comm_num'].' '.gram_record($row['comm_num'], 'comments'));
				else
					$tpl->set('{comm-num}', $lang['note_no_comments']);
				$tpl->compile('content');
			}

//* Если критерий поиск "по сообещствам" *//
		
		} elseif($type == 4){
			$tpl->load_template('search/result_groups.tpl');
			$user_speedbar = $lang['editmyprofile'].' &raquo; Другое';
			foreach($sql_ as $row){
				if($row['photo'])
					$tpl->set('{ava}', '/uploads/groups/'.$row['id'].'/100_'.$row['photo']);
				else
					$tpl->set('{ava}', '{theme}/images/no_ava_groups_100.gif');
				
				$tpl->set('{public-id}', $row['id']);
				$tpl->set('{name}', stripslashes($row['title']));
				$tpl->set('{note-id}', $row['id']);
				$tpl->set('{traf}', $row['traf'].' '.gram_record($row['traf'], 'groups_users'));
				if($row['adres']) $tpl->set('{adres}', $row['adres']);
				else $tpl->set('{adres}', 'public'.$row['id']);
				$tpl->compile('content');
			}

//* Если критерий поиск "по аудизаписям" *//
		
		} elseif($type == 5){
			$tpl->load_template('search/result_audio.tpl');
			$jid = 0 + $limit_page;
			foreach($sql_ as $row){
				$jid++;
				$tpl->set('{jid}', $jid);
				$tpl->set('{aid}', $row['aid']);
				$tpl->set('{url}', $row['url']);
				$tpl->set('{artist}', stripslashes($row['artist']));
				$tpl->set('{name}', stripslashes($row['name']));
				$tpl->set('{author-n}', iconv_substr($row['user_search_pref'], 0, 1, 'utf-8'));
				$expName = explode(' ', $row['user_search_pref']);
				$tpl->set('{author-f}', $expName[1]);
				$tpl->set('{author-id}', $row['auser_id']);
				$tpl->compile('content');
			}
		} else
			msgbox('', $lang['search_none'], 'info_2');

	} else {
		if ($_POST['ajax'] == 'yes' && $page != 1) {
			echo 'last_page';
		}

		msgbox('', '', 'info_search');
	}
	
	$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>
