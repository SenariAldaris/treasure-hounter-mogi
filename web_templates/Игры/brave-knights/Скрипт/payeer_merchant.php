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


		
	
	
if (isset($_POST["m_operation_id"]) && isset($_POST["m_sign"]))
{
	$m_key = $config->secretW;
	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);
	
	$sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));
	if ($_POST["m_sign"] == $sign_hash && $_POST['m_status'] == "success")
	{
		
	$db->Query("SELECT * FROM ".$pref."_payeer_insert WHERE id = '".intval($_POST['m_orderid'])."'");
	if($db->NumRows() == 0){ echo $_POST['m_orderid']."|error"; exit;}
	
	$payeer_row = $db->FetchArray();
	if($payeer_row["status"] > 0){ echo $_POST['m_orderid']."|success"; exit;}
	
	
	if($_POST['m_amount'] != $payeer_row["sum"]) { echo $_POST['m_orderid']."|success"; exit;}
	
	$db->Query("UPDATE ".$pref."_payeer_insert SET status = '1' WHERE id = '".intval($_POST['m_orderid'])."'");
	
	$ik_payment_amount = $payeer_row["sum"];
	$user_id = $payeer_row["user_id"];
   
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
   
   # Конкурс
$competition = new competition($db);
$competition->UpdatePoints($user_id, $ik_payment_amount);
#--------
   
	# Обновление статистики сайта
	$db->Query("UPDATE ".$pref."_stats SET all_insert = all_insert + '$ik_payment_amount' WHERE id = '2'");
	
  
   
   
   
   $db->Query("UPDATE ".$pref."_users_b SET a_t = a_t + '$a_t', b_t = b_t + '$b_t', c_t = c_t + '$c_t', d_t = d_t + '$d_t', e_t = e_t + '$e_t', 
   last_sbor = '$lsb' WHERE id = '{$user_id}'");
	
	echo $_POST['m_orderid']."|success";
	exit;
	
	
	}
	echo $_POST['m_orderid']."|error";
}
?>