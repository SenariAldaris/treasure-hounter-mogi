<div class="s-bk-lf">
	<div class="acc-title">������� �������</div>
</div>

<div class="silver-bk"><div class="clr"></div>	
�������� ���� ��������, ��� � �������� ������������ ��������� ������� ����� ������ ���� ���! �� ���������� ������ ������ ����. ��������� ���������� �������!<br><br>
�������� �����, ������� ������ ���������: <br>
<form action="" method="post">
<select name="fruit">
		<option value="a_t">����</option>
		<option value="b_t">�����</option>
		<option value="c_t">��������</option>
		<option value="d_t">����</option>
		<option value="e_t">��������</option>
</select>
<br><br>
������� �������� ���������, ������������ ������ (�������): <br>
<input type="text" name="pay" value="99" style="width: 30%;"/>
<br><br>
������� ��� ����� ������� <br>(�� ����� ����� ����� ������������� ��������� ������, ����� ������������<br> ��� �� ����� ����� ���������� � ������������, ������� ������������ �����):<br>
<input type="text" name="shag" value="5" style="width: 30%;"/>
<br><br>
������� ������ ���������� ������: <br>
<select name="period">
		<option value="1">1 ���</option>
		<option value="3">3 ����</option>
		<option value="6">6 �����</option>
		<option value="12">12 �����</option>
		<option value="24">24 ����</option>
</select>
<br><br>
<input type="submit" name="save" value="��������" style="height: 30px; margin-top:10px;" />
</form>
<?php
$date_add = time();
if(isset($_POST['save'])) {
$db->Query("SELECT * FROM wmrush_torg");
if($db->NumRows() < 1){
	if (intval($_POST['pay']) > 0 ){
	if (intval($_POST['shag']) > 0 ){
		$fruit = $_POST['fruit'];
		$period = $_POST['period'];
		$pay = $_POST['pay'];
		$shag = $_POST['shag'];
		$date_del = time() + 60 * 60 * $period;
		echo "������ ��������� � �����";
		
		$db->Query("INSERT INTO `wmrush_torg`(`fruit`,`pay`,`date_add`,`shag`,`date_del`) VALUES ('$fruit','$pay','".time()."','$shag','$date_del')");
	} else echo "������� ������ ���";
	} else echo "<br><br>������� ������� ���������<br>";
}else echo "��������� ���������� ����!";
}
?>


</div><div class='clr'></div>
