<?PHP
$_OPTIMIZATION["title"] = "������� - ��������� �����";
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a WHERE id = '$usid'");
$user_a = $db->FetchArray();
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_b = $db->FetchArray();
$min_cr = 100; // ����������� ����� �������
$max_cr = 100000; // ������������ ����� �������
$percent = 0.2; // ���������� ������ �� ������ 0.2 ��� 20%

?>
<div class="block1
"><div class="h-title1
">������������</div></div>

<div class="block2">	
<?

if($user_b['credit'] > 0) {
echo '<center><font color="red"><b>� ��� ��� ������� �� ��������� ������, �������� ���� ������ � ������� ����� ������<b></font></center>';
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_b = $db->FetchArray();
?>
<center><h3>�������� ������</h3></center><br>
<center>����� ������ �������: <font color="red"><?=$user_b['credit']; ?> </font> �������</center>
<br>
<center>�� ��������� � ������ ������ ��������: <?
$tt = $user_b['date_add'] + (60*60*24*30);

$ttt = ($tt - time()) / 86400;
echo intval($ttt).' - ����';
?><br></center><br>
<font color="red"><b>��� ��������� ������� ��� ���������� ��������� ������ �� ����� ������ �������, ����� ����������, ����� ������������� �������� � ���� ��������� �������, ��������� ����� ���������� ��� �� ������ ��� �������!<b></font>
<?
echo '</div>
<div class="block3"></div>
<div class="clr"></div>			
';
return;

}
if(isset($_POST['summa'])) {
$sum = intval($_POST['summa']);
$summ = $sum + ($sum * $percent);
$time = time();
$pen = time() + (60*60*24*30);
if($sum >= $min_cr) {
	if($sum <= $max_cr) {
		if($user_b['credit'] == 0) {
			$db->Query("UPDATE db_users_b SET money_b = money_b + '$sum', credit = credit + '$summ', credit_only = '$summ', date_add = '$time', date_peny = '$pen', credit_all = credit_all + '$summ' WHERE id = '$usid'");
			echo "<center><font color = '#914A1F'><b>�� ������� �������� ������ �� ����� ".$sum."�������, � �������� ".$summ." �������</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>� ��� ��� ������� �� ���������� ������! ��� ������ �������� ������ � ����� ������� ������!</b></font></center><BR />";
	}else echo "<center><font color = 'red'><b>����� ������� ������ ���� �� ������ 100000 �������</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>����� ������� ������ ���� �� ����� 100 �������</b></font></center><BR />";
}
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid'");
$user_b = $db->FetchArray();
?>
<br>
<center><h3>����� ������</h3></center>
�� ������ ����� ������ �� ���� 30 ���� � �� ����� �� 100 �� 100000 �������, �� ���� ��� �������!<br>��������!!! ������, ������ � ������ ����� ��������� �� ����������� ��� �������� ������ �������!
���������� ������ ����� ������ ����������� �������. <br>
���������� ������ 20%<br>
� ������� �� �������� ������� � ����, �� ������ �������� � ������ ������.<br>
��� ������� ����� ������������� ������������ ��� �������� ����� ������ �������!
<br>
<?PHP
$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
# �������� �� ����������
if($user_data["insert_sum"] <= 25){

?>

<BR /><BR />
<center><font color="red"><b>������ � ������� �������� ������������, ������� �������� ��������� ���� ����� ��� �� 250 ���.<b></font></center><BR />
<BR />
</div>

	

<div class="clr"></div>	<div class="block3"></div>

<?PHP

return;
}

?>

<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td><b>�����:</b></td>
    <td align="center"><input type="text" name="summa" /></td>
  </tr>


  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="�����" class="btn_8"/></td>
  </tr>
</table>
</form>


</div>
<div class="block3"></div>
<div class="clr"></div>	