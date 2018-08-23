<?php

$link = 'webtomat?act=games&';

//* Раскомментировать ниже, если нет ЧПУ *// 

//* $Link = 'index.php?go=webtomat&act=games&'; *//

if(!defined('MOZG'))
    die('Hacking attempt!');

if($ajax == 'yes')
    NoAjaxQuery();

//* Файл с классом работы с базой данных и объявлением констант модуля *//	
	
require_once "wt_conf.php"; 

//* Основная часть модуля, обработка .tpl *//

require_once "wt_class.php";
$wt = new Wt();

function wt_getProfile ($uid){
    global $config;
    $query = "SELECT user_name,user_lastname,user_sex,user_birthday,user_photo FROM ".WEBTOMAT_PREF."users WHERE user_id='$uid'";
    WebTomat_Data::wt_mysql($query);
    $value = WebTomat_Data::wt_getrow();

    if ($value){
        $s_photo = $value['user_photo'] ? $config['home_url'].'uploads/users/'.$uid.'/50_'.$value['user_photo'] : 'http://static.apitech.ru/webtomat/jslib2/images/defaultPhoto.jpg';
        $b_photo = $value['user_photo'] ? $config['home_url'].'uploads/users/'.$uid.'/100_'.$value['user_photo'] : '';
        $arr = array (
            'first_name' => $value['user_name'],
            'last_name' => $value['user_lastname'],
            'uid' => $uid,
            'photo' => $s_photo,
            'photo_big' => $b_photo,
            'sex'=> $value['user_sex'] == 2 ? 1 : 2,
            'bdate'=> $value['user_birthday'],
            'profile'=> $config['home_url'].'u'.$uid
        );
        return $arr;
    }
}


//* Рассчитываем корневую директорию (требуется, если сайт лежит не в корне) *//

$wt_root_dir = explode('/',$_SERVER['PHP_SELF']);
array_pop($wt_root_dir);
$wt_root_dir = implode('/',$wt_root_dir).'/';
$wt_link = ($_SERVER['REDIRECT_URL']) ? $_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL'] : $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$wt_link = ($_SERVER['HTTPS']) ? 'https://'.$wt_link : 'http://'.$wt_link;
$wt_link = strpos($wt_link,"?") !== false ? $wt_link.'&act=games':$wt_link.'?act=games';

$uid 		= $_REQUEST['uid']?$_REQUEST['uid']:$_REQUEST['user_id'];
$token		= $_REQUEST['token']?$_REQUEST['token']:$_REQUEST['access_token'];


//* Проверяем, указан ли в настройках webID, если нет - выводим ошибку *//

