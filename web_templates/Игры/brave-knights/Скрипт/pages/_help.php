<?PHP
$_OPTIMIZATION["title"] = "��������";
$_OPTIMIZATION["description"] = "����� � ��������������";
$_OPTIMIZATION["keywords"] = "����� � �������������� �������";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];
?>

<div class="block1
"><div class="h-title1
">������ ������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">

<div class="fr-te-gr-title"><center><b>������� ���� ������:</b></center></div>
<?PHP if($_SESSION["user"]=$usname) {?>

<table><tr><td>
<div id="link3" style="
    width: 270px;
    height: 300px;
    background: url(/img/korol.png);
    position: relative;
    left: 0px;
    background-repeat: no-repeat;
    background-size: 100% 100%;
    top: -40px;
    z-index: 100;
    cursor: pointer;

"></div>
</td>
</td><td>

<?
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];
$date = time();
$status = 0;
if(isset($_POST['desc'])) {
	$desc = strip_tags(htmlspecialchars($db->RealEscape($_POST['desc']), ENT_QUOTES, "cp1251"));
	$text = strip_tags(htmlspecialchars($db->RealEscape($_POST['text']), ENT_QUOTES, "cp1251"));
		if(!empty($desc)) {
			if(!empty($text)) {
				$db->Query("INSERT INTO db_ticket_id (`user_id`, `login`, `desc`, `date`, `status`) VALUES ('$usid', '$usname', '$desc', '$date', '$status')");
				$lid = $db->LastInsert();
				$db->Query("INSERT INTO db_ticket_full (id_ticket, login, text, date, status) VALUES ('$lid', '$usname', '$text', '$date', '$status')");
				echo '��� ������ ���������!';
				header("Location: http://".$_SERVER['HTTP_HOST']."/account/ticket/id/".$lid);
			}else echo "<div class='error'><b>������!</b> ������� ����� ���������!</div>";
		}else echo "<div class='error'><b>������!</b> ������� ���� ���������!</div>";

}
?>


<form action="" method="post">
<table width="280" border="0" cellspacing="0" cellpadding="0">

  <tr>

	<td align="left"><select id="selector" name="desc" style="width: 280px;margin-top: -50px;">
				<option value="1" disabled="disabled" selected="">�������� ���� ������ ���������</option>
				<option value="������ Payeer">������ Payeer</option>
				<option value="������ WebMoney">������ WebMoney</option>
				<option value="������ FREE-KASSA">������ FREE-KASSA</option>
				<option value="������ QIWI">������ QIWI</option>
				<option value="���� �������� Payeer �������">���� �������� Payeer �������</option>
				<option value="������� ��������������">������� ��������������</option>
				<option value="������ �������">������ �������</option>
				</select></td>
  </tr>
 <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
	<tr>
    <td align="right" style="padding:3px;"> <textarea class="chatmessage" required="" placeholder="��� ��������� �� ������ ��������� ��������, ��� ������� ��� ����� ������! �� ���������� �������� �����, �������� ��� �� ������� ��� ������!" name="text" style="width: 280px;height: 100px;margin: 0px 0 0 0px;" maxlength="480" onkeypress="return isNotMax(event)"></textarea></td>
	</tr>
  <tr>
    <td colspan="2" align="left"></td>
  </tr>
    <td colspan="2" align="center" style="padding:3px;"><input name="registr" type="submit" value="������� �����" class="btn_8" style="height: 30px;"></td>
  </tr>
</table>
</form>
</td></tr></table>

<?
if(isset($_GET['id'])) {
$idd = intval($_GET['id']);
$db->Query("UPDATE `db_ticket_id` SET `read` = 1 WHERE id = '$idd'");
$db->Query("SELECT * FROM db_ticket_full WHERE id_ticket = '$idd'");
if($db->NumRows() == 0) {
echo '�����...';
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

<td colspan="3"><?=date('d.m.Y H:i', $full['date']); ?><td>


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
		echo "<center><font color = 'green'><b>���� ��������� ����������!</b></font></center>";
		header("Location: /account/ticket/id/".$iddd);
	}else echo "<div class='error'><b>������!</b> ������� ����� ������!</div>";
}
$db->Query("SELECT * FROM db_ticket_id WHERE id = '$idd'");
$asd = $db->FetchArray();
if ($asd['status'] == 1) {echo '<center><font color="red">��������</font></center>';
} else {
?>
<form action="" method="post">
<table width="280" border="0" cellspacing="0" cellpadding="0">

 <input type="hidden" name="iddd" value="<?=$full['id_ticket']; ?>" />
 
  <tr>
    <td align="left" style="padding:3px;">����� ���������: <font color="#FF0000">*</font></td>
    <td align="left" style="padding:3px;"><textarea name="otvet" rows="10" cols="60"></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  
    <td colspan="2" align="center" style="padding:3px;"><input name="registr" type="submit" value="���������" class="btn_8" style="height: 30px;"></td>
  </tr>
</table>
</form>
<?

}

} else {

?>
<table cellpadding='4' cellspacing='0' border='0' bordercolor='#83AA13' align='center' width='98%'>
<tr height='25' valign=top align=center>
<td class="m-tb">����</td>
<td class="m-tb">����</td>
<td class="m-tb">������</td>
</tr>

<?
$db->Query("SELECT * FROM db_ticket_id WHERE user_id = '$usid' ORDER BY id DESC");
if($db->NumRows() == 0) {
echo '�����...';
} else {
	while($tik = $db->FetchArray()) {
?>

<tr height="25" class="htt" valign="top" align="center">
<td align="center"><?
if($tik['read'] == 0) { echo '<b>'; }
?>

<a href="/account/ticket/id/<?=$tik['id']; ?>"><font color="#000"><?=$tik['desc']; ?></font></a>
<?
if($tik['read'] == 0) { echo '</b>'; }
?>
</td>
<td align="center"><?=date('d.m.Y H:i', $tik['date']); ?></td>

<?
if ($tik['status'] == 0) $tik['status'] = '<font color="green">��������</font>';
if ($tik['status'] == 1) $tik['status'] = '<font color="red">��������</font>';

?>
<td align="center"><?=$tik['status']; ?></td>
</tr>

<?
	}
}
?>

</table>

<? } ?>

<?PHP } else {	?> <tr><td align="center" colspan="6"><font color="red"><center>������ ��� ���������� � ����������� ���������, ����������, ���������������!</center></font></td></tr><?PHP } ?>

</div></div>
</div>
<div class="block3"></div>
<div class="clr"></div>
