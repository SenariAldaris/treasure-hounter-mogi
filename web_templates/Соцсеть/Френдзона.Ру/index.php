<?php
if(isset($_POST["PHPSESSID"])){
	session_id($_POST["PHPSESSID"]);
}
@session_start();
@ob_start();
@ob_implicit_flush(0);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

define('MOZG', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/system');

header('Content-type: text/html; charset=utf-8');

//* AJAX *//

$ajax = $_POST['ajax'];

$logged = false;
$user_info = false;

include ENGINE_DIR.'/init.php';
$randjs=rand();
$tpl->set('{randjs}', $randjs);
//* Если юзер перешел по реф ссылке, то добавляем ID реферала в сессию *//

if($_GET['reg']) set_cookie('ref_id', intval($_GET['reg']));

//* Определения браузера *//

if(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) $xBrowser = 'ie6';
elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) $xBrowser = 'ie7';
elseif(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) $xBrowser = 'ie8';
if($xBrowser == 'ie6' OR $xBrowser == 'ie7' OR $xBrowser == 'ie8')
	header("Location: /badbrowser.php");

//* Загружаем кол-во новых новостей *//

$CacheNews = mozg_cache('user_'.$user_info['user_id'].'/new_news');
if($CacheNews){
	$new_news = "<div class=\"ic_newAct\">{$CacheNews}</div>";
	$news_link = '/notifications';
}

//* Загружаем кол-во новых подарков *//

$CacheGifts = mozg_cache('user_'.$user_info['user_id'].'/new_gifts');
if($CacheGifts){
	$new_gifts = "<div class=\"ic_newAct\">{$CacheGifts}</div>";
}

//* Загружаем кол-во новых подарков *//

$CacheGift = mozg_cache("user_{$user_info['user_id']}/new_gift");
if($CacheGift){
	$new_ubm = "<div class=\"ic_newAct\">{$CacheGift}</div>";
	$gifts_link = "/gifts{$user_info['user_id']}?new=1";
} else
	$gifts_link = '/balance';

//* Новые сообщения *//

$user_pm_num = $user_info['user_pm_num'];
if($user_pm_num)
	$user_pm_num = "<div class=\"bls_mess\" id=\"new_msg\"><div class=\"ic_newActq\">+{$user_pm_num}</div></div>";
else
	$user_pm_num = '';
	
