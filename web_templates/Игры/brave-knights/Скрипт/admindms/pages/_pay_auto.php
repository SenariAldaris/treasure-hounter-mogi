<div class="s-bk-lf">
	<div class="acc-title3">������ ������</div>
</div>
<div class="silver-bk"><div class="clr"></div>	

<center><a href="index.php?menu=pay_auto">������� �������</a> || <a href="index.php?menu=pay_auto&status">�������� �������</a></center>
<BR />
<?PHP

# �������
if(isset($_POST["return"])){

$ret_id = intval($_POST["return"]);
$db->Query("SELECT * FROM ".$pref."_payment WHERE (status = '0' OR status = '1') AND id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
	$serebro = $ret_data["serebro"];
		
		$db->Query("UPDATE ".$pref."_users_b SET money_p = money_p + '$serebro' WHERE id = '$user_id'");
		$db->Query("UPDATE ".$pref."_payment SET status = '2' WHERE id = '$ret_id'");
		
		echo "<center><b>������ ��������, �������� ����������</b></center><BR />";
		
	}else echo "<center><b>������ �� �������, �������� ��� ��� ���������</b></center><BR />";

}


####################### �������� �������� ###########################
if(isset($_GET["status"])){

	
	# �������
	if(isset($_POST["get_status"])){
	
	$get_status_id = intval($_POST["get_status"]);
	$db->Query("SELECT * FROM ".$pref."_payment WHERE status = '1' AND id = '{$get_status_id}'");
	
		if($db->NumRows() == 1){
		
		$get_status = $db->FetchArray();
		
		$user_id = $get_status["user_id"];
		$sum = $get_status["sum"];
		$payment_id = $get_status["payment_id"];	
			
			$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
			if ($payeer->isAuth())
			{
			
				$arHistory = $payeer->getHistoryInfo($payment_id);
				if($arHistory["info"]["status"] == "execute"){
					
					
						$db->Query("UPDATE ".$pref."_users_b SET payment_sum = payment_sum + '$sum' WHERE id = '$user_id'");
						$db->Query("UPDATE ".$pref."_stats SET all_payments = all_payments + '$sum' WHERE id = '1'");
						$db->Query("UPDATE ".$pref."_payment SET status = '3' WHERE id = '$get_status_id'");
						$db->Query("UPDATE ".$pref."_payment SET response = '1' WHERE id = '$get_status_id'");
						
						echo "<center><b>������ ���������� ������� � ������� �� ������ ���������</b></center><BR />";
				
				}else echo "<center><b>������ ��� �� ����������, ������ ������ �� Payeer.com = ".$arHistory["info"]["status"]."</b></center><BR />";
				
				$db->Query("UPDATE ".$pref."_payment SET response = '1' WHERE id = '$get_status_id'");
				
			}else echo "<center><b>�� ������� �������������� �� Payeer.com</b></center><BR />";
			
		}else echo "<center><b>������ �� �������, �������� ��� ��� ���������</b></center><BR />";
	
	}


	# ������ ������ � ��������
	$db->Query("SELECT * FROM ".$pref."_payment WHERE status = '1' ORDER BY id");
	
	if($db->NumRows() > 0){
	
		while($paydata = $db->FetchArray()){
		
		?>
		
			<div style="border:1px solid #336699; padding:10px;">			
				<table width="100%" border="0">
				  <tr bgcolor="#EACCA2">
					<td style="padding-left:10px;"><b>������������:</b></td>
					<td align="center"><?=$paydata["user"]; ?> [ID <?=$paydata["user_id"]; ?>]</td>
				  </tr>
				  <tr bgcolor="#EACCA2">
					<td style="padding-left:10px;"><b>��������� �������:</b></td>
					<td align="center"><?=$paydata["pay_sys"]; ?> [ID <?=$paydata["pay_sys_id"]; ?>]</td>
				  </tr>
				  <tr bgcolor="#EACCA2">
					<td style="padding-left:10px;"><b>�������:</b></td>
					<td align="center"><?=$paydata["purse"]; ?></td>
				  </tr>
				  <tr bgcolor="#EACCA2">
					<td style="padding-left:10px;"><b>������ �������:</b></td>
					<td align="center"><?=$paydata["valuta"]; ?></td>
				  </tr>
				  <tr bgcolor="#EACCA2">
					<td style="padding-left:10px;"><b>����� / �������� / �������:</b></td>
					<td align="center"><?=$paydata["sum"]; ?> / <?=$paydata["comission"]; ?> / <?=$paydata["sum"] - $paydata["comission"]; ?></td>
				  </tr>
				  <tr bgcolor="#EACCA2">
					<td style="padding-left:10px;"><b>������� �������:</b></td>
					<td align="center"><?=$paydata["serebro"]; ?></td>
				  </tr>
				  <tr>
					<td align="center">&nbsp;</td>
					<td align="center">&nbsp;</td>
				  </tr>
				  <tr>
					<td align="center">
					<?PHP if($paydata["response"] > 0) { ?>
					<form action="" method="post">
						<input type="hidden" name="return" value="<?=$paydata["id"]; ?>" />
						<input type="submit" value="�������� ������" class="btn_8"/>
					</form>
					<?PHP }else echo "&nbsp;"; ?>
					</td>
					<td align="center">
					<form action="" method="post">
						<input type="hidden" name="get_status" value="<?=$paydata["id"]; ?>" />
						<input type="submit" value="��������� ������" class="btn_8"/>
					</form>
					</td>
				  </tr>
				</table>
			</div>
			<BR />
		<?PHP
		
		}
	
	
	}else echo "<center><b>������ ��������� �������� ������� ���</b></center><BR />";

?></div><div class='clr'></div><?PHP
return;
}



