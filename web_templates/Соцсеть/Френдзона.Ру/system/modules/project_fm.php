<?php

if(!defined('MOZG'))

	die('Hacking attempt!');

if($ajax == 'yes')

	NoAjaxQuery();

if($logged){

	$act = $_GET['act'];

	$id = intval($_GET['id']);

    $user_id = $user_info['user_id'];

	$group = $user_info['user_group'];

	$metatags['title'] = 'Общий чат';

	$user_fm_wrap_bar = 'VALLERY';

	$date = time();

	//Категории панели.
	$array = array(

		0 => 'Новости радио',

		1 => 'Чат',

		2 => 'Афиша радио',

	);

$go_back = '<a href="/vallery" onclick="Page.Go(this.href); return false;">Вернуться назад</a>';


/*-----------------------------------------------------
| Afisha Index project fm
|------------------------------------------------------
|
| vallery/right_content.html
|
*/

$db_afisha = $db->super_query("SELECT id, title, description, place, date, sponsor, photos FROM `".PREFIX."_pfm_afisha` ORDER by rand() ASC LIMIT 0, 2", 1);

foreach($db_afisha as $views_afisha){

	$tpl->load_template('vallery/right_content.tpl');

	$tpl->set('{title}', $views_afisha['title']);

	$tpl->set('{description}', $views_afisha['description']);

	$tpl->set('{place}', $views_afisha['place']);

	$tpl->set('{date}', $views_afisha['date']);
	
	$tpl->set('{sponsor}', $views_afisha['sponsor']);
	
	$tpl->set('{photos}', $views_afisha['photos']);

	$tpl->set('{id}', $views_afisha['id']);

	$tpl->compile('right_content'); //Компилируем контент..

} //end ads views


/*-----------------------------------------------------
| News Index project fm
|------------------------------------------------------
|
| vallery/right_content.tpl
|
*/

$db_news = $db->super_query("SELECT tb1.id, tb1.user_id, tb1.title, tb1.news, tb1.date, tb1.photos, tb2.user_search_pref, tb2.alias FROM `".PREFIX."_pfm_news` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id ORDER by rand() ASC LIMIT 0, 50", 1);

foreach($db_news as $views_news){

	$tpl->load_template('vallery/left_content.tpl');

		if($views_news['alias']){

			$tpl->set('{user-id}', $views_news['alias']); 

		} else {

			$tpl->set('{user-id}', 'id'.$views_news['user_id']);

		}

	$tpl->set('{title}', $views_news['title']);

	$tpl->set('{news}', iconv_substr($views_news['news'], 0, 900, 'utf-8'));

	$tpl->set('{all_text}', '<a href="/vallery/news_wiev_all/id/'.$views_news['id'].'" onclick="Page.Go(this.href); return false;">Читать дальше</a>');

	$tpl->set('{date}', megaDateNoTpl($views_news['date']));

	$tpl->set('{photos}', $views_news['photos']);

	$tpl->set('{user_search_pref}', $views_news['user_search_pref']);

	$tpl->set('{id}', $views_news['id']);

	$tpl->compile('left_content'); //Компилируем контент..

} //end

/*-----------------------------------------------------
| Compile index
|------------------------------------------------------
|
| vallery/sample_index.tpl
|
*/


if ($act == 'news_all'){

	$user_fm_wrap_bar = 'Новости радио <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'chat_index'){

	$user_fm_wrap_bar = 'Чат радио <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'afisha_all'){

	$user_fm_wrap_bar = 'Афиша радио <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'afisha_adds'){

	$user_fm_wrap_bar = 'Создать афишу <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'afisha_edit_admin'){

	$user_fm_wrap_bar = 'Редактор афишы <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'chat_fm_view'){

	$tpl->set_block("'\\[summary_wrap\\](.*?)\\[/summary_wrap\\]'si",""); //fixed chat volume js

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

}elseif ($act == 'chat_fm_user'){

	$tpl->set_block("'\\[summary_wrap\\](.*?)\\[/summary_wrap\\]'si",""); //fixed chat volume js

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'news_adds'){

	$user_fm_wrap_bar = 'Создать новости <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'news_wiev_all'){

	$user_fm_wrap_bar = 'Режым полного просмотра <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

} elseif ($act == 'news_edit_admin'){

	$user_fm_wrap_bar = 'Редактор новость <span class="fl_r">'.$go_back.'</span>';

	$tpl->set_block("'\\[set_block\\](.*?)\\[/set_block\\]'si","");

}

	$tpl->set('{type_0}', $array[0]);

	$tpl->set('{type_1}', $array[1]);

	$tpl->set('{type_2}', $array[2]);

	$tpl->set('[summary_wrap]', '');

	$tpl->set('[/summary_wrap]', '');

	$tpl->set('[set_block]', '');

	$tpl->set('[/set_block]', '');

	$tpl->set('{left_content}', $tpl->result['left_content']);

	$tpl->set('{right_content}', $tpl->result['right_content']);

	$tpl->load_template('vallery/index_fm.tpl');

	$tpl->compile('content');

switch($act){

/*-----------------------------------------------------
| News case and module project fm
|------------------------------------------------------
|
| views content
|------------------------------------------------------
*/

case "news_all":

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;

	$gcount = 10;

	$limit_page = ($page-1) * $gcount;

	$rownews_all = $db->super_query("SELECT tb1.id, tb1.user_id, tb1.title, tb1.news, tb1.date, tb1.photos, tb2.user_search_pref FROM `".PREFIX."_pfm_news` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id ORDER by rand() ASC LIMIT {$limit_page}, {$gcount}", 1);

	foreach($rownews_all as $row_news_all){

		$tpl->load_template('vallery/news_all.tpl');

		$tpl->set('{title}', $row_news_all['title']);

		$tpl->set('{news}', $row_news_all['news']);

		$tpl->set('{date}', megaDateNoTpl($row_news_all['date']));

		$tpl->set('{photos}', $row_news_all['photos']);

		$tpl->set('{user_search_pref}', $row_news_all['user_search_pref']);

		$tpl->set('{id}', $row_news_all['id']);

		$tpl->compile('content');

	}

		$db_cnt = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_pfm_news`");

		navigation($gcount, $db_cnt['id'], $config['home_url'].'vallery/news_all/page/');

break;


case "news_wiev_all":

	$db_news_all_text = $db->super_query("SELECT tb1.id, tb1.user_id, tb1.title, tb1.news, tb1.date, tb1.photos FROM `".PREFIX."_pfm_news` tb1, `".PREFIX."_users` tb2 WHERE tb1.id = {$id}", 1);

	foreach($db_news_all_text as $row){

		$tpl->set('{title}', $row['title']);

		$tpl->set('{news}', $row['news']);

		$tpl->set('{date}', megaDateNoTpl($row['date']));

		$tpl->set('{photos}', $row['photos']);

		$tpl->set('{id}', $row['id']);

	}

	$tpl->load_template('vallery/news_wiev_all.tpl');

	$tpl->compile('content');

break;


case "news_save":

	if($group == 1){

			NoAjaxQuery();

			$title = ajax_utf8(textFilter($_POST['title']));

			$news = ajax_utf8(textFilter($_POST['news']));

			$photos = ajax_utf8(textFilter($_POST['photos']));

                if($title AND $news AND $photos AND $date){

					$db->query("INSERT INTO `".PREFIX."_pfm_news` SET title = '{$title}', news = '{$news}', date = '{$date}', photos = '{$photos}' , user_id = '{$user_id}'");

					echo '1';

                } else {

                    echo '2';  

                }

	} else

		msgbox('', 'Not group administrator', 'info_2');

	die();

break;

case "news_adds":

	if($group == 1){

		$tpl->load_template('vallery/news_adds.tpl');

		$tpl->compile('content');

	} else

		msgbox('', 'Not group administrator', 'info_2');

break;

case "news_delete":

	if($group == 1){

		$del = $db->super_query("SELECT id FROM `".PREFIX."_pfm_news` WHERE id = '{$id}'");

		if($del['id']){

			$db->query("DELETE FROM `".PREFIX."_pfm_news` WHERE id = '{$del['id']}'");

		}

	} else

		msgbox('', 'Not group administrator', 'info_2');

break;

case "news_edit_admin":

	if($group == 1){

	$row = $db->super_query("SELECT id, title, news, photos FROM `".PREFIX."_pfm_news` WHERE id = '{$id}'");

		$tpl->set('{title_}', $row['title']);

		$tpl->set('{news_}', $row['news']);

		$tpl->set('{photos_}', $row['photos']);

		$tpl->set('{id_}', $row['id']);

		$tpl->load_template('vallery/news_edit.tpl');

		$tpl->compile('content');

	} else

		msgbox('', 'Not group administrator', 'info_2');
		
break;

case "news_edit_save":

	if($group == 1){

			NoAjaxQuery();

			$title = ajax_utf8(textFilter($_POST['title']));

			$news = ajax_utf8(textFilter($_POST['news']));

			$photos = ajax_utf8(textFilter($_POST['photos']));

			if($title AND $news AND $photos OR $id){

				$db->query("UPDATE `".PREFIX."_pfm_news` SET title = '{$title}', news = '{$news}', date = '{$date}', photos = '{$photos}' WHERE id = '{$id}'");

				echo '1';

			}

	} else

		msgbox('', 'Not group administrator', 'info_2');

	die();

break;

/*-----------------------------------------------------
| Chat case and module project fm
|------------------------------------------------------
|
| views content
|------------------------------------------------------
*/

case "chat_index":

	$new_intro = $db->super_query("SELECT id FROM `".PREFIX."_pfm_act` WHERE user_id = '{$user_id}'");

	if($new_intro){

		$db->query("UPDATE `".PREFIX."_pfm_act` SET last_activity = NOW() WHERE user_id = '{$user_id}'");

	} else {

		$db->query("INSERT INTO `".PREFIX."_pfm_act` (user_id) VALUES ('{$user_id}') ON DUPLICATE KEY UPDATE last_activity = NOW()");

	}

	$tpl->load_template('vallery/chat_index.tpl');

	$tpl->compile('content');

break;

//Ajax JQuery Подгрузка

case "chat_fm_view":

	NoAjaxQuery();

	$db->query("DELETE FROM `".PREFIX."_pfm_act` WHERE last_activity < SUBTIME(NOW(),'0:5:00')");

	$update_chat = $db->super_query("SELECT tb1.id, tb1.chat_message, tb1.user_id, tb1.date, tb2.user_photo, tb2.user_search_pref, tb2.alias FROM `".PREFIX."_pfm_chat` tb1,`".PREFIX."_users` tb2 WHERE tb1.user_id=tb2.user_id", 1);

	//Достигаем критерии 200 сообщений и автоматом удаляем все..

	$default = 200;

	$chat_mess_num = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_pfm_chat`");

	if($chat_mess_num['id'] > $default){

		$db->query("DELETE FROM `".PREFIX."_pfm_chat`");

	}

	if($update_chat){

		foreach($update_chat as $row_upd){

			if($row_upd['user_photo'])

				$ava = $config['home_url'].'uploads/users/'.$row_upd['user_id'].'/50_'.$row_upd['user_photo'];

			else

				$ava = '/images/no_ava_50.png';

			if($row_upd['alias']){

				$tpl->set('{user-id}', $row_upd['alias']); 

			} else {

				$tpl->set('{user-id}', 'id'.$row_upd['user_id']);

			}

			$tpl->load_template('vallery/chat_message.tpl');

			if(preg_match("#(<a href=|\[url=|\[link=)?(ftp://|https?://|www)?([\s]?)([^-a-z0-9_@]+)([-a-z0-9/.\s]+\.[a-z]{2,6}[-a-z0-9_/.]*[html|php|cgi]*[\]>]?)+#is" , $row_upd['chat_message'])){ 

				$tpl->set('{chat_message}',  "<p class='error'>Присутствует запрещённый текст.</p>"); 

			} else {

				$tpl->set('{chat_message}',  $row_upd['chat_message']);

			}

			$tpl->set('{user_search_pref}', $row_upd['user_search_pref']);

			$tpl->set('{date}', megaDateNoTpl($row_upd['date']));

			$tpl->set('{ava}', $ava);

			$tpl->set('{id}', $row_upd['id']);

			$tpl->compile('content');

		}

	} else 

		msgbox('', 'Новых сообщений в чате необнаружено', 'info_2');

	AjaxTpl();

	die();

break;

case "chat_fm_user":

	NoAjaxQuery();

	$chat_user = $db->super_query("SELECT tb1.id, tb1.user_id, tb2.user_photo, tb2.user_search_pref, tb2.alias FROM `".PREFIX."_pfm_act` tb1,`".PREFIX."_users` tb2 WHERE tb1.user_id = tb2.user_id", 1);

		foreach($chat_user as $row_active){

			if($row_active['user_photo'])

				$ava = $config['home_url'].'uploads/users/'.$row_active['user_id'].'/50_'.$row_active['user_photo'];

			else

				$ava = '/images/no_ava_50.png';

			if($row_active['alias']){

				$tpl->set('{user-id}', $row_active['alias']); 

			} else {

				$tpl->set('{user-id}', 'id'.$row_active['user_id']);

			}

			$tpl->load_template('vallery/chat_user_act.tpl');

			$tpl->set('{user_search_pref}', $row_active['user_search_pref']);

			$tpl->set('{ava}', $ava);

			$tpl->set('{id}', $row_active['id']);

			$tpl->compile('content');

		}

		AjaxTpl();

	die();

break;

case "chat_fm_message":

	NoAjaxQuery();

	$new_intro = $db->super_query("SELECT id FROM `".PREFIX."_pfm_act` WHERE user_id = '{$user_id}'");

	if($new_intro){

		$db->query("UPDATE `".PREFIX."_pfm_act` SET last_activity = NOW() WHERE user_id = '{$user_id}'");

	} else {

		$db->query("INSERT INTO `".PREFIX."_pfm_act` (user_id) VALUES ('{$user_id}') ON DUPLICATE KEY UPDATE last_activity = NOW()");

	}

	$messame_chat = ajax_utf8(textFilter($_POST['chat_message']));

	if($messame_chat){

	$db->query("INSERT INTO `".PREFIX."_pfm_chat` SET chat_message = '{$messame_chat}', user_id = '{$user_id}', date = '{$date}'");

		echo '1';

	} else {

		echo '2';

	}

	die();

break;

/*-----------------------------------------------------
| Afisha case and module project fm
|------------------------------------------------------
|
| views content
|------------------------------------------------------
*/

case "afisha_save":

	if($group == 1){
	
			NoAjaxQuery();

			$title = ajax_utf8(textFilter($_POST['title']));

			$description = ajax_utf8(textFilter($_POST['description']));

			$place = ajax_utf8(textFilter($_POST['place']));

			$photos = ajax_utf8(textFilter($_POST['photos']));

			$date = ajax_utf8(textFilter($_POST['date']));

			$sponsor = ajax_utf8(textFilter($_POST['sponsor']));

                if($title AND $description AND $place AND $photos AND $date AND $sponsor){

					$db->query("INSERT INTO `".PREFIX."_pfm_afisha` SET title = '{$title}', description = '{$description}', place = '{$place}', date = '{$date}', sponsor = '{$sponsor}', photos = '{$photos}'");

					echo '1';

                } else {

                    echo '2';  

                }

	} else

		msgbox('', 'Not group administrator', 'info_2');

	die();

break;


case "afisha_adds":

	if($group == 1){

		$tpl->load_template('vallery/afisha_adds.tpl');

		$tpl->compile('content');

	} else

		msgbox('', 'Not group administrator', 'info_2');

break;


case "afisha_delete":

	if($group == 1){

		$del = $db->super_query("SELECT id FROM `".PREFIX."_pfm_afisha` WHERE id = '{$id}'");

		if($del['id']){

			$db->query("DELETE FROM `".PREFIX."_pfm_afisha` WHERE id = '{$del['id']}'");

		}

	} else

		msgbox('', 'Not group administrator', 'info_2');

break;


case "afisha_edit_admin":

	if($group == 1){

	$row = $db->super_query("SELECT id, title, description, place, date, sponsor, photos FROM `".PREFIX."_pfm_afisha` WHERE id = '{$id}'");

		$tpl->set('{title_}', $row['title']);

		$tpl->set('{description_}', $row['description']);

		$tpl->set('{place_}', $row['place']);

		$tpl->set('{date_}', $row['date']);
	
		$tpl->set('{sponsor_}', $row['sponsor']);
	
		$tpl->set('{photos_}', $row['photos']);

		$tpl->set('{id_}', $row['id']);

		$tpl->load_template('vallery/afisha_edit.tpl');

		$tpl->compile('content');

	} else

		msgbox('', 'Not group administrator', 'info_2');
		
break;


//Редактор afisha
case "afisha_edit_save":

	if($group == 1){

			NoAjaxQuery();

			$title = ajax_utf8(textFilter($_POST['title']));

			$description = ajax_utf8(textFilter($_POST['description']));

			$place = ajax_utf8(textFilter($_POST['place']));

			$photos = ajax_utf8(textFilter($_POST['photos']));

			$date = ajax_utf8(textFilter($_POST['date']));

			$sponsor = ajax_utf8(textFilter($_POST['sponsor']));

			if($id){

				$db->query("UPDATE `".PREFIX."_pfm_afisha` SET title = '{$title}', description = '{$description}', place = '{$place}', date = '{$date}', sponsor = '{$sponsor}', photos = '{$photos}' WHERE id = '{$id}'");

				echo '1';

			}

	} else

		msgbox('', 'Not group administrator', 'info_2');

	die();

break;


case "afisha_all":

	if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;

	$gcount = 10;

	$limit_page = ($page-1) * $gcount;

	$row = $db->super_query("SELECT id, title, description, place, date, sponsor, photos FROM `".PREFIX."_pfm_afisha` LIMIT {$limit_page}, {$gcount}", 1);

	foreach($row as $row_afisha_all){

		$tpl->load_template('vallery/afisha_all.tpl');

		$tpl->set('{title_all}', $row_afisha_all['title']);

		$tpl->set('{description_all}', $row_afisha_all['description']);

		$tpl->set('{place_all}', $row_afisha_all['place']);

		$tpl->set('{date_all}', $row_afisha_all['date']);

		$tpl->set('{sponsor_all}', $row_afisha_all['sponsor']);

		$tpl->set('{photos_all}', $row_afisha_all['photos']);

		$tpl->set('{id_all}', $row_afisha_all['id']);

		$tpl->compile('content');

	}

		$db_cnt = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_pfm_afisha`");

		navigation($gcount, $db_cnt['id'], $config['home_url'].'vallery/afisha_fm/page/');

break;

default:

}

$tpl->clear();

$db->free();

}

?>