<div class="block1
"><div class="h-title1
">����� �������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<br>
<?PHP
$_OPTIMIZATION["title"] = "������� - ����� �������";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_users_a WHERE id = '$usid' LIMIT 1");
$user_dataa = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

$status_array = array( 0 => "�����������", 1 => "�������������", 2 => "��������", 3 => "���������");

if($cfg['auto'] == 1) {
	
?>
<center><b><font color="red">����������� ������ �� 03.03.2016 � 00:00</font></b></center><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<center> <img src="/img/Payeer1.gif"> </center>
<center> ����������� ����� ������ - 0.50 ���<BR /><BR />
<hr>
<center><b>������� �������������� � �������������� ������ � ������ �� ��������� ������� PAYEER! ������� ��� ������ ���������� 0%</b> <BR /><BR />
<b>�� ��������� ������� Payeer �� ������ ������� ���� �������� � �������������� ������ �� ��� ��������� ��������� ������� � ������������� �����.</b><BR /><BR /></center>
<center><b>������ �� ������� ���������:</b><BR />
 - <a href="https://payeer.com/?partner=1840679" target="_blank">�������� ����� � Payeer</a> <BR />
 - <a href="https://payeer.com/?partner=1840679" target="_blank">����� ������� �� payeer</a> <BR /></center><BR />

<?PHP
	
	# ������� �������
	if(isset($_POST["sum"])){
		$purse = $user_dataa['purse'];
		//$purse = $func->ViewPurse($_POST["purse"]);
		$sum = intval($_POST["sum"]);
		$val = "RUB";
		
		if(!empty($purse)){
			
			$proc_pay = $user_data["insert_sum"] + ($user_data["insert_sum"] * 0.5);
            $pay_sum = ($proc_pay - $user_data["payment_sum"]);
            if(($sum/$sonfig_site["ser_per_wmr"]) <= $pay_sum){
				
					if($sum >= $minPay){
				
						if($sum <= $user_data["money_p"]){
						
							# ��������� �� ������������ ������
							$db->Query("SELECT COUNT(*) FROM ".$pref."_payment WHERE user_id = '$usid' AND (status = '0' OR status = '1')");
							if($db->FetchRow() == 0){
								
								
								### ������ ������� ###	
								$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
								if ($payeer->isAuth())
								{
								
									$arBalance = $payeer->getBalance();
									if($arBalance["auth_error"] == 0)
									{
									
										$sum_pay = round( ($sum / $sonfig_site["ser_per_wmr"]), 2);
										
										$balance = $arBalance["balance"]["RUB"]["DOSTUPNO"];
										if( ($balance) >= ($sum_pay+1)){
									
										
										
										$arTransfer = $payeer->transfer(array(
										'curIn' => 'RUB', // ���� ��������
										'sum' => $sum_pay, // ����� ���������
										'curOut' => 'RUB', // ������ ���������
										'to' => $purse, // ���������� (email)
										//'to' => '+71112223344',  // ���������� (�������)
										//'to' => 'P1000000',  // ���������� (����� �����)
										'comment' => iconv('windows-1251', 'utf-8', "������� ������������ {$usname} � ������� Brave-Knights.biz")
										//'anonim' => 'Y', // ��������� �������
										//'protect' => 'Y', // ��������� ������
										//'protectPeriod' => '3', // ������ ��������� (�� 1 �� 30 ����)
										//'protectCode' => '12345', // ��� ���������
										));
										
											if (!empty($arTransfer["historyId"]))
											{	
										
										
												# ������� � ������������
												$db->Query("UPDATE ".$pref."_users_b SET money_p = money_p - '$sum' WHERE id = '$usid'");
											
												# ��������� ������ � �������
												$da = time();
												$dd = $da + 60*60*24*15;
											
												$ppid = $arTransfer["historyId"];
											
												$db->Query("INSERT INTO ".$pref."_payment (user, user_id, purse, sum, valuta, serebro, payment_id, date_add, status) 
												VALUES ('$usname','$usid','$purse','$sum_pay','RUB', '$sum','$ppid','".time()."', '3')");
											
												$db->Query("UPDATE ".$pref."_users_b SET payment_sum = payment_sum + '$sum_pay' WHERE id = '$usid'");
												$db->Query("UPDATE ".$pref."_stats SET all_payments = all_payments + '$sum_pay' WHERE id = '2'");
											
												echo "<center><font color = 'green'><b>���������!</b></font></center><BR />";
											
											}
											else
											{
										
												echo "<center><font color = 'red'><b>��������� ������ - �������� � ��� ��������������!</b></font></center><BR />";	
										
											}
									
									
										}else echo "<center><font color = 'red'><b>��������� ������ - �������� � ��� ��������������!</b></font></center><BR />";
									
									}else echo "<center><font color = 'red'><b>�� ������� ���������! ���������� �����</b></font></center><BR />";
								
								}else echo "<center><font color = 'red'><b>�� ������� ���������! ���������� �����</b></font></center><BR />";
							
								
							}else echo "<center><font color = 'red'><b>� ��� ������� �������������� ������. ��������� �� ����������.</b></font></center><BR />";
							
						
						}else echo "<center><font color = 'red'><b>�� ������� ������, ��� ������� �� ����� �����</b></font></center><BR />";
				
					}else echo "<center><b><font color = 'red'>����������� ����� ��� ������� ���������� {$minPay} �������!</font></b></center><BR />";
					
			}else echo "������������ ����������� ����� �� ����� ��� ��� ����������  {$proc_pay} ���.!";
		
		}else echo "<center><b><font color = 'red'>������� Payeer ������ �������! �������� �������!</font></b></center><BR />";
		
	}
?>

<center><b><font color="red">����� �������� ������� ���� ����� �������� � ����������!</font></b></center><br />

<center><b><font color="red">����� ������ ������� �� ����� ������ ���������!<p> � ������ +50% �� ����� ����������</font></b></center><br />

<form action="" method="post">
<table width="99%" border="0" align="center">
  <tr>
    <td><font color="#000;">��� �������</font>: </td>
	<td><b><?=$user_dataa["purse"]; ?></b></td>
  </tr>
  <tr>
    <td><font color="#000;">������� ������ ��� ������</font> [���. <span id="res_min"></span>]<font color="#000;">:</font> </td>
	<td><input type="text" name="sum" id="sum" value="<?=round($user_data["money_p"]); ?>" size="15" onkeyup="PaymentSum();" /></td>
  </tr>
  <tr>
    <td><font color="#000;">��������� <span id="res_val"></span></font><font color="#000;">:</font> </td>
	<td>
	<input type="text" name="res" id="res_sum" value="0" size="15" disabled="disabled"/>
	<input type="hidden" name="per" id="RUB" value="<?=$sonfig_site["ser_per_wmr"]; ?>" disabled="disabled"/>
	<input type="hidden" name="per" id="min_sum_RUB" value="0.5" disabled="disabled"/>
	<input type="hidden" name="val_type" id="val_type" value="RUB" />
	</td>
  </tr>
  <br>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="swap" value="�������� �������" style="height: 30px; radius:10px; margin-top: 0px;" class="btn_8" /></td>
  </tr>
</table>
</form>
<script language="javascript">PaymentSum(); SetVal();</script>

<? } else { ?>
<?
# ������ ��������
if(!isset($_GET["pay_id"])){

	if(isset($_POST["sys_pay"])){ Header("Location: /account/payment/".$_POST["sys_pay"]); return; }
	
	
	$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
	if (!$payeer->isAuth())
	{
		echo '<center><font color = "red">������� �������� ����������! ���������� � ��������������!</font></center></div>
<div class="block3"></div>
<div class="clr"></div>'; return;
	}
	
	# ��������� �������
	$arPs = $payeer->getPaySystems();
	$systems_array = $arPs["list"];
	?>
	<form action="" method="POST">
	<center>������� ����� ���������� ��� ��� ��������� ������� �� ������ ���������. <BR /><BR />
		<select name="sys_pay" style="padding:3px;">
		<?PHP
			
			
			foreach($systems_array as $key => $value){
			
				?><option value="<?=$value["id"]; ?>"><?=iconv('utf-8', 'windows-1251', $value["name"]); ?> [������: <?=implode(", ",$value["currencies"])?>]</option><?PHP
			
			}
			
		?>
		</select>
		<BR /><BR />
		<input type="submit" value="�������" class="btn_8"/>
	</center>		
	</form>
	</div>
<div class="block3"></div>
<div class="clr"></div>		
	<?PHP
	
return;
}else{ 

	$pay_id = intval($_GET["pay_id"]);
	
	$payeer = new rfs_payeer($config->AccountNumber, $config->apiId, $config->apiKey);
	if (!$payeer->isAuth())
	{
		echo '<center><font color = "red">������� �������� ����������! ���������� � ��������������!</font></center></div>
<div class="block3"></div>
<div class="clr"></div>'; return;
	}
	
	$currentSystem = $payeer->PaySystemData($pay_id);
	
	if(!$currentSystem) {echo '<center><font color = "red">���������� ������! ��������� ������� �� �������, ���������� � ��������������</font></center></div>
<div class="block3"></div>
<div class="clr"></div>'; return;}
	
	$current_sys_name = $currentSystem["name"];
?>

<center><b><font color = "#914A1F"><?=iconv('utf-8', 'windows-1251', $current_sys_name); ?></font></b></center><BR />
<?PHP

if(count($currentSystem["gate_commission"]) > 0){
	
	if($currentSystem["gate_commission_min"]["RUB"] > 1 OR $currentSystem["gate_commission_min"]["USD"] > 1 OR $currentSystem["gate_commission_min"]["EUR"] > 1){
		
		echo '<center><font color = "red">������� �������� ���������� �� ��������� ��������� �������</font></center></div>
<div class="block3"></div>
<div class="clr"></div>			
';
		
		return;
	
	}
	
	echo "�������� ".iconv('utf-8', 'windows-1251',$currentSystem["name"])." ����������: <BR />";
	
	$rub_min_str = "<BR />";
	if(isset($currentSystem["gate_commission"]["RUB"])) echo "RUB - ".$currentSystem["gate_commission"]["RUB"].$rub_min_str; 
	
	$usd_min_str = "<BR />";
	if(isset($currentSystem["gate_commission"]["USD"])) echo "USD - ".$currentSystem["gate_commission"]["USD"].$usd_min_str; 
	
	$eur_min_str = "<BR />";
	if(isset($currentSystem["gate_commission"]["EUR"])) echo "EUR - ".$currentSystem["gate_commission"]["EUR"].$eur_min_str; 
	
	
}
	
	# �������� �� ����������� �������
	function MinPaySystemRet($pay_id){
	
		switch($pay_id){
			
			case "184": return array("RUB" => "60", "USD" => "2", "EUR" => "2"); break; // WebMoney
			
			default: return array("RUB" => "2", "USD" => "0.2", "EUR" => "0.2"); break;
		
		}
	
	}
	
	echo "�������� ������� �� ������� �� ������ ��������� ������� ".$currentSystem["commission_site_percent"]."%<BR />";

	$config_insert = $currentSystem["r_fields"]["ACCOUNT_NUMBER"];

	$array = array("RUB" => $sonfig_site["ser_per_wmr"], "USD" => $sonfig_site["ser_per_wmz"], "EUR" => $sonfig_site["ser_per_wme"]);
	
	foreach($currentSystem["currencies"] as $key => $value) echo "<font color='red'>{$array[$value]} ������� = 1{$value}</font><BR />";
	
	
	function ComissionWm($sum, $com_payee, $com_payysys){
		
		$a = round( ($com_payee/100)*$sum ,2);
		$b = round( (str_replace("%","",$com_payysys)/100)*$sum ,2);
		return $a+$b;
		
	}
	
	
	function ComissionWmReverce($sum, $com_payee, $com_payysys){
		
		$ret = round($sum/(1+($com_payee/100)+($com_payysys/100)),2);
		return $sum-$ret;
	}
	
	$mp_ar_f = MinPaySystemRet($pay_id);
	# ��������� ��� WMR
	$min_p_wmr = $mp_ar_f["RUB"] + ComissionWm($mp_ar_f["RUB"], $currentSystem["commission_site_percent"], $currentSystem["gate_commission"]["RUB"]);
	$min_p_wmz = $mp_ar_f["USD"] + ComissionWm($mp_ar_f["USD"], $currentSystem["commission_site_percent"], $currentSystem["gate_commission"]["USD"]);
	$min_p_wme = $mp_ar_f["EUR"] + ComissionWm($mp_ar_f["EUR"], $currentSystem["commission_site_percent"], $currentSystem["gate_commission"]["EUR"]);
	
	$min_ser_array = array( 
							"RUB" => ($min_p_wmr * $sonfig_site["ser_per_wmr"]),
							"USD" => ($min_p_wmz * $sonfig_site["ser_per_wmz"]),
							"EUR" => ($min_p_wme * $sonfig_site["ser_per_wme"]));
	
	function ExistVal($data, $current){
		
		$current = strtoupper($current);
		
		if($current == "RUB" OR $current == "USD" OR $current == "EUR"){
		
			return (in_array($current, $data)) ? $current : false;
		
		}else return false;
	
	}
	
	function SumPaymentSet($data, $current_val, $summa){
		
		$current = strtoupper($current_val);
		$sum = intval($summa);
		
		if($current == "RUB") return round( ($summa / $data["ser_per_wmr"]), 2);
		if($current == "USD") return round( ($summa / $data["ser_per_wmz"]), 2);
		if($current == "EUR") return round( ($summa / $data["ser_per_wme"]), 2);
		
	
	}



if($user_data['credit'] > 0) {
	echo '<center><font color="red">�� �� ������ ������� �������� ��� ��� �� ��� ����� ������ � ������� '.$user_data['credit'].' �������, �������� ������ � ������� �������� ��������</font></center>
	</div>
<div class="block3"></div>
<div class="clr"></div>			
</div>';
	return;
	}	


?>
<BR />

<?PHP

	# ������� �������
	if(isset($_POST["purse"])){
		
		
		
		$purse = (ereg(substr( substr($config_insert["reg_expr"], 1),0,-1), $_POST["purse"])) ? $_POST["purse"] : false;
		$sum = intval($_POST["sum"]);
		$val = ExistVal($currentSystem["currencies"], strval($_POST["val_type"]) );
		$min_serebra = $min_ser_array[$val];
                $maxPay = 10000;


		if($purse !== false){
		 
                  if($sum < $maxPay){

                       
 

			if($val !== false){
			
				if($sum >= $min_serebra){
				
					if($sum <= $user_data["money_p"]){
						
								# ��������� �� ������������ ������
								$db->Query("SELECT COUNT(*) FROM ".$pref."_payment WHERE user_id = '$usid' AND (status = '0' OR status = '1')");
								if($db->FetchRow() == 0){
							
								# ������� � ������������
								$db->Query("UPDATE ".$pref."_users_b SET money_p = money_p - '$sum' WHERE id = '$usid'");
								
								# ��������� ������ � �������
								$da = time();
								$dd = $da + 60*60*24*15;
								
								$sum_money = SumPaymentSet($sonfig_site, $val, $sum);
								$comission = ComissionWmReverce($sum_money, $currentSystem["commission_site_percent"], $currentSystem["gate_commission"][$val]);
								
								$db->Query("INSERT INTO ".$pref."_payment (user, user_id, purse, sum, comission, valuta, serebro, pay_sys, pay_sys_id, date_add) 
								VALUES ('$usname','$usid','$purse','$sum_money','$comission','$val', '$sum','$current_sys_name','$pay_id','".time()."')");
								
								
								echo "<center><font color = '#914A1F'><b>���� ������ ���������� � ������� �� ����������</b></font></center><BR />";
								
								}else echo "<center><font color = 'red'><b>� ��� ������� �������������� ������. ��������� �� ����������.</b></font></center><BR />";
							
						
						}else echo "<center><font color = 'red'><b>�� ������� ������, ��� ������� �� ����� �����</b></font></center><BR />";
				
				}else echo "<center><b><font color = 'red'>����������� ����� ��� ������� � ���� ��������� ������� {$min_serebra} �������!</font></b></center><BR />";
			
			}else echo "<center><b><font color = 'red'>������� ������� ������, � ���� ��������� ������� ��� ����� ������ �� �����!</font></b></center><BR />";
		


}else echo "<center><b><font color = 'red'>������������ ����� ��� ������� ���������� {$maxPay} �������!</font></b></center><BR />";

		}else echo "<center><b><font color = 'red'>��������� �������� ������ �������! �������� �������!</font></b></center><BR />";
		
	}


?>

<form action="" method="post">
<table width="99%" border="0" align="center">
  <tr>
    <td><font color="#914A1F"><?=iconv('utf-8', 'windows-1251', $config_insert["name"]); ?> [������: <?=$config_insert["example"];?>]</font>: </td>
	<td><input type="text" name="purse" size="15"/></td>
  </tr>
  <tr>
    <td><font color="#914A1F">������</font><font color="#000;">:</font> </td>
	<td>
		<select name="val_type" id="val_type" style="padding:3px;" onchange="SetVal();">
		<?PHP
			
			foreach($currentSystem["currencies"] as $key => $value) echo "<option value='{$value}'>$value</option>";
		
		?>
		</select>
	</td>
  </tr>
  <tr>
    <td><font color="#914A1F">������� ������� ��� ������</font> [���. <span id="res_min"></span>]<font color="#914A1F">:</font> </td>
	<td><input type="text" name="sum" id="sum" value="10000" size="15" onkeyup="PaymentSum();" /></td>
  </tr>
  <tr>
    <td><font color="#914A1F">��������� <span id="res_val"></span></font> [��� ����� ��������]<font color="#914A1F">:</font> </td>
	<td>
	<input type="text" name="res" id="res_sum" value="0" size="15" disabled="disabled"/>
	<input type="hidden" name="per" id="RUB" value="<?=$sonfig_site["ser_per_wmr"]; ?>" disabled="disabled"/>
	<input type="hidden" name="per" id="USD" value="<?=$sonfig_site["ser_per_wmz"]; ?>" disabled="disabled"/>
	<input type="hidden" name="per" id="EUR" value="<?=$sonfig_site["ser_per_wme"]; ?>" disabled="disabled"/>
	<input type="hidden" name="per" id="min_sum_RUB" value="<?=$min_p_wmr; ?>" disabled="disabled"/>
	<input type="hidden" name="per" id="min_sum_USD" value="<?=$min_p_wmz; ?>" disabled="disabled"/>
	<input type="hidden" name="per" id="min_sum_EUR" value="<?=$min_p_wme; ?>" disabled="disabled"/>
	</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="swap" value="�������� �������" style="height: 30px; margin-top:10px;" class="btn_8"/></td>
  </tr>
</table>
</form>
<script language="javascript">PaymentSum(); SetVal();</script>

<? }  }?>

<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><h4>��������� 10 ������</h4></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">�������</td>
    <td align="center" class="m-tb">���������</td>
	<td align="center" class="m-tb">�������</td>
	<td align="center" class="m-tb">����</td>
	<td align="center" class="m-tb">������</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM ".$pref."_payment WHERE user_id = '$usid' ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
		?>
		<tr class="htt">
    		<td align="center"><?=$ref["serebro"]; ?></td>
    		<td align="center"><?=sprintf("%.2f",$ref["sum"] - $ref["comission"]); ?> <?=$ref["valuta"]; ?></td>
    		<td align="center"><?=$ref["purse"]; ?></td>
			<td align="center"><?=date("d.m.Y",$ref["date_add"]); ?></td>
    		<td align="center"><?=$status_array[$ref["status"]]; ?></td>
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">��� �������</td></tr>'
  
  ?>

  
</table></div></div></div>
<div class="block3"></div>
<div class="clr"></div>	