# ���������
if(isset($_POST["payment"])){

$payment_id = intval($_POST["payment"]);
$db->Query("SELECT * FROM ".$pref."_payment WHERE status = '0' AND id = '{$payment_id}'");

	if($db->NumRows() == 1){
	
	$payment_data = $db->FetchArray();
	
	$user_id = $payment_data["user_id"];
	$sum = $payment_data["sum"];
	$serebro = $payment_data["serebro"];
	$comission = $payment_data["comission"];
	$valuta = $payment_data["valuta"];
	$pay_sys_id = $payment_data["pay_sys_id"];
	$purse = $payment_data["purse"];
	
	$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
	if ($payeer->isAuth())
	{
		
		$arBalance = $payeer->getBalance();
		if($arBalance["auth_error"] == 0)
		{
			
			$balance = $arBalance["balance"]["RUB"]["DOSTUPNO"];
			if( ($balance) >= ($sum+50)){
				
				$sum_to_payment = round($sum - $comission,2);
				$initOutput = $payeer->initOutput(array(
				// id ��������� ������� ���������� �� ������ ��������� ������
				'ps' => $pay_sys_id,
				// ����, � �������� ����� ������� ��������        
				'curIn' => 'RUB',
				// ����� ������
				'sumOut' => $sum_to_payment,
				// ������ ������
				'curOut' => $valuta,
				// ����� �������� ���������� �������
				'param_ACCOUNT_NUMBER' => $purse
				));
				
				if ($initOutput)
				{
					// ����� �������
					$historyId = $payeer->output();
					if ($historyId)
					{
						$db->Query("UPDATE ".$pref."_payment SET status = '1', payment_id = '$historyId' WHERE id = '$payment_id'");
						echo "<center>������� ���������� � ������� �� ���������� [ID".$historyId."] <BR /> �� �������� ��������� �� ������ ����� 3-5 �����</center><BR />";
						
					}
					else
					{
						echo "<center><font color = 'red'>������:".iconv('utf-8', 'windows-1251', ('<pre>'.print_r($payeer->getErrors(), true).'</pre>'))."</font></center><BR />";
					}
				}
				else
				{
					echo "<center><font color = 'red'>������:".iconv('utf-8', 'windows-1251', ('<pre>'.print_r($payeer->getErrors(), true).'</pre>'))."</font></center><BR />";
				}
			
			}else echo '<center><font color = "red">����� ������ ������� �� ����� ������� ������ ���������� �� ����� 50 RUB! � ������ ������ �� ����� ������� '.$balance.' RUB, ���� ������� ��� ������� �� ��������� ������ 50 RUB! 
			������ ������� ����������! ��������� ������!</font></center><BR />';
	
		}else echo '<center><font color = "red">�� ������� ��������� ������ �� Payeer.com!</font></center><BR />';
		
	}else echo '<center><font color = "red">�� ������� �������������� �� Payeer.com!</font></center><BR />';
		
	}else echo "<center><b>������ �� �������, �������� ��� ��� ���������</b></center><BR />";

}

# ������ ���������
$db->Query("SELECT * FROM ".$pref."_payment WHERE status = '0' ORDER BY id");

