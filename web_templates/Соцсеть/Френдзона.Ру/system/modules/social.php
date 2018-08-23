<?php
/*========================================= 
	Appointment: Соц.сети
	File: social.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();

if($logged){
	$act = $_GET['act'];
	$user_id = $user_info['user_id'];
	
	switch($act){
		
//* VK *// 
		
		case "vk":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$vk_login = textFilter($_POST['vk_login']);
			$vk_pass = textFilter($_POST['vk_pass']);
			
//* Удаляем старые куки *//
			
			if($_POST['not_logged']){
			
				@unlink(ROOT_DIR."/system/cache/social/coo{$user_info['user_id']}.txt");
				
//* Входим ВК *//
				
				post_content("https://login.vk.com/?act=login", "act=login&q=1&al_frame=1&expire=&captcha_sid=&captcha_key=&from_host=vk.com&email={$vk_login}&pass={$vk_pass}");
				
				@chmod(ROOT_DIR."/system/cache/social/coo{$user_info['user_id']}.txt", 0666);
				
				if($_POST['vk_save_cook']){
					
					$check = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_social` WHERE suser_id = '{$user_id}'");
					
					if(!$check['cnt'])
						$db->query("INSERT INTO `".PREFIX."_social` SET suser_id = '{$user_id}', vk_login = '{$vk_login}', vk_pass = '{$vk_pass}'");
					else
						$db->query("UPDATE `".PREFIX."_social` SET vk_login = '{$vk_login}', vk_pass = '{$vk_pass}' WHERE suser_id = '{$user_id}'");
					
				} else
					$db->query("DELETE FROM `".PREFIX."_social` WHERE suser_id = '{$user_id}'");
			
			}
			
//* Открываем ленту новостей *//
			
			$pars_data = post_content("http://vk.com/feed");

			preg_match_all("#<div id=\"security_check\">(.*?)<table#si", $pars_data['content'], $mob_sec);

			if($mob_sec[1][0]){
				
				preg_match_all("#, to: '(.*?)'#si", $pars_data['content'], $mob_to);
				preg_match_all("#, al_page: '(.*?)'#si", $pars_data['content'], $mob_al_page);
				preg_match_all("#<td><div class=\"label ta_r\">(.*?)</div>#si", $pars_data['content'], $mob_number);
			
				$pars_data_mob = post_content("http://m.vk.com/");
				
				preg_match_all("#&hash=(.*?)\"#si", $pars_data_mob['content'], $mob_hash);

				$tpl->load_template('social/vk_check.tpl');
				$tpl->set('{text}', str_replace(iconv('utf-8', 'windows-1251', 'К сожалению, цифры указаны неверно. Вы можете повторить попытку через 4 часа.'), '', $mob_sec[1][0]));
				$tpl->set('{mob_to}', '');
				$tpl->set('{al_page}', '');
				$tpl->set('{mob_hash}', $mob_hash[1][0]);
				$tpl->set('{mob_number}', $mob_number[1][0]);
				$tpl->compile('content');
				
				AjaxTpl();
				
				exit;
				
			}

			$st1 = explode('<div class="post_table">', $pars_data['content']);
			
			preg_match_all("#id: (.*?),#si", $pars_data['content'], $to_id);
			
			if(!$to_id[1][0] OR stripos($pars_data['content'], "/images/pics/spamfight.gif") !== false) exit;
			
			preg_match_all("#\"offset\":10,\"from\":\"(.*?)\"#si", $pars_data['content'], $next_page_id);
			preg_match_all("#,\"offset\":(.*?),\"#si", $pars_data['content'], $offset);
			preg_match_all("#,\"post_hash\":\"(.*?)\",\"#si", $pars_data['content'], $vk_post_hash);

			$rptext = iconv('utf-8', 'windows-1251', 'Мои Сообщения');
			preg_match_all("#Pads.show\('msg', event\)\" onclick=\"return \(checkEvent\(event\) \|\| browser.msie6\) \? true : cancelEvent\(event\)\"><span class=\"left_count_wrap  fl_r\"><span class=\"inl_bl left_count\">+(.*?)</span></span></span><span class=\"left_label inl_bl\">{$rptext}</span>#si", $pars_data['content'], $vk_new_msg_num);
			$vk_new_msg_num[1][0] = str_replace('+', '', $vk_new_msg_num[1][0]);
				
			if($_POST['not_logged']){
			
				$tpl->load_template('social/vk_head.tpl');
				$tpl->set('{next_page_id}', $next_page_id[1][0]);
				$tpl->set('{vk_post_hash}', $vk_post_hash[1][0]);
				$tpl->set('{to_id}', $to_id[1][0]);
				$tpl->set('{vk_new_msg_num}', $vk_new_msg_num[1][0]);
				$tpl->compile('info');
			
			} else
				$tpl->result['content'] .= "<script>$('#vk_new_msg_num').text('{$vk_new_msg_num[1][0]}')</script>";
			
			$tpl->result['content'] .= '<div id="vk_page_go">';
			
			$tpl->load_template('social/vk_feed.tpl');
			foreach($st1 as $arr){
				
				$rdaomc = '';
				
				preg_match_all("#<div class=\"wall_text\">(.*?)</a>#si", $arr, $data);
				
				if($data[1][0]){
					
					if(stripos($arr, 'published_by') !== false){
						
						preg_match_all("#<a class=\"published_by\"(.*?)</a>#si", $arr, $data10);
						preg_match_all("#<div class=\"published_by_date\">(.*?)</a>#si", $arr, $data11);
						
						$repostpref = ' <font color="#000">-> '.strip_tags('<a '.$data10[1][0]).'</font> / <span style="font-weight:normal;color:#777"><small>'.strip_tags($data11[1][0]).'</small></span>';
						
					} else
						$repostpref = '';
						
					$arr = preg_replace("#<table cellpadding=\"0\" cellspacing=\"0\" class=\"published_by_wrap\">(.*?)</table>#si", "", $arr);
					
//* Комментарии *//
					
					preg_match_all("#<div class=\"replies_wrap clear\"(.*?)<div class=\"feed_row#si", $arr, $xdata1);
					
					$fdsakm = explode('<div class="reply_table">', $xdata1[1][0]);
					
					foreach($fdsakm as $onemcdata){
						
						preg_match_all("#<a class=\"author\"(.*?)</a>#si", $onemcdata, $xdata2);
						$raen2 = explode('>', $xdata2[1][0]);
						
						preg_match_all("#<div class=\"wall_reply_text\">(.*?)</div>#si", $onemcdata, $xdata3);
						preg_match_all("#<span class=\"rel_date(.*?)</span>#si", $onemcdata, $xdata4);
						$expdsate = explode('">', $xdata4[1][0]);
						$xdata4[1][0] = str_replace('">', '', $expdsate[1]);
						
						preg_match_all("#img src=\"(.*?)\"#si", $onemcdata, $xdata5);
						$xdata4[1][0] = str_replace('">', '', $xdata4[1][0]);
						
						$checkpost2 = explode('http://', $xdata5[1][0]);
						if(!$checkpost2[1]) $xdata5[1][0] = 'http://vk.com'.$xdata5[1][0];
						
						$xdata3[1][0] = strip_tags($xdata3[1][0]);
						
						if($xdata4[1][0]){
						
							$rdaomc .= <<<HTML
<div class="wall_fast_block" style="border-top:1px solid #DAE1E8;margin-top:5px">
  <div class="wall_fast_ava">
   <img src="{$xdata5[1][0]}" />
  </div>
  <div>
    <a>{$raen2[1]}</a>
  </div>
  <div class="wall_fast_comment_text">{$xdata3[1][0]}</div>
  <div class="wall_fast_date">
    {$xdata4[1][0]}
  </div>
  <div class="clear"></div>
</div>
HTML;
						}
						
					}

					$tpl->set('{comments}', $rdaomc);
					
					preg_match_all("#\"><img src=\"(.*?)\" width=\"50\"#si", $arr, $data1);
					preg_match_all("#<div class=\"wall_text\">(.*?)<div class=\"post_like_wrap#si", $arr, $data2);
					preg_match_all("#<span class=\"rel_date(.*?)</span>#si", $arr, $data3);
					preg_match_all("#<span class=\"post_like_count fl_l\"(.*?)</span>#si", $arr, $data4);
					
					preg_match_all("#<div id=\"wpt(.*?)_#si", $arr, $data10);

					$tpl->set('{vk_uid}', $data10[1][0]);
					$tpl->set('{rand}', rand(1, 104032421));

					$author = strip_tags($data[1][0]);
					$author = trim($author);
					$poster = trim($data1[1][0]);
					$checkpost = explode('http://', $poster);
					if(!$checkpost[1]) $poster = 'http://vk.com'.$poster;

					$epxdat = explode($author.'</a>', $data2[1][0]);
					$data2[1][0] = $epxdat[1];
					
					$text = $data2[1][0];
					$text = str_replace(array('<br>', '<br />'), '{br}', $text);
					$text = strip_tags($text);
					$text = str_replace('{br}', '<br />', $text);
					$text = trim($text);
					
					$text = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $text);
					
					preg_match_all("#<img src=\"(.*?)\"#si", $data2[1][0], $imgposer);
					if(!$imgposer[1][0]) preg_match_all("#background-image: url\((.*?)\)#si", $arr, $imgposer);
					
					$expdatess = explode('">', $data3[1][0]);
					$likes = strip_tags('<a'.$data4[1][0]);

					$tpl->set('{author}', $author.$repostpref);
					$tpl->set('{poster}', $poster);
					$tpl->set('{text}', $text);
					if($text) $br_text = '<br />';
					else $br_text = '';
					if($imgposer[1][0]) $tpl->set('{addmsgpos}', "{$br_text}<img src=\"{$imgposer[1][0]}\" />");
					else $tpl->set('{addmsgpos}', '');
					$tpl->set('{date}', $expdatess[1]);
					$tpl->set('{likes}', $likes);
					
					preg_match_all("#id=\"post_hash(.*?)/>#si", $arr, $forcommga);
					$expds3 = explode('" value="', $forcommga[1][0]);
					$expds3[1] = str_replace('"', '', $expds3[1]);
					
					$tpl->set('{vk_hash}', $expds3[1]);
					$tpl->set('{vk_id}', $expds3[0]);
					
					if($expds3[1]){
					
						$tpl->set('[comm]', '');
						$tpl->set('[/comm]', '');
					
					} else
						$tpl->set_block("'\\[comm\\](.*?)\\[/comm\\]'si","");
					
					if($expds3[0] > 0){
					
						$tpl->set('[msg]', '');
						$tpl->set('[/msg]', '');
					
					} else
						$tpl->set_block("'\\[msg\\](.*?)\\[/msg\\]'si","");
					
					$news_found = true;

					$tpl->compile('content');
				
				}

			}
			
			if($news_found){
			
				$tpl->load_template('social/vk_boot.tpl');
				$tpl->set('{next_page_id}', $next_page_id[1][0]);
				$tpl->set('{offset}', $offset[1][0]);
				$tpl->compile('content');
				
			} else {
			
				$tpl->result['content'] = iconv('utf-8', 'windows-1251', '<div class="info_center" style="margin-top:60px;margin-bottom:50px">Здесь Вы будете видеть новостную ленту своих друзей.</div>');
				
			}
			
			$tpl->result['content'] .= '</div>';

			AjaxTpl();
			
			exit;
			
		break;
		
//* VK / Показать предыдущие новости *//
		
		case "vk_news_page":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
//* Получаем POST данные *//
			
			$next_page_id = $_POST['next_page_id'];
			$vk_offset = $_POST['vk_offset'];
			
//* Открываем пред.новости *//
			
			$pars_data = post_content("http://vk.com/al_feed.php?sm_news", "al=1&from={$next_page_id}&more=1&offset={$vk_offset}&part=1&section=news&subsection=recent");
			
			preg_match_all("#\"from\":\"(.*?)\"#si", $pars_data['content'], $new_next_page_id);
			preg_match_all("#,\"offset\":(.*?),\"#si", $pars_data['content'], $offset);
			
			$st1 = explode('<div class="post_table">', $pars_data['content']);
			
			echo $new_next_page_id[1][0].'|||||||||!!!!';
			echo $offset[1][0].'|||||||||!!!!';
			
			$tpl->load_template('social/vk_feed.tpl');
			foreach($st1 as $arr){
				
				preg_match_all("#<div class=\"wall_text\">(.*?)</a>#si", $arr, $data);
				
				$rdaomc = '';
				
				if($data[1][0]){
					
					if(stripos($arr, 'published_by') !== false){
						
						preg_match_all("#<a class=\"published_by\"(.*?)</a>#si", $arr, $data10);
						preg_match_all("#<div class=\"published_by_date\">(.*?)</a>#si", $arr, $data11);
						
						$repostpref = ' <font color="#000">-> '.strip_tags('<a '.$data10[1][0]).'</font> / <span style="font-weight:normal;color:#777"><small>'.strip_tags($data11[1][0]).'</small></span>';
						
					} else
						$repostpref = '';
						
					$arr = preg_replace("#<table cellpadding=\"0\" cellspacing=\"0\" class=\"published_by_wrap\">(.*?)</table>#si", "", $arr);
					
//* Комментарии *//
					
					preg_match_all("#<div class=\"replies_wrap clear\"(.*?)<div class=\"feed_row#si", $arr, $xdata1);
					
					$fdsakm = explode('<div class="reply_table">', $xdata1[1][0]);
					
					foreach($fdsakm as $onemcdata){
						
						preg_match_all("#<a class=\"author\"(.*?)</a>#si", $onemcdata, $xdata2);
						$raen2 = explode('>', $xdata2[1][0]);
						
						preg_match_all("#<div class=\"wall_reply_text\">(.*?)</div>#si", $onemcdata, $xdata3);
						preg_match_all("#<span class=\"rel_date(.*?)</span>#si", $onemcdata, $xdata4);
						$expdsate = explode('">', $xdata4[1][0]);
						$xdata4[1][0] = str_replace('">', '', $expdsate[1]);
						
						preg_match_all("#img src=\"(.*?)\"#si", $onemcdata, $xdata5);
						$xdata4[1][0] = str_replace('">', '', $xdata4[1][0]);
						
						$checkpost2 = explode('http://', $xdata5[1][0]);
						if(!$checkpost2[1]) $xdata5[1][0] = 'http://vk.com'.$xdata5[1][0];
						
						$xdata3[1][0] = strip_tags($xdata3[1][0]);
						
						if($xdata4[1][0]){
						
							$rdaomc .= <<<HTML
<div class="wall_fast_block" style="border-top:1px solid #DAE1E8;margin-top:5px">
  <div class="wall_fast_ava">
   <img src="{$xdata5[1][0]}" />
  </div>
  <div>
    <a>{$raen2[1]}</a>
  </div>
  <div class="wall_fast_comment_text">{$xdata3[1][0]}</div>
  <div class="wall_fast_date">
    {$xdata4[1][0]}
  </div>
  <div class="clear"></div>
</div>
HTML;
						}
						
					}

					$tpl->set('{comments}', $rdaomc);
					
					preg_match_all("#\"><img src=\"(.*?)\" width=\"50\"#si", $arr, $data1);
					preg_match_all("#<div class=\"wall_text\">(.*?)<div class=\"post_like_wrap#si", $arr, $data2);
					preg_match_all("#<span class=\"rel_date(.*?)</span>#si", $arr, $data3);
					preg_match_all("#<span class=\"post_like_count fl_l\"(.*?)</span>#si", $arr, $data4);

					preg_match_all("#<div id=\"wpt(.*?)_#si", $arr, $data10);

					$tpl->set('{vk_uid}', $data10[1][0]);
					$tpl->set('{rand}', rand(1, 104032421));
					
					$author = strip_tags($data[1][0]);
					$author = trim($author);
					$poster = trim($data1[1][0]);
					$checkpost = explode('http://', $poster);
					if(!$checkpost[1]) $poster = 'http://vk.com'.$poster;

					$epxdat = explode($author.'</a>', $data2[1][0]);
					$data2[1][0] = $epxdat[1];
					
					$text = $data2[1][0];
					$text = str_replace(array('<br>', '<br />'), '{br}', $text);
					$text = strip_tags($text);
					$text = str_replace('{br}', '<br />', $text);
					$text = trim($text);
					
					$text = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $text);
					
					preg_match_all("#<img src=\"(.*?)\"#si", $data2[1][0], $imgposer);
					if(!$imgposer[1][0]) preg_match_all("#background-image: url\((.*?)\)#si", $arr, $imgposer);
					
					$expdatess = explode('">', $data3[1][0]);
					$likes = strip_tags('<a'.$data4[1][0]);

					$tpl->set('{author}', $author.$repostpref);
					$tpl->set('{poster}', $poster);
					$tpl->set('{text}', $text);
					if($text) $br_text = '<br />';
					else $br_text = '';
					if($imgposer[1][0]) $tpl->set('{addmsgpos}', "{$br_text}<img src=\"{$imgposer[1][0]}\" />");
					else $tpl->set('{addmsgpos}', '');
					$tpl->set('{date}', $expdatess[1]);
					$tpl->set('{likes}', $likes);
					
					preg_match_all("#id=\"post_hash(.*?)/>#si", $arr, $forcommga);
					$expds3 = explode('" value="', $forcommga[1][0]);
					$expds3[1] = str_replace('"', '', $expds3[1]);
					
					$tpl->set('{vk_hash}', $expds3[1]);
					$tpl->set('{vk_id}', $expds3[0]);
					
					if($expds3[1]){
					
						$tpl->set('[comm]', '');
						$tpl->set('[/comm]', '');
					
					} else
						$tpl->set_block("'\\[comm\\](.*?)\\[/comm\\]'si","");
					
					if($expds3[0] > 0){
					
						$tpl->set('[msg]', '');
						$tpl->set('[/msg]', '');
					
					} else
						$tpl->set_block("'\\[msg\\](.*?)\\[/msg\\]'si","");

					$news_found = true;
					
					$tpl->compile('content');
				
				}

			}
			
			AjaxTpl();
			
			exit;
			
		break;
		
//* VK / Отправка записи на стену *//
		
		case "vk_send_post":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
//* Получаем POST данные *//
			
			$vk_text = $_POST['vk_text'];
			$hash = $_POST['hash'];
			$to_id = $_POST['to_id'];
			$from = $_POST['from'];
			
//* Открываем пред.новости *//
			
			$pars_data = post_content("http://vk.com/al_wall.php", "act=post&al=1&hash={$hash}&message={$vk_text}&type=feed&to_id={$to_id}&from={$from}");

			$st1 = explode('<div class="post_table">', $pars_data['content']);

			$tpl->load_template('social/vk_feed.tpl');
			
			$arr = $st1[1];
				
			preg_match_all("#<div class=\"wall_text\">(.*?)</a>#si", $arr, $data);
				
			if($data[1][0]){

				if(stripos($arr, 'published_by') !== false){
						
					preg_match_all("#<a class=\"published_by\"(.*?)</a>#si", $arr, $data10);
					preg_match_all("#<div class=\"published_by_date\">(.*?)</a>#si", $arr, $data11);
						
					$repostpref = ' <font color="#000">-> '.strip_tags('<a '.$data10[1][0]).'</font> / <span style="font-weight:normal;color:#777"><small>'.strip_tags($data11[1][0]).'</small></span>';
						
				} else
					$repostpref = '';
						
				$arr = preg_replace("#<table cellpadding=\"0\" cellspacing=\"0\" class=\"published_by_wrap\">(.*?)</table>#si", "", $arr);
					
				preg_match_all("#\"><img src=\"(.*?)\" width=\"50\"#si", $arr, $data1);
				preg_match_all("#<div class=\"wall_text\">(.*?)<div class=\"post_like_wrap#si", $arr, $data2);
				preg_match_all("#<span class=\"rel_date rel_date_needs_update\"(.*?)</span>#si", $arr, $data3);
				preg_match_all("#<span class=\"post_like_count fl_l\"(.*?)</span>#si", $arr, $data4);

				$author = strip_tags($data[1][0]);
				$author = trim($author);
				$poster = trim($data1[1][0]);
				$checkpost = explode('http://', $poster);
				if(!$checkpost[1]) $poster = 'http://vk.com'.$poster;

				$epxdat = explode($author.'</a>', $data2[1][0]);
				$data2[1][0] = $epxdat[1];
					
				$text = $data2[1][0];
				$text = str_replace(array('<br>', '<br />'), '{br}', $text);
				$text = strip_tags($text);
				$text = str_replace('{br}', '<br />', $text);
				$text = trim($text);
					
				$text = preg_replace('`(http(?:s)?://\w+[^\s\[\]\<]+)`i', '<a href="/away.php?url=$1" target="_blank">$1</a>', $text);
					
				preg_match_all("#<img src=\"(.*?)\"#si", $data2[1][0], $imgposer);
				if(!$imgposer[1][0]) preg_match_all("#background-image: url\((.*?)\)#si", $arr, $imgposer);
				
				$date = strip_tags('<a'.$data3[1][0]);
				$likes = strip_tags('<a'.$data4[1][0]);
					
				$tpl->set('{author}', $author.$repostpref);
				$tpl->set('{poster}', $poster);
				$tpl->set('{text}', $text);
				if($text) $br_text = '<br />';
				else $br_text = '';
				if($imgposer[1][0]) $tpl->set('{addmsgpos}', "{$br_text}<img src=\"{$imgposer[1][0]}\" />");
				else $tpl->set('{addmsgpos}', '');
				$tpl->set('{date}', $date);
				$tpl->set('{likes}', $likes);
					
				$news_found = true;
					
				$tpl->compile('content');
				
			}

			AjaxTpl();
			
			exit;
			
		break;
		
//* VK / Список друзей *//
		
		case "vk_friends":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
//* Открываем список друзей *//
			
			$pars_data = post_content("http://vk.com/friends?section=all");

			$stps = explode('<div class="user_block', $pars_data['content']);
			$cnt = 0;
			
			$rptext = iconv('utf-8', 'windows-1251', 'Мои Сообщения');
			preg_match_all("#Pads.show\('msg', event\)\" onclick=\"return \(checkEvent\(event\) \|\| browser.msie6\) \? true : cancelEvent\(event\)\"><span class=\"left_count_wrap  fl_r\"><span class=\"inl_bl left_count\">+(.*?)</span></span></span><span class=\"left_label inl_bl\">{$rptext}</span>#si", $pars_data['content'], $vk_new_msg_num);
			$vk_new_msg_num[1][0] = str_replace('+', '', $vk_new_msg_num[1][0]);
			$tpl->result['content'] .= "<script>$('#vk_new_msg_num').text('{$vk_new_msg_num[1][0]}')</script>";
			
			$tpl->load_template('social/vk_friend_head.tpl');
			preg_match_all("#<div class=\"summary\" id=\"friends_summary\">(.*?)</div>#si", $pars_data['content'], $friends_summary);
			$tpl->set('{friend-text}', $friends_summary[1][0]);
			$tpl->compile('info');
			
			$tpl->load_template('social/vk_friend.tpl');
			foreach($stps as $frdata){
			
				preg_match_all("#<img class=\"friends_photo_img\" src=\"(.*?)\"#si", $frdata, $data);
				preg_match_all("# <div class=\"friends_field\">(.*?)</div>#si", $frdata, $data1);
				preg_match_all("#onclick=\"return showWriteMessageBox\(event, (.*?)\)\">#si", $frdata, $data2);
				preg_match_all("# <div class=\"online\">(.*?)</div>#si", $frdata, $data3);
				
				$photo = $data[1][0];
				$frname = strip_tags($data1[1][0]);
				$info = strip_tags($data1[1][1]);
				$vk_uid = strip_tags($data2[1][0]);
				
				if($photo AND $vk_uid){
					
					$cnt++;
					
					if($cnt <= 15){
					
						$checkpost = explode('http://', $photo);
						if(!$checkpost[1]) $photo = 'http://vk.com'.$photo;
						
						$tpl->set('{ava}', $photo);
						$tpl->set('{name}', $frname);
						$tpl->set('{mininfo}', $info);
						$tpl->set('{online}', $data3[1][0]);
						$tpl->set('{vk_uid}', $vk_uid);
						
						$tpl->compile('content');
						
					}
					
				}
				
			}
			
			if($cnt >= 15){
				$tpl->load_template('social/vk_friend_boot.tpl');
				preg_match_all("#id: (.*?),#si", $pars_data['content'], $to_id);
				$tpl->set('{vk_uid}', $to_id[1][0]);
				$tpl->compile('content');
			}
			
			if(!$cnt){
				
				$tpl->result['content'] = iconv('utf-8', 'windows-1251', '<div class="info_center" style="margin-top:60px;margin-bottom:50px">Здесь Вы будете видеть список своих друзей.</div>');
				
			}
			
			AjaxTpl();
			
			exit;
			
		break;
		
//* VK / Список друзей / Показ всех *//
		
		case "vk_friends_prev":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$vk_uid = $_POST['vk_uid'];
			
//* Получаем список друзей *//
			
			$pars_data = post_content("http://vk.com/al_friends.php", "act=load_friends_silent&al=1&gid=0&id={$vk_uid}");
			$pars_data['content'] = nl2br($pars_data['content']);
			
			$paramexps = explode('<br />', $pars_data['content']);
			$cnt = 0;
			
			$tpl->load_template('social/vk_friend.tpl');
			foreach($paramexps as $frdata){
			
				$cnt++;
				
				if($cnt > 15){
				
					$data = explode("','", $frdata);
					
					$checkpost = explode('http://', $data[1]);
					if(!$checkpost[1]) $data[1] = 'http://vk.com'.$data[1];
						
					$tpl->set('{ava}', $data[1]);
					$tpl->set('{name}', $data[5]);
					$tpl->set('{mininfo}', '');
					if($data[4]) $tpl->set('{online}', 'Online');
					else $tpl->set('{online}', '');
					$tpl->set('{vk_uid}', $data[0]);
					
					$tpl->compile('content');
				
				}
				
			}
			
			AjaxTpl();

			exit;
			
		break;
		
//* VK / Сообщения *//
		
		case "vk_msg":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$pars_data = post_content("http://vk.com/mail");
			
			$exppa = explode('<tr class="', $pars_data['content']);
			
			$rptext = iconv('utf-8', 'windows-1251', 'Мои Сообщения');
			preg_match_all("#Pads.show\('msg', event\)\" onclick=\"return \(checkEvent\(event\) \|\| browser.msie6\) \? true : cancelEvent\(event\)\"><span class=\"left_count_wrap  fl_r\"><span class=\"inl_bl left_count\">+(.*?)</span></span></span><span class=\"left_label inl_bl\">{$rptext}</span>#si", $pars_data['content'], $vk_new_msg_num);
			$vk_new_msg_num[1][0] = str_replace('+', '', $vk_new_msg_num[1][0]);
			$tpl->result['content'] .= "<script>$('#vk_new_msg_num').text('{$vk_new_msg_num[1][0]}')</script>";
			
			$tpl->load_template('social/vk_msg_head.tpl');
			preg_match_all("#<span id=\"mail_summary\">(.*?)</span>#si", $pars_data['content'], $friends_summary);
			$tpl->set('{msg-text}', $friends_summary[1][0]);
			$tpl->compile('info');
			
			$tpl->load_template('social/vk_msg.tpl');
			foreach($exppa as $msdata){

				preg_match_all("#<img width=\"50\" height=\"50\" src=\"(.*?)\"#si", $msdata, $data);
				preg_match_all("#<div class=\"name wrapped\">(.*?)</a>#si", $msdata, $data1);
				preg_match_all("#<div class=\"date\">(.*?)</div>#si", $msdata, $data2);
				preg_match_all("#href=\"/mail\?act=show&id=(.*?)\"#si", $msdata, $data3);
				preg_match_all("#<div class=\"mail_body\">(.*?)</div>#si", $msdata, $data4);
				preg_match_all("#<div class=\"online\">(.*?)</div>#si", $msdata, $data5);
				preg_match_all("#<div class=\"mail_topic\">(.*?)</div>#si", $msdata, $data6);
				
				$ava = $data[1][0];
				
				if($ava){
					
					$msdata = str_replace(',"new_msg":', '', $msdata);
					
					$epxsnew = explode('new_msg"', $msdata);
					
					$checkpost = explode('http://', $ava);
					if(!$checkpost[1]) $ava = 'http://vk.com'.$ava;
					
					$name = strip_tags($data1[1][0]);
					$date = strip_tags($data2[1][0]);
					$msgid = $data3[1][0];
					$msgtext = $data4[1][0];
					$msgtext = str_replace(array('<br>', '<br />'), '{br}', $msgtext);
					$msgtext = strip_tags($msgtext);
					$msgtext = str_replace('{br}', '<br />', $msgtext);
					$online = $data5[1][0];
					$subj = strip_tags($data6[1][0]);
					
					$tpl->set('{ava}', $ava);
					$tpl->set('{name}', $name);
					$tpl->set('{date}', $date);
					$tpl->set('{msgid}', $msgid);
					$tpl->set('{msgtext}', $msgtext);
					$tpl->set('{online}', $online);
					$tpl->set('{subj}', $subj);
					
					if($epxsnew[1]) $tpl->set('{msg_new}', 'msg_new');
					else $tpl->set('{msg_new}', '');
	
					$tpl->compile('content');
				
				}
				
			}
			
			$intvnum = explode(' ', $friends_summary[1][0]);
			
			if($intvnum[2] > 20){
			
				$tpl->load_template('social/vk_msg_boot.tpl');
				$tpl->compile('content');
				
			}
			
			if(!$intvnum[2])
				$tpl->result['content'] = iconv('utf-8', 'windows-1251', '<div class="info_center" style="margin-top:60px;margin-bottom:52px">У Вас нет ни одного сообщения..</div>');
			
			AjaxTpl();
			
			exit;
			
		break;
		
//* VK / Сообщения / Страницы *//
		
		case "vk_msg_prev":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$offset = $_POST['vk_offset_msg'];
			$pars_data = post_content("http://vk.com/al_mail.php", "al=1&filter=all&offset={$offset}");
			
			$exppa = explode('<tr class="', $pars_data['content']);

			$tpl->load_template('social/vk_msg.tpl');
			foreach($exppa as $msdata){
				
				$epxsnew = explode('new_msg', $msdata);
				
				preg_match_all("#<img width=\"50\" height=\"50\" src=\"(.*?)\"#si", $msdata, $data);
				preg_match_all("#<div class=\"name wrapped\">(.*?)</a>#si", $msdata, $data1);
				preg_match_all("#<div class=\"date\">(.*?)</div>#si", $msdata, $data2);
				preg_match_all("#href=\"/mail\?act=show&id=(.*?)\"#si", $msdata, $data3);
				preg_match_all("#<div class=\"mail_body\">(.*?)</div>#si", $msdata, $data4);
				preg_match_all("#<div class=\"online\">(.*?)</div>#si", $msdata, $data5);
				preg_match_all("#<div class=\"mail_topic\">(.*?)</div>#si", $msdata, $data6);
				
				$ava = $data[1][0];
				
				if($ava){
				
					$checkpost = explode('http://', $ava);
					if(!$checkpost[1]) $ava = 'http://vk.com'.$ava;
					
					$name = strip_tags($data1[1][0]);
					$date = strip_tags($data2[1][0]);
					$msgid = $data3[1][0];
					$msgtext = $data4[1][0];
					$msgtext = str_replace(array('<br>', '<br />'), '{br}', $msgtext);
					$msgtext = strip_tags($msgtext);
					$msgtext = str_replace('{br}', '<br />', $msgtext);
					$online = $data5[1][0];
					$subj = strip_tags($data6[1][0]);
					
					$tpl->set('{ava}', $ava);
					$tpl->set('{name}', $name);
					$tpl->set('{date}', $date);
					$tpl->set('{msgid}', $msgid);
					$tpl->set('{msgtext}', $msgtext);
					$tpl->set('{online}', $online);
					$tpl->set('{subj}', $subj);
					
					if($epxsnew[1]) $tpl->set('{msg_new}', 'msg_new');
					else $tpl->set('{msg_new}', '');
					
					$tpl->compile('content');
				
				}
				
			}
			
			AjaxTpl();
			
			exit;
			
		break;
		
//* VK / Сообщения / Просмотр *//
		
		case "vk_msg_read":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$msgid = $_POST['msgid'];
			$pars_data = post_content("http://vk.com/mail?act=show&id={$msgid}");
			
			preg_match_all("#<img width=\"100\" src=\"(.*?)\"#si", $pars_data['content'], $data);
			preg_match_all("#<a class=\"mem_link\"(.*?)</a>#si", $pars_data['content'], $data1);
			preg_match_all("#<div class=\"mail_envelope_time\">(.*?)</div>#si", $pars_data['content'], $data2);
			preg_match_all("#<div class=\"mail_envelope_body(.*?)</div>#si", $pars_data['content'], $data3);
			preg_match_all("#<div class=\"mail_envelope_online\">(.*?)</div>#si", $pars_data['content'], $online);
			preg_match_all("#onclick=\"mail.showHistory\((.*?)\);#si", $pars_data['content'], $toid);

			$data1[1][0] = strip_tags('<a '.$data1[1][0]);
			
			$ava = $data[1][0];

			$checkpost = explode('http://', $ava);
			if(!$checkpost[1]) $ava = 'http://vk.com'.$ava;
					
			$name = strip_tags($data1[1][0]);
			$date = strip_tags($data2[1][0]);
			$msgtext = '<div class="'.$data3[1][0];
			$msgtext = str_replace(array('<br>', '<br />'), '{br}', $msgtext);
			$msgtext = strip_tags($msgtext);
			$msgtext = str_replace('{br}', '<br />', $msgtext);
			
			$tpl->set('{ava}', $ava);
			$tpl->set('{name}', $name);
			$tpl->set('{date}', $date);
			$tpl->set('{msgid}', $msgid);
			$tpl->set('{msgtext}', $msgtext);
			$tpl->set('{online}', $online[1][0]);
			$tpl->set('{toid}', $toid[1][0]);
			$tpl->set('{subj}', $subj);
					
			$tpl->load_template('social/vk_msg_view.tpl');
			$tpl->compile('content');
			
			AjaxTpl();
			
			exit;
			
		break;
		
//* VK / Сообщения / Отправка *// 
		
		case "vk_msg_send":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$vk_msg_value = $_POST['vk_msg_value']; 
			$msgid = $_POST['msgid']; 
			$toid = $_POST['toid']; 

//* Открываем моб версию, что узнать chas *//
			
			$pars_data_mb = post_content("http://m.vk.com/mail?act=show&peer={$toid}");
			
//* Получаем chas *//
			
			preg_match_all("#from=dialog&hash=(.*?)\"#si", $pars_data_mb['content'], $hash);

//* Отправляем сообщение *//
			
			post_content("http://vk.com/al_mail.php", "act=a_send&al=1&chas={$hash[1][0]}&from=msg&title=...&to_id={$toid}&to_reply={$msgid}&message={$vk_msg_value}");

			exit;
			
		break;
		
//* VK / Сообщения / Открытие окна для написания сообщения *//
		
		case "vk_msg_box":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$toid = $_POST['toid'];

			$pars_data = post_content("http://vk.com/al_mail.php", "act=write_box&al=1&to={$toid}");
			
			preg_match_all("#hash: '(.*?)'#si", $pars_data['content'], $hash);
			
			echo $hash[1][0];
			
			exit;
			
		break;
		
//* VK / Сообщения / Быстрая отправка *//
		
		case "vk_msg_fast_send":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$vk_msg_hash = $_POST['vk_msg_hash']; 
			$vk_msg_fast_text = $_POST['vk_msg_fast_text']; 
			$toid = $_POST['toid']; 

//* Отправляем сообщение *//
			
			post_content("http://vk.com/al_mail.php", "act=a_send&al=1&chas={$vk_msg_hash}&from=box&to_ids={$toid}&message={$vk_msg_fast_text}");

			exit;
			
		break;
		
//* VK / Проверка безопасности *//
		
		case "vk_check_mob":
			
//* Устанавливаем кодировку *//
			
			header('Content-type: text/html; charset=windows-1251');
			
			NoAjaxQuery();
			
			$code = $_POST['code'];
			$to = $_POST['to'];
			$al_page = $_POST['al_page'];
			$hash = $_POST['hash'];
			
			$pars_content = post_content("http://vk.com/login.php", "al=1&act=security_check&to=&hash={$hash}&code={$code}");

			$epas = explode('<!int>', $pars_content['content']);
			$ezpd = explode('<!>', $epas[1]);
			
			echo $ezpd[1];

			exit;
			
		break;
		
//* VK / Отправка комментария *//
		
		case "vk_send_comm":
		
			header('Content-type: text/html; charset=windows-1251');
			
			$hash = str_replace(' ', '', $_POST['hash']);
			$message = $_POST['message'];
			$reply_to = $_POST['reply_to'];

			post_content("http://vk.com/al_wall.php", "act=post&al=1&hash={$hash}&message={$message}&reply_to={$reply_to}&reply_to_user=0&type=feed");

			exit();
			
		break;
		
//* VK / Выход *// 
		
		case "vk_logout":
			
			NoAjaxQuery();
			
			@unlink(ROOT_DIR."/system/cache/social/coo{$user_info['user_id']}.txt");
			
			$db->query("DELETE FROM `".PREFIX."_social` WHERE suser_id = '{$user_id}'");
			
			exit;
			
		break;
		
			default:

//* VK / Страница входа *// 
			

			
			if($a){
			
				$row = $db->super_query("SELECT vk_login, vk_pass FROM `".PREFIX."_social` WHERE suser_id = '{$user_id}'");
				
				$tpl->load_template('social/main.tpl');
				$tpl->set('{vk_login}', $row['vk_login']);
				$tpl->set('{vk_pass}', stripslashes($row['vk_pass']));
				if($row['vk_login']) $tpl->set('{authologin}', 'vk.login()');
				else $tpl->set('{authologin}', '');
				$tpl->compile('content');
			
			}
			
			msgbox('', 'Сервис недоступен.', 'info_2');
			
	}
	
	$tpl->clear();
	$db->free();
	
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>