<?php
/*========================================= 
	Appointment: Верификация сообщества
	File: confirmation.php 
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

	$id = intval($_GET['id']);

    $user_id = $user_info['user_id'];

	$group = $user_info['user_group'];

if($group == 1){

	$metatags['title'] = 'Редактор групп';

switch($act){

		case "confirm_wiev":

				$tpl->load_template('confirmation/head.tpl');

				$tpl->set('{activetab-1}', 'activetab');

				$tpl->compile('info');

				if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;

				$gcount = 10;

				$limit_page = ($page-1) * $gcount;

				$confirm = $db->super_query("SELECT user_id, user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_stars_second = '1' LIMIT {$limit_page}, {$gcount}", 1);

				if($confirm){
				
					foreach($confirm as $row){

						$tpl->load_template('confirmation/confirmation.tpl');
						
						if($row['user_photo'])

							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);

						else

							$tpl->set('{ava}', $config['home_url'].'templates/'.$config['temp'].'/images/100_no_ava.png');

						$tpl->set('{user_id}', $row['user_id']);

						$tpl->set('{user_search_pref}', $row['user_search_pref']);

						$tpl->compile('content');

					}

						$db_cnt = $db->super_query("SELECT COUNT(*) AS user_id FROM `".PREFIX."_users` WHERE user_stars_second = '1'");

						navigation($gcount, $db_cnt['user_id'], $config['home_url'].'confirmation/confirm_wiev/page/');

				} else

					msgbox('', 'Заявки на группу звезда нету.', 'confirmation/info');

					$tpl->result['content'] .= '</div><div class="clear_fix"></div><br /></div>';

		break;

		case "confirm_yes":

			NoAjaxQuery();

			$stars_id = $_POST['stars_id'];

			$userid = intval($_POST['user_id']);

			if($stars_id AND $userid){

				$db->query("UPDATE `".PREFIX."_users` SET user_stars = '{$stars_id}' WHERE user_id = '{$userid}'");

				$db->query("UPDATE `".PREFIX."_users` SET user_stars_second = '0' WHERE user_id = '{$userid}'");
				
//* Чистим кеш *//
				
				mozg_clear_cache_file('user_'.$userid.'/profile_'.$userid);

				mozg_clear_cache();

				echo '1';

			} else {

				echo '2';

			}

			die();

		break;

		case "confirm_send":

			NoAjaxQuery();

			$user_confirm_send = intval($_POST['user_id']);

			if($user_confirm_send){

				$db->query("UPDATE `".PREFIX."_users` SET user_stars_second = '1' WHERE user_id = '{$user_confirm_send}'");

				echo '1';

			} else {

				echo '2';

			}

			die();

		break;

//* Status verification user real *//
		
		case "verification_wiev":

				$tpl->load_template('confirmation/head.tpl');
				
				$tpl->set('{activetab-2}', 'activetab');

				$tpl->compile('info');

				if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;

				$gcount = 10;

				$limit_page = ($page-1) * $gcount;

				$confirm = $db->super_query("SELECT user_id, user_search_pref, user_photo FROM `".PREFIX."_users` WHERE user_real_second = '1' LIMIT {$limit_page}, {$gcount}", 1);

				if($confirm){
				
					foreach($confirm as $row){

						$tpl->load_template('confirmation/verification.tpl');
						
						if($row['user_photo'])

							$tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/100_'.$row['user_photo']);

						else

							$tpl->set('{ava}', $config['home_url'].'templates/'.$config['temp'].'/images/100_no_ava.png');

						$tpl->set('{user_id}', $row['user_id']);

						$tpl->set('{user_search_pref}', $row['user_search_pref']);

						$tpl->compile('content');

					}

						$db_cnt = $db->super_query("SELECT COUNT(*) AS user_id FROM `".PREFIX."_users` WHERE user_real_second = '1'");

						navigation($gcount, $db_cnt['user_id'], $config['home_url'].'confirmation/verification_wiev/page/');

				} else

					msgbox('', 'Заявки на верификацыю профиля нету.', 'confirmation/info');

					$tpl->result['content'] .= '</div><div class="clear_fix"></div><br /></div>';

		break;

		case "verification_yes":

			NoAjaxQuery();

			$user_real = $_POST['user_real'];

			$user_real_id = intval($_POST['user_id']);

			if($user_real AND $user_real_id){

				$db->query("UPDATE `".PREFIX."_users` SET user_real = '{$user_real}' WHERE user_id = '{$user_real_id}'");

				$db->query("UPDATE `".PREFIX."_users` SET user_real_second = '0' WHERE user_id = '{$user_real_id}'");
				
//* Чистим кеш *//
				
				mozg_clear_cache_file('user_'.$user_real_id.'/profile_'.$user_real_id);

				mozg_clear_cache();

				echo '1';

			} else {

				echo '2';

			}

			die();

		break;

		case "verification_send":

			NoAjaxQuery();

			$user_real_send = intval($_POST['user_id']);

			if($user_real_send){

				$db->query("UPDATE `".PREFIX."_users` SET user_real_second = '1' WHERE user_id = '{$user_real_send}'");

				echo '1';

			} else {

				echo '2';

			}

			die();

		break;

		case "jobs_wiev":

			$tpl->load_template('confirmation/head.tpl');

			$tpl->set('{activetab-3}', 'activetab');

			$tpl->compile('info');

			if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;

				$gcount = 10;

				$limit_page = ($page-1) * $gcount;

				$confirm = $db->super_query("SELECT id, title, wages, category, news, photos, date FROM `".PREFIX."_jobs_news` WHERE user_jobs_join = '1' LIMIT {$limit_page}, {$gcount}", 1);
				
				if($confirm){

					foreach($confirm as $row){

						$tpl->load_template('confirmation/jobs_verifi.tpl');

						$tpl->set('{title}', $row['title']);

						$tpl->set('{category}', $array[$row['category']]);

						$tpl->set('{wages}', $row['wages']);

						$tpl->set('{news}', $row['news']);

						$tpl->set('{date}', megaDateNoTpl($row['date']));

						$tpl->set('{photos}', $row['photos']);

						$tpl->set('{id}', $row['id']);

						$tpl->compile('content');

					}

						$db_cnt = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_jobs_news` WHERE user_jobs_join = '1'");

						navigation($gcount, $db_cnt['id'], $config['home_url'].'confirmation/jobs_wiev/page/');

				} else

					msgbox('', 'Вакансий на проверку нету.', 'confirmation/info');

					$tpl->result['content'] .= '</div><div class="clear_fix"></div><br /></div>';

		break;

		case "jobs_del":

			NoAjaxQuery();

			$id = intval($_POST['id']);

			$jobs_del = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_jobs_news` WHERE id = '{$id}'");

			if($jobs_del['id']){

				$db->query("DELETE FROM `".PREFIX."_jobs_news` WHERE id='{$id}'");

				echo '1';

			} else {

				echo '2';

			}

			die();

		break;

		case "jobs_send":

			NoAjaxQuery();
			
			$id = intval($_POST['id']);

			$jobs_send = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_jobs_news` WHERE id = '{$id}'");

			if($jobs_send['id']){
			
				$db->query("UPDATE `".PREFIX."_jobs_news` SET user_jobs_join = '0' WHERE id='{$id}'");

				echo '1';

			} else {

				echo '2';

			}

			die();

		break;

	default:

}

} else {

	msgbox('', 'Вы не являетесь участником группы Администраторов.', 'confirmation/info');

}

$tpl->clear();

$db->free();

}
?>