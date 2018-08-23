<?php

if(!defined('MOZG'))

	die('И че ты тут забыл??');

if($ajax == 'yes')

	NoAjaxQuery();

$user_id = $user_info['user_id'];

$key = '0PFXXTE349BMNFSV9801DZ843VUAA482';

$tpl->set('{hash}', md5($key.'_'.$user_id));

$act = $_GET['act'];

	//Категории приложений.
	$array = array(
	
		//Games type

		0 => 'Игры: Прочее',

		1 => 'Игры: Приключения',

		2 => 'Игры: Симуляторы',

		3 => 'Игры: Экономические',

		4 => 'Игры: Стратегии',

		5 => 'Игры: Логические',

		6 => 'Игры: Настольные',

		7 => 'Игры: Аркады',

		//Apps type

		8 => 'Приложения: Прочее',

		9 => 'Приложения: Общение',

		10 => 'Приложения: Мультимедиа',

		11 => 'Приложения: Рисование',

		12 => 'Приложения: Образовательные',

		13 => 'Приложения: Магазины',

		14 => 'Приложения: Новостные'

	);

if($logged){

	switch($act){

		case "view":

			NoAjaxQuery();

			$id = intval($_POST['id']);

			$row = $db->super_query("SELECT `id`,`cols`,`title`,`img`,`desc` FROM `".PREFIX."_apps` WHERE id='{$id}'");

			$num = $row['cols'];

			//Склонение поля человека смотрящего обьявление
			if($user_info['user_sex'] == '1'){

				$user_sex = 'первым';

			}else{

				$user_sex = 'первой';

			}

			//Проверка устанавливал ли кто нибудь Приложения
			if($row['cols'] == 0){

				$application_f = 'Приложения еще ни кто не установил будь '.$user_sex;

			}else{

				$application_f = 'Приложения установили '.$num.' '.gram_record($num, 'apps');

			}
			
			//Если нету Изображение Приложения то ставим стандарт..

			if($row['img']){

				$application_img = $config['home_url'].'uploads/apps/'.$row['id'].'/'.$row['img'];

			} else {

				$application_img = '/images/no_apps.gif';

			}

			$tpl->set('{id}', $row['id']);

			$tpl->set('{nums}', $application_f);

			$tpl->set('{title}', $row['title']);

			$tpl->set('{desc}', $row['desc']);

			$tpl->set('{ava}', $application_img);

			$tpl->load_template('apps/viewapplication.tpl');

			$tpl->compile('content');

			AjaxTpl();

			die();

		break;

		//############### вывод катигорий ###############

		case "type_cat":

		$id = intval($_GET['id']); //Задаем ID

		$category = intval($_GET['category']); //Задаем катигорию..

		if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1; //Переменая для страниц..

		$gcount = 10; //Количество приложений на страницы...

		$limit_page = ($page-1) * $gcount; //Добавляем страницу если больше $gcount числа..

		$cat_row = $db->super_query("SELECT id, url, cols, title, img, user_id, status, `desc`, category FROM `".PREFIX."_apps` WHERE status!='-1' AND category='{$category}' ORDER by id ASC LIMIT {$limit_page}, {$gcount}", 1); //Выводим даные с таблицы..

		//top tabs bar
		$tpl->load_template('apps/apps_category_top.tpl');

		$count_num = $db->super_query("SELECT COUNT(*) AS id FROM `".PREFIX."_apps` WHERE category = '{$category}' AND status!='-1'");

		$static_id = $db->super_query("SELECT user_id, alias FROM `".PREFIX."_users` WHERE user_id='{$user_id}'");

		$tpl->set('{summary}', $array[$category]);

		$tpl->set('{summary_num}', $count_num['id']);

		//Замена (id) - на унекальное имя (aliast).

		if($static_id['alias']){

			$tpl->set('{user-id}', $static_id['alias']); 

		} else {

			$tpl->set('{user-id}', 'id'.$static_id['user_id']);

		}

		$tpl->compile('info');

		if($cat_row){ //Проверяем на наличее данных если их нету то выводим сообщение..

		$tpl->load_template('apps/apps_category.tpl'); //Подключаем сам шаблон..

			foreach($cat_row as $cur){ //Создаем смарт обект...

			if($cur['status'] == '1'){ //Проверяем если приложение включено, если выключено то не показываем его..

				if($cur['img'] == ''){ //Проверяем на наличея обложки..

					$img = '/uploads/apps/no.gif'; //Если нету обложки..

				} else {

					$img = '/uploads/apps/'.$cur['id'].'/100_'.$cur['img']; //Еслие есть обложка..

				}

					$declines = Array("пользователь", "пользователей", "пользователей"); //Склонения...
			
					$tpl->set('{app_cols}', 'Всего '.$cur['cols'].' '.num2word($cur['cols'], $declines)); //Сколько людей установило приложения..

					$tpl->set('{app_id}', $cur['id']); //ИД Приложения..

					$tpl->set('{cat_id}', $array[$cur['category']]); //Категория приложения..
					
					$tpl->set('[status]', ''); //Если включено то показываем..

					$tpl->set('[/status]', '');
					
					//Если приложение не установлено то предлагаем его установить

					$cat_row_ins = $db->super_query("SELECT user_id,application_id FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}' AND  application_id='{$id}'");

					if($cur['cols'] == 0){ //Проверяем на наличея установки приложения..
	
						$tpl->set('{type_title}', '<a href="/apps?i='.$cur['id'].'" onclick="apps.view(\''.$cur['id'].'\', this.href, \' \'); return false;" title="'.$cur['title'].'"><h1>'.$cur['title'].'</h1></a>'); //Название приложения..

						$tpl->set('{app_img}', '<a href="/apps?i='.$cur['id'].'" onclick="apps.view(\''.$cur['id'].'\', this.href, \' \'); return false;"><div class="apps_img_st"><img src="'.$img.'" /></div></a>'); //Обложка приложения..
						
						$tpl->set('{app_desc}', $cur['desc']);
						
						$tpl->set('[install]', ''); //Не установлено приложения придлогаем установить..

						$tpl->set('[/install]', '');

						$tpl->set_block("'\\[not-install\\](.*?)\\[/not-install\\]'si",""); //lock not install

					} else {

						$tpl->set('{type_title}', '<a href="/app'.$cur['id'].'" onclick="Page.Go(this.href); clear_style(); return false;" title="'.$cur['title'].'"><h1>'.$cur['title'].'</h1></a>'); //Название приложения..

						$tpl->set('{app_img}', '<a href="/app'.$cur['id'].'" onclick="Page.Go(this.href); clear_style(); return false;"><div class="apps_img_st"><img src="'.$img.'" /></div></a>'); //Обложка приложения..

						$tpl->set('{app_desc}', $cur['desc']);
						
						$tpl->set('[not-install]', ''); //Установлено приложения, не придлогаем установить его заново..)

						$tpl->set('[/not-install]', '');

						$tpl->set_block("'\\[install\\](.*?)\\[/install\\]'si","");

					}

			} else {

				$tpl->set_block("'\\[status\\](.*?)\\[/status\\]'si",""); //Если выключено то непоказываем..

			}

				$tpl->compile('apps_view'); //Компилируем контент..

			}

			//ads views
			$db_ads_apps = $db->super_query("SELECT id, user_id, settings, description, links, link FROM `".PREFIX."_ads` WHERE views != '0' AND category = '14' ORDER by rand() ASC LIMIT 0, 4", 1);

			foreach($db_ads_apps as $ads_apps){

				$tpl->load_template('apps/apps_right_ads.tpl');

				$tpl->set('{settings}', $ads_apps['settings']);

				$tpl->set('{description}', $ads_apps['description']);

				$tpl->set('{link}', $ads_apps['link']);

				$tpl->set('{links}', $ads_apps['links']);

				$tpl->set('{id}', $ads_apps['id']);

				$tpl->compile('apps_ads'); //Компилируем контент..

			} //end ads views

				$tpl->load_template('apps/cat_content.tpl');
			
				$tpl->set('{apps_ads}', $tpl->result['apps_ads']);

				$tpl->set('{apps_view}', $tpl->result['apps_view']);

				$tpl->compile('content');

				//navigator pages
				$db_cnt = $db->super_query("SELECT COUNT(*) AS id, category FROM `".PREFIX."_apps` WHERE category = '{$category}'"); //Выводим данные для постраничного контента

				navigation($gcount, $db_cnt['id'], $config['home_url'].'apps/appcenter/category/'.$db_cnt['category'].'&page='); //Генерируем ссылку для постраничого контента..

		} else

				msgbox('', 'В данной категории нету приложений ', 'info_2'); //Если нету в катигории ни одного приложения то выводим ошибку..

		break;

		//############### Вывод игры ###############

		case "app":

			$id = intval($_GET['id']);

			//Вывод игры из базы
			$row = $db->super_query("SELECT id,url,cols,title,img,width,height,secret,user_id,status,type,flash FROM `".PREFIX."_apps` WHERE id='{$id}'");

			$metatags['title'] = 'Приложения | '.$row['title'].'';

			if($row['status'] == '1' or $row['user_id'] == $user_id){

				if($row['user_id'] == $user_id){

					$tpl->set('[edit]', '');

					$tpl->set('[/edit]', '');

					$tpl->set_block("'\\[not-edit\\](.*?)\\[/not-edit\\]'si","");

				} else {

					$tpl->set('[not-edit]', '');

					$tpl->set('[/not-edit]', '');

					$tpl->set_block("'\\[edit\\](.*?)\\[/edit\\]'si","");

				}

				$rows = $db->super_query("SELECT user_id,application_id FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}' AND  application_id='{$id}'");

				if($rows['user_id'] != $user_id && $rows['application_id'] != $id){

					$tpl->set('[install]', '');

					$tpl->set('[/install]', '');

					$tpl->set_block("'\\[not-install\\](.*?)\\[/not-install\\]'si","");

				} else {

					$tpl->set('[not-install]', '');

					$tpl->set('[/not-install]', '');

					$tpl->set_block("'\\[install\\](.*?)\\[/install\\]'si","");

				}

				if($row['type'] == '1'){

					$tpl->set('[iframe]', '');

					$tpl->set('[/iframe]', '');

					$tpl->set_block("'\\[flash\\](.*?)\\[/flash\\]'si","");

				} else {

					$tpl->set('[flash]', '');

					$tpl->set('[/flash]', '');

					$tpl->set_block("'\\[iframe\\](.*?)\\[/iframe\\]'si","");

				}

				if($row['img'] == '') $img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$row['id'].'/100_'.$row['img'];

				$num = $row['cols'];

            	$tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

				$tpl->set('{title}', $row['title']);

				$tpl->set('{id}', $row['id']);

				$tpl->set('{height}', $row['height']);

				$tpl->set('{width}', $row['width']);

				$tpl->set('{api_url}', $config['home_url']);

				$tpl->set('{viewer_id}', $user_id);

				$tpl->set('{auth_key}', md5($row['id']."_".$user_id."_".$row['secret']));
				
				$tpl->set('{sid}', md5($row['id']."_".$user_id."_".$row['secret']));

				$tpl->set('{ava}', $img);

				$tpl->set('{site}', $config['home_url']);

				$tpl->set('{url}', $row['url']);

				$tpl->set('{flash}', $row['flash']);

				if($row['url'] == '' && $row['flash'] == '')  $tpl->load_template('apps/editapp/no_app.tpl'); else $tpl->load_template('apps/application.tpl');

			} else $tpl->load_template('apps/editapp/ofline.tpl');

			$tpl->compile('content');

		break;

		case "show_settings":

			NoAjaxQuery();

			$id =intval($_POST['id']);

			$row = $db->super_query("SELECT user_id,user_balance,user_photo FROM `".PREFIX."_users` WHERE user_id='{$user_id}'");

			$app = $db->super_query("SELECT user_id,balance,application_id FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}'  AND application_id='{$id}'");
			
			if($app['user_id'] != $user_id && $app['application_id'] != $id){

					$tpl->set('[install]', '');

					$tpl->set('[/install]', '');

					$tpl->set_block("'\\[not-install\\](.*?)\\[/not-install\\]'si","");

				} else {

					$tpl->set('[not-install]', '');

					$tpl->set('[/not-install]', '');

					$tpl->set_block("'\\[install\\](.*?)\\[/install\\]'si","");

				}

			$tpl->set('{id}', $id);

			$tpl->set('{balance}', $row['user_balance']);

			$tpl->set('{app_balance}', $app['balance']);

			$tpl->set('{userid}', $user_id);

			$tpl->load_template('/apps/show_settings.tpl');

			$tpl->compile('content');

			AjaxTpl();

			die();
		
		break;

		case"save_settings":

			$id = intval($_POST['aid']);

			$balance = intval($_POST['add']);

			$hash = $_POST['hash'];

			if($hash == md5($key.'_'.$user_id) && $balance >= '0'){

				$row = $db->super_query("SELECT user_balance FROM `".PREFIX."_users` WHERE user_id='{$user_id}'");

				if($balance <= $row['user_balance']) {

					$db->query("UPDATE `".PREFIX."_apps_users` SET balance=balance+'{$balance}' WHERE application_id='{$id}' and user_id='{$user_id}'");

					$db->super_query("UPDATE `".PREFIX."_users` SET user_balance=user_balance-'{$balance}' WHERE user_id='{$user_id}'");

					$db->query("INSERT INTO `".PREFIX."_historytab` SET user_id = '{$user_id}', title='{$id}', for_user_id = '{$id}', type = '6', price='{$balance}', status = '-', date = '{$server_time}'");

					echo "ok";

				} else echo "not";

			}

		break;

		//##################### Удаление игр у пользователя #####################

		case"quit":

			$id = intval($_POST['id']);

			$hash = $_POST['hash'];

			if($hash == md5($key.'_'.$user_id)){

				$db->query("DELETE FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}' AND application_id='{$id}'");

				$db->query("UPDATE `".PREFIX."_apps` SET cols=cols-1 WHERE id='{$id}'");

				echo 'ok';

			}

		break;

		//##################### Установка игры #####################

		case 'install':

			$id = intval($_POST['id']);

			$hash = $_POST['hash'];

			//Проверка добавлял ли игру пользователь
			$rows = $db->super_query("SELECT user_id,application_id FROM `".PREFIX."_apps_users` WHERE user_id='{$user_id}' AND  application_id='{$id}'");

			if($rows['user_id'] != $user_id && $rows['application_id'] != $id && $hash == md5($key.'_'.$user_id)){

				$db->query("INSERT INTO `".PREFIX."_apps_users` (user_id,application_id,date) VALUES ('".$user_id."','".$id."','".$server_time."')");

				$db->query("UPDATE `".PREFIX."_apps` SET cols=cols+1 WHERE id='{$id}'");

				echo 'ok';

			}

			break;

		//########## Отправка рассказать друзьям об игре ################

		case"mywall":

			$id = intval($_POST['id']);

			$hash = $_POST['hash'];

			$sql = $db->super_query("SELECT id,cols,title,img FROM `".PREFIX."_apps` WHERE id='{$id}'");

			if($user_info['user_sex'] == 1){

				$sex = 'Я запустила';

			}else{

				$sex = 'Я запустил';

			}

			if($sql['img'] == '') $img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$sql['id'].'/'.$sql['img'];

			$text = $sex.' приложение <a href="/apps?i='.$sql['id'].'" onclick="apps.view(\''.$attach_type[1].'\', this.href, \' \'); return false;">'.$sql['title'].'</a>. Присоединяйся!';

			if($sql['img']){
				
				$app_img = $sql['img'];
				
			} else {
			
				$app_img = 'no_apps.gif';
			}

			$attach = 'apps|'.$sql['id'].'|'.$app_img.'||';

			$db->query("INSERT INTO `".PREFIX."_wall` (author_user_id,add_date,text,attach,for_user_id) VALUES ('".$user_id."','".$server_time."','".$text."','".$attach."','".$user_id."')");

			$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$user_id}'");

			//Вставляем в ленту новотсей
			$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$user_id}', action_type = 6, action_text = '{$attach}', action_time = '{$server_time}'");

			//Чистим кеш
			mozg_clear_cache_file('user_'.$user_id.'/profile_'.$user_id);

			mozg_clear_cache();

		break;

		//############### Поиск по приложениям ##################

		case"search":

			$application = $db->safesql(ajax_utf8(strip_data(urldecode($_POST['query_application']))));

			$application = strtr($application, array(' ' => '%'));

			$sql = $db->super_query("SELECT * FROM `".PREFIX."_apps` WHERE title LIKE '%{$application}%'",1);

			foreach($sql as $row_app){

			$num = $row_app['cols'];

			//Если нету Изображение Приложения то ставим стандарт..
			if($row_app['img']){

				$application_img = $config['home_url'].'uploads/apps/'.$row_app['id'].'/'.$row_app['img'];

			} else {

				$application_img = '/images/no_apps.gif';

			}

			$search_aps .='

					<div class="apps_application apps_application2 apps_last_new" id="{id}">

					<a class="apps_mr" href="/apps?i='.$row_app['id'].'" onClick="apps.view(\''.$row_app['id'].'\', this.href, \'/apps\'); return false">

					<img src="'.$application_img.'" class="fl_l" width="75" height="75" /></a>

					<a href="/apps?i='.$row_app['id'].'" onClick="apps.view(\''.$row_app['id'].'\', this.href, \'/apps\'); return false">'.$row_app['title'].'</a>

					<div class="apps_num">'.$num.' '.gram_record($num, 'apps').'</div>

					<div class="clear"></div>

					</div>

				';
			}

			echo $search_aps;

			AjaxTpl();

            die();

		break;

		//################# Подгружаем игры ######################

		case"doload":

			$start = intval($_POST['num']);

			$sqll_ = $db->super_query("SELECT tb1.user_id,tb1.application_id,tb2.title,tb2.img,tb2.cols FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_apps` tb2 WHERE tb1.user_id='{$user_id}' AND tb2.id=tb1.application_id ORDER BY tb1.date DESC LIMIT {$start}, 5",1);
			
			$tpl->load_template('apps/my_application.tpl');
			
			foreach($sqll_ as $rows){

				$num = $rows['cols'];

				if($rows['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rows['application_id'].'/'.$rows['img'];

				$my_application .='

				<div id="app'.$rows['application_id'].'" class="apps_application">

				<a class="apps_mr" onclick="Page.Go(this.href); return false" href="/app'.$rows['application_id'].'">

				<img class="fl_l" width="50" height="50" src="'.$img.'">

				</a>

				<a onclick="Page.Go(this.href); return false" href="/app'.$rows['application_id'].'">'.$rows['title'].'</a>

				<div id="appsgan'.$rows['application_id'].'" class="apps_fast_del fl_r cursor_pointer" onmouseover="myhtml.title(\''.$rows['application_id'].'\', \'Удалить игру\', \'appsgan\')" onclick="apps.mydel(\''.$rows['application_id'].'\', true)">

				<img src="/images/close_a.png">

				</div>

				<div class="clear"></div>

				</div>

				';

			}
			
			$sqlls_ = $db->super_query("

			SELECT tb1.*,tb2.*,tb3.*,tb4.user_id,tb4.user_search_pref,tb4.user_sex,tb4.user_photo 

			FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_friends` tb2,`".PREFIX."_apps` tb3,`".PREFIX."_users` tb4 

			WHERE tb2.friend_id=tb1.user_id AND tb2.user_id='{$user_id}' AND tb2.subscriptions='0' AND tb3.id=tb1.application_id AND tb4.user_id=tb2.friend_id 

			ORDER BY tb1.date DESC LIMIT {$start}, 5",1);

			foreach($sqlls_ as $rowsa){

				if($rowsa['user_sex'] == 1){

					$m = 'запустил игру';

				}else{

					$m = 'запустила игру';

				}

				if(date('Y-m-d', $rowsa['date']) == date('Y-m-d', $server_time))

						$dateTell = langdate('сегодня в H:i', $rowsa['date']);

					elseif(date('Y-m-d', $rowsa['date']) == date('Y-m-d', ($server_time-84600)))

						$dateTell = langdate('вчера в H:i',$rowsa['date']);

					else

						$dateTell = langdate('j F Y в H:i', $rowsa['date']);

                if($rowsa['user_photo'])

			    $ava = $config['home_url'].'uploads/users/'.$rowsa['user_id'].'/50_'.$rowsa['user_photo'];

					else

			    $ava = '/images/no_ava_50.png';

				if($rowsa['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsa['id'].'/100_'.$rowsa['img'];

				$friends_application .= '
				
				<div class="apps_application">

					<a class="apps_mr" href="/id'.$rowsa['user_id'].'" onClick="Page.Go(this.href); return false">

					<img src="'.$ava.'" class="fl_l" width="50" style="max-height:50px;" title="'.$rowsa['user_search_pref'].'" /></a>

					<a class="apps_ml" href="/apps?i='.$rowsa['id'].'" onClick="apps.view(\''.$rowsa['id'].'\', this.href, \'/apps\'); return false">

					<img src="'.$img.'" class="fl_r" width="50" height="50" title="'.$rowsa['title'].'" /></a>

					<div class="apps_gr"><div class="apps_grtext">'.$m.'<br /><small>'.$dateTell.'</small></div></div>

					<div class="clear"></div>

					</div>

				';

			}

			echo $my_application.'||'.$friends_application;

			AjaxTpl();

            die();

		break;

		case"loads":

		$start = intval($_POST['num']);

		$sql_ = $db->super_query("SELECT id,cols,title,img FROM `".PREFIX."_apps` where status!='-1' ORDER BY id DESC LIMIT {$start},20",1);

		$tpl->load_template('apps/newapplication.tpl');

		//#################### Вывод популярных игр ######################

		foreach($sql_ as $rowsd){

			if($rowsd['cols'] >= 2){

				$num = $rowsd['cols'];

				if($rowsd['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsd['id'].'/100_'.$rowsd['img'];

				$le .='

				<div class="apps_application apps_application2 apps_last_new" id="{id}">

				<a class="apps_mr" href="/apps?i='. $rowsd['id'].'" onClick="apps.view(\''. $rowsd['id'].'\', this.href,\'/apps\'); return false"><img src="'.$img.'" class="fl_l" width="75" height="75" /></a>

				<a href="/apps?i='. $rowsd['id'].'" onClick="apps.view(\''. $rowsd['id'].'\', this.href, \'/apps\'); return false">'.$rowsd['title'].'</a>

				<div class="apps_num">'.$num.' '.gram_record($num, 'apps').'</div>

				<div class="clear"></div>

				</div>

				';
			}
		}

		//#################### Вывод новых игр ######################

		foreach($sql_ as $row){

			$num = $row['cols'];

			if($row['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$row['id'].'/100_'.$row['img'];

			$new .='

			<div class="apps_application apps_application2 apps_last_new" id="{id}">

				<a class="apps_mr" href="/apps?i='. $row['id'].'" onClick="apps.view(\''. $row['id'].'\', this.href,\'/apps\'); return false">

				<img src="'.$img.'" class="fl_l" width="75" height="75" /></a>

				<a href="/apps?i='. $row['id'].'" onClick="apps.view(\''. $row['id'].'\', this.href, \'/apps\'); return false">'.$row['title'].'</a>

				<div class="apps_num">'.$num.' '.gram_record($num, 'apps').'</div>

				<div class="clear"></div>

				</div>

			';

		}

		echo $le.'||'.$new;

			AjaxTpl();

            die();

		break;

		default:

		$sqls_ = $db->super_query("SELECT id,cols,title,`desc`,img FROM `".PREFIX."_apps` where status!='-1' ORDER BY id DESC LIMIT 4",1);

		$tpl->load_template('apps/slider.tpl');

		//#################### Вывод популярных игр ######################

		foreach($sqls_ as $rowsds){

				if($rowsds['img'] == '') $img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsds['id'].'/100_'.$rowsds['img'];

				$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$rowsds[id]'");

				if(!$db->num_rows()){

					$tpl->set('{link}', '<a href="/apps?i='.$rowsds['id'].'" onClick="apps.view('.$rowsds['id'].'); return false">');

				} else $tpl->set('{link}', '<a href="/app'.$rowsds['id'].'">');

				$tpl->set('{title}', $rowsds['title']);

				$tpl->set('{id}', $rowsds['id']);

				$tpl->set('{desc}', $rowsds['desc']);

				$tpl->set('{ava}', $img);

				$tpl->compile('slider');

		}

		//############# Вывод моих игр #####################

		$sqll_ = $db->super_query("SELECT tb1.user_id,tb1.application_id,tb2.title,tb2.img,tb2.cols FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_apps` tb2 WHERE tb1.user_id='{$user_id}' AND tb2.id=tb1.application_id ORDER BY tb1.date DESC LIMIT 5",1);

		$tpl->load_template('apps/my_application.tpl');

		foreach($sqll_ as $rows){

			if($rows['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rows['application_id'].'/100_'.$rows['img'];

			$num = $rows['cols'];

            $tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

			$tpl->set('{title}', $rows['title']);

			$tpl->set('{id}', $rows['application_id']);

			$tpl->set('{ava}', $img);

			$tpl->set('{hash}', md5($key.'_'.$user_id));

			$tpl->compile('my_application');

		}

		//################ Игры друзей ###################

		$sqlls_ = $db->super_query("

		SELECT tb1.*,tb2.*,tb3.*,tb4.user_id,tb4.user_search_pref,tb4.user_sex,tb4.user_photo 

		FROM `".PREFIX."_apps_users` tb1,`".PREFIX."_friends` tb2,`".PREFIX."_apps` tb3,`".PREFIX."_users` tb4 

		WHERE 

		tb2.friend_id=tb1.user_id

		AND tb2.user_id='{$user_id}'

		AND tb2.subscriptions='0'

		AND tb3.id=tb1.application_id

		AND tb4.user_id=tb2.friend_id

		ORDER BY tb1.date DESC LIMIT 5",1);

		$tpl->load_template('apps/friends_application.tpl');

		foreach($sqlls_ as $rowsa){

			if($rowsa['user_sex'] == 1){

				$tpl->set('{application_start}', 'запустил игру');

			}else{

				$tpl->set('{application_start}', 'запустила игру');

			}

			if(date('Y-m-d', $rowsa['date']) == date('Y-m-d', $server_time))

					$dateTell = langdate('сегодня в H:i', $rowsa['date']);

				elseif(date('Y-m-d', $rowsa['date']) == date('Y-m-d', ($server_time-84600)))

					$dateTell = langdate('вчера в H:i',$rowsa['date']);

				else

					$dateTell = langdate('j F Y в H:i', $rowsa['date']);

	        if($rowsa['user_photo'])

				$ava = $config['home_url'].'uploads/users/'.$rowsa['user_id'].'/50_'.$rowsa['user_photo'];

		    else

				$ava = '/images/no_ava_50.png';

			if($rowsa['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsa['id'].'/100_'.$rowsa['img'];

			$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$rowsa[id]'");

			if(!$db->num_rows())$tpl->set('{link}', '<a class="apps_ml" href="/apps?i='.$rowsa['id'].'" onClick="apps.view('.$rowsa['id'].', this.href, "/apps"); return false">');

			else $tpl->set('{link}', '<a class="apps_ml" href="/app'.$rowsa['id'].'">');

			$tpl->set('{title}', $rowsa['title']);

			$tpl->set('{date}', $dateTell);

			$tpl->set('{name}', $rowsa['user_search_pref']);

			$tpl->set('{user-id}', $rowsa['user_id']);

			$tpl->set('{id}', $rowsa['id']);

			$tpl->set('{ava}', $ava);

			$tpl->set('{img}', $img);

			$tpl->compile('friends_application');

		}


		//################### Вывод новых и популярных игр #####################

		$metatags['title'] = 'Игры';

		$sql_ = $db->super_query("SELECT id,cols,title,img FROM `".PREFIX."_apps` WHERE status!='-1' ORDER BY id DESC LIMIT 20",1);

		$tpl->load_template('apps/newapplication.tpl');

		//#################### Вывод популярных игр ######################

		foreach($sql_ as $rowsd){

			if($rowsd['cols'] >= 2){

				if($rowsd['img'] == '')	$img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$rowsd['id'].'/100_'.$rowsd['img'];

				$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$rowsd[id]'");

				if(!$db->num_rows())$tpl->set('{link}', '<a href="/apps?i='.$rowsd['id'].'" onClick="apps.view('.$rowsd['id'].', this.href, "/apps"); return false">');

				else $tpl->set('{link}', '<a href="/app'.$rowsd['id'].'">');

				$num = $rowsd['cols'];

                $tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

				$tpl->set('{title}', $rowsd['title']);

				$tpl->set('{id}', $rowsd['id']);

				$tpl->set('{ava}', $img);

				$tpl->compile('popular_application');

			}

		}

		//#################### Вывод новых игр ######################

		foreach($sql_ as $row){

			if($row['img'] == '') $img = '/uploads/apps/no.gif'; else $img = '/uploads/apps/'.$row['id'].'/100_'.$row['img'];

				$db->query("SELECT * FROM `".PREFIX."_apps_users` WHERE user_id = '$user_id' and application_id = '$row[id]'");

			if(!$db->num_rows()) $tpl->set('{link}', '<a href="/apps?i='.$row['id'].'" onClick="apps.view('.$row['id'].', this.href, "/apps"); return false">');

				else $tpl->set('{link}', '<a href="/app'.$row['id'].'" onClick="Page.Go(this.href); return false;">');

				$num = $row['cols'];

				$tpl->set('{nums}', $num.' '.gram_record($num, 'apps'));

				$tpl->set('{title}', $row['title']);

				$tpl->set('{id}', $row['id']);

				$tpl->set('{ava}', $img);

				$tpl->compile('newapplication');

		}

		$tpl->load_template('apps/content.tpl');
		
		$static_id = $db->super_query("SELECT user_id, alias FROM `".PREFIX."_users` WHERE user_id = '$user_id'");
		
		//Замена (id) - на унекальное имя (aliast).

		if($static_id['alias']){

			$tpl->set('{user-id}', $static_id['alias']); 

		} else {

			$tpl->set('{user-id}', 'id'.$static_id['user_id']);

		}

		$tpl->set('{slider}', $tpl->result['slider']);

		$tpl->set('{my_application}', $tpl->result['my_application']);

		$tpl->set('{friends_application}', $tpl->result['friends_application']);

		$tpl->set('{popular_application}', $tpl->result['popular_application']);

		$tpl->set('{newapplication}', $tpl->result['newapplication']);

		$tpl->compile('content');

	}

	$db->free();

	$tpl->clear();

} else {

	$user_speedbar = 'Информация';

	msgbox('', $lang['not_logged'], 'info');

}

?>