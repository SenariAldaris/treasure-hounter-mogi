<?php
/*========================================= 
	Appointment: Пользователи
	File: users.php
	Author: Sergei Pavlenko 
	Engine: People Engine Cms
	Copyright: People Design Group (с) 2014
	e-mail: info@vxas.ru
	URL: http://www.vxas.ru/
	Данный код защищен авторскими правами
==========================================*/

if(!defined('MOZG'))
	die('Hacking attempt!');

//* Редактирование *//

if($_GET['act'] == 'edit'){
	
	$id = intval($_GET['id']);
	
	$row = $db->super_query("SELECT user_name, user_lastname, user_email FROM `".PREFIX."_users` WHERE user_id = '{$id}'");
	
	if($row){
	
//* Сохранение *//
		
		if(isset($_POST['save'])){
			
			$name = textFilter($_POST['name']);
			$lastname = textFilter($_POST['lastname']);
			$email = textFilter($_POST['email']);
			$user_search_pref = $name.' '.$lastname;
			
			if(isset($_POST['password']) AND !empty($_POST['password'])){
			
				$password = md5(md5($_POST['password']));
				$sql_pass = ", user_password = '{$password}'";
			}
			
			
			$db->query("UPDATE `".PREFIX."_users` SET user_name = '{$name}', user_lastname = '{$lastname}', user_email = '{$email}', user_search_pref = '{$user_search_pref}' {$sql_pass} WHERE user_id = '{$id}'");
			
			mozg_clear_cache_file('user_'.$id.'/profile_'.$id);
			mozg_clear_cache();
						
			msgbox('Информация', 'Пользователь успешно отредактирован!', '?mod=users');
			
			exit();
			
		}
		
		echoheader();
		
		echohtmlstart('Редактирование');
	
		echo <<<HTML
<form action="" method="POST">

<div class="fllogall">Имя:</div>
 <input type="text" name="name" class="inpu" value="{$row['user_name']}" />
<div class="mgcler"></div>

<div class="fllogall">Фамилия:</div>
 <input type="text" name="lastname" class="inpu" value="{$row['user_lastname']}" />
<div class="mgcler"></div>

<div class="fllogall">E-mail:</div>
 <input type="text" name="email" class="inpu" value="{$row['user_email']}" />
<div class="mgcler"></div>

<div class="fllogall">Новый пароль:</div>
 <input type="text" name="password" class="inpu" />
<div class="mgcler"></div>

<div class="fllogall">&nbsp;</div>
 <input type="submit" value="Сохранить" name="save" class="inp" style="margin-top:0px" />
 <input type="submit" value="Назад" class="inp" style="margin-top:0px" onClick="history.go(-1); return false" />

</form>
HTML;

		htmlclear();

		echohtmlend();

	} else
		msgbox('Ошибка', 'Пользователь не найден', '?mod=users');
	
	exit();
	
}

echoheader(1013);	

$se_uid = intval($_GET['se_uid']);
if(!$se_uid) $se_uid = '';

$sort = intval($_GET['sort']);
$se_name = textFilter($_GET['se_name'], false, true);
$se_email = textFilter($_GET['se_email'], false, true);
$ban = $_GET['ban'];
$delet = $_GET['delet'];

if($se_uid OR $sort OR $se_name OR $se_email OR $ban OR $delet OR $_GET['regdate']){
	$where_sql .= "WHERE user_email != ''";
	if($se_uid) $where_sql .= "AND user_id = '".$se_uid."' ";
	if($se_name) $where_sql .= "AND user_search_pref LIKE '%".$se_name."%' ";
	if($se_email) $where_sql .= "AND user_email LIKE '%".$se_email."%' ";
	if($ban){$where_sql .= "AND user_ban = 1 ";$checked_ban = "checked";}
	if($delet){$where_sql .= "AND user_delet = 1 ";$checked_delet = "checked";}
	if($sort == 1) $order_sql = "`user_search_pref` ASC";
	else if($sort == 2) $order_sql = "`user_reg_date` ASC";
	else if($sort == 3) $order_sql = "`user_last_visit` DESC";
	else if($sort == 4) $order_sql = "`user_rating` DESC";
	else if($sort == 5) $order_sql = "`user_balance` DESC";
	else if($sort == 6) $order_sql = "`balance_rub` DESC";
	else $order_sql = "`user_reg_date` DESC";
} else
	$order_sql = "`user_reg_date` DESC";
	