if ( !isset($wt_webid) or empty($wt_webid) ) {
    echo '<div style="width:200px;height:20px;margin:100px auto;font-weight:bold;color:red">'.$wt_lang['wt_no_installed'].'.</div>';
} 
else if ($uid and $token){
    $method 	= $_REQUEST['method'];
    $uids	 	= $_REQUEST['uids'];
    $uid 		= $_REQUEST['uid']?$_REQUEST['uid']:$_REQUEST['user_id'];
    $user_id    = $_REQUEST['user_id'];
    $token		= $_REQUEST['token']?$_REQUEST['token']:$_REQUEST['access_token'];
    $apiid		= $_REQUEST['api_id'];
    $method		= $_REQUEST['method'];
    $image		= $_REQUEST['app_img'];
    $name		= iconv('utf-8','utf-8',$_REQUEST['app_name']);
    $message	= iconv('utf-8','utf-8',$_REQUEST['message']);

    if((!$method and md5($uid.$wt_skey)!=$token) or ($method and md5($apiid.$user_id.$wt_skey)!=$token)){
        echo "{'error': 'Not valid token'}";
        exit();
    }

//* Получаем друзей пользователя *//	
	
    if ($method == 'getAppFriends'){
        $result_content = '<?xml version="1.0" encoding="UTF-8"?><response>';
        $query = "SELECT friend_id FROM ".WEBTOMAT_PREF."friends WHERE user_id='$uid'";
        WebTomat_Data::wt_mysql($query);

        while($value = WebTomat_Data::wt_getrow()){
            if ($value['friend_id']!=$uid) $result_content .= '<uid>'.$value['friend_id'].'</uid>';
        }
        $result_content .= '</response>';
    }
	
//* Получаем профили по уидс *//	
	
    else if ($method == 'getProfiles'){
        $users = explode(',', $uids);
        $result_content = '<?xml version="1.0" encoding="UTF-8"?><response>';
        foreach($users as $value ){
            $arr = wt_getProfile($value);
            $result_content .='<user>';
            foreach($arr as $key=>$value){
                $result_content .= '<'.$key.'>'.$value.'</'.$key.'>';
            }
            $result_content .='</user>';
        }
        $result_content .='</response>';
    }
    else if ($method == 'wallPost'){
	
//* Загружаем файл с изображением игры на сервер *//
		
        $copy_dir="uploads/webtomat/";
        if (!opendir($copy_dir)) mkdir($copy_dir);
        $img = preg_split("/\\//", $image);
        $img = preg_split("/\\?/", $img[count($img)-1]);
        $new_image = $copy_dir.$img[0];
		
//* Если нет такого файла, то копируем его *//		
		
        if (!opendir($new_image)){
            if (!copy($image,$new_image)) {
                echo "Unable to copy file...\n";
                $new_image='';
            }
        }

        require_once 'wt_message.php';
        $link = ($wt_load != 'AJAX') ? $wt_link.'&ingame='.$apiid : $wt_link.'#gameid='.$apiid;
        $block_img = $new_image ? str_replace('{img}', $new_image, $block_img) : '';
        $letter = str_replace('{block_img}', $block_img, $letter);
        $letter = str_replace('{link}', $link, $letter);
        $letter = str_replace('{name_link}', $name, $letter);
        $letter = str_replace('{text}', $message, $letter);

        $sql = "INSERT INTO ".WEBTOMAT_PREF."wall (data,val_wall,check_friend,tell_comm,attach,likes_users,fast_comm_id, fasts_num, author_user_id, likes_num, add_date,text,tell_uid,tell_date,public,for_user_id,type,user_id,cnt) VALUES ('','','','','','','0', '0', '$user_id', '0', '$server_time','$letter','0','0','0','$uid','','0','0')";
        WebTomat_Data::wt_mysql($sql);

        echo '<wallPost>'.$letter.'</wallPost>';
    }
    else {
        $arr = wt_getProfile($uid);
        $result_content ='{';
        $c=0;
        foreach($arr as $key=>$value){
            if ($c) $result_content .=',';
            $result_content .= '"'.$key.'":"'.$value.'"';
            $c++;
        }
        $result_content .='}';
    }

    echo iconv('utf-8','utf-8',$result_content);
    exit();

} 
else if (isset($wt_load) and $wt_load=='AJAX') {
    $tmp = preg_split("/_escaped_fragment_=/",$_SERVER['REQUEST_URI']);
	
//* Исключаем данные после амперсанда *//	
	
    if (isset($tmp[1]) && $tmp[1]) {$tmp1=preg_split("/&/",$tmp[1]);$tmp[1]=$tmp1[0];}
    $escaped_fragment = $tmp[1];
    if (isset($escaped_fragment)){
        $request = preg_split("/_/",$escaped_fragment);
        if (isset($request[2])) $request[1] = substr($escaped_fragment,strpos($escaped_fragment,'_')+1);
		
//* Индексация 2ой версии *//	
		
        if ($wt_version == '2'){
            if ($request[0] == 'gameid'){
                $wt_game = file_get_contents( WEBTOMAT_DIR .'/themes/gamebrd/wt_game.tpl');
                if ( $config['charset'] == "utf-8" ) $wt_game = iconv( "UTF-8", "utf-8", $wt_game );
                $wt_cont = $wt->wt_ingame2($wt_game,$request[1],'#!genre_');
            }
            else{
                $wt_board = file_get_contents( WEBTOMAT_DIR .'/themes/gamebrd/wt_board.tpl');
                if ( $config['charset'] == "utf-8" ) $wt_board = iconv( "UTF-8", "utf-8", $wt_board );

                if ($request[0] == 'genre')
                    $wt_cont = $wt->wt_gameboard($wt_board,$request[1],'#!gameid_','#!genre_');
                else
                    $wt_cont = $wt->wt_gameboard($wt_board,null,'#!gameid_','#!genre_');
            }

        }
		
//* Индексация 1ой версии *//		
		
        else {
            if ($request[0] == 'gameid'){
                $ingame = $request[1];
                $_REQUEST['ingame']=$ingame;
                $wt_cont = file_get_contents( WEBTOMAT_DIR .'/themes/Old/wt_ingame.tpl');
                if ( $config['charset'] == "utf-8" ) $wt_cont = iconv( "UTF-8", "utf-8", $wt_cont );
                $wt_cont = $wt->wt_ingame($wt_cont,$ingame);
            }
            else {
			
//* Жанр *//			
			
                if ($request[0] == 'genre' || $request[0] == 'cat' || $request[0] == 'tag'){
                    $wt_cont = file_get_contents( WEBTOMAT_DIR .'/themes/Old/wt_list.tpl');
                    if ( $config['charset'] == "utf-8" ) $wt_cont = iconv( "UTF-8", "utf-8", $wt_cont );
                    if ($request[0] == 'genre') $_REQUEST['ingenre'] = $request[1];
                    else if ($request[0] == 'cat') $_REQUEST['cat'] = $request[1];
                    else if ($request[0] == 'tag') $_REQUEST['intag'] = $request[1];
                }
				
//* Главная страница каталога *//				
				
                else {
                    if ($request[0] == 'a' && isset($request[1]) && $request[1] == 'tags') {
                        $_REQUEST['a'] = 'tags';
                    }
                    $wt_cont = file_get_contents( WEBTOMAT_DIR .'/themes/Old/wt_main.tpl');
                    if ( $config['charset'] == "utf-8" ) $wt_cont = iconv( "UTF-8", "utf-8", $wt_cont );
                    $a = ($_REQUEST['a']) ? $_REQUEST['a'] : 'main';
                    if (strpos ( $wt_cont, "[page=".$a ) !== false) {
                        $_REQUEST['a']='main';
                        $wt_cont = preg_replace ( "#\\[page=".$a."\\](.*?)\\[/page\\]#ies", "\$wt->".$a."('\\1')", $wt_cont );
                        $wt_cont = preg_replace ( "#\\[page=(.*?)\\](.*?)\\[/page\\]#ies", "", $wt_cont );
                    }
                }
            }
            if (strpos ( $wt_cont, "[cont=" ) !== false) $wt_cont = preg_replace ( "#\\[cont=(.*?)\\](.*?)\\[/cont\\]#ies", "\$wt->\\1('\\2')", $wt_cont );
			
//* $Wt->wt_reating(); *//

        }
		
//* Производим замену переменных в шаблоне *//
		
        $end_link = (strpos('?',$wt_link) != false) ? '&a=main' : '';
        $find = array('&ingame=','&ingenre=','&cat=','&intag=','&a=tags','{WTDIR}','{WTURLMAIN}','{WTMAIN}');
        $replace = array('#!gameid_','#!genre_','#!cat_','#!tag_','#!a_tags',$wt_root_dir.WEBTOMAT_DIR .'/',$wt_link,$wt_link,$wt_link);
        $wt_cont = str_replace($find,$replace,$wt_cont);
        $find = array('?ingame=','?ingenre=','?cat=','?intag=','?a=tags','{WTDIR}','{WTURLMAIN}','{WTMAIN}');
        $wt_cont = str_replace($find,$replace,$wt_cont);
        $find = array('ingame=','ingenre=','cat=','intag=','a=tags','{WTDIR}','{WTURLMAIN}','{WTMAIN}');
        $wt_cont = str_replace($find,$replace,$wt_cont);
        $wt_cont = str_replace('{WT_LOGIN}','',$wt_cont);
    }
    else {
        $wt_cont = file_get_contents( WEBTOMAT_DIR.'/js-catalog.php' );
        $wt_cont = str_replace('{RAND}',mt_rand(),$wt_cont);
        $wt_cont = str_replace('{WEBID}',$wt_webid,$wt_cont);
        $wt_cont = str_replace('{VERSION}',$wt_version,$wt_cont);
        $buf='';
        if ($wt_mainpage) $buf.="&mainpage=".$wt_mainpage;
        if ($wt_theme) $buf.="&background=".$wt_theme;
        if ($wt_window) $buf.="&window=popup";
        if ($wt_skey) $buf.="&auth=1";
        if ($wt_logo) $buf.="&nologo=1";
        if ($wt_cache) $buf.="&nocache=true";
        $wt_cont = str_replace('{params}',$buf,$wt_cont);

    }

} 
else {

//* Обработка данных, полученных через $_REQUEST и создание соответствующих переменных *//
	
    $a          = $wt->globper('a');
    $ingenre    = $wt->globper('ingenre');
    $intag      = $wt->globper('intag');
    $ingame     = $wt->globper('ingame');
    $cat        = $wt->globper('cat');
    $search     = $wt->globper('search');
    $p          = $wt->globper('p');
    $rate       = $wt->globper('rate');
    $wt_ajax    = $wt->globper('wt_ajax');
    $wt_id      = $wt->globper('wt_id');
    $wtid       = $wt->globper('wtid');

//* Принимаем AJAX с id пользователя и передаем его на запись в сессию *//
	
    if ( isset($wt_ajax) and isset($wtid) ){	

        exit($wt->wt_sessWtId($wtid));

    }
	
//* Принимаем AJAX с голосом и ID игры, передаем на проверку и запись в базу данных	*//
	
    elseif ( isset($rate) and isset($ingame) ) {	

        exit($wt->wt_rate($rate,$ingame,$wt_id));

    }
	
//* Обработка страницы с игрой *//	
	
    elseif ( isset( $ingame ) ) { 

        $ingame = $data->wt_safesql( $wt->globper('ingame') );
        $wt_cont = file_get_contents( WEBTOMAT_DIR .'/themes/Old/wt_ingame.tpl');
        if ( $config['charset'] == "utf-8" ) $wt_cont = iconv( "UTF-8", "utf-8", $wt_cont );

        $wt_cont = $wt->wt_ingame($wt_cont,$ingame);

//* Обработка страниц с выводом списка игр *//		
		
    } elseif ( isset( $ingenre ) or isset( $cat ) or isset( $search ) or isset( $p ) or isset( $intag ) ) {	

        $wt_cont = file_get_contents( WEBTOMAT_DIR .'/themes/Old/wt_list.tpl');
        if ( $config['charset'] == "utf-8" ) $wt_cont = iconv( "UTF-8", "utf-8", $wt_cont );

//* Если запрос пришел через AJAX, готовим на вывод только список игр *//		
		
        if ( isset($wt_ajax) ) {		

            if (strpos ( $wt_cont, "[cont=wt_gameblock]" ) !== false)
                preg_match("#\\[cont=wt_gameblock\\](.*?)\\[/cont\\]#ies", $wt_cont, $matches);
            $wt_cont = $wt->wt_gameblock($matches[1]);

        }
    }
	
//* Обработка главной страницы и страницы "все теги" *//	
	
    else {	
        $wt_cont = file_get_contents( WEBTOMAT_DIR .'/themes/Old/wt_main.tpl');
        if ( $config['charset'] == "utf-8" ) $wt_cont = iconv( "UTF-8", "utf-8", $wt_cont );
        if (!$a) $a='main';
        $_REQUEST['a']='main';
        if (strpos ( $wt_cont, "[page=".$a ) !== false) {
            $wt_cont = preg_replace ( "#\\[page=".$a."\\](.*?)\\[/page\\]#ies", "\$wt->".$a."('\\1')", $wt_cont );
            $wt_cont = preg_replace ( "#\\[page=(.*?)\\](.*?)\\[/page\\]#ies", "", $wt_cont );
        }


    }

    if (strpos ( $wt_cont, "[cont=" ) !== false)
        $wt_cont = preg_replace ( "#\\[cont=(.*?)\\](.*?)\\[/cont\\]#ies", "\$wt->\\1('\\2')", $wt_cont );

//* Производим замену переменных в шаблоне *//
	
    if (!$wt_skey) {
        $auth = file_get_contents( WEBTOMAT_DIR.'/themes/Old/wt_login.tpl' );
        if ( $config['charset'] == "utf-8" ) $auth  = iconv( "UTF-8", "utf-8", $auth  );
        $wt_cont = str_replace('{WT_LOGIN}',$auth,$wt_cont);
    }
    $find = array(
        '{WTDIR}','{WTMAIN}','{WTURLMAIN}','{WTURLCALL}'
    );
    $mainlink = substr($link,0,strlen($link)-1);
    if (substr($link,strlen($link)-1,strlen($link)) == '&') $mainlink.='&a=main';
    $replace = array(
        $wt_root_dir.WEBTOMAT_DIR .'/',$wt_root_dir.$mainlink,$wt_root_dir.$link,urlencode("http://".$_SERVER['SERVER_NAME'].$wt_root_dir.WEBTOMAT_DIR.'/ulogin_xd.html')
    );

    $wt_cont = str_replace($find,$replace,$wt_cont);

//* Если запрос пришел GET-методом - отдаем контент CMS, если AJAX - прекращаем работу скрипта и отвечаем клиенту *//
	
    if ( isset($wt_ajax) ){
		header("Content-Type: text/html; charset=utf-8");
        if ( $config['charset'] != "utf-8") $wt_cont = iconv( "UTF-8","utf-8", $wt_cont );
        exit($wt_cont);
    }

    $metatags['header_title']   = $wt->wt_meta('title');

}
$auth = '';

