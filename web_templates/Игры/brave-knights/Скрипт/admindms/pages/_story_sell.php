<div class="s-bk-lf">
	<div class="acc-title3">������� �������� </div>
</div>
<div class="silver-bk"><div class="clr"></div>
<center>
<span onclick="show('1')"><a onclick="return false"><button class="btn_8" type="button">������� ������</button></a></span>
<span onclick="show('2')"><a onclick="return false"><button class="btn_8" type="button">������� �������</button></a></span>
</center>
<script language="JavaScript"> 
function show(obj) { 
if (document.getElementById(obj).style.display == 'none') 
document.getElementById(obj).style.display = 'block'; 
else document.getElementById(obj).style.display = 'none'; 
} 
</script>
<span class="sub" id="1" style="display: none;"> <br />
<?PHP
$tdadd = time() - 5*60;
	if(isset($_POST["clean1"])){
	
		$db->Query("DELETE FROM db_sell_trade WHERE date_add < '$tdadd'");
		echo "<center><font color = 'green'><b>�������</b></font></center><BR />";
	}

$db->Query("SELECT * FROM db_sell_trade ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" class="m-tb" width="50" >ID</td>
    <td align="center" class="m-tb" >������������</td>
    <td align="center" class="m-tb" width="80" >������</td>
	<td align="center" class="m-tb" width="80" >�������</td>
	<td align="center" class="m-tb" width="80" >�� �����</td>
	<td align="center" class="m-tb" width="150" >���� ��������</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center"  width="50"><?=$data["id"]; ?></td>
    <td align="center"  ><?=$data["user"]; ?></td>
    <td align="center"  width="80"><?=$data["citem"]; ?></td>
    <td align="center"  width="80"><?=$data["kolvo"]; ?></td>
	<td align="center"  width="80"><?=sprintf("%.2f",$data["amount"]); ?></td>
	<td align="center"  width="150"><?=date("d.m.Y � H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<form action="" method="post">
<center><input type="submit" name="clean1" class="btn_8" value="�������� �������" /></center>
</form>
<?PHP

}else echo "<center><b>������� ���</b></center><BR />";
?>
</span>

<span class="sub" id="2" style="display: none;"> <br />
<?PHP
$tdadd = time() - 5*60;
	if(isset($_POST["clean2"])){
	
		$db->Query("DELETE FROM db_buy_trade WHERE date_add < '$tdadd'");
		echo "<center><font color = 'green'><b>�������</b></font></center><BR />";
	}

$db->Query("SELECT * FROM db_buy_trade ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" class="m-tb" width="50" >ID</td>
    <td align="center" class="m-tb">������������</td>
    <td align="center" class="m-tb" width="80" >�����</td>
	<td align="center" class="m-tb" width="80" >�������</td>
	<td align="center" class="m-tb" width="80" >�� �����</td>
	<td align="center" class="m-tb" width="150" >���� ��������</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
    <td align="center" width="80"><?=$data["citem"]; ?></td>
    <td align="center" width="80"><?=$data["kolvo"]; ?></td>
	<td align="center" width="80"><?=sprintf("%.2f",$data["amount"]); ?></td>
	<td align="center" width="150"><?=date("d.m.Y � H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<form action="" method="post">
<center><input type="submit" name="clean2" class="btn_8" value="�������� �������" /></center>
</form>
<?PHP

}else echo "<center><b>������� ���</b></center><BR />";
?>
</span>

</div>
<div class="clr"></div>	