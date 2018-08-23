<?php
/* 
	Appointment: Основные функции админ панели
	File: functions.php 
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

function totranslit($var, $lower = true, $punkt = true) {
	global $langtranslit;
	
	if ( is_array($var) ) return "";

	if (!is_array ( $langtranslit ) OR !count( $langtranslit ) ) {

		$langtranslit = array(
		'а' => 'a', 'б' => 'b', 'в' => 'v',
		'г' => 'g', 'д' => 'd', 'е' => 'e',
		'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
		'и' => 'i', 'й' => 'y', 'к' => 'k',
		'л' => 'l', 'м' => 'm', 'н' => 'n',
		'о' => 'o', 'п' => 'p', 'р' => 'r',
		'с' => 's', 'т' => 't', 'у' => 'u',
		'ф' => 'f', 'х' => 'h', 'ц' => 'c',
		'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
		'ь' => '', 'ы' => 'y', 'ъ' => '',
		'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
		"ї" => "yi", "є" => "ye",
		
		'А' => 'A', 'Б' => 'B', 'В' => 'V',
		'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
		'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
		'И' => 'I', 'Й' => 'Y', 'К' => 'K',
		'Л' => 'L', 'М' => 'M', 'Н' => 'N',
		'О' => 'O', 'П' => 'P', 'Р' => 'R',
		'С' => 'S', 'Т' => 'T', 'У' => 'U',
		'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
		'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
		'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
		'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
		"Ї" => "yi", "Є" => "ye",
		);

	}
	
	$var = str_replace( ".php", "", $var );
	$var = trim( strip_tags( $var ) );
	$var = preg_replace( "/\s+/ms", "-", $var );

	$var = strtr($var, $langtranslit);
	
	if ( $punkt ) $var = preg_replace( "/[^a-z0-9\_\-.]+/mi", "", $var );
	else $var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

	$var = preg_replace( '#[\-]+#i', '-', $var );

	if ( $lower ) $var = strtolower( $var );
	
	if( strlen( $var ) > 200 ) {
		
		$var = substr( $var, 0, 200 );
		
		if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );
	
	}
	
	return $var;
}
function GetVar($v) {
	if(ini_get('magic_quotes_gpc'))
		return stripslashes($v) ;
	return $v;
} 
function strip_data($text) {
	$quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "'", ",", "/", ";", ":", "@", "[", "]", "{", "}", "=", ")", "(", "*", "&", "^", "%", "$", "<", ">", "?", "!", '"' );
	$goodquotes = array ("-", "+", "#" );
	$repquotes = array ("\-", "\+", "\#" );
	$text = stripslashes( $text );
	$text = trim( strip_tags( $text ) );
	$text = str_replace( $quotes, '', $text );
	$text = str_replace( $goodquotes, $repquotes, $text );
	return $text;
}
function clean_url($url) {
	if( $url == '' ) return;
	
	$url = str_replace( "http://", "", strtolower( $url ) );
	$url = str_replace( "https://", "", $url );
	if( substr( $url, 0, 4 ) == 'www.' ) $url = substr( $url, 4 );
	$url = explode( '/', $url );
	$url = reset( $url );
	$url = explode( ':', $url );
	$url = reset( $url );
	
	return $url;
}

$domain_cookie = explode (".", clean_url( $_SERVER['HTTP_HOST'] ));
$domain_cookie_count = count($domain_cookie);
$domain_allow_count = -2;

if($domain_cookie_count > 2){

	if(in_array($domain_cookie[$domain_cookie_count-2], array('com', 'net', 'org') )) 
		$domain_allow_count = -3;
		
	if($domain_cookie[$domain_cookie_count-1] == 'ua' ) 
		$domain_allow_count = -3;
		
	$domain_cookie = array_slice($domain_cookie, $domain_allow_count);
}

$domain_cookie = ".".implode(".", $domain_cookie);

define('DOMAIN', $domain_cookie);

function set_cookie($name, $value, $expires) {
	
	if( $expires ) {
		
		$expires = time() + ($expires * 86400);
	
	} else {
		
		$expires = FALSE;
	
	}
	
	if( PHP_VERSION < 5.2 ) {
		
		setcookie($name, $value, $expires, "/", DOMAIN . "; HttpOnly");
	
	} else {
		
		setcookie($name, $value, $expires, "/", DOMAIN, NULL, TRUE);
	
	}
}
function check_xss() {
	
	$url = html_entity_decode( urldecode( $_SERVER['QUERY_STRING'] ) );
	
	if( $url ) {
		
		if( (strpos( $url, '<' ) !== false) || (strpos( $url, '>' ) !== false) || (strpos( $url, '"' ) !== false) || (strpos( $url, './' ) !== false) || (strpos( $url, '../' ) !== false) || (strpos( $url, '\'' ) !== false) || (strpos( $url, '.php' ) !== false) ) {
			die('Hacking attempt!');
		}
	
	}
	
	$url = html_entity_decode( urldecode( $_SERVER['REQUEST_URI'] ) );
	
	if( $url ) {
		
		if( (strpos( $url, '<' ) !== false) || (strpos( $url, '>' ) !== false) || (strpos( $url, '"' ) !== false) || (strpos( $url, '\'' ) !== false) ) {
			die('Hacking attempt!');
		}
	
	}

}
function langdate($format, $stamp){
	global $langdate;
	return strtr(@date($format, $stamp), $langdate);
}
function navigation($gc, $num, $type){
	$page = ( isset( $_GET['page'] )&& !empty( $_GET['page'] ) ) ? intval( $_GET['page'] ) : 1;
	$gcount = $gc;
	$cnt = $num;
	$items_count = $cnt;
	$items_per_page = $gcount;
	$page_refers_per_page = 5;
	$pages = '';		
	$pages_count = ( ( $items_count % $items_per_page != 0 ) ) ? floor( $items_count / $items_per_page ) + 1 : floor( $items_count / $items_per_page );
	$start_page = ( $page - $page_refers_per_page <= 0  ) ? 1 : $page - $page_refers_per_page + 1;
	$page_refers_per_page_count = ( ( $page - $page_refers_per_page < 0 ) ? $page : $page_refers_per_page ) + ( ( $page + $page_refers_per_page > $pages_count ) ? ( $pages_count - $page )  :  $page_refers_per_page - 1 );
			
	if($page > 1)
		$pages .= '<a href="'.$type.($page-1).'">&laquo;</a>';
	else
		$pages .= '';
				
	if ( $start_page > 1 ) {
		$pages .= '<a href="'.$type.'1">1</a>';
		$pages .= '<a href="'.$type.( $start_page - 1 ).'">...</a>';
			
	}
					
	for ( $index = -1; ++$index <= $page_refers_per_page_count-1; ) {
		if ( $index + $start_page == $page )
			$pages .= '<span>' . ( $start_page + $index ) . '</span>';
		else 
			$pages .= '<a href="'.$type.($start_page+$index).'">'.($start_page+$index).'</a>';
	} 
			
	if ( $page + $page_refers_per_page <= $pages_count ) { 
		$pages .= '<a href="'.$type.( $start_page + $page_refers_per_page_count ).'">...</a>';
		$pages .= '<a href="'.$type.$pages_count.'">'.$pages_count.'</a>';	
	} 
				
	$resif = $cnt/$gcount;
	if(ceil($resif) == $page)
		$pages .= '';
	else
		$pages .= '<a href="'.$type.($page+1).'">&raquo;</a>';

	if ( $pages_count <= 1 )
		$pages = '';
		
		if($pages)
			return '<div class="nav">'.$pages.'</div>';
}
function echoheader($box_width = false){
	global $config, $logged, $admin_link, $user_info;
	
	if($logged AND $user_info['user_group'] == 1)
		$exit_link = '<a href="'.$admin_link.'?act=logout">Выход</a>';
	else
		$exit_link = '';
	
	if(!$box_width) $box_width = 600;
	
	echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<title>Vii Engine - Админка</title>
<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
</head>
<body style='background: url("/system/inc/images/background.jpg")  no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;'>>
<style type="text/css" media="all">
html,body{font-size:11px;font-family:Tahoma;line-height:17px;}
a{color:#4274a5;text-decoration:underline}
a:hover{color:#4274a5;text-decoration:none}
.box{margin:auto;width:60%;background:#fff;#cfcfcf;margin-top:70px;border:1px solid #dfdfdf;background:#f6f7f8;padding:10px;}
.head{background:#444444;height:25px;margin:-70px 0 0 -10px;position:fixed;width:100%;padding-right:5px;}
.h1{font-size:13px;font-weight:bold;color:#4c4c4c;margin-top:5px;margin-bottom:5px;padding-bottom:2px;border-bottom:1px solid #e5edf5;padding-left:2px}
.clr{clear:both}
.fl_l{float:left}
.fl_r{float:right}
.fl_r{float:right}
.inp{border:0px;font-size:11px;padding:5px 10px 5px 10px;background:#fff;border:1px solid #ccc;color:#777;margin-top:10px;}
.inpu{width:200px;box-shadow:inset 0px 1px 3px 0px #d2d2d2;border:1px solid #ccc;padding:4px;border-radius:3px;font-size:11px;font-family:tahoma;margin-bottom:5px;-moz-box-shadow:inset 0px 1px 3px 0px #d2d2d2;-webkit-box-shadow:inset 0px 1px 3px 0px #d2d2d2}
textarea{width:300px;height:100px;}
.fllogall{color:#555;margin-left:2px;float:left;width:280px;padding-top:2px;opacity: 0.5;}
.oneb{float:left;width:300px;font-size:17px;font-weight:700;color:#777;margin-top:5px;padding-top:3px;height:70px;margin-left:10px;}
.oneb img{float:left;margin-right:7px}
.oneb div{font-size:11px;font-weight:normal;line-height:14px;margin-left:68px;margin-top:5px}
.tmenu{background:#f5f5f5;padding:5px;margin-top:-5px;margin-left:-10px;margin-right:-10px}
.tmenu a{float:right;margin-left:10px}
.foot{clear:both;text-align:center;color:#000;margin-top:10px;width:100%;font-size:11px}
.foot a{color:#000}
.foot a:hover{text-decoration:none}
.mgcler{clear:both;border-bottom:1px dashed #ccc;margin-bottom:5px}
.tempdata{height:500px;width:250px;overflow:scroll;border:1px solid #ddd;padding:5px}
.tefolfer{background:url("/system/inc/images/directory.png") no-repeat 3px 3px;padding:5px;height:15px;padding-left:24px;cursor:pointer;color:#444;padding-top:3px;font-family:Verdana;}
.tefolfer:hover{background:#c8e5f5 url("/system/inc/images/directory.png") no-repeat 3px 3px;}
.tetpl{background:url("/system/inc/images/html.png") no-repeat 3px 3px;padding:5px;height:15px;padding-left:24px;padding-top:3px;cursor:pointer;color:#444;font-family:Verdana;}
.tetpl:hover{background:#c8e5f5 url("/system/inc/images/html.png") no-repeat 3px 3px;}
.tecss{background:url("/system/inc/images/css.png") no-repeat 3px 3px;padding:5px;height:15px;padding-top:3px;padding-left:24px;cursor:pointer;color:#444;font-family:Verdana;}
.tecss:hover{background:#c8e5f5 url("/system/inc/images/css.png") no-repeat 3px 3px;}
.tejs{background:url("/system/inc/images/script.png") no-repeat 3px 3px;padding:5px;height:15px;padding-top:3px;padding-left:24px;cursor:pointer;color:#444;font-family:Verdana;}
.tejs:hover{background:#c8e5f5 url("/system/inc/images/script.png") no-repeat 3px 3px;}
.edittable{height:490px;width:645px;border:1px solid #ddd;padding:10px;margin-left:10px}
.ftext{height:420px;width:635px;border:1px solid #ddd;line-height: 155%;margin-top:10px;padding:4px;font-family:verdana;font-size:12px;-moz-box-shadow:inset 0px 1px 3px 0px #d2d2d2;-webkit-box-shadow:inset 0px 1px 3px 0px #d2d2d2;box-shadow:inset 0px 1px 3px 0px #d2d2d2}
#loading_text{color:#fff;position:relative;background: url("/system/inc/images/showb.png");width:250px;margin:auto;margin-top: 250px;padding:10px;font-size:11px;font-family:Verdana;border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;text-align:center;}
#loading{z-index:100; position:fixed; padding:0; margin:0 auto; height:100%; min-height:100%; width:100%; overflow:hidden; display:none; left:0px; right:0px; bottom:0px; top:0px;background:url("../images/spacer.gif");}

img:hover{
-o-transform:scale(1) rotate(25deg) translate(1px, 1px);
-moz-transform:scale(1) rotate(25deg) translate(1px, 1px);
-webkit-transform:scale(1) rotate(25deg) translate(1px,1px)
}
img{
-o-transition:all 0.2s cubic-bezier(0, 0, 1, 1) 0;
-moz-transition:all 0.2s linear 0s;
-webkit-transition:all 0.2s linear 0s
}
.nav .active {
color: #c6342e; }
.nav {
  overflow: hidden;
  position: relative;
  width: 480px; }
  
.nav a {
    display: block;
    position: relative;
    float: left;
    padding: 1em 0 2em;
    width: 120px;
    text-decoration: none;
    color: #fff;
    transition: .7s; 
	margin-top:7px;}
.nav a:hover {
      color: #c6342e;}
.effect {
  position: absolute;
  left: -12.5%;
  transition: 0.5s ease-in-out; }
.nav a:nth-child(1):hover ~ .effect {
  left: 17.87%;top:80% }
.nav a:nth-child(2):hover ~ .effect {
  left: 26.3%;top:80% }
.nav a:nth-child(3):hover ~ .effect {
  left: 34.91%;top:80% }
.nav a:nth-child(4):hover ~ .effect {
  left: 41.2%;top:80% }
.menu .effect {
  width: 90px;
  height: 2px;
  bottom: 36px;
  background: #c6342e;
  margin-left:-45px;
}
.menu {width:100%;margin-top:25px;;height:50px;padding-left:19.7%;background: #014464;background: -moz-linear-gradient(top, #3B3B3B, #2D2D2D);background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#3B3B3B), to(#2D2D2D));border: 1px solid #242424;-moz-box-shadow:inset 0px 0px 1px #edf9ff;-webkit-box-shadow:inset 0px 0px 1px #edf9ff;box-shadow:inset 0px 0px 1px #edf9ff;}
</style>
<div class="h1" style="margin-top:10px">{$title}</div>
<div class="h1"></div>
<div class="head">
<div class="menu nav">
	<a href="{$admin_link}" class="active">Главная</a>
 	<a href="{$admin_link}?mod=stats">Статистика</a>
   <a href="/" target="_blank">Просмотр сайта</a>
	<a href="{$admin_link}?act=logout" target="_blank">Выход</a>
    <div class="effect"></div>
</div>
</div>

<div class="box clr">
HTML;
}
function echohtmlstart($title){
	echo <<<HTML
<div style="margin-top:10px">{$title}</div>
HTML;
}
function echohtmlend(){
	global $admin_link, $logged;
	
	if($logged){
		$stat_lnk = "<a href=\"{$admin_link}?mod=stats\" style=\"margin-right:10px\">статистика</a>";
		$exit_lnk = "<a href=\"{$admin_link}?act=logout\">выйти</a>";
	}
	
	echo <<<HTML
<div class="clr"></div>
</div>
<div class="clr"></div>
<div class="foot">Vii Engine <br />Copyright 2013 © All rights reserved.</div>
</body>
</html>
HTML;
}
function msgbox($title, $text, $link = false){
	echoheader();
	echohtmlstart($title);
	echo '<center>'.$text.'<br /><a href="'.$link.'">Вернуться назад</a></center>';
	echohtmlend();
}
function echoblock($title, $description, $link, $icon){
	global $admin_link;
	
	echo <<<HTML
<a href="{$admin_link}?mod={$link}">
<div class="oneb">
<img src="/system/inc/images/{$icon}.png" alt="" title="" />{$title}
<div>{$description}</div>
</div>
</a>
HTML;
}
function htmlclear(){
	echo '<div class="clr"></div>';
}
function myBr($source){
	$find[] = "'\r'";
	$replace[] = "<br />";
	
	//$find[] = "'\n'";
	//$replace[] = "<br />";

	$source = preg_replace($find, $replace, $source);
	
	return $source;
}
function myBrRn($source){

	$find[] = "<br />";
	$replace[] = "\r";
	$find[] = "<br />";
	$replace[] = "\n";
	
	$source = str_replace($find, $replace, $source);
	
	return $source;
}
function textFilter($source, $substr_num = false, $strip_tags = false){
	global $db;
	
	if(function_exists("get_magic_quotes_gpc") AND get_magic_quotes_gpc())
		$source = stripslashes($source);  
	
	$find = array('/data:/i', '/about:/i', '/vbscript:/i', '/onclick/i', '/onload/i', '/onunload/i', '/onabort/i', '/onerror/i', '/onblur/i', '/onchange/i', '/onfocus/i', '/onreset/i', '/onsubmit/i', '/ondblclick/i', '/onkeydown/i', '/onkeypress/i', '/onkeyup/i', '/onmousedown/i', '/onmouseup/i', '/onmouseover/i', '/onmouseout/i', '/onselect/i', '/javascript/i');
		
	$replace = array("d&#097;ta:", "&#097;bout:", "vbscript<b></b>:", "&#111;nclick", "&#111;nload", "&#111;nunload", "&#111;nabort", "&#111;nerror", "&#111;nblur", "&#111;nchange", "&#111;nfocus", "&#111;nreset", "&#111;nsubmit", "&#111;ndblclick", "&#111;nkeydown", "&#111;nkeypress", "&#111;nkeyup", "&#111;nmousedown", "&#111;nmouseup", "&#111;nmouseover", "&#111;nmouseout", "&#111;nselect", "j&#097;vascript");

	$source = preg_replace("#<iframe#i", "&lt;iframe", $source);
	$source = preg_replace("#<script#i", "&lt;script", $source);
		
	if(!$substr_num)
		$substr_num = 25000;

	$source = $db->safesql(myBr(htmlspecialchars(substr(trim($source), 0, $substr_num))));
	
	$source = str_ireplace("{", "&#123;", $source);
	$source = str_ireplace("`", "&#96;", $source);
	$source = str_ireplace("{theme}", "&#123;theme}", $source);
	
	$source = preg_replace($find, $replace, $source);
	
	if($strip_tags)
		$source = strip_tags($source);

	return $source;
}
function ajax_utf8($source){
	return iconv('utf-8', 'windows-1251', $source);
}
function installationSelected($id, $options){
	$source = str_replace('value="'.$id.'"', 'value="'.$id.'" selected', $options);
	return $source;
}
function mozg_clear_cache_file($prefix) {
	@unlink(ENGINE_DIR.'/cache/'.$prefix.'.tmp');
}
function mozg_clear_cache(){
	$fdir = opendir(ENGINE_DIR.'/cache/');
	
	while($file = readdir($fdir))
		if($file != '.' and $file != '..' and $file != '.htaccess' and $file != 'system')
			@unlink(ENGINE_DIR.'/cache/'.$file);
}
function mozg_mass_clear_cache_file($prefix){
	$arr_prefix = explode('|', $prefix);
	foreach($arr_prefix as $file)
		@unlink(ENGINE_DIR.'/cache/'.$file.'.tmp');
}
function convert_unicode($t, $to = 'windows-1251') {
	$to = strtolower($to);
	if($to == 'utf-8'){
		return $t;
	} else {
		if(function_exists('iconv')) $t = iconv("UTF-8", $to . "//IGNORE", $t);
		else $t = "The library iconv is not supported by your server";
	}
	return $t;
}
function formatsize($file_size){
	if($file_size >= 1073741824){
		$file_size = round($file_size / 1073741824 * 100 ) / 100 ." Gb";
	} elseif($file_size >= 1048576){
		$file_size = round($file_size / 1048576 * 100 ) / 100 ." Mb";
	} elseif($file_size >= 1024){
		$file_size = round($file_size / 1024 * 100 ) / 100 ." Kb";
	} else {
		$file_size = $file_size." b";
	}
	return $file_size;
}
function system_mozg_clear_cache_file($prefix) {
	@unlink(ENGINE_DIR.'/cache/system/'.$prefix.'.php');
}
?>