//* Авторизация через cms *//

if ($wt_skey){
    $auth = file_get_contents( WEBTOMAT_DIR.'/js-auth.php' );
    if ( $config['charset'] == "utf-8" ) $auth  = iconv( "UTF-8", "utf-8", $auth  );
    $auth = str_replace('{webid}',$wt_webid,$auth);
    $user_id = $user_info['user_id'];
    if (isset($user_id) && $user_id) {
        $auth = str_replace('{uid}',$user_id,$auth);
        $auth = str_replace('{token}',"'".md5($user_id.$wt_skey)."'",$auth);
    }
    $auth = str_replace('{uid}','null',$auth);
    $auth = str_replace('{token}','null',$auth);
    if ($wt_load == 'AJAX'){
        $auth = str_replace('{fready_begin}','window.wt_tomatReady = function(){',$auth);
        $auth = str_replace('{fready_end}','}',$auth);
        $auth = str_replace('{script}','',$auth);
    }
    else {
        $auth = str_replace('{fready_begin}','',$auth);
        $auth = str_replace('{fready_end}','',$auth);
        $auth = str_replace('{script}','<script id="wt_custom_api" type="text/javascript" src="http://static.apitech.ru/webtomat/api/api.js"> </script>',$auth);
    }
}
$wt_cont = str_replace('{WT_LOGIN}','',$wt_cont);
$wt_cont=$auth.$wt_cont;

$tpl->load_template('webtomat/catalog.tpl');
$tpl->set('{catalog}',$wt_cont);
$tpl->compile('content');
$tpl->clear();
$db->free();


?>