<div class="block1
"><div class="h-title1
">���������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<BR />
<?PHP
$_OPTIMIZATION["title"] = "���������";
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



<?php if($user_data["s_t"] == 0) { ?>
<center>
��� ������������� ��������� ��������� ��������� ����������� ������������ ������������ ����������, ������� ����� ������ � �����. �� ���������� ������� ������ �� ������� �������� ������ ������� � ���������� �� ��� ���������� � ��� "�������".</center>
<BR ><BR >

<?php echo $build->GetBuildingTable(0, "s_t"); ?>		
</br>
</br>
<?php echo $build->GetBuildProcess($usid, "s_t"); ?>


<?php } else { ?>
<center>
��� ���� ���������. ������ � ��� ���� ����������� �������������� ������������� ������ ������� �� ����������� �������. ���� ����� ��������� �� ���������� � ���� "�������". ��������� ����������� ����������� ������������ � �������� ������� ������� ������ 24 ����. �� ������ �������� ��������� ��������� 2 ��. �������, 2 ������� ���������� � ����������� 2 ��. �����. �� ������ ���� ��������� 1 ��. ������� � ����������, ����������� 3 ��. �����.</center>

		
<?php
# ��������� ����������� � 7 ���
if(isset($_POST["load7"])){
$array_items2 = array(1 => "b_b"); 
$array_name2 = array(1 => "�������");
$item = intval($_POST["load7"]);
$citem = $array_items2[$item];
if(strlen($citem) >= 3){
$need = $user_data[$citem];

if($need >= 100){	

$need_en = 2;
if($need_en <= $user_data["en"]){	

$need_ns = 2; 
if($need_ns <= $user_data["ns"]){

$db->Query("UPDATE db_users_b SET  en = en - 2, ns = ns - 2, $citem = $citem - 100, last_bar7 = IF(last_bar7 > 0, last_bar7, '".time()."') WHERE id = '$usid'");
 $db->Query("UPDATE db_users_b SET pbar7 = pbar7 + 1 WHERE id = '$usid'"); 
$db->Query("UPDATE db_users_a SET balls = balls + 2 WHERE id = '$usid'");
# ������ ������ � ������� � �������
$db->Query("INSERT INTO db_stats_pbar (user_id, user, bar, date_add, date_del) VALUES ('$usid','$usname','����','".time()."','".(time()+60*60*24*15)."')");
$da = time();
$dd = $da + 60*60*24;
# ���������
$db->Query("INSERT INTO db_bar2 (user, user_id, area, $citem, date_add, date_del) VALUES ('$usname', '$usid', '7', '1', '$da','$dd')");
echo "<center><font color = 'green'><b>������������ ��������� ������� ��������.</b></font></center><BR />";
header( 'Refresh: 3; url=/account/pivovarna' );
}else echo "<center><font color = 'red'><b>������������ ���������� ��� �������� ���������.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>������������ ������� ��� �������� ���������.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>������������ ������������ ��� ������������ ���������. ������ �� � �����.</b></font></center><BR />";
}
}
?>

<?PHP
# ���� ��� 7
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_bar2 WHERE area = 7 AND user_id = '$usid' LIMIT 1");
$derevo = $db->FetchArray();
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
if(isset($_POST["sbor7"])){
if($user_data["last_bar7"] < (time() - 60*60*24) ){

$need_en = 1;
if($need_en <= $user_data["en"]){

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){

$db->Query("UPDATE db_users_b SET  en = en - 1, ns = ns - 1, coctel_d = coctel_d + 100,  last_bar7 = '".time()."' WHERE id = '$usid' LIMIT 1");
$db->Query("UPDATE db_users_a SET balls = balls + 3 WHERE id = '$usid'");
$db->Query("UPDATE db_bar2 SET sbor = sbor - 1 WHERE area = 7 AND user_id = '$usid' LIMIT 1");
	echo "<center><font color = 'green'><b>�� ������� ������� ���������.</b></font></center><BR />";
	header( 'Refresh: 3; url=/account/pivovarna' );
}else echo "<center><font color = 'red'><b>������������ ���������� ��� ����� ���������.</b></font></center><BR />";
			}else echo "<center><font color = 'red'><b>������������ �������.</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>��������� �� ������.</b></font></center><BR />";
	}
?>




<div class="fr-block">
<form action="" method="post">
<div class="cl-fr-lf">
<img src="/img/fruit/9.png" />
</div>
<div class="cl-fr-rg" style="padding-left:20px;">

<div class="fr-te-gr-title"><b>���������</b></div> 


<?PHP if ($user_data["pbar7"] < 1) { ?>
<? $db->Query("SELECT * FROM db_bar2 WHERE area = 7 AND user_id = '$usid' LIMIT 1");
 if($db->NumRows() == 0){  ?>

��� ������������� 100 �. ����:<br />
����� - 100 ��. ������<br />


<form action="" method="post">
<input type="hidden" name="load7" value="1">
<input type="submit" class="btn_8" value="�����������" /></form><br />

<?PHP } } else {?>  
<?php 
$db->Query("SELECT * FROM db_bar2 WHERE area = 7 AND user_id = '$usid' LIMIT 1");
$fact = $db->FetchArray();
?>
<?PHP		
if ($fact["b_b"]==1) { ?>
<form action="" method="post">
�������������... <br />
<center><img src="/img/fruit/pivo.png" width="90" height="80" /><br />����: 100 ������.<br /></center> 
<?PHP		
if ($fact["active"] < 0) { ?>  <center><input type="submit" class="btn_8" name="sbor7" value="�������" /></center>
<?PHP	}	else { ?> <font color="red"><b><center>�� ������</center></b></font>
<?PHP	} ?> </form>
<?PHP	} ?>
<?php 
$db->Query("SELECT * FROM db_bar2 WHERE area = 7 AND user_id = '$usid' LIMIT 1");
if($db->NumRows() == 0){  $db->Query("UPDATE db_users_b SET pbar7 = pbar7 - 1 WHERE id = '$usid'");  }
?>
<?PHP } ?> 
</div></form></div>



		



<?php } ?>

<div class="clr"></div>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>		