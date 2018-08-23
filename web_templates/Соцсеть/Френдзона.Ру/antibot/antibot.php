<?php
/*==========================================
	Appointment: Антибот
	File: antibot.php 
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================*/

@session_start();

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

function clean_url($url){

  if ($url == '') return;

  $url = str_replace("http://", "", strtolower($url));
  $url = str_replace("https://", "", $url );
  if (substr($url, 0, 4) == 'www.')  $url = substr($url, 4);
  $url = explode('/', $url);
  $url = reset($url);
  $url = explode(':', $url);
  $url = reset($url);

  return $url;
  
}

if(clean_url($_SERVER['HTTP_REFERER']) != clean_url($_SERVER['HTTP_HOST'])) 
	die("Hacking attempt!");
	
//* Ширина изображения *//	
$width = 120;

//* Высота изображения *//				
$height = 50;

//* Размер шрифта *//				
$font_size = 16;

//* Количество символов, которые нужно набрать *//   			
$let_amount = 5;

//* Количество символов на фоне *//			
$fon_let_amount = 30;

//* Путь к шрифту *//
$font = "../system/fonts/cour.ttf";
 
//* Набор символов *//
$letters = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');		

//* Цвета для фона *//
$background_color = array(mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));

//* Цвета для обводки *//
$foreground_color = array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));

//* Создаем изображение *//
$src = imagecreatetruecolor($width,$height);			

//* Создаем фон *//	
$fon = imagecolorallocate($src, $background_color[0], $background_color[1], $background_color[2]); 

//* Заливаем изображение фоном *//
imagefill($src,0,0,$fon); 

//* То же самое для основных букв *//
for($i=0; $i < $let_amount; $i++){

//* Цвет шрифта *//
	$color = imagecolorallocatealpha($src, $foreground_color[0], $foreground_color[1], $foreground_color[2], rand(20,40));
	$letter = $letters[rand(0,sizeof($letters)-1)];
	$size = rand($font_size*2-2,$font_size*2+2);
	
//* Даем каждому символу случайное смещение *//	
	$x = ($i+1)*$font_size + rand(2,5);
	$y = (($height*2)/3) + rand(0,5);

//* Запоминаем код *//	
	$cod[] = $letter;
	imagettftext($src,$size,rand(0,15),$x,$y,$color,$font,$letter);
}

$foreground = imagecolorallocate($src, $foreground_color[0], $foreground_color[1], $foreground_color[2]);

imageline($src, 0, 0,  $width, 0, $foreground);
imageline($src, 0, 0,  0, $height, $foreground);
imageline($src, 0, $height-1,  $width, $height-1, $foreground);
imageline($src, $width-1, 0,  $width-1, $height, $foreground);

//* Переводим код в строку *//
$cod = implode("",$cod); 

//* Выводим готовую картинку *//
header("Content-type: image/gif");

imagegif($src); 

//* Добавляем код в сессию *//
$_SESSION['sec_code'] = $cod; 
?>