$selsorlist = installationSelected($sort, '<option value="1">по алфавиту</option><option value="2">по дате регистрации</option><option value="3">по дате посещения</option><option value="4">по рейтингу</option><option value="5">по mix</option><option value="6">по руб.</option>');

//* Выводим список людей *//

if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT user_group, user_search_pref, user_id, user_reg_date, user_last_visit, user_email, user_delet, user_ban, user_balance, user_rating, balance_rub FROM `".PREFIX."_users`  {$where_sql} ORDER by {$order_sql} LIMIT {$limit_page}, {$gcount}", 1);

//* Кол-во людей считаем *//

$numRows = $db->super_query("SELECT COUNT(*) AS cnt FROM `".PREFIX."_users` {$where_sql}");

echo <<<HTML
<style type="text/css" media="all">
.inpu{width:300px;}
textarea{width:300px;height:100px;}
</style>

<form action="controlpanel.php" method="GET">

<input type="hidden" name="mod" value="users" />

<div class="fllogall">Поиск по ID:</div>
 <input type="text" name="se_uid" class="inpu" value="{$se_uid}" />
<div class="mgcler"></div>

<div class="fllogall">Поиск по имени:</div>
 <input type="text" name="se_name" class="inpu" value="{$se_name}" />
<div class="mgcler"></div>

<div class="fllogall">Поиск по email:</div>
 <input type="text" name="se_email" class="inpu" value="{$se_email}" />
<div class="mgcler"></div>

<div class="fllogall">Бан:</div>
 <input type="checkbox" name="ban" style="margin-bottom:10px" {$checked_ban} />
<div class="mgcler"></div>

<div class="fllogall">Удалены:</div>
 <input type="checkbox" name="delet" style="margin-bottom:10px" {$checked_delet} />
<div class="mgcler"></div>

<div class="fllogall">Сортировка:</div>
 <select name="sort" class="inpu">
  <option value="0"></option>
  {$selsorlist}
 </select>
<div class="mgcler"></div>

<div class="fllogall">&nbsp;</div>
 <input type="submit" value="Найти" class="inp" style="margin-top:0px" />

</form>
HTML;

echohtmlstart('Список пользователей ('.$numRows['cnt'].')');

foreach($sql_ as $row){
	$format_reg_date = date('Y-m-d', $row['user_reg_date']);
	$lastvisit = date('Y-m-d', $row['user_last_visit']);
	
	$row['user_reg_date'] = langdate('j M Y в H:i', $row['user_reg_date']);
	$row['user_last_visit'] = langdate('j M Y в H:i', $row['user_last_visit']);

	if($row['user_delet']) 
		$color = 'color:red';
	else if($row['user_ban'])
		$color = 'color:blue';
	else if($row['user_group'] == 4)
		$color = 'color:green';
	else
		$color = '';
	
	$users .= <<<HTML
<div style="background:#fff;float:left;padding:5px;width:170px;text-align:center;font-weight:bold;" title="Баланс: {$row['user_balance']} голосов"><a href="/u{$row['user_id']}" target="_blank" style="{$color}">{$row['user_search_pref']}</a> <a href="?mod=users&act=edit&id={$row['user_id']}" style="font-weight:normal">ред.</a></div>
<div style="background:#fff;float:left;padding:5px;width:110px;text-align:center;margin-left:1px">{$row['user_reg_date']}</div>
<div style="background:#fff;float:left;padding:5px;width:100px;text-align:center;margin-left:1px">{$row['user_last_visit']}</div>
<div style="background:#fff;float:left;padding:5px;width:148px;text-align:center;margin-left:1px">{$row['user_email']}</div>
<div style="background:#fff;float:left;padding:5px;width:89px;text-align:center;margin-left:1px">{$row['user_rating']}</div>
<div style="background:#fff;float:left;padding:5px;width:89px;text-align:center;margin-left:1px">{$row['user_balance']}</div>
<div style="background:#fff;float:left;padding:5px;width:89px;text-align:center;margin-left:1px">{$row['balance_rub']}</div>
<div style="background:#fff;float:left;padding:5px;width:100px;text-align:center;margin-left:1px"><a href="?mod=users_logs&id={$row['user_id']}">Посмотреть</a></div>
<div style="background:#fff;float:left;padding:4px;width:20px;text-align:center;font-weight:bold;margin-left:1px"><input type="checkbox" name="massaction_users[]" style="float:right;" value="{$row['user_id']}" /></div>
<div class="mgcler"></div>
HTML;
}

