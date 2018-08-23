<div class="s-bk-lf">
	<div class="acc-title3">История производств</div>
</div>
<div class="silver-bk"><div class="clr"></div><BR />		
<center>

<span onclick="show('3')"><a onclick="return false"><button class="btn_8" type="button">Приготовление</button></a></span>
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
	
		$db->Query("DELETE FROM ".$pref."_stats_area WHERE date_add < '$tdadd'");
		echo "<center><font color = '#914A1F'><b>Очищено</b></font></center><BR />";
	}
$db->Query("SELECT * FROM ".$pref."_stats_area ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" width="50" class="m-tb">ID</td>
    <td align="center" width="150" class="m-tb">Пользователь</td>
    <td align="center" width="150" class="m-tb">Покупка</td>
	<td align="center" width="150" class="m-tb">Дата операции</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
    <td align="center" width="150"><?=$data["area"]; ?></td>
	<td align="center" width="150"><?=date("d.m.Y в H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<form action="" method="post">
<center><input type="submit" name="clean1" class="btn_8" value="Очистить" /></center>
</form>
<?PHP
}else echo "<center><b>Записей нет</b></center><BR />";
?>
</span>

<span class="sub" id="2" style="display: none;"> <br />
<?PHP
$tdadd = time() - 5*60;
	if(isset($_POST["clean2"])){
	
		$db->Query("DELETE FROM ".$pref."_stats_bar WHERE date_add < '$tdadd'");
		echo "<center><font color = '#914A1F'><b>Очищено</b></font></center><BR />";
	}
$db->Query("SELECT * FROM ".$pref."_stats_bar ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" width="50" class="m-tb">ID</td>
    <td align="center" width="150" class="m-tb">Пользователь</td>
    <td align="center" width="150" class="m-tb">Бизнес</td>
	<td align="center" width="150" class="m-tb">Дата операции</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
    <td align="center" width="150"><?=$data["bar"]; ?></td>
	<td align="center" width="150"><?=date("d.m.Y в H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<form action="" method="post">
<center><input type="submit" name="clean2" class="btn_8" value="Очистить" /></center>
</form>
<?PHP

}else echo "<center><b>Записей нет</b></center><BR />";
?>
</span>

<span class="sub" id="3" style="display: none;"> <br />
<?PHP
$tdadd = time() - 5*60;
	if(isset($_POST["clean3"])){
	
		$db->Query("DELETE FROM ".$pref."_stats_pbar WHERE date_add < '$tdadd'");
		echo "<center><font color = '#914A1F'><b>Очищено</b></font></center><BR />";
	}
$db->Query("SELECT * FROM ".$pref."_stats_pbar ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" width="50" class="m-tb">ID</td>
    <td align="center" width="150" class="m-tb">Пользователь</td>
    <td align="center" width="150" class="m-tb">Продукция</td>
	<td align="center" width="150" class="m-tb">Дата операции</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
    <td align="center" width="150"><?=$data["bar"]; ?></td>
	<td align="center" width="150"><?=date("d.m.Y в H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<form action="" method="post">
<center><input type="submit" name="clean3" class="btn_8" value="Очистить" /></center>
</form>
<?PHP

}else echo "<center><b>Записей нет</b></center><BR />";
?>
</span>

</div>
<div class="clr"></div>	