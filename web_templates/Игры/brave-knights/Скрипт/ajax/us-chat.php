<?php
define('TIME', time());
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);

//header("Content-Type: text/html; charset=windows-1251");
header("Content-type: text/html; charset=utf-8");

session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) { exit(); }

function __autoload($name){ include(BASE_DIR."/classes/_class.".$name.".php");}

$config = new config;

function relative_date_chat($t, $rdl = '<br />') 
{
  $reldays = ($t - strtotime(date('d.m.Y'))) / 86400;
    
  if ($reldays >= 0 && $reldays < 1)
  { 
    return '<b>Сегодня</b>'.$rdl.date('H:i:s', $t);
  }  
  else if ($reldays >= -1 && $reldays < 0)
  { 
    return '<b>Вчера</b>'.$rdl.date('H:i:s', $t);
  }  
  else 
  {     
    return date('d.m.Y', $t).$rdl.date('H:i:s', $t);     
  }  
}

function parseBBcodeChat($text)
{  
  $smiles = array('{smile01}' => '<img src="/smiles/aa.gif" />',
                  '{smile31}' => '<img src="/smiles/bj.gif" />',
                  '{smile02}' => '<img src="/smiles/ab.gif" />',
                  '{smile03}' => '<img src="/smiles/ac.gif" />',
                  '{smile04}' => '<img src="/smiles/ad.gif" />',
                  '{smile05}' => '<img src="/smiles/ae.gif" />',
                  '{smile06}' => '<img src="/smiles/af.gif" />',
                  '{smile07}' => '<img src="/smiles/ah.gif" />',
                  '{smile08}' => '<img src="/smiles/ai.gif" />',
                  '{smile27}' => '<img src="/smiles/cp.gif" />',
                  '{smile12}' => '<img src="/smiles/am.gif" />',
                  '{smile32}' => '<img src="/smiles/shuher.gif" />',
                  '{smile13}' => '<img src="/smiles/aq.gif" />',
                  '{smile14}' => '<img src="/smiles/ar.gif" />',
                  '{smile15}' => '<img src="/smiles/at.gif" />',
                  '{smile16}' => '<img src="/smiles/ay.gif" />',
                  '{smile17}' => '<img src="/smiles/cs.gif" />',
                  '{smile19}' => '<img src="/smiles/be.gif" />',
                  '{smile21}' => '<img src="/smiles/bm.gif" />',
                  '{smile22}' => '<img src="/smiles/bp.gif" />',
                  '{smile23}' => '<img src="/smiles/bs.gif" />',
                  '{smile33}' => '<img src="/smiles/tos.gif" />',
                  '{smile24}' => '<img src="/smiles/bt.gif" />',
                  '{smile25}' => '<img src="/smiles/cb.gif" />',
                  '{smile10}' => '<img src="/smiles/ak.gif" />',
                  '{smile28}' => '<img src="/smiles/redbul.gif" />',
                  '{smile30}' => '<img src="/smiles/bv.gif" />',
                  '{smile18}' => '<img src="/smiles/ba.gif" />',
                  '{smile09}' => '<img src="/smiles/aj.gif" />',
                  '{smile26}' => '<img src="/smiles/az.gif" />'                         
                    );
  $text = strtr($text, $smiles);
  
  $text = preg_replace("#\[b\](.+)\[\/b\]#isU", '<b>\\1</b>', $text);
  $text = preg_replace("#\[i\](.+)\[\/i\]#isU", '<i>\\1</i>', $text);
  $text = preg_replace("#\[u\](.+)\[\/u\]#isU", '<u>\\1</u>', $text);         
  $text = preg_replace("#\[url\](.+)\[\/url\]#isU",'<a href="\\1" rel="nofollow" target="_blank">\\1</a>',$text);     
    
  $text = nl2br($text);   
  return $text;
}

$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$db->Query("set names cp1251;");

$db->Query("SELECT * FROM db_users_a WHERE id = '".$_SESSION['user_id']."'");
$users_info = $db->FetchAssoc();

$echo = ['status' => 'no', 'msg' => 'Не получается почему-то...'];

