<?php
/*========================================= 
	Appointment: Переводчик
	File: tranlsate.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

NoAjaxQuery();

if($logged){

	$user_id = $user_info['user_id'];
	$act = $_GET['act'];

	switch($act){
	
//* Переводим *//
		
		case "go":
			
			$msg_id = intval($_POST['msg_id']);

			$row = $db->super_query("SELECT text FROM `".PREFIX."_messages` WHERE id = '{$msg_id}' AND for_user_id = '{$user_id}'");

			if($row){
				
				$txt = myBrRn(stripslashes($row['text']));
				
				if(preg_match('/[а-яА-Я0-9]/iu', $txt)){
					
					$rSL = 'ru';
					$rTL = 'en';
				} else {
					
					$rSL = 'en';
					$rTL = 'ru';
					
				}

				
			} else {
			
				$txt = strip_tags($_POST['txt']);
				$sl = $_POST['sl'];
				$tl = $_POST['tl'];
				
				if($sl == 1) $rSL = 'ru';
				else $rSL = 'en';
				
				if($tl == 1) $rTL = 'ru';
				else $rTL = 'en';
			
			}
			
			if(isset($txt) AND !empty($txt)){

				$dataBase = CURL_POST('http://translate.google.com/', 'sl='.$rSL.'&tl='.$rTL.'&js=n&prev=_t&hl=ru&ie=UTF-8&eotf=1&text='.$txt);

				$onePARSE = explode('<span id=result_box', $dataBase['content']);
				
				$twoPARSE = explode('</span></div>', $onePARSE[1]);

				$twoPARSE[0] = str_replace('<br>', '
', $twoPARSE[0]);
				
				$twoPARSE[0] = strip_tags($twoPARSE[0]);
				
				$threePARSE = explode('">', $twoPARSE[0]);
				
				$twoPARSE[0] = str_replace($threePARSE[0].'">', '', $twoPARSE[0]);
				
				echo $twoPARSE[0];
			
			}
			
		break;
		
//* Страница выбора перевода *//
		
		default: 
			
			$msg_id = intval($_POST['msg_id']);

			$row = $db->super_query("SELECT text FROM `".PREFIX."_messages` WHERE id = '{$msg_id}' AND for_user_id = '{$user_id}'");
			
			$tpl->load_template('tranlsate/main.tpl');
			$tpl->set('{msg}', myBrRn(stripslashes($row['text'])));
			$tpl->compile('content');
			
			AjaxTpl();
	}
	
}

$tpl->clear();
$db->free();
	
exit();
?>