<div class="block1
"><div class="h-title1
">Тикеты</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<?
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];
?>


<?
if(isset($_GET['id'])) {
$idd = intval($_GET['id']);
$db->Query("UPDATE `db_ticket_id` SET `read` = 1 WHERE id = '$idd'");
$db->Query("SELECT * FROM db_ticket_full WHERE id_ticket = '$idd'");
if($db->NumRows() == 0) {
echo 'Пусто...';
} else {
while($full = $db->FetchArray()) {
?>

<table cellpadding='4' cellspacing='0' border='0' bordercolor='#83AA13' align='center' width='98%'>
<tr height='25' valign=top align=center>

<td class="m-tb"><?=$full['login']; ?></td>


</tr>
</table>
<table cellpadding='0' cellspacing='0' border='0' bordercolor='#83AA13' align='center' width='98%'>
<tr height='25' valign=top align=center>


<td colspan="3"><?=$full['text']; ?><td>

</tr>

<tr align="right">

<td colspan="3"><?=date('d.m.Y H:i', $full['date']); ?></td><td>


</tr>

<tr height='25' valign=top align=center>


<td colspan="3"><hr><td>

</tr>
</table>
<?

}

}

?>

<?
if (isset($_POST['otvet'])) {
$otvet = strip_tags(htmlspecialchars($db->RealEscape($_POST['otvet']), ENT_QUOTES, "cp1251"));
$iddd = intval($idd);
$status = 0;
$date = time();
	if(!empty($otvet)) {
		$db->Query("INSERT INTO db_ticket_full (id_ticket, login, text, date, status) VALUE ('$iddd', '$usname', '$otvet', '$date', '$status')");
		echo "<center><font color = '#914A1F'><b>Ваше сообщение отправлено!</b></font></center>";
		header("Location: /account/ticket/id/".$iddd);
	}else echo "<div class='error'><b>Ошибка!</b> Введите текст ответа!</div>";
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

<center><a href="/account/ticket">Мои тикеты</a> || <a href="/account/newticket">Создать тикет</a></center><br>
<?

}

} else {

?>
<center><a href="/account/ticket">Мои тикеты</a> || <a href="/account/newticket">Создать тикет</a></center><br>
<table cellpadding='4' cellspacing='0' border='0' bordercolor='#83AA13' align='center' width='98%'>
<tr height='25' valign=top align=center>
<td class="m-tb">#</td>
<td class="m-tb">Дата</td>
<td class="m-tb">Тема</td>
<td class="m-tb">Статус</td>
</tr>

<?
$db->Query("SELECT * FROM db_ticket_id WHERE user_id = '$usid' ORDER BY id DESC");
if($db->NumRows() == 0) {
echo 'Пусто...';
} else {
	while($tik = $db->FetchArray()) {
?>

<tr height="25" class="htt" valign="top" align="center">
<td align="center">#</td>
<td align="center"><?=date('d.m.Y H:i', $tik['date']); ?></td>
<td align="center"><?
if($tik['read'] == 0) { echo '<b>'; }
?>

<a href="/account/ticket/id/<?=$tik['id']; ?>"><font color="#000"><?=$tik['desc']; ?></font></a>
<?
if($tik['read'] == 0) { echo '</b>'; }
?>
</td>
<?
if ($tik['status'] == 0) $tik['status'] = '<font color="#914A1F">Открытый</font>';
if ($tik['status'] == 1) $tik['status'] = '<font color="red">Закрытый</font>';

?>
<td align="center"><?=$tik['status']; ?></td>
</tr>

<?
	}
}
?>

</table>



<? } ?>

</div></div></div>
<div class="block3"></div>
<div class="clr"></div>


