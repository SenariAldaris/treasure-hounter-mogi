<div class="s-bk-lf">
	<div class="acc-title3">�������� �������������</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<center>
	<a href = "index.php?menu=sender" class="stn">������ ��������</a> || <a href = "index.php?menu=sender&add" class="stn">�������� ��������</a>
</center>
<BR />
<?PHP

if(isset($_POST["title"])){

$title = $func->TextClean($_POST["title"]);
$mess = $func->TextClean($_POST["mess"]);

	if(strlen($title) > 3){
	
		if(strlen($mess) > 10){
		
		$db->Query("INSERT INTO ".$pref."_sender (name, mess, date_add) VALUES ('$title','$mess','".time()."')");
		
		echo "<center><b>�������� ���������� � ������� �� ����������</b></center><BR />";
		
		}else echo "<center><b>��������� ������ ���� ������ 10 ��������</b></center><BR />";
	
	}else echo "<center><b>��������� ������ ���� ������ 3� ��������</b></center><BR />";

}

# ���������� ��������
if(isset($_GET["add"])){

?>
<form action="" method="post">
<table width="" border="0">
  <tr>
    <td>��������� ���������:</td>
    <td align="right"><input type="text" name="title" size="35"/></td>
  </tr>
  
  <tr>
    <td align="center" colspan="2">
	<textarea name="mess" cols="78" rows="15"></textarea>
	</td>
  </tr>
  
  <tr>
    <td align="center" colspan="2"><input type="submit" value="��������"class="btn_8"/></td>
  </tr>
</table>
</form>

<BR /><BR />
<b>������� ��� ������:</b><BR />

<font color = "red">{!USER!}</font> - ��� ������������<BR />
<font color = "red">{!PASS!}</font> - ������� ������<BR />
<font color = "red">{!REFERER!}</font> - �������<BR />
<font color = "red">{!REFERALS!}</font> - ���-�� ���������<BR />
<font color = "red">{!MONEY_B!}</font> - ������ ��� �������<BR />
<font color = "red">{!MONEY_P!}</font> - ������ �� �����<BR />


<BR /><BR />
</div>
<div class="clr"></div>	
<?PHP
return;
}

# ��������
if(isset($_POST["del"])){

	$db->Query("DELETE FROM ".$pref."_sender WHERE id = '".intval($_POST["del"])."'");	
	echo "<center><b>�������� �������</b></center><BR />";

}

$db->Query("SELECT * FROM ".$pref."_sender ORDER BY id DESC");

if($db->NumRows() > 0){



?>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr bgcolor="#efefef">
    <td align="center" width="50" class="m-tb"><b>ID</b></td>
    <td align="center" class="m-tb"><b>��������</b></td>
    <td align="center" width="100" class="m-tb"><b>����������</b></td>
	<td align="center" width="100" class="m-tb"><b>������</b></td>
	<td align="center" width="50" class="m-tb"><b>�������</b></td>
  </tr>

<?PHP

while($data = $db->FetchArray()){

?>
	<tr>
    <td align="center"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["name"]; ?></td>
    <td align="center"><?=$data["sended"]; ?> ��.</td>
	<td align="center"><?=$data["status"] == 0 ? "��������" : "���������"; ?></td>
	<td align="center">
		<form action="" method="post">
			<input type="hidden" name="del" value="<?=$data["id"]; ?>" />
			<input type="submit" value="�������" />
		</form>
	</td>
  	</tr>
<?PHP

}

?>
</table>
<BR />
<?PHP

}else echo "<center><b>�������� ���</b></center><BR />";

?>
</div>
<div class="clr"></div>	