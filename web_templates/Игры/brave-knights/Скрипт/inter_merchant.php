<?PHP
# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}

# Класс конфига 
$config = new config;

# Функции
$func = new func;

# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$pref = $config->BasePrefix;
//extract($_POST);

$fk_merchant_id = '22202'; //merchant_id ID мазагина в free-kassa.ru (http://free-kassa.ru/merchant/cabinet/help/)
$fk_merchant_key = 'z46j38fr'; //Секретное слово http://free-kassa.ru/merchant/cabinet/profile/tech.php
$fk_merchant_key2 = 'lh5pcik9'; //Секретное слово2 (result) http://free-kassa.ru/merchant/cabinet/profile/tech.php

$ik_payment_amount = round(floatval($_POST['AMOUNT']),2);
$user_id = intval($_POST['us_id']);
	
$hash = md5($fk_merchant_id.":".$_POST['AMOUNT'].":".$fk_merchant_key2.":".$_POST['MERCHANT_ORDER_ID']);

if ($hash != $_POST['SIGN']) die("SumError");
    
   
   	# Настройки
	$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
	$sonfig_site = $db->FetchArray();
   
   $db->Query("SELECT user, referer_id FROM ".$pref."_users_a WHERE id = '{$user_id}' LIMIT 1");
   $user_ardata = $db->FetchArray();
   $user_name = $user_ardata["user"];
   $refid = $user_ardata["referer_id"];
   
   
   
  # Зачисляем баланс
   $serebro = sprintf("%.4f", floatval($sonfig_site["ser_per_wmr"] * $ik_payment_amount) );
   
   $db->Query("SELECT insert_sum FROM ".$pref."_users_b WHERE id = '{$user_id}' LIMIT 1");
   $ins_sum = $db->FetchRow();
   
   $serebro = intval($ins_sum <= 0.01) ? ($serebro + ($serebro * 0.50) ) : $serebro;
   $add_tree = ( $ik_payment_amount >= 499.99) ? 2 : 0;
   $lsb = time();
   $to_referer = ($ik_payment_amount * 0.10)*100;

   
   //Credit
   $db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '{$user_id}'");
   $cr = $db->FetchArray();
   if($cr['credit'] == 0) {
   $db->Query("UPDATE ".$pref."_users_b SET money_b = money_b + '$serebro',  to_referer = to_referer + '$to_referer', last_sbor = '$lsb', insert_sum = insert_sum + '$ik_payment_amount' WHERE id = '{$user_id}'");
   } else { 
   $money  = sprintf("%.4f", floatval($sonfig_site["ser_per_wmr"] * $ik_payment_amount) );
   if($cr['credit'] < $money) {
   $mon = $money - $cr['credit'];
   $mone = $money - $mon;
   
   }else{
   $mone = $money;
   }
   $db->Query("UPDATE ".$pref."_users_b SET money_b = money_b + '$mon', to_referer = to_referer + '$to_referer', insert_sum = insert_sum + '$ik_payment_amount', credit = credit - '$mone' WHERE id = '{$user_id}'");
   }
   
  // echo $bill;

  
   # Зачисляем средства рефереру и дерево
   $add_tree_referer = ($ins_sum <= 0.01) ? ", a_t = a_t + 0" : "";
   $db->Query("UPDATE ".$pref."_users_b SET money_b = money_b + $to_referer, from_referals = from_referals + '$to_referer' {$add_tree_referer} WHERE id = '$refid'");
   
   
   
   # Статистика пополнений
   $da = time();
   $dd = $da + 60*60*24*15;
   $db->Query("INSERT INTO ".$pref."_insert_money (user, user_id, money, serebro, date_add, date_del) 
   VALUES ('$user_name','$user_id','$ik_payment_amount','$serebro','$da','$dd')");
   
   
   
   # Обновление статистики сайта
   $db->Query("UPDATE ".$pref."_stats SET all_insert = all_insert + '$ik_payment_amount' WHERE id = '2'");
   
  
   
   # Конкурс
$competition = new competition($db);
$competition->UpdatePoints($user_id, $ik_payment_amount);
#--------
   
   $db->Query("UPDATE ".$pref."_users_b SET a_t = a_t + '$a_t', b_t = b_t + '$b_t', c_t = c_t + '$c_t', d_t = d_t + '$d_t', e_t = e_t + '$e_t', 
   last_sbor = '$lsb', insert_sum = insert_sum + '$ik_payment_amount' WHERE id = '{$user_id}'");


?>