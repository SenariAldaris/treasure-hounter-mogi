<div class="block1
"><div class="h-title1
">�������� �����</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<BR />
<?PHP
$_OPTIMIZATION["title"] = "�������� �����";
$usid = $_SESSION["user_id"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
?>
<?PHP
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];
$name_tree = $build->GetNames($_POST["item"]);
    $price = $build->GetPriceAndResource($_POST["item"]);
    $price = $price['price'];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();


# ������� ������ ������
if(isset($_POST["item"])){

//if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) )
	//{
		echo $build->Build($usid,$_POST["item"]);

 
	
	//}
	//else echo "<center><font color = 'red'><b>����� ��� ��� ������ ������� ������� ������� ������� �� ������!</b></font></center><BR />";

}

?>




<?php if($user_data["o_t"] == 0) { ?>

<center>
��� ������������� ��������� ������ ��������� ��������� ����������� ������������ ������������ ����������, ������� ����� ������ � �����. �� ���������� ������� ������ �� ������� ���� ������������� ��������, ������� ������������, ��� ��������� �������������� � ����� � ��������. </center>
<BR ><BR >

<?php echo $build->GetBuildingTable(0, "o_t"); ?>		
</br>
</br>
<?php echo $build->GetBuildProcess($usid, "o_t"); ?>
			

<?php } else { ?>
<center>
��� ���  �������� �����. ������ �� ������ �������������� ���������� ����� �� �������� ����. �������� �������� ����� ������������ � ������������� ��� ������ ������� � �����. ��������� ����������� ����������� �������� ���� � ���� � �������� ������� ����� ������ 24 ����. 
�� ������ �������� ��������� ��������� 2 ��. �������, 2 ������� ���������� � ����������� 2 ��. �����. �� ������ ���� ��������� 1 ��. ������� � ����������, ����������� 3 ��. �����.</center>
		
</center>
<?php
# ��������� ����������� � 4 ���
if(isset($_POST["load4"])){
$array_items2 = array(1 => "d_b");
$array_name2 = array(1 => "����");
$item = intval($_POST["load4"]);
$citem = $array_items2[$item];
if(strlen($citem) >= 3){
$need = $user_data[$citem];
if($need >= 200){

$need_en = 2;
if($need_en <= $user_data["en"]){	

$need_ns = 2; 
if($need_ns <= $user_data["ns"]){

$db->Query("UPDATE db_users_b SET  en = en - 2, ns = ns - 2, $citem = $citem - 200, last_bar4 = IF(last_bar4 > 0, last_bar4, '".time()."') WHERE id = '$usid'");
 $db->Query("UPDATE db_users_b SET pbar4 = pbar4 + 1 WHERE id = '$usid'"); 
$db->Query("UPDATE db_users_a SET balls = balls + 2 WHERE id = '$usid'");
# ������ ������ � ������� � �������
$db->Query("INSERT INTO db_stats_pbar (user_id, user, bar, date_add, date_del) VALUES ('$usid','$usname','�����','".time()."','".(time()+60*60*24*30*6)."')");
$da = time();
$dd = $da + 60*60*24;
# ���������
$db->Query("INSERT INTO db_bar (user, user_id, area, $citem, date_add, date_del) VALUES ('$usname', '$usid', '4', '1', '$da','$dd')");
echo "<center><font color = 'green'><b>������������ ��������� ������� ��������.</b></font></center><BR />";
header( 'Refresh: 3; url=/account/liteyniyzavod' );
}else echo "<center><font color = 'red'><b>������������ ���������� ��� �������� ���������.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>������������ ������� ��� �������� ���������.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>������������ ������������ ��� ������������ ���������. ������ �� � �����.</b></font></center><BR />";
}
}
?>
		
<?PHP
# ���� ��� 4
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_bar WHERE area = 4 AND user_id = '$usid' LIMIT 1");
$derevo = $db->FetchArray();
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
if(isset($_POST["sbor4"])){
if($user_data["last_bar4"] < (time() - 60*60*24) ){

$need_en = 1;
if($need_en <= $user_data["en"]){	

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){

$db->Query("UPDATE db_users_b SET  en = en - 1, ns = ns - 1, i_b = i_b + 200,  last_bar4 = '".time()."' WHERE id = '$usid' LIMIT 1");
$db->Query("UPDATE db_users_a SET balls = balls + 3 WHERE id = '$usid'");
$db->Query("UPDATE db_bar SET sbor = sbor - 1 WHERE area = 4 AND user_id = '$usid' LIMIT 1");
	echo "<center><font color = 'green'><b>�� ������� ������� ���������.</b></font></center><BR />";
	header( 'Refresh: 3; url=/account/liteyniyzavod' );
}else echo "<center><font color = 'red'><b>������������ ���������� ��� ����� ���������.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>������������ �������.</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>��������� �� ������.</b></font></center><BR />";
	}
?>


<table class="ta" align="center" width="100%"><tr><td>
<div class="fr-block">
<form action="" method="post">
<div class="cl-fr-lf">
<img src="/img/fruit/5.png" />
</div>
<div class="cl-fr-rg" style="padding-left:0px;">


<div class="fr-te-gr-title"><b>�������� �����</b></div> 

<?PHP if ($user_data["pbar4"] < 1) { ?>
<? $db->Query("SELECT * FROM db_bar WHERE area = 4 AND user_id = '$usid' LIMIT 1");
 if($db->NumRows() == 0){  ?>

��� ������������ 200 ��. �����:<br />
����� - 200 ��. ����<br />

<form action="" method="post">
<input type="hidden" name="load4" value="1">
<input type="submit" class="btn_8" value="������������" /></form><br /><br />

<?PHP } } else {?>  
<?php 
$db->Query("SELECT * FROM db_bar WHERE area = 4 AND user_id = '$usid' LIMIT 1");
$fact = $db->FetchArray();
?>
<?PHP		
if ($fact["d_b"]==1) { ?>
<form action="" method="post">
�������������...<br />
<center><img src="/img/fruit/stall.png" width="70" height="60" /> <br />�����: 200��.<br /> </center>
<?PHP		
if ($fact["active"] < 0) { ?> <center><input type="submit" name="sbor4" class="btn_8" value="�������" /></center>
<?PHP	}	else { ?> <font color="red"><b><center>�� ������</center></b></font>
<?PHP	} ?> </form>
<?PHP	} ?>
<?php 
$db->Query("SELECT * FROM db_bar WHERE area = 4 AND user_id = '$usid' LIMIT 1");
if($db->NumRows() == 0){  $db->Query("UPDATE db_users_b SET pbar4 = pbar4 - 1 WHERE id = '$usid'");  }
?>
<?php }?> 
</div></form></div>

</td></tr></table>


<?php } ?>

<div class="clr"></div>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>	