<?PHP
$_OPTIMIZATION["title"] = "������� - �������";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

# ������� ������ ������
if(isset($_POST["item"])){

$array_items = array(1 => "a_t", 2 => "b_t", 3 => "c_t", 4 => "d_t", 5 => "e_t", 6 => "f_t");
$array_name = array(1 => "�������", 2 => "��������", 3 => "�������", 4 => "������", 5 => "������", 6 => "�������");
$item = intval($_POST["item"]);
$citem = $array_items[$item];

	
	if(strlen($citem) >= 3){
		
		# ��������� �������� ������������
		$need_money = $sonfig_site["amount_".$citem];

                                $need_en = 2; 
                                if($need_en <= $user_data["en"]){

		if($need_money <= $user_data["money_b"]){
		
			if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) ){
				


				$to_referer = $need_money * 0.1;
				# ��������� ������ � ��������� ������
				$db->Query("UPDATE ".$pref."_users_b SET money_b = money_b - $need_money, $citem = $citem + 1, en = en - 2, 
				last_sbor = IF(last_sbor > 0, last_sbor, '".time()."') WHERE id = '$usid'");
				$db->Query("UPDATE ".$pref."_users_a SET balls = balls + 3 WHERE id = '$usid'");
				# ������ ������ � �������
				$db->Query("INSERT INTO ".$pref."_stats_btree (user_id, user, tree_name, amount, date_add, date_del) 
				VALUES ('$usid','$usname','".$array_name[$item]."','$need_money','".time()."','".(time()+60*60*24*15)."')");
				$life_time->AddItem($usid,$citem);
				echo "<center><font color = '#914A1F'><b>�� ������� ��������� ���� ������!</b></font></center><BR />";
				
				$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
				$user_data = $db->FetchArray();


				
			}else echo "<center><font color = 'red'><b>����� ��� ��� ������/���������� �����, ������� ������� ������� �� ������!</b></font></center><BR />";
		
		}else echo "<center><font color = 'red'><b>������������ ������� ��� ������</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>������������ ������� ��� �������!</b></font></center><BR />";
	
	}else echo 222;

}

$all_items = ($user_data["a_t"] + $user_data["b_t"] + $user_data["c_t"] + $user_data["d_t"] + $user_data["e_t"] + $user_data["f_t"]);

?>


<div class="block1
"><div class="h-title1
">�������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<?PHP
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

# ������� ����� �������
if(isset($_POST["item"])){

$array_items = array(7 => "g_t");
$array_name = array(7 => "�������2");
$item = intval($_POST["item"]);
$citem = $array_items[$item];

	
	if(strlen($citem) >= 3){
		
		# ��������� �������� ������������
		$need_money = $sonfig_site["amount_".$citem];

                                $need_en = 2; 
                                if($need_en <= $user_data["en"]){

		if($need_money <= $user_data["money_b"]){
		
			
				


				$to_referer = $need_money * 0.1;
				# ��������� ������ � ��������� ������
				$db->Query("UPDATE ".$pref."_users_b SET money_b = money_b - $need_money, $citem = $citem + 1, en = en - 2, 
				last_sbor = IF(last_sbor > 0, last_sbor, '".time()."') WHERE id = '$usid'");
				$db->Query("UPDATE ".$pref."_users_a SET balls = balls + 3 WHERE id = '$usid'");
				# ������ ������ � �������
				$db->Query("INSERT INTO ".$pref."_stats_btree (user_id, user, tree_name, amount, date_add, date_del) 
				VALUES ('$usid','$usname','".$array_name[$item]."','$need_money','".time()."','".(time()+60*60*24*15)."')");
				
				echo "<center><font color = '#914A1F'><b>�� ������� �������� ���� �������!</b></font></center><BR />";
				header( 'Refresh: 3; url=/account/kazarma' );
				$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
				$user_data = $db->FetchArray();


				
			
		}else echo "<center><font color = 'red'><b>������������ ������� ��� ������</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>������������ ������� ��� �������!</b></font></center><BR />";
	
	}else echo 222;

}


?>


<?php if($user_data["g_t"] == 0) { ?>
<table border="0">
<tbody>
<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/kazarma1.png" name="slide_show"></div>   
</td>
<td valign="top">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; ��� ����� ��� ����� ������� �������. ����� ����� ���������� �� 10 �������. ���� �� ���������� �������� ������ ������, ��� ���������� ��������� ������� �� 30 �������� ����. </span></h3>
<center>
���� ������� �� 30 �������: </br>
<div colspan="3"><?=$sonfig_site["amount_g_t"]; ?> <img src="/img/fruit/serebro.png" width="30" height="30" name="slide_show"> = 100 ������!</div>
<form action="" method="post">

		<input type="hidden" name="item" value="7" />
		<input type="submit" value="��������" style="margin-top:10px;" class="btn_8" />
	
	</form>

</center> 
</td>
</tr>
</tbody>
</table>		

<?php } else { ?>		
<table border="0">
<tbody>
<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/kazarma2.png" name="slide_show"></div>   
</td>
<td valign="top">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; ��� ����� ��� ����� ������� �������. ����� ����� ���������� �� ����� 30 �������. ����� ������ ������ ������� ���������� ��������� ��������� ����� ������ ����� ������� ������. </span></h3>
 
</td>
</tr>
</tbody>
</table>				
<?php } ?>

	

				


<hr>
<center>




<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 12pt;"> &nbsp; � ��� � �������: <?=$all_items; ?> ������� </span></h3>

<div>
���� ������:

 <?php $life_time->GetTable($usid); ?></div>
</center> 	
</div></div></div>
<div class="clr"></div>	<div class="block3"></div>

