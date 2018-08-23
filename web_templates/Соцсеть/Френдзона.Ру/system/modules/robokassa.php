<?php
if(!defined('MOZG'))
	die('Hacking attempt!');

if($ajax == 'yes')
	NoAjaxQuery();


if($logged){
	$user_id = $user_info['user_id'];
	$act = $_GET['act'];
	$metatags['title'] = "Пополнение через робокассу";
  	switch($act){
		 //################### Отправляем счет в бд  ###################//
  case "metodbox_inter_send":
  	
			NoAjaxQuery();
  
  
   $user_id = $user_info['user_id'];
   $min = intval($_POST['min']);
 
    if($min ){
  $db->query("INSERT INTO `".PREFIX."_payments` SET payment_user = '{$user_id}', payment_datecreat= '{$server_time}',payment_datepay = '0', payment_cont = 'неоплачен', payment_money = '{$min}', payment_system = 'robokassa'");
   	echo '1';

                } else {

                    echo '2';  
					
                }
   AjaxTpl();
  die();
  $tpl->clear();
  $db->free();
  
  case "outsumm":
  	
$user_id = $user_info['user_id'];
$mrh_login = "sad";
$mrh_pass1 = "dsa";
$in_curr = "";
$culture = "ru";
$shp_item = "1";
$encoding = "utf-8";
$inv_desc = "Пополнение баланса vzex.ru";
$sql_ = $db->super_query("SELECT * FROM `".PREFIX."_payments` WHERE payment_user = '".$user_id."' ORDER BY `payment_id`   DESC LIMIT 0, 1", 1);
 
     
     $tpl->load_template('robokassa/order.tpl');
      foreach($sql_ as $row){
				$inv_id = $row['payment_id'] ;
 $out_summ = $row['payment_money'] ;
 $crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");	
					$tpl->set('{money}', $row['payment_money']);
					$tpl->set('{mrh_login}', $mrh_login);
					$tpl->set('{out_summ}', $row['payment_money']);
          $tpl->set('{inv_id}', $row['payment_id']);
          $tpl->set('{inv_desc}', $inv_desc);
          $tpl->set('{crc}', $crc);
          $tpl->set('{shp_item}', $shp_item);
          $tpl->set('{in_curr}', $in_curr);
          $tpl->set('{culture}', $culture);
          $tpl->set('{encoding}', $encoding);
					$tpl->compile('content');
				}
  
 	break;
  

  
  
  
case "success":
$mrh_pass1 = "asdasd";
$user_id = $user_info['user_id'];
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["Shp_item"];
$crc = $_REQUEST["SignatureValue"];

$crc = strtoupper($crc);

$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item"));

// проверка корректности подписи
// check signature
if ($my_crc != $crc)
{
  $tpl->load_template('robokassa/hack.tpl');
 $tpl->compile('content');
}else{
  	$db->query("UPDATE `".PREFIX."_users` SET balance_rub = balance_rub + '{$out_summ}' WHERE user_id = '{$user_id}'");
    $db->query("UPDATE `".PREFIX."_payments` SET payment_cont = 'оплачено' WHERE payment_id = '{$inv_id}'");
 $tpl->load_template('robokassa/success.tpl');
  
    $tpl->set('{money}', $out_summ );
   $tpl->compile('content');
  
  	
}

  
 	break;    
   
 case "fail":
  	
$inv_id = $_REQUEST["InvId"];
$tpl->load_template('robokassa/fail.tpl');
 $tpl->compile('content');
  
 	break;       
    
	default:
  $user_id = $user_info['user_id'];
   $row = $db->super_query("SELECT user_photo, user_id, user_balance, balance_rub FROM `".PREFIX."_users` WHERE user_id = '{$user_id}'");  
 $tpl->load_template('robokassa/robokassa.tpl');
 
 if($row['user_photo']){
    $tpl->set('{ava}', $config['home_url'].'uploads/users/'.$row['user_id'].'/50_'.$row['user_photo']);
   } else {
    $tpl->set('{ava}', '/templates/Old/images/no_ava.gif');
   }
   $tpl->set('{balance}', $row['user_balance']);
 
 
 
 $tpl->compile('content'); 
 }
$tpl->clear();
	$db->free();
} else {
	$user_speedbar = $lang['no_infooo'];
	msgbox('', $lang['not_logged'], 'info');
}
?>

