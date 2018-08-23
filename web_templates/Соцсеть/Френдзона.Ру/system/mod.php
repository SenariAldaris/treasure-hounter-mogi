<?php
if(!defined('MOZG'))
	die('Hacking attempt!');

if(isset($_GET['go']))
	$go = htmlspecialchars(strip_tags(stripslashes(trim(urldecode(mysql_escape_string($_GET['go']))))));
else
	$go = "main";

$mozg_module = $go;

check_xss();

//* Проверка на то что страница привязана к телефону *//

if($user_info['new_reg'] AND $a){
	
//* Завершение *//
	
	if(isset($_POST['send2'])){
		
		$color_head = intval($_POST['color_head']);
		$bg = intval($_POST['bg']);
		if($bg <= 0 OR $bg > 4) $bg = 0;

		$row = $db->super_query("SELECT user_design FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
		
		$data = xfieldsdataload($row['user_design']);
		
//* Имя фотографии *//		
		
		$name_bg = substr(md5($server_time+rand(1,100000)), 0, 20);
		
		if($data['background'])
			@unlink(ROOT_DIR.'/uploads/users/'.$data['background']);
		
		if($bg)
			@copy(ROOT_DIR.'/uploads/bg/'.$bg.'.jpg', ROOT_DIR.'/uploads/users/'.$user_info['user_id'].'/'.$name_bg.'.jpg');
		
		$row['user_design'] = str_replace("background|{$data['background']}||", '', $row['user_design']);
		$row['user_design'] = str_replace("color_head|{$data['color_head']}||", '', $row['user_design']);
		
		if($bg)
			$user_design .= "background|{$name_bg}.jpg||";
		
		$user_design .= "color_head|{$color_head}||background_repeat|1||opacity|30||{$row['user_design']}";
		
		$db->query("UPDATE `".PREFIX."_users` SET user_design = '{$user_design}', new_reg = '0' WHERE user_id = '{$user_info['user_id']}'");
		
		mozg_clear_cache_file("user_{$user_info['user_id']}/profile_{$user_info['user_id']}");

		header("Location: /editmypage");
		
	}
	
	$tpl->load_template('all/set_step1.tpl');
	$tpl->compile('main');
	
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);
	
	exit();
	
}

//* Проверка на то что страница привязана к телефону *//

if($user_info['user_active'] AND $config['active_mobile'] == 'yes'){
	
	$tpl->load_template('all/phone.tpl');
	$tpl->compile('main');
	
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);
	
	exit();
	
}

