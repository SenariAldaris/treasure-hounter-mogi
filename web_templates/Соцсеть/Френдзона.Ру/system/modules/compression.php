<?php
/* 
	Appointment: Сompression
	File: compression.php
	Author: Konotopskiy Aleksander 
	Engine: Vii Engine
	Skype: openspace2014

*/

if(!defined('MOZG'))

	die('Hacking attempt!');

	header( "Content-Type: text/css", true, 200 );

	$godirectory = 'templates/'.$config['temp'].'/style/';

	$nameexplode = explode('.', $go);

	$ext = $nameexplode[1];

	$name = $godirectory . $go . '.css';

		if ($ext != 'css') {

			$handle = fopen($name, 'r');

			$input = fread($handle, filesize($name));

			$url = $config['home_url'].'templates/'.$config['temp'].'';

				$output = preg_replace('/\s+/', ' ', $input);

				$output = preg_replace('/URL_TPL/', $url, $output);
			
				$output = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $output);

			fclose($handle);

		echo $output;

	}

exit();

?>