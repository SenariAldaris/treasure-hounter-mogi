<div class="block1
"><div class="h-title1
">�������� �����</div></div>
<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<table border="0">
<tbody>
<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/lavka.png" name="slide_show"></div>   
</td>
<td valign="top">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; �� ���� ����� ����� ���������� ������� ����� ��� �����������, ��� ������� ���� �����. ������� ��� ������� - 50 ��. ������, � ������� - 100 ��.������.
������ ����� - 200000 �� ������ �� ���. <font color = 'red'><b>��������!!! ����� ������� ������� ��������� ��������� �����!!! </b></font>
��� �������/������� ��������� 1 ��.������� � ����������.
�������� � ������� ��������� �� ���� ��� ������. </span></h3>


</td>
</tr>
</tbody>
</table>
<hr>

<?PHP
$_OPTIMIZATION["title"] = "�����";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_trade WHERE id = '1' LIMIT 1");
$trade = $db->FetchArray();

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
# �������� ����� � �����
$maxab = 200000;
?>

<?php
if(isset($_POST["sell"])){
$sum = intval($_POST["sum"]);
$array_items2 = array(1 => "a_b", 2 => "b_b", 3 => "c_b", 4 => "d_b", 5 => "f_b", 6 => "l_b", 7 => "h_b", 8 => "i_b", 9 => "u_b", 10 => "v_b");
$array_name2 = array(1 => "�����", 2 => "�����", 3 => "������", 4 => "����", 5 => "�������", 6 => "����", 7 => "�����", 8 => "�����", 9 => "��������", 10 => "������");
$item = intval($_POST["sell"]);
$citem = $array_items2[$item];
if(strlen($citem) >= 3){
$need = $user_data[$citem];

$need_en = 1;
if($need_en <= $user_data["en"]){

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){

$need_s = 1;
                if($need_s <= $user_data["k_t"]){

if($need >= $sum){
if($sum >= 100){
$sellb = $sum + $trade[$citem]; 
if($maxab > $sellb){	
$money = $sum * $sonfig_site["sell_".$citem];
# ��� ����� � ������� ��������
$db->Query("UPDATE db_users_b SET money_p = money_p + $money, en = en - $need_en, ns = ns - $need_ns, $citem = $citem - '$sum' WHERE id = '$usid'");
# ��������� �����
$db->Query("UPDATE db_trade SET $citem = $citem + '$sum'");

$db->Query("INSERT INTO db_sell_trade (user_id, user, kolvo, amount, citem, date_add, date_del) VALUES ('$usid','$usname', '$sum','$money','".$array_name2[$item]."','".time()."','".(time()+60*60*24*30*6)."')");
  
	echo "<center><font color = '#964D1F'><b>������� ������ �������.</b></font></center><BR />";
		header( 'Refresh: 1; url=/account/trade' );
	}else echo "<center><font color = 'red'><b>������ ����� ����������. ���������� ����� ��� �������� ������ ������.</b></font></center>";
	
	}else echo "<center><font color = 'red'><b>���-�� ������������ ����� �� ����� ���� ������ 100 ��.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>������������ ����� ��� �������.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>�� �� ������ ������� �������. <BR />� ��� ��� ��� ������.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>������������ ����������.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>������������ �������.</b></font></center><BR />";
}
}
?>

<?php
if(isset($_POST["buy"])){
$sum = intval($_POST["sum"]);

$array_items2 = array(1 => "a_b", 2 => "b_b", 3 => "c_b", 4 => "d_b", 5 => "f_b", 6 => "l_b", 7 => "h_b", 8 => "i_b", 9 => "u_b", 10 => "v_b");
$array_name2 = array(1 => "�����", 2 => "�����", 3 => "������", 4 => "����", 5 => "�������", 6 => "����", 7 => "�����", 8 => "�����", 9 => "��������", 10 => "������");
$pitem = intval($_POST["buy"]);
$pcitem = $array_items2[$pitem];

$array_items3 = array(1 => "a_b", 2 => "b_b", 3 => "c_b", 4 => "d_b", 5 => "f_b", 6 => "l_b", 7 => "h_b", 8 => "i_b", 9 => "u_b", 10 => "v_b");
$array_name3 = array(1 => "�����", 2 => "�����", 3 => "������", 4 => "����", 5 => "�������", 6 => "����", 7 => "�����", 8 => "�����", 9 => "��������", 10 => "������");
$item = intval($_POST["buy"]);
$citem = $array_items3[$item];

if(strlen($pcitem) >= 3){
$need = $trade[$citem];

if($need >= $sum){
if($sum >= 50){	
		
		$need_en = 1;
if($need_en <= $user_data["en"]){
		

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){


                

$money = $sum * $sonfig_site["buy_".$pcitem];
if($money <= $user_data["money_b"]){	
# ��������� ��������� � ������� ������
$db->Query("UPDATE db_users_b SET money_b = money_b - $money, en = en - $need_en, ns = ns - $need_ns,  $pcitem = $pcitem + '$sum' WHERE id = '$usid'");

$db->Query("INSERT INTO db_buy_trade (user_id, user, kolvo, amount, citem, date_add, date_del) VALUES ('$usid','$usname', '$sum', '$money','".$array_name3[$item]."','".time()."','".(time()+60*60*24*30*6)."')");

# ��������� �����
$db->Query("UPDATE db_trade SET $citem = $citem - '$sum'");
  
	echo "<center><font color = '#964D1F'><b>������� ������ �������.</b></font></center><BR />";
		header( 'Refresh: 1; url=/account/trade' );
	}else echo "<center><font color = 'red'><b>������������ ������� ��� �������.</b></font></center><BR />";

		}else echo "<center><font color = 'red'><b>������������ ����������.</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>������������ �������.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>���-�� ����������� ����� �� ����� ���� ������ 50.</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>� ����� ������������ ����� ��� �������.</b></font></center><BR />";
}
}
?>

 <?PHP
  
  $db->Query("SELECT * FROM db_trade WHERE id = '1' LIMIT 1");
$trade = $db->FetchArray();
		
		?>


<table width = "100%" class="ta" align="center">
<tr><td align="center">

<form action="" method="post">
<select type="hidden" name="sell">
<option value="1"><b>�����</b> (����: <?=$sonfig_site["sell_a_b"]; ?> ���/��)</option>
<option value="2"><b>�����</b> (����: <?=$sonfig_site["sell_b_b"]; ?> ���/��)</option>
<option value="3"><b>������</b> (����: <?=$sonfig_site["sell_c_b"]; ?> ���/��)</option>
<option value="4"><b>����</b> (����: <?=$sonfig_site["sell_d_b"]; ?> ���/��)</option>
<option value="5"><b>�������</b> (����: <?=$sonfig_site["sell_f_b"]; ?> ���/��)</option>
<option value="6"><b>����</b> (����: <?=$sonfig_site["sell_l_b"]; ?> ���/��)</option>
<option value="7"><b>�����</b> (����: <?=$sonfig_site["sell_h_b"]; ?> ���/��)</option>
<option value="8"><b>�����</b> (����: <?=$sonfig_site["sell_i_b"]; ?> ���/��)</option>
<option value="9"><b>��������</b> (����: <?=$sonfig_site["sell_u_b"]; ?> ���/��)</option>
<option value="10"><b>������</b> (����: <?=$sonfig_site["sell_v_b"]; ?> ���/��)</option>
</select>
<input name="sum" size="6" type="text" value="100" style="width: 40px; margin-right: 25px"/><br />
<center>
<input type="submit" class="btn_8" value="�������" style="height: 30px; margin-top:15px;" /></form> 
</center>
</td>
<td align="center">


<form action="" method="post">
<select type="hidden" name="buy">
<option value="1"><b>�����</b> (����: <?=$sonfig_site["buy_a_b"]; ?> ���/��)</option>
<option value="2"><b>�����</b> (����: <?=$sonfig_site["buy_b_b"]; ?> ���/��)</option>
<option value="3"><b>������</b> (����: <?=$sonfig_site["buy_c_b"]; ?> ���/��)</option>
<option value="4"><b>����</b> (����: <?=$sonfig_site["buy_d_b"]; ?> ���/��)</option>
<option value="5"><b>�������</b> (����: <?=$sonfig_site["buy_f_b"]; ?> ���/��)</option>
<option value="6"><b>����</b> (����: <?=$sonfig_site["buy_l_b"]; ?> ���/��)</option>
<option value="7"><b>�����</b> (����: <?=$sonfig_site["buy_h_b"]; ?> ���/��)</option>
<option value="8"><b>�����</b> (����: <?=$sonfig_site["buy_i_b"]; ?> ���/��)</option>
<option value="9"><b>��������</b> (����: <?=$sonfig_site["buy_u_b"]; ?> ���/��)</option>
<option value="10"><b>������</b> (����: <?=$sonfig_site["buy_v_b"]; ?> ���/��)</option>
</select>
<input name="sum" size="6" type="text" value="50" style="width: 40px;"/>	<br />
<center>
<input type="submit" class="btn_8" value="������" style="height: 30px;  margin-top:15px;" /></form>
</center>
</td>
</tr>
</table>




<table class="ta" width = "100%" align="center">
<tr>
<td align="center"><b><font color="#964D1F" size="+1">�� ������</font></td>
<td align="center"><b><font color="#964D1F" size="+1">� �����</font></td>
</tr>
<tr>
<td align="center">
�����: <?=$user_data["a_b"];?> ��.
</td>
<td align="center">
�����: <?=$trade["a_b"];?> ��. 
</td>
</tr>
<tr>
<td align="center">
������: <?=$user_data["b_b"];?> ��.
</td>
<td align="center">
������: <?=$trade["b_b"];?> ��. 
</td>
</tr>
<tr>
<td align="center">
������: <?=$user_data["c_b"];?> ��.
</td>
<td align="center">
������: <?=$trade["c_b"];?> ��.
<tr>
<td align="center">
����: <?=$user_data["d_b"];?> ��.
</td>
<td align="center">
����: <?=$trade["d_b"];?> ��. 
</td>
</tr>
<tr>
<td align="center">
��������: <?=$user_data["f_b"];?> ��.
</td>
<td align="center">
��������: <?=$trade["f_b"];?> ��. 
</td>
</tr>
<tr>
<td align="center">
����: <?=$user_data["l_b"];?> ��.
</td>
<td align="center">
����: <?=$trade["l_b"];?> ��.
</td>
</tr>
<tr>
<td align="center">
�����: <?=$user_data["h_b"];?> ��.
</td>
<td align="center">
�����: <?=$trade["h_b"];?> ��.
</td>
</tr>
<tr>
<td align="center">
�����: <?=$user_data["i_b"];?> ��.
</td>
<td align="center">
�����: <?=$trade["i_b"];?> ��.
</td>
</tr>
<tr>
<td align="center">
��������: <?=$user_data["u_b"];?> ��.
</td>
<td align="center">
��������: <?=$trade["u_b"];?> ��.
</td>
</tr>
<tr>
<td align="center">
������: <?=$user_data["v_b"];?> ��.
</td>
<td align="center">
������: <?=$trade["v_b"];?> ��.
</td>
</tr>
</table>
<br />

</div>
</div>


<div class="clr"></div>	</div> <div class="block3"></div>