//* Тех-поддержке +1 *//

 $supports = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_support` WHERE sfor_user_id");
 $agent = ($user_info['user_group'] == '4');

 if($supports == $agent){
 $supports_owner = "<div class=\"ic_newAct\">{$supports['cnt']}</div>";
 }
 if($supports['cnt'] == 0){
 $supports_owner = '';
 }	
				if($user_info['user_vip']==1) 
			$tpl->set('{vip_status}','<div class="textvip"><div class="img_vip"></div>vip</div>');
		   else $tpl->set('{vip_status}', '');
	
	if($logged){

     if($user_info['user_photo'])

          $ava = $config['home_url'].'uploads/users/'.$user_info['user_id'].'/'.$user_info['user_photo'];

     else

          $ava = '/templates/Old/images/no_ava_200.jpg';

     $myphoto_header.='<img src="'.$ava.'"  id="avatar" class="ava_style" />'."\n";

     $tpl->set('{myphoto_headser}', $myphoto_header);


     $tpl->load_template('main.tpl');

}	if($logged){

     if($user_info['user_photo'])

          $ava = $config['home_url'].'uploads/users/'.$user_info['user_id'].'/100_'.$user_info['user_photo'];

     else

          $ava = '/templates/Old/images/no_ava_100.jpg';

     $myphoto_header.='<img src="'.$ava.'"  id="avatar" class="ava_style" />'."\n";

     $tpl->set('{myphoto_load}', $myphoto_header);
     $tpl->load_template('main.tpl');

}
		
//* Новые друзья *//

$user_friends_demands = $user_info['user_friends_demands'];
if($user_friends_demands){
	$demands = "<div class=\"ic_newAct\">+{$user_friends_demands}</div>";
	$requests_link = '/requests';
} else
	$demands = '';
	
//* ТП *//

$user_support = $user_info['user_support'];
if($user_support)
	$support = "<div class=\"ic_newAct\">{$user_support}</div>";
else
	$support = '';
	
//* Отметки на фото *//

if($user_info['user_new_mark_photos']){
	$new_photos_link = 'newphotos';
	$new_photos = "<div class=\"ic_newAct\">".$user_info['user_new_mark_photos']."</div>";
} else {
	$new_photos = '';
	$new_photos_link = $user_info['user_id'];
}

//* Приглашения в сообщества *//

if($user_info['invties_pub_num']){
	
	$new_groups = "<div class=\"ic_newAct\">".$user_info['invties_pub_num']."</div>";;
	$new_groups_lnk = '/groups?act=invites';

} else {
	
	$new_groups = '';
	$new_groups_lnk = '/groups';
	
}

//* Если включен AJAX то загружаем стр *//

if($ajax == 'yes'){
	
	$speedbar = addslashes($speedbar);
	
//* Если есть POST Запрос и значение AJAX, а $ajax не равняется "yes" то не пропускаем *//
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' AND $ajax != 'yes')
		die('Неизвестная ошибка');

	if($spBar)
		$ajaxSpBar = "$('#speedbar').show().html('{$speedbar}')";
	else
		$ajaxSpBar = "$('#speedbar').hide()";


	$result_ajax = <<<HTML
<script type="text/javascript">
document.title = '{$metatags['title']}';
{$ajaxSpBar};
$('#new_requests').html('{$demands}');
document.getElementById('new_msg').innerHTML = '{$user_pm_num}';
document.getElementById('new_gifts').innerHTML = '{$new_gifts}';
document.getElementById('new_news').innerHTML = '{$new_news}';
document.getElementById('new_ubm').innerHTML = '{$new_ubm}';
document.getElementById('ubm_link').setAttribute('href', '{$gifts_link}');
document.getElementById('new_support').innerHTML = '{$support}';
document.getElementById('news_link').setAttribute('href', '/news{$news_link}');
document.getElementById('new_photos').innerHTML = '{$new_photos}';
document.getElementById('requests_link_new_photos').setAttribute('href', '/albums/{$new_photos_link}');
document.getElementById('new_support_owner').innerHTML = '${$supports_owner}';
$('#upBal').html('{$rur}');
$('#new_groups').html('{$new_groups}');
$('#new_groups_lnk').attr('href', '{$new_groups_lnk}');
</script>
{$tpl->result['info']}{$tpl->result['content']}
HTML;
	echo str_replace('{theme}', '/templates/'.$config['temp'], $result_ajax);

	$tpl->global_clear();
	$db->close();

	if($config['gzip'] == 'yes')
		GzipOut();
		
	die();
} 

//* Если обращение к модулю регистрации или главной и юзер не авторизован то показываем регистрацию *//

if($go == 'main' AND !$logged)
	include ENGINE_DIR.'/modules/register_main.php';

$tpl->load_template('main.tpl');

//* Тех-поддержке +1 *//

 if($supports)
 $tpl->set('{supports-owner}', $supports_owner);
 else
 $tpl->set('{supports-owner}', '');

//* Если юзер залогинен *//

if($logged){
	$tpl->set_block("'\\[not-logged\\](.*?)\\[/not-logged\\]'si","");
	$tpl->set('[logged]','');
	$tpl->set('[/logged]','');

	$check_short_link = $db->super_query("SELECT `short_link` FROM `" . PREFIX . "_users` WHERE `user_id` = " . $user_info['user_id']);
	if ($check_short_link['short_link'] != null && $check_short_link['short_link'] != 'empty') {
		$tpl->set('{my-page-link}', '/'.$check_short_link['short_link']);
	} else {
		$tpl->set('{my-page-link}', '/u'.$user_info['user_id']);
	}

	$tpl->set('{my-id}', $user_info['user_id']);
	
//* Подгрузка фона *//
	
$row_fon = $db->super_query("SELECT user_img_fon FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");
  if($row_fon['user_img_fon']){
   $tpl->set('{fon_facemy}', $row_fon['user_img_fon']); 
  } else {      
   $tpl->set('{fon_facemy}', '{theme}/images/lot.jpg');
  }
	
//* Заявки в друзья *//
	
	$user_friends_demands = $user_info['user_friends_demands'];
	if($user_friends_demands){
		$tpl->set('{demands}', $demands);
		$tpl->set('{requests-link}', $requests_link);
	} else {
		$tpl->set('{demands}', '');
		$tpl->set('{requests-link}', '');
	}
	
//* Новости *//
	
	if($CacheNews){
		$tpl->set('{new-news}', $new_news);
		$tpl->set('{news-link}', $news_link);
	} else {
		$tpl->set('{new-news}', '');
		$tpl->set('{news-link}', '');
	}
	
//* Сообщения *//
	
	if($user_pm_num)
		$tpl->set('{msg}', $user_pm_num);
	else 
		$tpl->set('{msg}', '');
	
//* Поддержка *//
	
	if($user_support)
		$tpl->set('{new-support}', $support);
	else 
		$tpl->set('{new-support}', '');
	
//* Отметки на фото *//
	
	if($user_info['user_new_mark_photos']){
		$tpl->set('{my-id}', 'newphotos');
		$tpl->set('{new_photos}', $new_photos);
	} else 
		$tpl->set('{new_photos}', '');

//* UBM *//
	
	if($CacheGift){
		$tpl->set('{new-ubm}', $new_ubm);
		$tpl->set('{ubm-link}', $gifts_link);
	} else {
		$tpl->set('{new-ubm}', '');
		$tpl->set('{ubm-link}', $gifts_link);
	}

//* Подарки *//
	
	if($CacheGifts)
		$tpl->set('{new-gifts}', $new_gifts);
	else
		$tpl->set('{new-gifts}', '');
	
//* Приглашения в сообщества *//
	
	if($user_info['invties_pub_num']){
		
		$tpl->set('{groups-link}', $new_groups_lnk);
		$tpl->set('{new_groups}', $new_groups);
		
	} else {
		
		$tpl->set('{groups-link}', $new_groups_lnk);
		$tpl->set('{new_groups}', '');
		
	}

} else {
	$tpl->set_block("'\\[logged\\](.*?)\\[/logged\\]'si","");
	$tpl->set('[not-logged]','');
	$tpl->set('[/not-logged]','');
	$tpl->set('{my-page-link}', '');
}

$tpl->set('{header}', $headers);
$tpl->set('{speedbar}', $speedbar);
$tpl->set('{mobile-speedbar}', $mobile_speedbar);
$tpl->set('{info}', $tpl->result['info']);
						
//* Fon www.vxas.ru *//
						 
   if($user_id = $id){
    $user_img_fon = $db->super_query("SELECT user_img_fon FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
    if($user_img_fon['user_img_fon']){
      $img = $user_img_fon['user_img_fon'];
     }else{
      $img = '{theme}/images/eQjYYhV0xFI.jpg';
     }
         $tpl->set('{url_img}', '<style type="text/css" media="all">html, body{background: url('.$img.') repeat 0 0 fixed;margin:0px;padding:0px;font-size:11px;}</style>');
   } else {
    $user_img_fon = $db->super_query("SELECT user_img_fon FROM `".PREFIX."_users` WHERE user_id = '{$user_info['user_id']}'");
     if($user_img_fon['user_img_fon']){
      $img = $user_img_fon['user_img_fon'];
     }else{
      $img = '{theme}/images/eQjYYhV0xFI.jpg';
     }
     $tpl->set('{url_img}', '<style type="text/css" media="all">html, body{background: url('.$img.') repeat 0 0 fixed;margin:0px;padding:0px;font-size:11px;}</style>');
   }	
   
//* Статус *//
			
			$expStatus = explode('<audio', $user_info['user_status']);

			if($expStatus[1] AND $row_online['user_last_visit'] <= $online_time){
				
				$user_info['user_status'] = '';
				$expStatus[1] = '';
				
			}
			
			if($expStatus[1]){
			
				$tpl->set('{status-text}', stripslashes($expStatus[0]));
				$tpl->set('{val-status-text}', strip_tags(stripslashes($expStatus[0])));
				$tpl->set('[player-link]', '');
				$tpl->set('[/player-link]', '');
				$tpl->set('{aid-profile}', $expStatus[1]);
				
			} else {
				
				$tpl->set('{status-text-profile}', stripslashes($user_info['user_status']));
				$tpl->set('{val-status-text-profile}', strip_tags(stripslashes($user_info['user_status'])));
				$tpl->set_block("'\\[player-link\\](.*?)\\[/player-link\\]'si","");
				
			}
   			if($user_info['user_status']){
				$tpl->set('[status]', '');
				$tpl->set('[/status]', '');
				$tpl->set_block("'\\[no-status\\](.*?)\\[/no-status\\]'si","");
			} else {
				$tpl->set_block("'\\[status\\](.*?)\\[/status\\]'si","");
				$tpl->set('[no-status]', '');
				$tpl->set('[/no-status]', '');
			}
			
			
//* FOR MOBILE VERSION 1.0 *//

if($config['temp'] == 'mobile'){

	$tpl->result['content'] = str_replace('onClick="Page.Go(this.href); return false"', '', $tpl->result['content']);
	
	if($user_info['user_status'])
		$tpl->set('{status-mobile}', '<span style="font-size:11px;color:#000">'.$user_info['user_status'].'</span>');
	else
		$tpl->set('{status-mobile}', '<span style="font-size:11px;color:#999">установить статус</span>');
	
	$new_actions = $user_friends_demands+$user_support+$CacheNews+$CacheGift+$user_info['user_pm_num'];

	if($new_actions)
		$tpl->set('{new-actions}', "<div class=\"ic_newAct\">+{$new_actions}</div>");
	else
		$tpl->set('{new-actions}', "");
	
}

$tpl->set('{content}', $tpl->result['content']);



if($spBar)
	$tpl->set_block("'\\[speedbar\\](.*?)\\[/speedbar\\]'si","");
else {
	$tpl->set('[speedbar]','');
	$tpl->set('[/speedbar]','');
}

//* BUILD JS *//

	if($logged)
$tpl->set('{js}', '<script type="text/javascript" src="{theme}/js/jquery.lib.js"></script>
<script type="text/javascript" src="{theme}/js/'.$checkLang.'/lang.js"></script>
<script type="text/javascript" src="{theme}/js/profile.js"></script>
<script type="text/javascript" src="{theme}/js/main.js"></script>');
	else
$tpl->set('{js}', '<script type="text/javascript" src="{theme}/js/jquery.lib.js"></script>
<script type="text/javascript" src="{theme}/js/'.$checkLang.'/lang.js"></script>
<script type="text/javascript" src="{theme}/js/main.js"></script>');

//* FOR MOBILE VERSION 1.0 *//

if($user_info['user_photo']) $tpl->set('{my-ava}', "/uploads/users/{$user_info['user_id']}/50_{$user_info['user_photo']}");
else $tpl->set('{my-ava}', "{theme}/images/no_ava_50.png");
$tpl->set('{my-name}', $user_info['user_search_pref']);

if($check_smartphone) $tpl->set('{mobile-link}', '<a href="/index.php?act=change_mobile">мобильная версия</a>');
else $tpl->set('{mobile-link}', '');

if($_SESSION['skin'])
	$tpl->set('{design}', 'перейти на новый дизайн');
else
	$tpl->set('{design}', 'перейти на старый дизайн');

//* Баннеры *//

$tpl->set('{banner-top}', '');
$tpl->set('{banner-bottom}', '');
$tpl->set('{banner-right-1}', '');
$tpl->set('{banner-right-2}', '');
$tpl->set('{banner-right-3}', '');
		
if($logged){

if($user_info['banner_cat']){
	
	$banner_cat = "AND cat = '{$user_info['banner_cat']}'";
	
}

$sql_banners = $db->super_query("SELECT id, user_id, pos, img, title, descr, link FROM `".PREFIX."_users_banners` WHERE approve = '0' {$banner_cat}", 1);

foreach($sql_banners as $rowB){

	$rowB['title'] = stripslashes($rowB['title']);
	$rowB['descr'] = stripslashes($rowB['descr']);
	
	if($rowB['pos'] == 1){
		
		$tpl->set('{banner-top}', '<a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')"><img src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'" style="width:1020px;height:150px;margin-top:-10px;margin-left:5px;" title="'.$rowB['title'].' - '.$rowB['descr'].'" /></a>');
		
	} elseif($rowB['pos'] == 2){
		
		$tpl->set('{banner-bottom}', '<a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')"><img width="560" height="175" src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'"></a>');


} elseif($rowB['pos'] == 3 AND !$_SESSION['banner13']){
		
		$tpl->set('{banner-right-1}', '<div class="ads_view"><div class="ads_close" onclick="ads_close();"></div>
<h4 class="title_obshenie"><a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')">'.$rowB['title'].'</a></h4>
<a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')"><div class="ads_imgs_rekl"><img width="65" height="90" src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'"/></div></a>
<div class="ads_description" style="word-wrap: break-word;">'.$rowB['descr'].'</div><div style="margin-top:3px;"></div>
<div class="more_div"></div>
</div>');
		
	} elseif($rowB['pos'] == 4 AND !$_SESSION['banner14']){
		
		$tpl->set('{banner-right-2}', '<div class="ads_view"><div class="ads_close" onclick="ads_close();"></div>
<h4 class="title_obshenie"><a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')">'.$rowB['title'].'</a></h4>
<a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')"><div class="ads_imgs_rekl"><img width="65" height="90" src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'"/></div></a>
<div class="ads_description" style="word-wrap: break-word;">'.$rowB['descr'].'</div><div style="margin-top:3px;"></div>
<div class="more_div"></div>
</div>');
		
	} elseif($rowB['pos'] == 5 AND !$_SESSION['banner15']){
		
		$tpl->set('{banner-right-3}', '<div class="ads_view"><div class="ads_close" onclick="ads_close();"></div>
<h4 class="title_obshenie"><a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')">'.$rowB['title'].'</a></h4>
<a href="'.$rowB['link'].'" target="_blank" onClick="recForBannerStat('.$rowB['id'].')"><div class="ads_imgs_rekl"><img width="65" height="90" src="/uploads/mybanners/'.$rowB['user_id'].'/ok/'.$rowB['img'].'"/></div></a>
<div class="ads_description" style="word-wrap: break-word;">'.$rowB['descr'].'</div><div style="margin-top:3px;"></div>
<div class="more_div"></div>
</div>');
		
	}
	
}

}

$tpl->set('{lang}', $rMyLang);

$tpl->compile('main');

echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);

$tpl->global_clear();
$db->close();

if($config['gzip'] == 'yes')
	GzipOut();
?>
