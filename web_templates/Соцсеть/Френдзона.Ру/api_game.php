<?php

@session_start();
@ob_start();
@ob_implicit_flush(0);

@error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

define('MOZG', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/system');

header('Content-type: text/html; charset=utf8');
	
include ENGINE_DIR.'/init.php';

include (ENGINE_DIR . '/data/nextgame.config.php');
require_once ENGINE_DIR.'/modules/nextgame/nextgame.functions.php';
require_once ENGINE_DIR.'/modules/functions.php';

if(!checksign($_GET)) die('SIG Error'); //check sig
switch(strtolower($_GET['method']))
{
// Показываем профиль..

case 'getprofile': 
$id=$_GET['uid'];

    $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM ".PREFIX."_users where user_id in($id)");
    $resp="<profiles>";
    while($row=$db->get_row())
    {
    if($row['user_sex']==1){
    
   $sex="M"; 
    }else{
    $sex="F"; 
    
    }
  $row['user_name']=iconv($config['charset'],"UTF-8",$row['user_name']);
    $row['user_lastname']=iconv($config['charset'],"UTF-8",$row['user_lastname']);
    $row['user_country_city_name']=iconv($config['charset'],"UTF-8",$row['user_country_city_name']);
    $user_land = explode('|', $row['user_country_city_name']); 
$resp .=<<<XML
<user>
        <uid>{$row['user_id']}</uid>
        <first_name>{$row['user_name']}</first_name>
        <last_name>{$row['user_lastname']}</last_name>
        <nickname>{$row['user_name']} {$row['user_lastname']}</nickname>
        <birthday>{$row['user_birthday']}</birthday>
        <sex></sex>
        <avatar_url>{$config['home_url']}/uploads/users/{$row['user_id']}/100_{$row['user_photo']}</avatar_url>
        <country>{$user_land[0]}</country>
        <city>{$user_land[1]}</city>
</user>
XML;
}
$resp.="</profiles>";
break;
// Получаем список друзей..
case 'getfriends': 
$user_id=$_GET['uid'];

    $db->query("SELECT SQL_CALC_FOUND_ROWS friend_id  FROM `".PREFIX."_friends` tb1, `".PREFIX."_users` tb2 WHERE tb1.user_id = '{$user_id}' ");
    $resp = "<friends>";
while($row_friend = $db->get_row()) {
$resp .= "<friend_id>{$row_friend['friend_id']}</friend_id>";
}
$resp .= "</friends>";

break;
case 'wallpost': 
require_once ENGINE_DIR . '/classes/parse.php';
$parse = new Parse( );
$parse->safe_mode = true;

$uid=intval($_GET['uid']);
$poster_id=intval($_GET['poster_id']);
$game_id=intval($_GET['poster_id']);
$app_name=game_from_cache('nextgame_'.$game_id.'tmp');
$app_logo=game_from_cache('nextgame_'.$game_id.'tmp');
    if(!$app_name)
    {
        $app_name=get_games("apps.getInfo&app_id={$game_id}");
        game_to_cache('nextgame_'.$game_id,$app_name);   
    }
  $game_name=json_decode($app_name,true);
  if(!$app_logo)
    {
        $app_logo=get_games("apps.getInfo&app_id={$game_id}");
        game_to_cache('nextgame_'.$game_id,$app_logo);   
    }
  $game_logo=json_decode($app_logo,true);   
  $game_name=json_decode($app_name,true);    
 $game_link= $config['home_url']."game/".$game_id;   
$message=convert_unicode($_GET['message'],$config['charset']);
 $messages=str_replace('&quot;', '"',$nextgame['message_wall']);
    $messages=str_replace("[game_link]",$game_link,$messages);
    $messages=str_replace("[/game_link]","",$messages);
    $messages=str_replace("{game_name}",convert_unicode($game_name['data'][$game_id]['title'],$config['charset']),$messages);
    $messages=str_replace("{game_logo}", "<img src='http://api2.nextgame.ru/service/picture/app/?app_id=".$game_id."&size=80x80 '>",$messages);
    $messages=$db->safesql($messages);
    $logo = "http://api2.nextgame.ru/service/picture/app/?app_id=".$game_id."&size=80x80";
if($_GET['poster_type']=='app'){
$app= intval($_GET['about_app']);

}else
{
    $app ="support@webelita.com";
}
$str_date = time();
								$db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$uid}', for_user_id = '{$uid}', text = '{$message}<br>{$messages}',code='{$logo}', add_date = '{$str_date}', fast_comm_id = '0'");
								$db_id = $db->insert_id();

							
 	$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$uid}'");
  //Добавляем запись в новости
	$db->query("INSERT INTO `".PREFIX."_news` SET ac_user_id = '{$uid}', action_type = 1, action_text = '{$message}<br>{$messages}', obj_id = '{$db_id}', action_time = '{$str_date}'");
 mozg_clear_cache_file('user_'.$uid.'/profile_'.$uid);
