<div class="block1
"><div class="h-title1
">���������� �������</div></div>

<div class="block2">	

<?PHP
$_OPTIMIZATION["title"] = "������� - ���������� �������";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];


$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();


$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();


?>

<center>

<span style="color: #914A1F; font-family: 'Comic Sans MS', cursive; font-size: 13pt;text-shadow: #000 0 1px 1px;"><strong><font color = "#000">�����:</font> ��� ������ ���������� ������� +50% � �������.</strong></span>
<b>���������� ����� QIWI <font color ="red">(������� 30 ������)</font></b><br>(������ �������� �� ���� � ������� 24 �����)<br><br>
<img src="/img/qiwi1.gif" style="width: 203px; height: 103;"> <br><br></center>

1. � ������� ��������, �������� �QIWI ����, ����� ��������.
<br>
2. ��������� ��������, ������� ����� � ����������.
<br>
3. ���������� ��� ������� � ����� ���������� ������� ����.
<br>
<?php
if(isset($_POST["sum"])){
	$err = "";
	$err .= $_POST["sum"]==NULL?"�� �� ����� ����� ����������<br />":"";
	$err .= $_POST["vaycher"]==NULL?"�� �� ����� ������ (��� Qiwi-����) <br />":"";
	$err .= (intval($_POST["sum"]))< 30?"������� ��� ���������� Qiwi-����� 30���!<br />":"";
	
	if($err == NULL){

		$db->Query("INSERT INTO ".$pref."_qiwi_insert (user, user_id, vaycher, sum) VALUES ('$usname', '$usid', '".$_POST["vaycher"]."', '".$_POST['sum']."')");
		
		echo "<font color='#914A1F'><br><br><br>���������� ������ �������! �������� ���������� �������.</font>";
		$advok = true;
	}else{
		echo "<br /><b>������:</b><br />".$err;
	}
}		
	if(!$advok)
		echo"<form action='/account/wm_insert/' method='post' style='padding:5px; margin-top:10px;' >
				
			<p>����� ���������� � ������: <input name='sum' type='text' class='input' value='".htmlspecialchars($_POST["sum"])."' maxlength='6' size='5'/></p>

			<p>������: <input name='vaycher' type='text' class='input' value='".htmlspecialchars($_POST["vaycher"])."' maxlength='30' size='40' /> <input name='kod0' type='submit' value='��������' class='btn_7' style='margin-top:4px;height: 30px;' /></p>
													
		</form>";
		?>

</div>
<div class="block3"></div>
<div class="clr"></div>		