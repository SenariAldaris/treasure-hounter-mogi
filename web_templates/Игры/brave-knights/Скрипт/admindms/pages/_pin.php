<div class="s-bk-lf">
	<div class="acc-title3">Пин коды</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<!--Powered By WmRush.name -->
<?
if (isset($_POST['gen'])) {
$sum = intval($_POST['summa']);
$kol = intval($_POST['kol']);
$status = 0;
 if($kol > 0) {
	for($i = 0; $i < $kol; $i++) {
		$gen = rand(1000000000, 9999999999);
		$gen_md = md5($gen);
		
		$db->Query("INSERT INTO ".$pref."_pin (pin, summa, status) VALUES ('$gen_md', '$sum', '$status')");
		echo $gen_md.'<br>';
	}
 }else echo 'Введите колличество пинкодов';
} else {

?>



<table align="center" width="500" border="0">
<tr>
<td></td>
<td>Пин код</td>
<td>Сумма</td>
<td>Статус</td>
</tr>
<?
$db->Query("SELECT * FROM ".$pref."_pin ORDER BY status ASC");
while($pin = $db->FetchArray()) {
if ($pin['status'] == 1) {$pin['status'] = '<font color="red">Активирован</font>';}else{$pin['status'] = '<font color="green">Не Активирован</font>';}
?>
<tr>
<td></td>
<td><?=$pin['pin']; ?></td>
<td><?=$pin['summa']; ?> руб.</td>
<td><?=$pin['status']; ?></td>
</tr>

<? } ?>

</table>

<hr>
<div class="s-bk-lf">
	<div class="acc-title">Сгенерировать Пин коды</div>
</div>
<table align="center">
<form method="post" action="">
<tr>
<td>Сумма</td>
<td><select name="summa">
<option value="1">1 Руб
<option value="10">10 Руб
<option value="100">100 Руб
<option value="250">250 Руб
<option value="500">500 Руб
<option value="1000">1000 Руб
<option value="2000">2000 Руб
</select></td>
</tr><br>
<tr>
<td>Колличество</td>
<td><input type="text" name="kol"></td>
<br>
<td colspan="2">
<input type="submit" name="gen" value="Сгенерировать"class="btn_8"></td>
</tr>
  <tr align="right"><td colspan="2"><font size="1"><a href="http://wmrush.name/" target="_blank">Powered By WmRush.name</a></font></tr>
</form>
</table>


<? } ?>

<!--Powered By WmRush.name -->


</div>
<div class="clr"></div>	