echo <<<HTML
<script language="text/javascript" type="text/javascript">
function ckeck_uncheck_all() {
    var frm = document.editusers;
    for (var i=0;i<frm.elements.length;i++) {
        var elmnt = frm.elements[i];
        if (elmnt.type=='checkbox') {
            if(frm.master_box.checked == true){ elmnt.checked=false; }
            else{ elmnt.checked=true; }
        }
    }
    if(frm.master_box.checked == true){ frm.master_box.checked = false; }
    else{ frm.master_box.checked = true; }
}
</script>
<form action="?mod=massaction&act=users" method="post" name="editusers">
<div style="background:#f0f0f0;float:left;padding:5px;width:170px;text-align:center;font-weight:bold;margin-top:-5px">Пользователь</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:110px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Дата регистрации</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:100px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Дата посещения</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:148px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">E-mail</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:89px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Рейтинг</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:89px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Кол-во mix</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:89px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Кол-во руб</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:100px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">История</div>
<div style="background:#f0f0f0;float:left;padding:4px;width:20px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px"><input type="checkbox" name="master_box" title="Выбрать все" onclick="javascript:ckeck_uncheck_all()" style="float:right;"></div>
<div class="clr"></div>
{$users}
<div style="float:left;font-size:10px">
<font color="red">Удаленные пользователи помечены красным цветом</font><br />
<font color="blue">Забаненые пользователи помечены синим цветом</font><br />
<font color="green">Агенты поддержки помечены зеленым цветом</font>
</div>
<div style="float:right">
<select name="mass_type" class="inpu" style="width:260px">
 <option value="0">- Действие -</option>
 <option value="1">Удалить пользователей</option>
 <option value="2">Заблокировать пользователей</option>
 <option value="3">Удалить отправленные сообщения</option>
 <option value="4">Удалить оставленные комментарии к фото</option>
 <option value="5">Удалить оставленные комментарии к видео</option>
 <option value="11">Удалить оставленные комментарии к заметкам</option>
 <option value="6">Удалить оставленные записи на стенах</option>
 <option value="18">Удалить заметки пользователя</option>
 <option value="19">Удалить видеозаписи пользователя</option>
 <option value="20">Удалить аудиозаписи пользователя</option>
 <option value="21">Удалить сообщества пользователя</option>
 <option value="22">Удалить документы пользователя</option>
 <option value="30">Удалить записи пользователя с его стены</option>
 <option value="29">Удалить все</option>
 <option value="7">Воостановить пользователей</option>
 <option value="9">Разблокировать пользователей</option>
 <option value="12">Начислить голосов</option>
 <option value="13">Забрать голоса</option>
 <option value="16">Перевести в группу "Техподдержка"</option>
 <option value="17">Перевести в группу "Пользователи"</option>
 <option value="23">Верифицировать пользователя</option>
 <option value="24">Убрать верификацию пользователя</option>
 <option value="25">Забрать рейтинг</option>
 <option value="27">Установить штамп звезды</option>
 <option value="28">Убрать штамп звезды</option>
</select>
<input type="submit" value="Выолнить" class="inp" />
</div>
</form>
<div class="clr"></div>
HTML;

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);
echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

htmlclear();

echohtmlend();
?>