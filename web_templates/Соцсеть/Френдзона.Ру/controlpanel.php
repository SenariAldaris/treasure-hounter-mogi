<?php
/*========================================== 
	Appointment:  Панель управления
	File: controlpanel.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

@session_start();
@ob_start();
@ob_implicit_flush(0);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

define('MOZG', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/system');
define('ADMIN_DIR', ROOT_DIR.'/system/inc');
header('Content-type: text/html; charset=Windows-1251');

@include ENGINE_DIR.'/data/config.php';

if(!$config['home_url']) die("Vii Engine not installed. Please run install.php");

$admin_link = $config['home_url'].'controlpanel.php';

include ENGINE_DIR.'/classes/mysql.php';
include ENGINE_DIR.'/data/db.php';
include ADMIN_DIR.'/functions.php';
include ADMIN_DIR.'/login.php';

$db->close();
?>