if($db->NumRows() > 0){

	while($paydata = $db->FetchArray()){
	
	?>
	
		<div style="border:1px solid #336699; padding:10px;">			
			<table width="100%" border="0">
			  <tr bgcolor="#EACCA2">
				<td style="padding-left:10px;"><b>������������:</b></td>
				<td align="center"><?=$paydata["user"]; ?> [ID <?=$paydata["user_id"]; ?>]</td>
			  </tr>
			  <tr bgcolor="#EACCA2">
				<td style="padding-left:10px;"><b>��������� �������:</b></td>
				<td align="center"><?=$paydata["pay_sys"]; ?> [ID <?=$paydata["pay_sys_id"]; ?>]</td>
			  </tr>
			  <tr bgcolor="#EACCA2">
				<td style="padding-left:10px;"><b>�������:</b></td>
				<td align="center"><?=$paydata["purse"]; ?></td>
			  </tr>
			  <tr bgcolor="#EACCA2">
				<td style="padding-left:10px;"><b>������ �������:</b></td>
				<td align="center"><?=$paydata["valuta"]; ?></td>
			  </tr>
			  <tr bgcolor="#EACCA2">
				<td style="padding-left:10px;"><b>����� / �������� / �������:</b></td>
				<td align="center"><?=$paydata["sum"]; ?> / <?=$paydata["comission"]; ?> / <?=$paydata["sum"] - $paydata["comission"]; ?></td>
			  </tr>
			  <tr bgcolor="#EACCA2">
				<td style="padding-left:10px;"><b>������� �������:</b></td>
				<td align="center"><?=$paydata["serebro"]; ?></td>
			  </tr>
			  <tr>
				<td align="center">&nbsp;</td>
				<td align="center">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="center">
				<form action="" method="post">
					<input type="hidden" name="return" value="<?=$paydata["id"]; ?>" />
					<input type="submit" value="�������� ������" class="btn_8"/>
				</form>
				</td>
				<td align="center">
				<form action="" method="post">
					<input type="hidden" name="payment" value="<?=$paydata["id"]; ?>" />
					<input type="submit" value="���������" class="btn_8"/>
				</form>
				</td>
			  </tr>
			</table>
		</div>
		<BR />
	<?PHP
	
	}


}else echo "<center><b>������ �� ������� ���</b></center><BR />";

/*
# ���������
if(isset($_POST["payment"])){

$ret_id = intval($_POST["payment"]);
$db->Query("SELECT * FROM db_payment WHERE status = '0' AND id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
	$serebro = $ret_data["serebro"];
		
		$db->Query("UPDATE db_users_b SET payment_sum = payment_sum + '$sum' WHERE id = '$user_id'");
		$db->Query("UPDATE db_payment SET status = '1' WHERE id = '$ret_id'");
		$db->Query("UPDATE db_stats SET all_payments = all_payments + '$sum' WHERE id = '1'");
		
		
		echo "<center><b>���������, ���������� ���������</b></center><BR />";
		
	}else echo "<center><b>������ �� ������� :(</b></center><BR />";

}

# �������
if(isset($_POST["return"])){

$ret_id = intval($_POST["return"]);
$db->Query("SELECT * FROM db_payment WHERE status = '0' AND id = '{$ret_id}'");

	if($db->NumRows() == 1){
	
	$ret_data = $db->FetchArray();
	
	$user_id = $ret_data["user_id"];
	$sum = $ret_data["sum"];
	$serebro = $ret_data["serebro"];
		
		$db->Query("UPDATE db_users_b SET money_p = money_p + '$serebro' WHERE id = '$user_id'");
		$db->Query("UPDATE db_payment SET status = '2' WHERE id = '$ret_id'");
		
		echo "<center><b>������ ��������, �������� ����������</b></center><BR />";
		
	}else echo "<center><b>������ �� ������� :(</b></center><BR />";

}




$db->Query("SELECT * FROM db_payment WHERE status = '0'");
$ast = $db->NumRows();
if($ast > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
	<td align="center" class="m-tb">��������</td>
    <td align="center" class="m-tb">������������</td>
    <td align="center" width="75" class="m-tb">�����</td>
	<td align="center" width="100" class="m-tb">�������</td>
	<td align="center" width="50" class="m-tb">�������</td>
	<td align="center" width="50" class="m-tb">���������</td>
  </tr>

<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center"><?=$data["pay_sys"]; ?></td>
	<td align="center"><?=$data["user"]; ?></td>
	<td align="center"><?=sprintf("%.2f", $data["sum"]); ?> <?=$config->VAL; ?></td>
	<td align="center"><input type="text" value="<?=$data["purse"]; ?>" size="12"/></td>
  	<td align="center">
	
		<form action="" method="post">
			<input type="hidden" name="return" value="<?=$data["id"]; ?>" />
			<input type="submit" value="�������" class="btn_8"/>
		</form>
	
	</td>
	<td align="center">
	
		<form action="" method="post">
			<input type="hidden" name="payment" value="<?=$data["id"]; ?>" />
			<input type="submit" value="���������" />
		</form>
	
	</td>
	</tr>
	<?PHP
	
	}

?>

</table>
<?PHP

}else echo "<center><b>��� ������ ��� �������</b></center><BR />";

*/
?>
</div><div class='clr'></div>
