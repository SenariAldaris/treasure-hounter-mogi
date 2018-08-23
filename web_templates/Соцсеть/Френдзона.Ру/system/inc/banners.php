<?php
/*========================================= 
	Appointment: Рекламные материалы
	File: banners.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

//* Saved Левый рекламный блок *//

if(isset($_POST['save_banner_left'])){
		
	$code = $db->safesql($_POST['code']);
	$country = intval($_POST['country']);
	$city = intval($_POST['city']);
	$year = intval($_POST['year']);
	$sex = intval($_POST['sex']);
	
	$db->query("UPDATE `".PREFIX."_banners` SET code = '{$code}', country = '{$country}', city = '{$city}', year = '{$year}', sex = '{$sex}' WHERE id = 1");
	
	msgbox('Информация', 'Сохранено!', '?mod=banners');
	
	exit();
	
}

//* Saved Правый рекламный блок *//

if(isset($_POST['save_banner_right'])){
		
	$code = $db->safesql($_POST['code']);
	$country = intval($_POST['country']);
	$city = intval($_POST['city']);
	$year = intval($_POST['year']);
	$sex = intval($_POST['sex']);
	
	$db->query("UPDATE `".PREFIX."_banners` SET code = '{$code}', country = '{$country}', city = '{$city}', year = '{$year}', sex = '{$sex}' WHERE id = 2");
	
	msgbox('Информация', 'Сохранено!', '?mod=banners');
	
	exit();
	
}

//* Saved Верхний рекламный блок *//

if(isset($_POST['save_banner_top'])){
		
	$code = $db->safesql($_POST['code']);
	$country = intval($_POST['country']);
	$city = intval($_POST['city']);
	$year = intval($_POST['year']);
	$sex = intval($_POST['sex']);
	
	$db->query("UPDATE `".PREFIX."_banners` SET code = '{$code}', country = '{$country}', city = '{$city}', year = '{$year}', sex = '{$sex}' WHERE id = 3");
	
	msgbox('Информация', 'Сохранено!', '?mod=banners');
	
	exit();
	
}

//* Saved Нижний рекламный блок *//

if(isset($_POST['save_banner_bottom'])){
		
	$code = $db->safesql($_POST['code']);
	$country = intval($_POST['country']);
	$city = intval($_POST['city']);
	$year = intval($_POST['year']);
	$sex = intval($_POST['sex']);
	
	$db->query("UPDATE `".PREFIX."_banners` SET code = '{$code}', country = '{$country}', city = '{$city}', year = '{$year}', sex = '{$sex}' WHERE id = 4");
	
	msgbox('Информация', 'Сохранено!', '?mod=banners');
	
	exit();
	
}

//* Загрузка файла *//

if($_GET['act'] == 'upload'){
	
//* Получаем данные о файле *//
	
	$image_tmp = $_FILES['uploadfile']['tmp_name'];
	
//* Оригинальное название для определения формата *//	
	
	$image_name = totranslit($_FILES['uploadfile']['name']);
	
//* Размер файла *//	
	
	$image_size = $_FILES['uploadfile']['size'];
	
//* Формат файла *//	
	
	$type = end(explode(".", $image_name));
	$image_name_2 = str_replace(".{$type}", "", $image_name);
	
//* Имя файла *//	
		
	$image_rename = substr($image_name_2, 0, 40);
	
	$max_size = 1024 * 5000;
	
// * Проверка размера *//

	if($image_size <= $max_size){
		
//* Разришенные форматы *//
		
		$allowed_files = explode(', ', 'jpg, jpeg, jpe, png, gif, swf');
		
//* Проверяем если, формат верный то пропускаем *//
		
		if(in_array(strtolower($type), $allowed_files)){
			
			$res_type = strtolower('.'.$type);
			
			$upDir = ROOT_DIR.'/uploads/files/';
			
			$rImg = $upDir.$image_rename.$res_type;
			
			if(move_uploaded_file($image_tmp, $rImg)){
			
				$db->query("INSERT INTO `".PREFIX."_files` SET file = '{$image_rename}{$res_type}'");

				echo <<<HTML
<div style="line-height:25px"><a href="{$config['home_url']}uploads/files/{$image_rename}{$res_type}" target="_blank">{$config['home_url']}uploads/files/{$image_rename}{$res_type}</a> <a href="?mod=banners&act=del&id={$db->insert_id()}" style="float:right"><b>X</b></a></div>
HTML;
			
			}
			
		} else
			echo 2;
			
	} else
		echo 1;
		
	exit();
	
}

