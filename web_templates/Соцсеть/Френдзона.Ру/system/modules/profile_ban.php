<?php
/*========================================= 
	Appointment: Страница заблокирована
	File: profile_ban.php
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
	$tpl->load_template('profile_baned.tpl');
	if($user_info['user_ban_date'])
		$tpl->set('{date}', langdate('j F Y в H:i', $user_info['user_ban_date']));
	else
		$tpl->set('{date}', 'Неограниченно');
	$tpl->compile('main');
	echo str_replace('{theme}', '/templates/'.$config['temp'], $tpl->result['main']);
	die();
}
?>