//* FOR MOBILE VERSION 1.0 *//

   if($config['temp'] == 'mobile')
        $lang['online'] = '<img src="{theme}/images/monline.gif" />';
	
   switch($go){
	
//* Каталог игр *//

    case "webtomat":
        include ENGINE_DIR.'/modules/webtomat/index.php';
    break;
	
//* Гости *//
 
    case "guests" :
        include ENGINE_DIR . '/modules/guests.php';
    break; 

	//* Гости *//
 
    case "chat" :
        include ENGINE_DIR . '/modules/chat.php';
    break; 
	
//* Регистрация *//

	case "register":
		include ENGINE_DIR.'/modules/register.php';
	break;
//* Вип *//

    case "vip":
        include ENGINE_DIR.'/modules/vip.php';
    break;
	
	 case "razvlecheniya":
        include ENGINE_DIR.'/modules/razvlecheniya.php';
    break;
	
//* Хочу общаться *//
	
    case "obshenie":
        include ENGINE_DIR.'/modules/obshenie.php';
    break;
	
 //ADS
 case "ads":
  include ENGINE_DIR.'/modules/ads.php';
 break;
 
//* Фон *//

	case "fon":
		include ENGINE_DIR.'/modules/fon.php';
	break;	
	
	case "game":
		include ENGINE_DIR.'/modules/nextgame/nextgame.php';
	break;
	
//* Пины *//

    case "pins":
        include ENGINE_DIR . '/modules/pins.php';
    break;
	
//* Фото в группах *//

    case "photo_groups":
        include ENGINE_DIR.'/modules/photo_groups.php';
    break;
	
//* Профиль пользователя *//

	case "profile":
		$spBar = true;
		include ENGINE_DIR.'/modules/profile.php';
	break;
	
//* Статистика страницы пользователя *//

	case "my_stats":
		include ENGINE_DIR.'/modules/my_stats.php';
	break;
	
//* Редактирование моей страницы *//

	case "editprofile":
		$spBar = true;
		include ENGINE_DIR.'/modules/editprofile.php';
	break;
	
//* Загрузка городов *//

	case "loadcity":
		include ENGINE_DIR.'/modules/loadcity.php';
	break;
		
//* Альбомы *//

	case "albums":
	    $spBar = true;
	if($config['album_mod'] == 'yes')
	    include ENGINE_DIR.'/modules/albums.php';
		else {
			$user_speedbar = 'Информация';
			msgbox('', 'Сервис отключен.', 'info');
		}
	break;
	
//* Мисс сайта *//

	case "miss":
	$spBar = true;
		include ENGINE_DIR.'/modules/miss.php';
	break;
	
//* Просмотр фотографии *//

	case "photo":
		include ENGINE_DIR.'/modules/photo.php';
	break;
	
//* Друзья *//

	case "friends":
		$spBar = true;
		include ENGINE_DIR.'/modules/friends.php';
	break;
	
//Верификация сообществ *//

	case "confirmation":
		$spBar = true;
		include ENGINE_DIR.'/modules/confirmation.php';
	break;
	
//* Закладки *//

	case "fave":
		$spBar = true;
		include ENGINE_DIR.'/modules/fave.php';
	break;
	
//* Сообщения *//

	case "messages":
		$spBar = true;
		include ENGINE_DIR.'/modules/messages.php';
	break;
	
//* Диалоги *//

	case "im":
		include ENGINE_DIR.'/modules/im.php';
	break;

//* Заметки *//

	case "notes":
		$spBar = true;
		include ENGINE_DIR.'/modules/notes.php';
	break;

	
//* Подписки *//

	case "subscriptions":
		include ENGINE_DIR.'/modules/subscriptions.php';
	break;
	
//* Видео *//

	case "videos":
		$spBar = true;
		if($config['video_mod'] == 'yes')
			include ENGINE_DIR.'/modules/videos.php';
		else {
			$user_speedbar = 'Информация';
			msgbox('', 'Сервис отключен.', 'info');
		}
	break;
	
//* Сообщества / Публичные страницы / Видеозаписи *//

	case "public_videos":
		include ENGINE_DIR.'/modules/public_videos.php';
	break;
	
//* Поиск *//

	case "search":
		include ENGINE_DIR.'/modules/search.php';
	break;
	
//* Стена *//

	case "wall":
		$spBar = true;
		include ENGINE_DIR.'/modules/wall.php';
	break;
	
//* Статус *//

	case "status":
		include ENGINE_DIR.'/modules/status.php';
	break;
	
//* Новости *//

	case "news":
		$spBar = true;
		include ENGINE_DIR.'/modules/news.php';
	break;
	
//* Настройки *//

	case "settings":
		include ENGINE_DIR.'/modules/settings.php';
	break;
	
//* Помощь *//

	case "support":
		include ENGINE_DIR.'/modules/support.php';
	break;
	
//* Восстановление доступа *//

	case "restore":
		include ENGINE_DIR.'/modules/restore.php';
	break;
	
//* Загрузка картинок при прикриплении файлов со стены, заметок, или сообщений *//

	case "attach":
		include ENGINE_DIR.'/modules/attach.php';
	break;
	
//* Блог сайта *//

	case "blog":
		$spBar = true;
		include ENGINE_DIR.'/modules/blog.php';
	break;

//* Баланс *//

	case "balance":
		include ENGINE_DIR.'/modules/balance.php';
	break;
	
//* Подарки *//

	case "gifts":
		include ENGINE_DIR.'/modules/gifts.php';
	break;

//* Сообщества *//

	case "groups":
		include ENGINE_DIR.'/modules/groups.php';
	break;

//* Фамилии *//

	case "families":
		include ENGINE_DIR.'/modules/families.php';
	break;
	
//* Сообщества / Публичные страницы *//

	case "public":
		$spBar = true;
		include ENGINE_DIR.'/modules/public.php';
	break;

//* Фамилия *//

	case "family":
		include ENGINE_DIR.'/modules/family.php';
	break;

	case "short_link":
		$link = $db->safesql($_GET['link']);
		$check_public = $db->super_query("SELECT COUNT(*) as `check` FROM `" . PREFIX . "_communities` WHERE `adres` = '{$link}'");
		if ($check_public['check']) {
			$_GET['get_adres'] = $link;
			$spBar = true;
			include ENGINE_DIR.'/modules/public.php';
		} else {
			$check_profile = $db->super_query("SELECT COUNT(*) as `check`, `user_id` FROM `" . PREFIX . "_users` WHERE `short_link` = '{$link}'");
			if ($check_profile['check']) {
				$_GET['id'] = $check_profile['user_id'];
				$spBar = true;
				include ENGINE_DIR.'/modules/profile.php';
			} else {
				$spBar = true;
				msgbox('', $lang['no_str_bar'], 'info');
			}
		}
		break;
	
//* Сообщества / Загрузка фото *//

	case "attach_groups":
		include ENGINE_DIR.'/modules/attach_groups.php';
	break;

//* Музыка *//

	case "audio":
		if($config['audio_mod'] == 'yes')
			include ENGINE_DIR.'/modules/audio.php';
		else {
			$spBar = true;
			$user_speedbar = 'Информация';
			msgbox('', 'Сервис отключен.', 'info');
		}
	break;
	//Плеер в окне
	case "audio_player":
		if($config['audio_mod'] == 'yes')
			include ENGINE_DIR.'/modules/audio_player.php';
		else {
			$spBar = true;
			$user_speedbar = 'Информация';
			msgbox('', 'Сервис отключен.', 'info');
		}
	break;
//* Статические страницы *//

	case "static":
		include ENGINE_DIR.'/modules/static.php';
	break;

//* Выделить человека на фото *//

	case "distinguish":
		include ENGINE_DIR.'/modules/distinguish.php';
	break;

//* Скрываем блок дни рожденья друзей *//
	
	case "happy_friends_block_hide":
		$_SESSION['happy_friends_block_hide'] = 1;
		die();
	break;

//* Скрываем блок дни рожденья друзей *//

	case "fast_search":
		include ENGINE_DIR.'/modules/fast_search.php';
	break;

//* RK *//

	case "robokassa":
		include ENGINE_DIR.'/modules/robokassa.php';
	break;

//* Жалобы *//

	case "report":
		include ENGINE_DIR.'/modules/report.php';
	break;

//* Отправка записи в сообщество или другу *//

	case "repost":
		include ENGINE_DIR.'/modules/repost.php';
	break;

//* Моментальные оповещания *//

	case "updates":
		include ENGINE_DIR.'/modules/updates.php';
	break;

//* Документы *//

	case "doc":
		include ENGINE_DIR.'/modules/doc.php';
	break;

//* Опросы *//

	case "votes":
		include ENGINE_DIR.'/modules/votes.php';
	break;
	
//* Сообщества / Публичные страницы / Аудиозаписи *//

	case "public_audio":
		include ENGINE_DIR.'/modules/public_audio.php';
	break;
	
//Сообщества / Публичные страницы / Обсуждения *//

	case "groups_forum":
		include ENGINE_DIR.'/modules/groups_forum.php';
	break;
	
//* Комментарии к прикприпленным фото *//

	case "attach_comm":
		include ENGINE_DIR.'/modules/attach_comm.php';
	break;

	//О сайте
 case "about":
  
  include ENGINE_DIR.'/modules/about.php';
 break;
	
//* Фоторедактор *//

	case "photo_editor":
		include ENGINE_DIR.'/modules/photo_editor.php';
	break;

//* Мои соц. сети *//

	case "social":
		include ENGINE_DIR.'/modules/social.php';
	break;

//Приложения
	case "apps":
		include ENGINE_DIR.'/modules/apps/apps.php';
	break;
	
	case "editapp":
		include ENGINE_DIR.'/modules/apps/editapp.php';
	break;

//* Плеер *//

	case "audio_player":
		include ENGINE_DIR.'/modules/audio_player.php';
	break;

//* Рейтинг *//

	case "rating":
		include ENGINE_DIR.'/modules/rating.php';
	break;

//* Баннеры *//

	case "banners":
		
		$id = intval($_POST['id']);
		
		if($id > 0 AND $id <= 14){
			
			$_SESSION['banner'.$id] = 1;
			
		}
		
	break;

//* Розыгрыши *//

	case "nonsense":
		include ENGINE_DIR.'/modules/nonsense.php';
	break;

//* Начисление mix За переход по рекламе *//

	case "bonus":
		
		if($logged){
		
			$user_id = $user_info['user_id'];
			
			$url = $_GET['url'];
			
			$url = str_replace('>', '', $url);
			$url = str_replace('<', '', $url);
			$url = str_replace(';', '', $url);
			$url = str_replace('"', '', $url);
			$url = str_replace("'", '', $url);
			$url = str_replace("(", '', $url);
			$url = str_replace(")", '', $url);
			
//* Выводим все баннеры *//

			$sql_banners = $db->super_query("SELECT code FROM `".PREFIX."_banners`", 1);
			
			foreach($sql_banners as $row){
				
//* Проверка *//
				
				if(stripos($row['code'], '<a href="'.$url.'"') !== false){
					
					$cost .= 1;
					
				} else {
					
					$cost .= '';
					
				}
				
			}
			
//* Если пользователь реально клацнул на рекламу, то начисляем *//
			
			if($cost){
				
				$last_conver = mozg_cache("user_{$user_id}/banners") + 86400;
				
				if($last_conver < $server_time){
					
//* Начисляем *//
					
					$db->query("UPDATE `".PREFIX."_users` SET user_balance = user_balance + '{$config['banners_mix']}' WHERE user_id = '{$user_id}'");
					
					mozg_create_cache("user_{$user_id}/banners", $server_time);

				}
				
			}
			
			header("Location: {$url}");
		
		}
		
	break;

//* Обновление баланс 5 сек *//
	
	case "up_balance":
	
		NoAjaxQuery();
		
		echo '<b>'.deColNums($user_info['balance_rub']).' руб.</b><br /><b>'.deColNums($user_info['user_balance']).' mix</b>';
		
		exit();
		
	break;

//* Переводчик *//
	
	case "tranlsate":
		include ENGINE_DIR.'/modules/tranlsate.php';
	break;

//* Фото дуэли *//
	   
    case "compare" : 
        include ENGINE_DIR . '/modules/compare.php'; 
    break;
	
//* Реклама баннеры *//

	case "mybanners":
		include ENGINE_DIR.'/modules/mybanners.php';
	break;

//* Выбор языка *//
	
	case "lang":
		include ENGINE_DIR.'/modules/lang.php';
	break;

//* Сообщества / Публичные страницы / Видеозаписи *//

	case "public_videos":
		include ENGINE_DIR.'/modules/public_videos.php';
	break;

		default:
			$spBar = true;
			
			if($go != 'main')
					msgbox('', $lang['no_str_bar'], 'info');
}

if(!$metatags['title'])
	$metatags['title'] = $config['home'];
	
if($user_speedbar) 
	$speedbar = $user_speedbar;
else 
	$speedbar = $lang['welcome'];

$headers = '<title>'.$metatags['title'].'</title>
<meta name="generator" content="MixNet Engine" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
?>