//* Удаление файла *//

if($_GET['act'] == 'del'){
	
	$id = intval($_GET['id']);
	
	$row = $db->super_query("SELECT file FROM `".PREFIX."_files` WHERE id = '{$id}'");
	
	if($row){
		
		@unlink(ROOT_DIR."/uploads/files/{$row['file']}");
		
		$db->query("DELETE FROM `".PREFIX."_files` WHERE id = '{$id}'");

	}
	
	header("Location: ?mod=banners");
	
}

echoheader();

$sql_files = $db->super_query("SELECT * FROM `".PREFIX."_files` ORDER by `id` DESC", 1);

foreach($sql_files as $row_files){

	$files .= <<<HTML
<div style="line-height:25px"><a href="{$config['home_url']}uploads/files/{$row_files['file']}" target="_blank">{$config['home_url']}uploads/files/{$row_files['file']}</a> <a href="?mod=banners&act=del&id={$row_files['id']}" style="float:right"><b>X</b></a></div>
HTML;
	
}
	
echohtmlstart('Загруженные файлы');

echo <<<HTML
<script type="text/javascript" src="/system/inc/js/jquery.js"></script>
<script type="text/javascript" src="/system/inc/js/upload.photo.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	aj1 = new AjaxUpload('upload', {
		action: '?mod=banners&act=upload',
		name: 'uploadfile',
		onSubmit: function (file, ext) {
			if(!(ext && /^(jpg|png|jpeg|gif|jpe|swf)$/.test(ext))) {
				alert('Неверный формат файла');
				return false;
			}
			$('#upload').hide();
			$('#prog_poster').show();
		},
		onComplete: function (file, row){
			if(row == 1){
				alert('Файл привышает 5 МБ');
			} else {
				$('#files').append(row);
			}
			$('#upload').show();
			$('#prog_poster').hide();
		}
	});
});
</script>
<div id="files">{$files}</div>
<center><input type="submit" value="Загрузить новый файл" name="save" id="upload" class="inp" style="margin-top:10px;cursor:pointer" /></center>
<div id="prog_poster" style="display:none;margin-top:15px;margin-bottom:16px;background:url('/system/inc/images/progress_grad.gif');width:136px;height:18px;border:1px solid #006699;margin-left:230px"></div>
<div style="clear:both"></div>
HTML;

//* Баннер №1 *//

echohtmlstart('Баннер #1');

$row1 = $db->super_query("SELECT * FROM `".PREFIX."_banners` WHERE id = 1");
$row1['code'] = stripslashes($row1['code']);

//* Загружаем Страны *//
 
$sql_country = $db->super_query("SELECT * FROM `".PREFIX."_country` ORDER by `name` ASC", true);
foreach($sql_country as $row_country)
	$all_country .= '<option value="'.$row_country['id'].'">'.stripslashes($row_country['name']).'</option>';
			
$sel_all_country = installationSelected($row1['country'], $all_country);
			
//* Загружаем Города *//

$sql_city = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row1['country']}' ORDER by `name` ASC", true);
foreach($sql_city as $row2) 
	$all_city .= '<option value="'.$row2['id'].'">'.stripslashes($row2['name']).'</option>';
	
$sel_all_city = installationSelected($row1['city'], $all_city);

$sel_year = installationSelected($row1['year'], '<option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option>');

$sel_sex = installationSelected($row1['sex'], '<option value="1">Мужской</option><option value="2">Женский</option>');

echo <<<HTML
<script type="text/javascript">
function loadCity(id){
	$('#country, #select_city').attr('disabled', 1);
	$('#select_city').load('/index.php?go=loadcity', {country: id}, function(){
		$('#country, #select_city').attr('disabled', 0);
	});
}
</script>
<style type="text/css" media="all">
.inpu{width:457px}
textarea{height:150px;}
.fllogall{width:130px}
</style>