$resp="<posts>post id='$message' user_id='$uid'</posts>";
break;
// Отправляем ПМ
case "sendmessage": 
require_once ENGINE_DIR . '/classes/parse.php';
$parse = new Parse();
$parse->safe_mode = true;

$uid=intval($_GET['uid']);
$sender_id=intval($_GET['sender_id']);
$message=convert_unicode($_GET['message'],$config['charset']);

$message=$parse->BBparse( $parse->process($message ), false );

$subj=strip_tags($db->safesql($nextgame['subj_pm'],$config['charset']));
if($_GET['type']=='user'){
$user=$db->super_query("SELECT user_id,user_name from ".PREFIX."_users where user_id='{$sender_id}'");

}else
{
    $user['user_name']="support@webelita.com";
}

$db->query("INSERT INTO `".PREFIX."_messages` SET theme = '{$subj}', text = '{$message}', for_user_id = '{$uid}', from_user_id = '{$sender_id}', date = '{$server_time}', pm_read = 'no', folder = 'inbox', history_user_id = '{$uid}'");
//Проверка на наличии созданого диалога у себя
						$check_im = $db->super_query("SELECT iuser_id FROM `".PREFIX."_im` WHERE iuser_id = '".$sender_id."' AND im_user_id = '".$uid."'");
						if(!$check_im)
							$db->query("INSERT INTO ".PREFIX."_im SET iuser_id = '".$sender_id."', im_user_id = '".$uid."', idate = '".$server_time."', all_msg_num = 1");
						else
							$db->query("UPDATE ".PREFIX."_im  SET idate = '".$server_time."', all_msg_num = all_msg_num+1 WHERE iuser_id = '".$sender_id."' AND im_user_id = '".$uid."'");
							
						//Проверка на наличии созданого диалога у получателя, а если есть то просто обновляем кол-во новых сообщений в диалоге
						$check_im_2 = $db->super_query("SELECT iuser_id FROM ".PREFIX."_im WHERE iuser_id = '".$uid."' AND im_user_id = '".$sender_id."'");
						if(!$check_im_2)
							$db->query("INSERT INTO ".PREFIX."_im SET iuser_id = '".$uid."', im_user_id = '".$sender_id."', msg_num = 1, idate = '".$server_time."', all_msg_num = 1");
						else
							$db->query("UPDATE ".PREFIX."_im  SET idate = '".$server_time."', msg_num = msg_num+1, all_msg_num = all_msg_num+1 WHERE iuser_id = '".$uid."' AND im_user_id = '".$sender_id."'");