if (isset($_POST['mode']))
{
  switch ($_POST['mode']) 
  {
    case 'add_message':

    if (isset($_SESSION['chat_spam_time']) && $_SESSION['chat_spam_time'] + 5 > TIME) { $echo = ['status' => 'no', 'msg' => 'Уважаемый успокойтесь, Вы слишком часто пишите...'];  exit(json_encode($echo)); } 
    
    //if ($users_info['ban_chat'] > TIME) { exit(json_encode(['status' => 'no', 'msg' => '�?звиняйте, но началька решил что Вы нарушитель правил чата. Ожидайте окончания блокировки ещё '.($users_info['ban_chat'] - TIME).' секунд'])); }
    
    //if ($users_info['ban_chat'] > TIME) { exit(json_encode(['status' => 'no', 'msg' => '�?звиняйте, но началька решил что Вы нарушитель правил чата. Ожидайте окончания блокировки ещё '.($users_info['ban_chat'] - TIME).' секунд'])); }
    
    if ($users_info['ban_chat']) { exit(json_encode(['status' => 'no', 'msg' => 'Banned'])); }
    
    
    $pay = 0;
    $user_id = $_SESSION['user_id'];
    $user_name = $users_info['user'];
    $to_user = filter_var(mb_substr($_POST['touser'], 0, 30), FILTER_SANITIZE_STRING);
$message = mb_substr(trim($db->RealEscape($_POST['message'] )), 0, 255);
    $message = filter_var($message, FILTER_SANITIZE_STRING); 
    
    if (empty($message)) { break; }
    
    if (strlen($message) > 20)
    {
      $db->Query('UPDATE db_users_b SET chat = chat + "1" WHERE `user` = "'.$_SESSION["user"].'"');
      $db->Query('UPDATE db_users_b SET chat_money = chat_money + "1" WHERE user = "'.$_SESSION["user"].'"');
		  $db->Query('UPDATE db_users_b SET money_b = money_b + "0" WHERE user = "'.$_SESSION["user"].'"');
    } 
    
    $private = (int)$_POST['private'];
    
    if (!empty($to_user))
    {
      if ($private)
      {
        $to_user_str = '<span style="color: red;">Сообщение -></span> <b style="color: green;">'.$to_user.'</b><br>';   
      } 
      else
      {
        $to_user_str = '<span style="color: black;">Сообщение -></span> <b style="color: green;">'.$to_user.'</b><br>';    
      }
      
      $message = $to_user_str.$message;          
    }  
    
    if (empty($message)) { exit(json_encode($echo)); }
    
    $message = parseBBcodeChat($message);
    
    $db->query("INSERT INTO db_chat_message
        (
          `user_id`,
          `user_name`,
          `user_to_id`,
          `user_to_name`,
          `time_add`,
          `private`,  
          `message`,
          `user_status`,
          `ava`          
        )
        VALUES
        (
          '".$user_id."',
          '".$user_name."',
          '0',
          '".$to_user."', 
          '".TIME."',  
          '".$private."',    
          '".base64_encode($message)."',
          '".$users_info['chat_moder']."',
          '".$users_info['ava']."'
        )");
     
    
    
      $id_message = $db->LastInsert();
     
      $ava = ($users_info['ava']) ? $users_info['ava'] : 'noavatar.png';
      $color = ($users_info['chat_moder']) ? 'red' : '';
      
      $html = '';
      $html = $html.'<div id="'.$id_message.'" class="chat-message-block">';
      $html = $html.'<div class="chat-message-blockleft">';
      $html = $html.'<span class="chat-message-name" style="color: '.$color.';" onclick="message_to_user(this.innerHTML);">'.$user_name.'</span><br>';
      $html = $html.'<img src="/'.$ava.'" style="width: 28px; height: 28px;"/><br>';
      $html = $html.'<span class="chat-message-time">'.relative_date_chat(TIME, $rdl = '<br />').'</span>';
      $html = $html.'</div>';
      $html = $html.'<div class="chat-message-blockright">';
      $html = $html.'<span class="chat-message-text">'.$message.'</span>';
      if ($users_info['chat_moder']) { $html = $html.'<span class="scon-delete" title="Удалить" onclick="delmsg('.$id_message.');"></span>'; }
      $html = $html.'</div>';
      $html = $html.'<div class="chat-clear"></div>';
      $html = $html.'</div>';
         
      $echo = ['status' => 'yes', 'html' => $html];
      
      $_SESSION['chat_spam_time'] = TIME;
     
    
    break;
    
    case 'del_message':
     
    if ($users_info['chat_moder']) 
    {
      $id = (int)$_POST['id'];
     
      $db->query("DELETE FROM db_chat_message WHERE id = '".$id."'"); 
      
      $echo = ['status' => 'yes'];
    }  
     
    break;
    
    case 'refresh':
     
    $last_id = (int)$_POST['id']; 
     
    $db->query("SELECT * FROM db_chat_message WHERE id > '".$last_id."' ORDER BY id ASC");	
  
    $html = '';
    $sound = 0;
    
    if ($db->NumRows())
    {    
      while ($row = $db->FetchAssoc())
      {  
        if ($row['private'] && $row['user_to_name'] != $users_info['user'])
        {
          continue;
        }
        
        $ava = ($row['ava']) ? $row['ava'] : 'noavatar.png';
        $color = ($row['user_status']) ? 'red' : '';
        
        if ($row['user_to_name'] == $users_info['user']) { $sound = 1; }
        
        $html = $html.'<div id="'.$row['id'].'" class="chat-message-block">';
        $html = $html.'<div class="chat-message-blockleft">';
        $html = $html.'<span class="chat-message-name" style="color: '.$color.';"  onclick="message_to_user(this.innerHTML);">'.$row['user_name'].'</span><br>';
        $html = $html.'<img src="/'.$ava.'" style="width: 28px; height: 28px;"/><br>';
        $html = $html.'<span class="chat-message-time">'.relative_date_chat($row['time_add'], $rdl = '<br />').'</span>';
        $html = $html.'</div>';
        $html = $html.'<div class="chat-message-blockright">';
        $html = $html.'<span class="chat-message-text">'.base64_decode($row['message']).'</span>';
        if ($users_info['chat_moder']) { $html = $html.'<span class="scon-delete" title="Удалить" onclick="delmsg('.$row['id'].');"></span>'; }
        $html = $html.'</div>';
        $html = $html.'<div class="chat-clear"></div>';
        $html = $html.'</div>';  
      }
    }
    
    
    $db->query("SELECT * FROM db_chat_online");	
  
    $html2 = '';
    
    $sound_new = 0;
    
    if ($db->NumRows())
    {        
      $sound_new = $db->NumRows();
      
      while ($row = $db->FetchAssoc())
      {
        if ($row['user_id'] == $_SESSION['user_id'])
        {
          $user_is = 1;        
        } 
       
        $ban = ($users_info['chat_moder'] && $row['user_id'] != $_SESSION['user_id'] && !$row['status']) ? '<span class="chat-ban" onclick="chat_ban('.$row['user_id'].');"></span>' : '';
        
        
          
        $ava = ($row['ava']) ? $row['ava'] : 'noavatar.png';
        $color = ($row['status']) ? 'red' : '';
        $banan = ($row['banan']) ? 'text-decoration: line-through;' : '';
        
        $html2 = $html2.'<div class="chat-online-block"><img src="/'.$ava.'" style="width: 28px; height: 28px;"/><div class="chat-online-name" style="color: '.$color.'; '.$banan.'" onclick="message_to_user(this.innerHTML);" title="Сообщение пользователю '.$row['user_name'].'">'.$row['user_name'].'</div>'.$ban.'</div>';
      }
    }
    
    if (!$user_is)
    {
      $db->query("INSERT INTO db_chat_online
        (
          `user_id`,
          `user_name`,
          `ava`,
          `time_add`,
          `color`
        )
        VALUES
        (
          '".$_SESSION['user_id']."',
          '".$users_info['user']."',
          '".$users_info['ava']."', 
          '".TIME."',
          '' 
        )");
    
      $ava = ($users_info['ava']) ? $users_info['ava'] : 'noavatar.png';
      $color = ($users_info['chat_moder']) ? 'red' : '';
      $banan = ($users_info['banan']) ? 'text-decoration: line-through;' : '';
      $ban = ($users_info['chat_moder'] && $row['user_id'] != $_SESSION['user_id'] && !$row['status']) ? '<span class="chat-ban" onclick="chat_ban('.$row['user_id'].');"></span>' : '';
        
        
      
      $html2 = $html2.'<div class="chat-online-block"><img src="/'.$ava.'" style="width: 28px; height: 28px;"/><div class="chat-online-name" style="color: '.$color.'; '.$banan.'" onclick="message_to_user(this.innerHTML);" title="��������� ������������ '.$users_info['user'].'">'.$users_info['user'].'</div>'.$ban.'</div>';
    
    }
    
    $db->query("UPDATE db_chat_online SET time_add = '".TIME."' WHERE user_id = '".$_SESSION['user_id']."'");       
     
    $db->query("DELETE FROM db_chat_online WHERE time_add < '".(TIME - (5 + 10))."'");	
          
    $echo = ['status' => 'yes', 'html' => $html, 'html2' => $html2, 'sound' => $sound, 'sound_new' => $sound_new];
     
    break; 
    
    case 'ban_users':
     
    if ($users_info['chat_moder']) 
    {
      $id = (int)$_POST['id'];
      $bantime = 1;
      //$bantime = (int)$_POST['bantime'];
      
      //$bantime = $bantime + TIME;
     
      $db->query("UPDATE db_users_a SET ban_chat = '".$bantime."' WHERE id = '".$id."'");       
    
      $echo = ['status' => 'yes'];
    } 
     
    break; 

    case 'add_reklama':
     
    if ($_SESSION['user_id'] == 51 || isset($_SESSION['admin']))  
    {
      $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING); 
      
      $message = iconv('utf-8', 'windows-1251', $message);
      
      $db->query("UPDATE db_chat_reklama SET reklama = '".$message."'");   
      
      $echo = ['status' => 'yes'];
    } 
     
    break; 
    
    default:
    break;
  } 
} 

exit(json_encode($echo));
?>