<form method="POST" action="">

<div class="fllogall">Код баннера:</div><textarea class="inpu" name="code">{$row1['code']}</textarea><div class="mgcler"></div>

<div class="fllogall">Страна:</div><select name="country" id="country" onChange="loadCity(this.value)" class="inpu"><option value="0">Любая</option>{$sel_all_country}</select><div class="mgcler"></div>

<div class="fllogall">Город:</div><select name="city" id="select_city" class="inpu"><option value="0">Любой</option>{$sel_all_city}</select><div class="mgcler"></div>

<div class="fllogall">Год рождения:</div><select name="year" class="inpu"><option value="0">Любой</option>{$sel_year}</select><div class="mgcler"></div>

<div class="fllogall">Пол:</div><select name="sex" class="inpu"><option value="0">Все</option>{$sel_sex}</select><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><input type="submit" value="Сохранить" name="save_banner_left" class="inp" style="margin-top:0px" />

<div style="height:20px"></div>

</form>
HTML;

//* Баннер №2 *//

echohtmlstart('Баннер #2');

$row2 = $db->super_query("SELECT * FROM `".PREFIX."_banners` WHERE id = 2");
$row2['code'] = stripslashes($row2['code']);

$sel_all_country1 = installationSelected($row2['country'], $all_country);

//* Загружаем Города *//

$sql_city2 = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row2['country']}' ORDER by `name` ASC", true);
foreach($sql_city2 as $crow2) 
	$all_city2 .= '<option value="'.$crow2['id'].'">'.stripslashes($crow2['name']).'</option>';
	
$sel_all_city1 = installationSelected($row2['city'], $all_city2);

$sel_year1 = installationSelected($row2['year'], '<option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option>');

$sel_sex1 = installationSelected($row2['sex'], '<option value="1">Мужской</option><option value="2">Женский</option>');

echo <<<HTML
<script type="text/javascript">
function loadCity1(id){
	$('#country1, #select_city1').attr('disabled', 1);
	$('#select_city1').load('/index.php?go=loadcity', {country: id}, function(){
		$('#country1, #select_city1').attr('disabled', 0);
	});
}
</script>
<style type="text/css" media="all">
.inpu{width:457px}
textarea{height:150px;}
.fllogall{width:130px}
</style>

<form method="POST" action="">

<div class="fllogall">Код баннера:</div><textarea class="inpu" name="code">{$row2['code']}</textarea><div class="mgcler"></div>

<div class="fllogall">Страна:</div><select name="country" id="country1" onChange="loadCity1(this.value)" class="inpu"><option value="0">Любая</option>{$sel_all_country1}</select><div class="mgcler"></div>

<div class="fllogall">Город:</div><select name="city" id="select_city1" class="inpu"><option value="0">Любой</option>{$sel_all_city1}</select><div class="mgcler"></div>

<div class="fllogall">Год рождения:</div><select name="year" class="inpu"><option value="0">Любой</option>{$sel_year1}</select><div class="mgcler"></div>

<div class="fllogall">Пол:</div><select name="sex" class="inpu"><option value="0">Все</option>{$sel_sex1}</select><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><input type="submit" value="Сохранить" name="save_banner_right" class="inp" style="margin-top:0px" />

<div style="height:20px"></div>

</form>
HTML;

//* Баннер №3 *//

echohtmlstart('Баннер #3');

$row3 = $db->super_query("SELECT * FROM `".PREFIX."_banners` WHERE id = 3");
$row3['code'] = stripslashes($row3['code']);

$sel_all_country2 = installationSelected($row3['country'], $all_country);

//* Загружаем Города *//

$sql_city3 = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row3['country']}' ORDER by `name` ASC", true);
foreach($sql_city3 as $crow3) 
	$all_city3 .= '<option value="'.$crow3['id'].'">'.stripslashes($crow3['name']).'</option>';
	
$sel_all_city2 = installationSelected($row3['city'], $all_city3);

