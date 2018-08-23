<?php
/* 
	Наименование: Проверка смены имени
	Файл: users_name.php
	Автор: PaZiTiF
	Skype: kos_pazitif
	ICQ: 44-63-662
	
*/
if(!defined('MOZG'))
	die('Hacking attempt!');

echoheader();

    //########################### Одобрение заявки на смену имени ###########################//
    if($_GET['act'] == 'yes'){
	$id = intval($_GET['id']);
	//########################### Таймер на зперет подачи заявки после одобрения, стандартно 3 дня ###########################//
	$yes_time = 3 ? $server_time + (3 * 60 * 60 * 24) : 0;
	//########################### Запрос для обновления статуса заявки ###########################//
	$db->query("UPDATE `".PREFIX."_users_name` SET user_name_active = '3', time_yes = '".$yes_time."' WHERE id = '{$id}'");
	//########################### Загрузка данных для изменения имени ###########################//
	$uyes = $db->super_query("SELECT user_name, user_lastname, user_id FROM `".PREFIX."_users_name` WHERE id = '{$id}'");
	$yes_uid = $uyes['user_id'];
	$yes_name = $uyes['user_name'];
	$yes_lastname = $uyes['user_lastname'];
	//########################### Обновление данных пользователя ###########################//
	$db->query("UPDATE `".PREFIX."_users` SET user_name = '{$yes_name}', user_lastname = '{$yes_lastname}', user_search_pref = '{$yes_name} {$yes_lastname}' WHERE user_id = '{$yes_uid}'");					
	mozg_clear_cache_file('user_'.$yes_uid.'/profile_'.$yes_uid);
	mozg_clear_cache();
	
	header("Location: ?mod=users_name");	
    }

    //########################### Отклонение заявки на смену имени ###########################//
    if($_GET['act'] == 'no'){
	$id = intval($_GET['id']);
	//########################### Таймер на зперет подачи заявки после отклонения, стандартно 1 день ###########################//
    $no_time = 1 ? $server_time + (1 * 60 * 60 * 24) : 0;
    //########################### Запрос для обновления статуса заявки ###########################//	
	$db->query("UPDATE `".PREFIX."_users_name` SET user_name_active = '1', time_no = '".$no_time."' WHERE id = '{$id}'");
	
	header("Location: ?mod=users_name");
	}

//########################### Вывод всех заявок на смену имени ###########################//
$se_uid = intval($_GET['id']);
if($se_uid){
	$where_sql .= "WHERE id='".$se_uid."'";
} else
	$order_sql = "`user_name_active` DESC";
if($_GET['page'] > 0) $page = intval($_GET['page']); else $page = 1;
$gcount = 20;
$limit_page = ($page-1)*$gcount;

$sql_ = $db->super_query("SELECT id, user_search_pref, user_id, user_name_active FROM `".PREFIX."_users_name`  {$where_sql} ORDER by {$order_sql} LIMIT {$limit_page}, {$gcount}", 1);

if($sql_){
	foreach($sql_ as $row){
		if($row['user_name_active']) $moder_lnk = '<a href="?mod=reviews&act=ok&id='.$row['id'].'">Отправить на сайт</a>';
		else $moder_lnk = '&nbsp;';
		
if($row['user_name_active'] == 2){	
	$yes = '<a href="?mod=users_name&act=yes&id='.$row['id'].'">Одобряю</a>';
    $no = '<a href="?mod=users_name&act=no&id='.$row['id'].'">Не одобряю</a>';	
} else {	
    $yes = 'Одобряю';
    $no = 'Не одобряю';	
}

if($row['user_name_active'] == 1)
       $status = '<font color="red">Отклонено</font>';
else if($row['user_name_active'] == 2)
       $status = '<font color="blue">На проверке</font>';	
else if($row['user_name_active'] == 3)
       $status = '<font color="green">Одобрено</font>';	   
		
$users .= <<<HTML
<div style="background:#fff;float:left;padding:5px;width:160px;text-align:center;border-bottom:1px dashed #ccc"><a href="/u{$row['user_id']}" target="_blank">{$row['user_search_pref']}</a></div>
<div style="background:#fff;float:left;padding:5px;width:130px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc">{$status}</div>
<div style="background:#fff;float:left;padding:5px;width:129px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc">{$yes}</div>
<div style="background:#fff;float:left;padding:5px;width:138px;text-align:center;margin-left:1px;border-bottom:1px dashed #ccc;border-bottom:1px dashed #ccc" >{$no}</div>
HTML;

echo <<<HTML
<div class="clr"></div><br>
<div style="background:#f0f0f0;float:left;padding:5px;width:160px;text-align:center;font-weight:bold;margin-top:-5px">Новое имя</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:130px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Статус</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:129px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Разрешение</div>
<div style="background:#f0f0f0;float:left;padding:5px;width:138px;text-align:center;font-weight:bold;margin-top:-5px;margin-left:1px">Запрет</div>
<div class="clr"></div>
{$users}
<div class="clr" style="margin-bottom:10px"></div>
HTML;

		
	}

} else
	echo '<div style="font-size:13px;color:#555;text-align:center;padding:50px">Заявок на смену имени нету...</div>';

$query_string = preg_replace("/&page=[0-9]+/i", '', $_SERVER['QUERY_STRING']);

echo navigation($gcount, $numRows['cnt'], '?'.$query_string.'&page=');

echohtmlend();
?>