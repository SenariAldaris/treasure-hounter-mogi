
<div class="block1
"><div class="h-title1
">������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">

<table border="0">

<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/7.png" name="slide_show"></div>   
</td>
<td align="center" width="70%">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; margin-left: 10px; font-size: 11pt;"> &nbsp; ��� ����� ��� ����� �������� ��������. ������ ��������� �������� � ��� �������� ��� ������ ���������. �� ����� ������� � ����� ��� ����������� ����� �� ����� ��� �������� � ��������. �� ���� �������/������ ��������� 2 ��. �������, 1��. ���������� � ����������� 3 ��. �����. </span></h3>

<center>
  


<form action="" method="post">
<input type="submit" name="sbor" value="������� ���" class="btn_8" style="height: 32px;">
</form>


</center>
</td></tr></table>		
<hr>


<?PHP
$_OPTIMIZATION["title"] = "������";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

# ������� ������ ������
if(isset($_POST["item"])){

$sum = intval($_POST["sum"]);

$array_items = array(1 => "u_t", 2 => "v_t");
$array_name = array(1 => "����", 2 => "������");

$item = intval($_POST["item"]);
$citem = $array_items[$item];

	if(strlen($citem) >= 3){

		# ��������� �������� ������������
		$need_money = $sonfig_site["amount_".$citem] * $sum;
		if($need_money <= $user_data["money_b"]){

                                $need_ns = 1; 
                                if($need_ns <= $user_data["ns"]){		

$need_en = 2;
if($need_en <= $user_data["en"]){
		$to_referer = ($need_money * 0.10);	

				# ��������� ������ � ��������� ������
				$db->Query("UPDATE db_users_b SET  ns = ns - 1, en = en - 2, money_b = money_b - $need_money, $citem = $citem + '$sum', to_referer = to_referer + '$to_referer' WHERE id = '$usid'");
$db->Query("UPDATE db_users_a SET balls = balls + 3 WHERE id = '$usid'");

				# ������ ������ � �������
				$db->Query("INSERT INTO db_stats_tree (user_id, user, kolvo, tree_name, amount, date_add, date_del)
				VALUES ('$usid','$usname', '$sum', '".$array_name[$item]."','$need_money','".time()."','".(time()+60*60*24*30*6)."')");


				
				echo "<center><font color = '#914A1F'><b>�� ������� ��������� ��������!</b></font></center><BR />";
header( 'Refresh: 3; url=/account/market' );
		$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
				$user_data = $db->FetchArray();
				

				
}else echo "<div class='error message'><center><font color = 'red'><b>������������ �������.</b></font></center><BR /></div>";
}else echo "<center><font color = 'red'><b>������������ ���������� ��� ������!</b></font></center><BR />";
		}else echo "<div class='error message'><center><font color = 'red'><b>������������ ������� ��� �������.</b></font></center><BR /></div>";
	}else echo 222;
}
?>


<?PHP
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();



	if(isset($_POST["sbor"])){
	
$need_en = 2;
if($need_en <= $user_data["en"]){

$need_s = 1;
if($need_s <= $user_data["k_t"]){

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){

		if($user_data["last_sbor2"] < (time() - 600) ){
		

              
			
			$pump_s = $func->SumCalc($sonfig_site["u_in_h"], $user_data["u_t"], $user_data["last_sbor2"]);
			$peas_s = $func->SumCalc($sonfig_site["v_in_h"], $user_data["v_t"], $user_data["last_sbor2"]);
			
			
			$db->Query("UPDATE ".$pref."_users_b SET 
			u_b = u_b + '$pump_s', 
			v_b = v_b + '$peas_s', 
			all_time_u = all_time_u + '$pump_s',
			all_time_v = all_time_v + '$peas_s', en = en - 2, ns = ns - 1,
			last_sbor2 = '".time()."' 
			WHERE id = '$usid' LIMIT 1");
			$db->Query("UPDATE db_users_a SET balls = balls + 3 WHERE id = '$usid'");
			echo "<center><font color = '#914A1F'><b>�� ������� ������ ���������!</b></font></center><BR />";
			header( 'Refresh: 3; url=/account/market' );
			$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
			$user_data = $db->FetchArray();
			
		}else echo "<center><font color = 'red'><b>������ ��������� ����� �������� �� ���� 1�� ���� �� 10 �����</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>������������ ���������� ��� ����� ��������!</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>�� �� ������ ������� <BR />������ ���������. � ���  ��� ������.</b></font></center><BR />";

}else echo "<center><font color = 'red'><b>�� ������( ���� ����������!</b></font></center><BR />";
		

	}



?>



<table class="ta" align="center" width="60%"><tr><td>
<div class="fr-block">
	<form action="" method="post">
	<div class="cl-fr-lf">
		<img src="/img/fruit/ovca.png" width="130" height="170"/>
	</div>
	<div class="cl-fr-rg" style="padding-left:40px;">
		<div class="fr-te-gr-title"><b>����</b></div>
		
		<div class="fr-te-gr"><b>���������: </b><font color="#000000"><?=$sonfig_site["amount_u_t"]; ?> ���.</font></div>
<div class="fr-te-gr"><b>���������: </b><font color="#000000"><?=$sonfig_site["u_in_h"]; ?> � ���</font></div>
 <?if(user_level::getInstance()->get_level() >= 30) {
  ?>                      		
<input name="sum" type="text" value="1" style="width: 40px;" />		
		<input type="hidden" name="item" value="1" />
		<input type="submit" class="btn_9" value="������" style="height: 33px; margin:10px;" /><?PHP } else {	?> <br><center><font color="red"><b>�������� � 30 ������</b></font></center><?PHP } ?>
	
	</form>

<div class="fr-te-gr"><b>� ������: </b><font color="#000000"><?=$user_data["u_t"]; ?> ����</font></div>
<div class="fr-te-gr"><b>��������: </b><font color="#000000"><?=$func->SumCalc($sonfig_site["u_in_h"], $user_data["u_t"], $user_data["last_sbor2"]);?> ��. ����</font></div>
</div>
</div>

<div class="fr-block">
	<form action="" method="post">
	<div class="cl-fr-lf">
		<img src="/img/fruit/loshadi.png" width="150" height="170"/>
	</div>

	<div class="cl-fr-rg" style="padding-left:20px;">
		<div class="fr-te-gr-title"><b>������</b></div>
		
		<div class="fr-te-gr"><b>���������: </b><font color="#000000"><?=$sonfig_site["amount_v_t"]; ?> ���.</font></div>
<div class="fr-te-gr"><b>���������: </b><font color="#000000"><?=$sonfig_site["v_in_h"]; ?> � ���</font></div>
   <?if(user_level::getInstance()->get_level() >= 35) {
  ?>              
<input name="sum" type="text" value="1" style="width: 40px;"/>	
<input type="hidden" name="item" value="2" />
<input type="submit" class="btn_9" value="������" style="height: 33px; margin:10px;">
<?PHP } else {	?> <br><center><font color="red"><b>�������� � 35 ������</b></font></center><?PHP } ?>
	</form>

<div class="fr-te-gr"><b>� ������: </b><font color="#000000"><?=$user_data["v_t"]; ?> �������</font></div>
<div class="fr-te-gr"><b>��������: </b><font color="#000000"><?=$func->SumCalc($sonfig_site["v_in_h"], $user_data["v_t"], $user_data["last_sbor2"]);?> ��. ����</font></div>

</div>
</div>



</td></tr></table>


</div></div>
</div>
<div class="block3"></div>
<div class="clr"></div>		