$sel_year2 = installationSelected($row3['year'], '<option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option>');

$sel_sex2 = installationSelected($row3['sex'], '<option value="1">Мужской</option><option value="2">Женский</option>');

echo <<<HTML
<script type="text/javascript">
function loadCity2(id){
	$('#country2, #select_city2').attr('disabled', 1);
	$('#select_city2').load('/index.php?go=loadcity', {country: id}, function(){
		$('#country2, #select_city2').attr('disabled', 0);
	});
}
</script>
<style type="text/css" media="all">
.inpu{width:457px}
textarea{height:150px;}
.fllogall{width:130px}
</style>

<form method="POST" action="">

<div class="fllogall">Код баннера:</div><textarea class="inpu" name="code">{$row3['code']}</textarea><div class="mgcler"></div>

<div class="fllogall">Страна:</div><select name="country" id="country2" onChange="loadCity2(this.value)" class="inpu"><option value="0">Любая</option>{$sel_all_country2}</select><div class="mgcler"></div>

<div class="fllogall">Город:</div><select name="city" id="select_city2" class="inpu"><option value="0">Любой</option>{$sel_all_city2}</select><div class="mgcler"></div>

<div class="fllogall">Год рождения:</div><select name="year" class="inpu"><option value="0">Любой</option>{$sel_year2}</select><div class="mgcler"></div>

<div class="fllogall">Пол:</div><select name="sex" class="inpu"><option value="0">Все</option>{$sel_sex2}</select><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><input type="submit" value="Сохранить" name="save_banner_top" class="inp" style="margin-top:0px" />

<div style="height:20px"></div>

</form>
HTML;

// Баннер №4 *//

echohtmlstart('Баннер #4');
	
$row4 = $db->super_query("SELECT * FROM `".PREFIX."_banners` WHERE id = 4");
$row4['code'] = stripslashes($row4['code']);

$sel_all_country3 = installationSelected($row4['country'], $all_country);

//* Загружаем Города *//

$sql_city4 = $db->super_query("SELECT id, name FROM `".PREFIX."_city` WHERE id_country = '{$row4['country']}' ORDER by `name` ASC", true);
foreach($sql_city4 as $crow4) 
	$all_city4 .= '<option value="'.$crow4['id'].'">'.stripslashes($crow4['name']).'</option>';
	
$sel_all_city3 = installationSelected($row4['city'], $all_city4);

$sel_year3 = installationSelected($row4['year'], '<option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option>');

$sel_sex3 = installationSelected($row4['sex'], '<option value="1">Мужской</option><option value="2">Женский</option>');

echo <<<HTML
<script type="text/javascript">
function loadCity3(id){
	$('#country3, #select_city3').attr('disabled', 1);
	$('#select_city3').load('/index.php?go=loadcity', {country: id}, function(){
		$('#country3, #select_city3').attr('disabled', 0);
	});
}
</script>
<style type="text/css" media="all">
.inpu{width:457px}
textarea{height:150px;}
.fllogall{width:130px}
</style>

<form method="POST" action="">

<div class="fllogall">Код баннера:</div><textarea class="inpu" name="code">{$row4['code']}</textarea><div class="mgcler"></div>

<div class="fllogall">Страна:</div><select name="country" id="country3" onChange="loadCity3(this.value)" class="inpu"><option value="0">Любая</option>{$sel_all_country3}</select><div class="mgcler"></div>

<div class="fllogall">Город:</div><select name="city" id="select_city3" class="inpu"><option value="0">Любой</option>{$sel_all_city3}</select><div class="mgcler"></div>

<div class="fllogall">Год рождения:</div><select name="year" class="inpu"><option value="0">Любой</option>{$sel_year3}</select><div class="mgcler"></div>

<div class="fllogall">Пол:</div><select name="sex" class="inpu"><option value="0">Все</option>{$sel_sex3}</select><div class="mgcler"></div>

<div class="fllogall">&nbsp;</div><input type="submit" value="Сохранить" name="save_banner_bottom" class="inp" style="margin-top:0px" />

<div style="height:20px"></div>

</form>
HTML;

echohtmlend();
?>