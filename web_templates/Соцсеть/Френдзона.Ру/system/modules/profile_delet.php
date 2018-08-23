<?php
/*========================================= 
	Appointment: Страница удалена
	File: profile_delet.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die("Hacking attempt!");

if($user_info['user_group'] != '1'){
	$tpl->load_template('profile_deleted.tpl');
	$tpl->compile('main');
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);
	die();
}
?>