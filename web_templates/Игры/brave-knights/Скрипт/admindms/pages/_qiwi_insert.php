<div class="s-bk-lf">
	<div class="acc-title3">Пополнение киви</div>
</div>
<div class="silver-bk"><div class="clr"></div>		
<?PHP

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

# Выплачено
if(isset($_POST["payment"])){

$ret_id = intval($_POST["payment"]);
$db->Query("SELECT * FROM ".$pref."_qiwi_insert WHERE id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	
$ret_data = $db->FetchArray();

   $user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];

	$serebro = $ret_data["sum"] * $sonfig_site["ser_per_wmr"];
	$ik_payment_amount = $ret_data["sum"];
	
	# Зачисляем баланс
   $serebro = sprintf("%.4f", floatval($sonfig_site["ser_per_wmr"] * $ik_payment_amount) );
   $db->Query("SELECT user, referer_id FROM ".$pref."_users_a WHERE id = '{$user_id}' LIMIT 1");$user_ardata = $db->FetchArray();
	$user_name = $user_ardata["user"];
	$refid = $user_ardata["referer_id"];
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
   $db->Query("UPDATE ".$pref."_users_b SET money_b = money_b + '$serebro',  to_referer = to_referer + '$to_referer', last_sbor = '$lsb', insert_sum = insert_sum + '$sum' WHERE id = '{$user_id}'");
   } else { 
   $money  = sprintf("%.4f", floatval($sonfig_site["ser_per_wmr"] * $sum) );
   if($cr['credit'] < $money) {
   $mon = $money - $cr['credit'];
   $mone = $money - $mon;
   
   }else{
   $mone = $money;
   }
   $db->Query("UPDATE ".$pref."_users_b SET money_b = money_b + '$mon', to_referer = to_referer + '$to_referer', insert_sum = insert_sum + '$sum', credit = credit - '$mone' WHERE id = '{$user_id}'");
   }
   
  # Зачисляем средства рефереру и дерево
   $add_tree_referer = ($ins_sum <= 0.01) ? ", a_t = a_t + 0" : "";
   $db->Query("UPDATE ".$pref."_users_b SET money_b = money_b + '$to_referer', from_referals = from_referals + '$to_referer' {$add_tree_referer} WHERE id = '$refid'");
	$refid = $user_ardata["referer_id"];
		 


	# Статистика пополнений
   $da = time();
   $dd = $da + 60*60*24*15;
   $sums = 'Qiwi';
   $db->Query("INSERT INTO ".$pref."_insert_money (user, user_id, money, serebro, date_add, date_del) 
   VALUES ('$user_name','$user_id','$sum','$serebro','$da','$dd')");
  

# Конкурс
$competition = new competition($db);
$competition->UpdatePoints($user_id, $sum);
#--------





# Обновление статистики сайта
	$db->Query("UPDATE ".$pref."_stats SET all_insert = all_insert + '$sum' WHERE id = '1'");
		
		$db->Query("DELETE FROM ".$pref."_qiwi_insert WHERE id = '$ret_id'");
	
		echo "<center><b>Зачислено, статистика обновлена</b></center><BR />";
		
	}else echo "<center><b>Заявка не найдена :(</b></center><BR />";

}

# Отказ в пополнении
if(isset($_POST["return"])){

$ret_id = intval($_POST["return"]);
$db->Query("SELECT * FROM ".$pref."_qiwi_insert WHERE id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
		
		$db->Query("DELETE FROM ".$pref."_qiwi_insert WHERE id = '$ret_id'");
		
		echo "<center><b>Заявка на пополнение отклонена</b></center><BR />";
		
	}else echo "<center><b>Заявка не найдена :(</b></center><BR />";

}




$db->Query("SELECT * FROM ".$pref."_qiwi_insert");
$ast = $db->NumRows();
if($ast > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" class="m-tb">Пользователь</td>
    <td align="center" class="m-tb">Сумма</td>
	<td align="center" class="m-tb">Ваучер</td>
	<td align="center" class="m-tb">Отказать</td>
	<td align="center" class="m-tb">Зачислить</td>
  </tr>

<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
	<td align="center"><?=$data["user"]; ?></td>
    <td align="center"><?=$data["sum"]; ?></td>
	<td align="center"><input type="text" value="<?=$data["vaycher"]; ?>" /></td>
  	<td align="center">
	
		<form action="" method="post">
			<input type="hidden" name="return" value="<?=$data["id"]; ?>" />
			<input type="submit" value="Отказать" class="btn_8"/>
		</form>
	
	</td>
	<td align="center">
	
		<form action="" method="post">
			<input type="hidden" name="payment" value="<?=$data["id"]; ?>" />
			<input type="submit" value="Зачислить"class="btn_8" />
		</form>
	
	</td>
	</tr>
	<?PHP
	
	}

?>

</table>
<?PHP

}else echo "<center><b>Нет заявок на пополнение через Qiwi</b></center><BR />";

?>
</div>
<div class="clr"></div>
