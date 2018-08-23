<br>
<div class="s-bk-lf">
	<div class="acc-title3">Тикеты</div>
</div>
<div class="silver-bk"><div class="clr"></div>	

<?
//$usid = $_SESSION["user_id"];
//$usname = $_SESSION["user"];
?>
<table cellpadding='4' cellspacing='0' border='0' bordercolor='#83AA13' align='center' width='98%'>


<?
if(isset($_GET['id'])) {
$idd = intval($_GET['id']);
$db->Query("UPDATE `db_ticket_id` SET `admin_read` = 1 WHERE id = '$idd'");
$db->Query("SELECT * FROM db_ticket_full WHERE id_ticket = '$idd'");
if($db->NumRows() == 0) {
echo 'Пусто...';
} else {
while($full = $db->FetchArray()) {
?>

<tr height='25' valign=top align=center>

<td class="m-tb"><?=$full['login']; ?></font></td>


</tr>

<tr align="center">


<td colspan="3"><?=$full['text']; ?><td>

</tr>

<tr align="right">

<td colspan="3"><?=date('d.m.Y H:i', $full['date']); ?><td>

</tr>
<tr align="center">


<td colspan="3"><hr><td>

</tr>
<?

}

}

?>
</table>
<?
if (isset($_POST['close'])) {
$close = intval($_POST['close']);
$db->Query("UPDATE db_ticket_id SET status = 1 WHERE id = '$close'");
}
if (isset($_POST['otvet'])) {
$otvet = $db->RealEscape($_POST['otvet']);
$otvet = $otvet;
$iddd = intval($idd);
$status = 0;
$date = time();
$adm = 'Администрация';

	if(!empty($otvet)) {
		$db->Query("INSERT INTO db_ticket_full (id_ticket, login, text, date, status) VALUE ('$iddd', '$adm', '$otvet', '$date', '$status')");
		echo 'Ваше сообщение отправлено!';
		header("Location: index.php?menu=ticket&id=".$iddd);
	}else echo 'Введите текст ответа!';
}
$db->Query("SELECT * FROM db_ticket_id WHERE id = '$idd'");
$asd = $db->FetchArray();
if ($asd['status'] == 1) {echo '<center><font color="red">Закрытый</font></center>'; 
} else {
?>
<form action="" method="post">
<table width="500" border="0" cellspacing="0" cellpadding="0">

 <input type="hidden" name="iddd" value="<?=$full['id_ticket']; ?>" />


  <tr>
    <td align="left" style="padding:3px;">Текст сообщения: <font color="#FF0000">*</font></td>
    <td align="left" style="padding:3px;"><textarea name="otvet" rows="10" cols="60"></textarea></td>
  </tr>
 
 
  
 
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
 
 
    <td colspan="2" align="center" style="padding:3px;"><input name="registr" type="submit" value="Отправить" class="btn_8" style="height: 30px;"></td>
  </tr>

</table>
</form>
<table>
<form method="post" action="">
   <tr>
    <td colspan="2" align="left">
	<input type="hidden" name="close" value="<?=$idd; ?>">
	
	<input type="submit" value="Закрыть" class="btn_8"></td>
  </tr>
  </form>
  </table>
<?

}

} else {

?>
<table cellpadding='4' cellspacing='0' border='0' bordercolor='#83AA13' align='center' width='98%'>
<tr height='25' valign=top align=center>
<td class="m-tb">#</td>
<td class="m-tb">Дата</td>
<td class="m-tb">Тема</td>
<td class="m-tb">Статус</td>
</tr>

<?
$db->Query("SELECT * FROM db_ticket_id ORDER BY id DESC");
if($db->NumRows() == 0) {
echo 'Пусто...';
} else {
	while($tik = $db->FetchArray()) {
?>

<tr height="25" class="htt" valign="top" align="center">
<td align="center">#</td>
<td align="center"><?=date('d.m.Y H:i', $tik['date']); ?></td>
<td align="center"><?
if($tik['admin_read'] == 0) { echo '<b>'; }
?>

<a href="index.php?menu=ticket&id=<?=$tik['id'];  ?>"><font color="#000"><?=$tik['desc']; ?></font></a>
<?
if($tik['admin_read'] == 0) { echo '</b>'; }
?>
</td>
<?
if ($tik['status'] == 0) $tik['status'] = '<font color="green">Открытый</font>';
if ($tik['status'] == 1) $tik['status'] = '<font color="red">Закрытый</font>';

?>
<td><?=$tik['status']; ?><td>
</tr>

<?
	}
}
?>

</table>



<? } ?>
 
</div><div class='clr'></div>


