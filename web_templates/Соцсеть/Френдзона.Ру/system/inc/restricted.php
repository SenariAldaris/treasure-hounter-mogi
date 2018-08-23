<?php
/*========================================== 
	Appointment: Запрещенные сайты
	File: city.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
===========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

//* Добавление *//

if(isset($_POST['add'])){
	$domain = textFilter($_POST['domain'], false, true);
	$text = textFilter($_POST['text'], false, true);
	if(isset($domain) AND !empty($domain) AND isset($text) && !empty($text)){
		$row = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_restricted_sites` WHERE domain = '".$domain."'");
		if(!$row['cnt']){
			$db->query("INSERT INTO `".PREFIX."_restricted_sites` SET domain = '".$domain."', text = '".$text."'");
			msgbox('Информация', 'Домен успешно добавлен', '?mod=restricted');
		} else
			msgbox('Ошибка', 'Такой домен уже добавлен', 'javascript:history.go(-1)');
	} else
		msgbox('Ошибка', 'Все поля обязательны', 'javascript:history.go(-1)');
	
	die();
}

//* Удаление *//

if($_GET['act'] == 'del'){
	$domain = textFilter($_GET['domain'], false, true);
	$row = $db->super_query("SELECT domain FROM `".PREFIX."_restricted_sites` WHERE domain = '".$domain."'");
	if($row){
		$db->query("DELETE FROM `".PREFIX."_restricted_sites` WHERE domain = '".$domain."'");
		header("Location: ?mod=restricted");
	}
	die();
}

//* Редактирование *//

if($_GET['act'] == 'edit'){
	$domain = textFilter($_GET['domain'], false, true);
	$row = $db->super_query("SELECT * FROM `".PREFIX."_restricted_sites` WHERE domain = '".$domain."'");
        if ($row && $_POST['domain'] && !empty($_POST['domain']) && $_POST['text'] && !empty($_POST['text'])) {
                $db->query("UPDATE `" . PREFIX . "_restricted_sites` SET domain = '{$_POST['domain']}', text = '{$_POST['text']}' WHERE domain = '{$domain}'");
                msgbox('Информация', 'Домен успешно обновлен', '?mod=restricted');
                die();
        }
	if($row){
	
//* $Db->query("DELETE FROM `".PREFIX."_restricted_sites` WHERE domain = '".$domain."'"); *//

//* Header("Location: ?mod=restricted"); *//
		
                echoheader();
                echohtmlstart('Редактирование домена');
                echo <<<HTML
<form method="POST" action="">
<table border="0">
    <tr>
        <td>Домен:</td>
        <td><input style="width:150px" type="text" class="inpu" name="domain" value="{$row['domain']}" /></td>
    </tr>
    <tr>
        <td>Текст ошибки:</td>
        <td><textarea style="width:150px" class="inpu" name="text">{$row['text']}</textarea></td>
    </tr>
</table>
<input type="submit" value="Изменить" class="inp" style="margin-top:0px" />
</form>
HTML;
	} else {
                msgbox('Ошибка', 'Неверные входные данные', 'javascript:history.go(-1)');
        }
        echohtmlend();
	die();
}

echoheader();
echohtmlstart('Добавление домена');
	
echo <<<HTML
<form method="POST" action="">
<table border="0">
    <tr>
        <td>Домен:</td>
        <td><input style="width:150px" type="text" class="inpu" name="domain" /></td>
    </tr>
    <tr>
        <td>Текст ошибки:</td>
        <td><textarea style="width:150px" class="inpu" name="text"></textarea></td>
    </tr>
</table>
<input type="submit" value="Добавить" name="add" class="inp" style="margin-top:0px" />
</form>
HTML;

	echohtmlstart('Запрещенные домены:');
	$sql_c = $db->super_query("SELECT * FROM `".PREFIX."_restricted_sites`", 1);
	foreach($sql_c as $row_c){
		$row_c['domain'] = stripslashes($row_c['domain']);
		$domains .= <<<HTML
<div style="margin-bottom:5px;border-bottom:1px dashed #ccc;padding-bottom:5px">&raquo;&nbsp; <span style="font-size:13px"><b>{$row_c['domain']}</b></span> &nbsp; <span style="color:#777">[ <a href="?mod=restricted&act=edit&domain={$row_c['domain']}" style="color:#777">редактировать</a> ] [ <a href="?mod=restricted&act=del&domain={$row_c['domain']}" style="color:#777">удалить</a> ]</span></div>
HTML;
	}
        echo $domains.'<input type="submit" value="Назад" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />';

echohtmlend();
?>