$db->query("UPDATE `".PREFIX."_users` SET user_pm_num = user_pm_num+1 WHERE user_id = '{$uid}'");
$resp="<msg><uid>{$uid}</uid><delivered>1</delivered></msg>";
break;

 case 'sendinvite': /// Инвайт отправим.
    
    if(empty($_GET['uid']) OR intval($_GET['sender_id'])==0 OR intval($_GET['app_id'])==0) die();
    $sender_id=intval($_GET['sender_id']);
    $game_id=intval($_GET['app_id']);
    $uid=intval($_GET['uid']);
    $app_name=game_from_cache('nextgame_'.$game_id.'.tmp');
    if(!$app_name)
    {
        $app_name=get_games("apps.getInfo&app_id={$game_id}");
        game_to_cache('nextgame_'.$game_id,$app_name);   
    }
   if(!$app_logo)
    {
        $app_logo=get_games("apps.getInfo&app_id={$game_id}");
        game_to_cache('nextgame_'.$game_id,$app_logo);   
    }
  $game_logo=json_decode($app_logo,true);
   $logo = "http://api2.nextgame.ru/service/picture/app/?app_id=".$game_id."&size=80x80";        
    $game_name= json_decode($app_name,true);
    $subj= "Приглашение в игру" ;
    $time = time() + ($config['date_adjust'] * 60);
    $game_link= $config['home_url']."game/".$game_id."/?ref_id=".$sender_id;
    $row_send = $db->super_query("SELECT user_name,user_id FROM ".PREFIX."_users where user_id='{$sender_id}'");
    if(!$row_send['user_id']) die("No Such User"); //Фтопку отправлять от анонимов
    
    $gamer =  $row_send['user_name'];  
    $name=  convert_unicode($game_name['data'][$game_id]['title'],$config['charset']);
   $message = " {$gamer} приглашает Вас сыграть в игру {$name}<br />Для начала игры воспользуйтесь ссылкой<br />{$game_link}";
    $message=$db->safesql($message);
    $users=explode(",",$_GET['uid']);
    $query=array();
    $users_id=array();
    foreach($users as $user)
        {
            $users_id[]=intval($user);
            $query[]="('$subj','$message','$user','{$row['user_name']}','$time','no','inbox', '$user')";
            $resp.="<user>$user</user>";
        }
    $invite_recipients=implode(",",$query);
    $invite_recipients_id=implode(",",$users_id);
     $db->query("INSERT INTO `".PREFIX."_wall` SET author_user_id = '{$sender_id}', for_user_id = '{$uid}', text = '{$message}', code='{$code}' , add_date = '{$server_time}', fast_comm_id = '0'");
    $db->query("INSERT INTO `".PREFIX."_messages` SET theme = '{$subj}', text = '{$message}', for_user_id = '{$uid}', from_user_id = '{$sender_id}', date = '{$server_time}', pm_read = 'no', folder = 'inbox', history_user_id = '{$uid}'");
  $check_im = $db->super_query("SELECT iuser_id FROM `".PREFIX."_im` WHERE iuser_id = '".$sender_id."' AND im_user_id = '".$uid."'");
						if(!$check_im)
							$db->query("INSERT INTO ".PREFIX."_im SET iuser_id = '".$sender_id."', im_user_id = '".$uid."', idate = '".$server_time."', all_msg_num = 1");
						else
							$db->query("UPDATE ".PREFIX."_im  SET idate = '".$server_time."', all_msg_num = all_msg_num+1 WHERE iuser_id = '".$sender_id."' AND im_user_id = '".$uid."'");
							
						//Проверка на наличии созданого диалога у получателя, а если есть то просто обновляем кол-во новых сообщений в диалоге
						$check_im_2 = $db->super_query("SELECT iuser_id FROM ".PREFIX."_im WHERE iuser_id = '".$uid."' AND im_user_id = '".$sender_id."'");
						if(!$check_im_2)
							$db->query("INSERT INTO ".PREFIX."_im SET iuser_id = '".$uid."', im_user_id = '".$sender_id."', msg_num = 1, idate = '".$server_time."', all_msg_num = 1");
						else
							$db->query("UPDATE ".PREFIX."_im  SET idate = '".$server_time."', msg_num = msg_num+1, all_msg_num = all_msg_num+1 WHERE iuser_id = '".$uid."' AND im_user_id = '".$sender_id."'"); 
  $db->query("UPDATE `".PREFIX."_users` SET user_pm_num = user_pm_num+1 WHERE user_id = '{$uid}'");
  	$db->query("UPDATE `".PREFIX."_users` SET user_wall_num = user_wall_num+1 WHERE user_id = '{$uid}'");
    $resp="<invite><user>{$uid}</user></invite>";
break;
default:
    $resp="<error>true</error>";
}
@header('Content-type: text/xml');
echo<<<XML
<?xml version="1.0" encoding="UTF-8"?>
$resp
XML;

?>
