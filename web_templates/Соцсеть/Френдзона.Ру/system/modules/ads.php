<?php

if(!defined('MOZG'))

	die('Hacking attempt!');

if($ajax == 'yes')

	NoAjaxQuery();

if($logged){

    $act = $_GET['act'];

    $user_id = $user_info['user_id'];

    $metatags['title'] = 'Объявления';
	
//* Категории обьявлений *//
	
	$array = array(

		0 => 'Любая',

		1 => 'Охота, рыбалка',

		2 => 'Электроника и техника',

		3 => 'Фото, оптика',

		4 => 'Услуги и деятельность',

		5 => 'Телефоны и связь',

		6 => 'Строительство и ремонт',

		7 => 'Публичная страница',

		8 => 'Одежда, обувь, аксессуары',

		9 => 'Недвижимость',

		10 => 'Музыка, искусство',

		11 => 'Мебель, интерьер',

		12 => 'Компьютерная техника',

		13 => 'Книги, учебники, журналы',

		14 => 'Игры',

		15 => 'Видео',

		16 => 'Авто и мото'

	);

    switch($act){

//* Считываем сколько просмотров *//
        case "view":

            $id = intval($_POST['id']);

            if($id){

                $db->query("UPDATE `".PREFIX."_ads` SET views=views-1 WHERE id='{$id}'");

            }

        break;

//Выводим обьявления пользователя *//
		
		case "ads_view_my":

		if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;

		$gcount = 10;

		$limit_page = ($page-1) * $gcount;

		$db_ads = $db->super_query("SELECT id, settings, description, links, link, views, category FROM `".PREFIX."_ads` WHERE user_id = '{$user_id}' ORDER by rand() ASC LIMIT {$limit_page}, {$gcount}", 1);

//* Top tabs bar *//
			
			$tpl->load_template('ads/ads_top.tpl');

			$db_num = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_ads` WHERE user_id = '{$user_id}'");

			$tpl->set('{summary}', 'У Вас '.$db_num['id'].' объявлений');

			$tpl->set('[ads_view_my]', '');

			$tpl->set('[/ads_view_my]', '');

			$tpl->set_block("'\\[ads_view_all\\](.*?)\\[/ads_view_all\\]'si","");

			$tpl->set_block("'\\[create_ads\\](.*?)\\[/create_ads\\]'si","");

			$tpl->compile('info');

		if($db_ads){

		$tpl->load_template('ads/ads_view_my.tpl');

			foreach($db_ads as $row_ads){

				$tpl->set('{id}', $row_ads['id']);

				$tpl->set('{settings}', $row_ads['settings']);

				$tpl->set('{description}', $row_ads['description']);

				$tpl->set('{views}', $row_ads['views']);

				$tpl->set('{category}', $array[$row_ads['category']]);

				$tpl->set('{link}', $row_ads['link']);

				$tpl->set('{links}', $row_ads['links']);

				$tpl->compile('content');

			}

			$db_cnt = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_ads` WHERE user_id = '{$user_id}'");

			navigation($gcount, $db_cnt['id'], $config['home_url'].'ads&act=ads_view_my&page=');

		} else

				msgbox('', 'На данный момент у вас нету объявлений ', 'info_2');

		break;

//* Редактор обявлений *//

		case "edit_save":

			NoAjaxQuery();

			$id = intval($_POST['id']);

			$settings = ajax_utf8(textFilter($_POST['settings']));
			
            $link_photos = $_POST['link_photos'];

            $link_site = $_POST['link_site'];

            $description = ajax_utf8(textFilter($_POST['description']));

			$category =  $_POST['category'];

			if($id){

				$db->query("UPDATE `".PREFIX."_ads` SET settings = '{$settings}', links = '{$link_site}', link = '{$link_photos}', description = '{$description}', category = '{$category}' WHERE id = '{$id}'");
				
				echo '1';
			
			}

			exit();

		break;

//* Создаем обьявления пользователя *//
		
		case "create_ads":

//* Top tabs bar *//
			
			$tpl->load_template('ads/ads_top.tpl');

			$tpl->set('[create_ads]', '');

			$tpl->set('[/create_ads]', '');

			$tpl->set_block("'\\[ads_view_all\\](.*?)\\[/ads_view_all\\]'si","");

			$tpl->set_block("'\\[ads_view_my\\](.*?)\\[/ads_view_my\\]'si","");

			$tpl->compile('info');
			
			$tpl->load_template('ads/ads_create.tpl');

			$tpl->compile('content');

		break;

//* Записываем все данные в базу данных *//
		
         case "add_ads":

            $title = ajax_utf8(textFilter($_POST['title']));

            $description = ajax_utf8(textFilter($_POST['description']));

            $link_photos = $_POST['link_photos'];

            $link_site = $_POST['link_site'];
            
            $category = $_POST['category'];

            $transitions = intval($_POST['transitions']);

            $ubalance = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
            
            if($transitions < 0) {die;}

            if($transitions <= $ubalance['user_balance']){

                if($title AND $link_photos AND $link_site AND $transitions AND $description){

                    $db->query("INSERT INTO `".PREFIX."_ads` SET settings = '{$title}', description = '{$description}', links = '{$link_site}', link = '{$link_photos}', category = '{$category}', views = '{$transitions}', user_id = '{$user_id}'");

                    $db->query("UPDATE `".PREFIX."_users` SET user_balance=user_balance-'{$transitions}' WHERE user_id='{$user_id}'");

                    echo '1';

                } else {

                    echo '2';  
                    
                }

            } else {

                echo '3';

            }

        die();

        break;  
//* Ajax JQuery Подгрузка обьявлений *//
		
        case "ads_view":

            $upload_ads = $db->super_query("SELECT * FROM `".PREFIX."_ads` WHERE views != '0' ORDER BY RAND() LIMIT 5");

            if($upload_ads){

                $links = explode('|', $upload_ads['links']);

                $link = explode('|', $upload_ads['link']);

                echo '

                <div class="ads_view">

				<div class="ads_close" onclick="ads_close();"></div>

				<h4 class="title_obshenie"><a href="'.$links[0].'" onClick="ads.ClickLink('.$upload_ads['id'].');" target="_blank">'.$upload_ads['settings'].'</a></h4>

				<a href="'.$links[0].'" onClick="ads.ClickLink('.$upload_ads['id'].');" target="_blank"><div class="ads_imgs_rekl"><img width="100" src="'.$link[0].'"/></div></a>

				<div class="ads_description">'.$upload_ads['description'].'</div><div style="margin-top:3px;"></div>

				<div class="more_div"></div>
				
				</div>

				';

            }

        die();

        break;
		
//* Ajax JQuery Подгрузка обьявлений *//
		
        case "ads_view1":

            $upload_ads = $db->super_query("SELECT * FROM `".PREFIX."_ads` WHERE views != '0' ORDER BY RAND() LIMIT 5");

            if($upload_ads){

                $links = explode('|', $upload_ads['links']);

                $link = explode('|', $upload_ads['link']);

                echo '

                <div class="ads_view">

    <div class="ads_close" onclick="ads_close();"></div>

    <h4><a href="'.$links[0].'" onClick="ads.ClickLink('.$upload_ads['id'].');" target="_blank">'.$upload_ads['settings'].'</a></h4>

    <a href="'.$links[0].'" onClick="ads.ClickLink('.$upload_ads['id'].');" target="_blank"><img width="100" src="'.$link[0].'"/></a>

    <div class="ads_description">'.$upload_ads['description'].'</div><div style="margin-top:3px;"></div>
	
    <div class="more_div"></div>
	
    <a href="/ads&act=ads" onClick="Page.Go(this.href); return false" class="size10 infowalltext_f clear">Все объявления</a>

    </div>

    ';

            }

        die();

        break;

//* Удаление обьявления юзера + возврат средств (голосов) *//
		
		case "delete_ads":

		$del = $db->super_query("SELECT id, views FROM `".PREFIX."_ads` WHERE user_id = '{$user_id}'");

		if($del['id']){

			$db->query("UPDATE `".PREFIX."_users` SET user_balance=user_balance+'{$del['views']}' WHERE user_id='{$user_id}'");

			$db->query("DELETE FROM `".PREFIX."_ads` WHERE user_id='{$user_id}' AND id='{$del['id']}'");

		}

		break;
		
//* Главная страница *//

		case "ads_target":

		$tpl->load_template('ads/ads_target.tpl');

		$tpl->compile('content');
		
		break;


        default:

//* Вывод всех обьявлений *//
		
		if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;

		$gcount = 10;

		$limit_page = ($page-1) * $gcount;

		$db_ads_all = $db->super_query("SELECT id, user_id, settings, description, links, link, views, category FROM `".PREFIX."_ads` ORDER by rand() ASC LIMIT {$limit_page}, {$gcount}", 1);

		if($db_ads_all){

//* Top tabs bar *//
			
			$tpl->load_template('ads/ads_top.tpl');

			$db_num_all = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_ads`");

			$tpl->set('{summary}', 'Всего '.$db_num_all['id'].' объявлений');

			$tpl->set('[ads_view_all]', '');

			$tpl->set('[/ads_view_all]', '');

			$tpl->set_block("'\\[ads_view_my\\](.*?)\\[/ads_view_my\\]'si","");

			$tpl->set_block("'\\[create_ads\\](.*?)\\[/create_ads\\]'si","");

			$tpl->compile('info');

			$tpl->load_template('ads/ads_view_all.tpl');

			foreach($db_ads_all as $row_ads){

//* Информируем выделевшие обьявления жолтым, когда просмотров осталось 5 *//
				
				if($row_ads['views'] == '5'){

					$tpl->set('{style}', 'style="background: #F3EFE5;border: 1px solid #D8C5B8;"');

				}
				
//* Удаляем обьявления если просмотры равны к нулю *//
				
				else if($row_ads['views'] == '0'){

					$db->query("DELETE FROM `".PREFIX."_ads` WHERE user_id='{$row_ads['user_id']}' AND id='{$row_ads['id']}'");

				}

				$tpl->set('{settings}', $row_ads['settings']);

				$tpl->set('{description}', $row_ads['description']);

				$tpl->set('{category}', $array[$row_ads['category']]);

				$tpl->set('{link}', $row_ads['link']);

				$tpl->set('{links}', $row_ads['links']);

				$tpl->set('{id}', $row_ads['id']);

				$tpl->compile('content');

			}

				$db_cnt = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_ads`");

				navigation($gcount, $db_cnt['id'], $config['home_url'].'ads&page=');

		} else

				msgbox('', '<script type="text/javascript" type="text/javascript" src="{theme}/js/speedbar.js"></script>На данный момент нету объявлений<div class="box_right_rel" style="margin-left: 571px; margin-top: -44px;"><div class="kki_reklama"><a class="btn btn-big d-b btn-blue-hover target-create-btn" href="/ads&act=create_ads" onClick="Page.Go(this.href); return false;" style="  font-size: 11px;width: 164px;">Создать объявление</a></div><a class=" nav_selected" onclick="Page.Go(this.href); return false" href="/ads&act=ads_target">Таргетинг</a><a  class="" href="/ads&act=ads_view_my" onClick="Page.Go(this.href); return false;">Мои объявления</a><a  class="act_rel" href="/ads&act=ads" onClick="Page.Go(this.href); return false;">Все объявления</a></div> ', 'info_2');

    }

    $tpl->clear();

	$db->free();

} else {

	$user_speedbar = $lang['no_infooo'];

	msgbox('', $lang['not_logged'], 'info');

}
?>