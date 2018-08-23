<div class="s-bk-lf">
	<div class="acc-title3">История главной столовой</div>
</div>
<div class="silver-bk"><div class="clr"></div>	<br />	
<center>
<span onclick="show('1')"><a onclick="return false"><button class="btn_8" type="button">В продаже</button></a></span>
<span onclick="show('2')"><a onclick="return false"><button class="btn_8" type="button">История покупок</button></a></span>
<span onclick="show('3')"><a onclick="return false"><button class="btn_8" type="button">Пополнение энергии</button></a></span>
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
if(isset($_POST["delotz"]) AND isset($_POST["del_id"]))
{
	$id=intval($_POST["del_id"]);

		$db->Query("DELETE FROM ".$pref."_power WHERE id = {$id};");
		echo('<center><font color="#914A1F">Заявка успешно удалено без возврата продукции!</font></center>');

}

$db->Query("SELECT * FROM ".$pref."_power ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" width="50" class="m-tb">ID</td>
    <td align="center" width="150" class="m-tb">Пользователь</td>
    <td align="center" width="150" class="m-tb">Продукт</td>
	<td align="center" width="50" class="m-tb">Кол-во</td>
	<td align="center" width="75" class="m-tb">Цена/шт.</td>
	<td align="center" width="150" class="m-tb">Дата операции</td>
	<td align="center" width="150" class="m-tb">Удалить</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
	    <td align="center" width="80">
	<?php if ($data["coctel_a"]==1) { ?> Кофе 
	<?php } if ($data["coctel_b"]==1) { ?> Гамбургер 
	<?php } if ($data["coctel_c"]==1) { ?> Пицца 
	<?php } ?>
	</td>
	
    <td align="center" width="80"><?=$data["kolvo"]; ?></td>
	<td align="center" width="80"><?=sprintf("%.2f",$data["amount"]); ?></td>
	<td align="center" width="150"><?=date("d.m.Y",$data["date_add"]); ?></td>
	<td align="center">
	<?
$by_user_id = $data['id']; ?>
	<form action="" method="post">
<input type="hidden" name="del_id" value="<?=$by_user_id;?>">
<input type="submit" class="btn_8" name="delotz" value="Удалить" />
</form>
	</td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />

<?PHP

}else echo "<center><b>Записей нет</b></center><BR />";
?>
</span>

<span class="sub" id="2" style="display: none;"> <br />
<?PHP
$tdadd = time() - 5*60;
	if(isset($_POST["clean1"])){
	
		$db->Query("DELETE FROM ".$pref."_power_buy WHERE date_add < '$tdadd'");
		echo "<center><font color = '#914A1F'><b>Очищено</b></font></center><BR />";
	}
$db->Query("SELECT * FROM ".$pref."_power_buy ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" width="50" class="m-tb">ID</td>
    <td align="center"  class="m-tb">Пользователь</td>
    <td align="center" width="80" class="m-tb">Покупка</td>
	<td align="center" width="80" class="m-tb">Сколько</td>
	<td align="center" width="80" class="m-tb">На Сумму</td>
	<td align="center" width="150" class="m-tb">Дата операции</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
    <td align="center" width="80"><?=$data["coctel"]; ?></td>
    <td align="center" width="80"><?=$data["kolvo"]; ?></td>
	<td align="center" width="80"><?=sprintf("%.2f",$data["amount"]); ?></td>
	<td align="center" width="150"><?=date("d.m.Y в H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<form action="" method="post">
<center><input type="submit" name="clean1" class="btn_8" value="Очистить покупки" /></center>
</form>
<?PHP

}else echo "<center><b>Записей нет</b></center><BR />";
?>
</span>

<span class="sub" id="3" style="display: none;"> <br />
<?PHP
$tdadd = time() - 5*60;
	if(isset($_POST["clean2"])){
	
		$db->Query("DELETE FROM ".$pref."_power_add WHERE date_add < '$tdadd'");
		echo "<center><font color = '#914A1F'><b>Очищено</b></font></center><BR />";
	}
$db->Query("SELECT * FROM ".$pref."_power_add ORDER BY id DESC");

if($db->NumRows() > 0){

?>
<table cellpadding='3' cellspacing='0' border='0' class='ta' align='center' width="99%">
  <tr bgcolor="#914A1F">
    <td align="center" width="50" class="m-tb">ID</td>
    <td align="center" width="150" class="m-tb">Пользователь</td>
    <td align="center" width="80" class="m-tb">Продукт</td>
	<td align="center" width="80" class="m-tb">Энергии</td>
	<td align="center" width="150" class="m-tb">Дата операции</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center" width="50"><?=$data["id"]; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
    <td align="center" width="80"><?=$data["coctel"]; ?></td>
    <td align="center" width="80"><?=$data["kolvo"]; ?></td>
	<td align="center" width="150"><?=date("d.m.Y в H:i:s",$data["date_add"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<form action="" method="post">
<center><input type="submit" name="clean2" class="btn_8" value="Очистить историю" /></center>
</form>
<?PHP

}else echo "<center><b>Записей нет</b></center><BR />";
?>
</span>

</div>
<div class="clr"></div>	
