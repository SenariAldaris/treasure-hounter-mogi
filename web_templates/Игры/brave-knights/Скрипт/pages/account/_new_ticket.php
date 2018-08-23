<div class="block1
"><div class="h-title1
">Создать тикет</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<br>
<?
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];
$date = time();
$status = 0;
if(isset($_POST['desc'])) {
	$desc = strip_tags(htmlspecialchars($db->RealEscape($_POST['desc']), ENT_QUOTES, "cp1251"));
	$text = strip_tags(htmlspecialchars($db->RealEscape($_POST['text']), ENT_QUOTES, "cp1251"));
	$text = $text;
		if(!empty($desc)) {
			if(!empty($text)) {
				$db->Query("INSERT INTO db_ticket_id (`user_id`, `login`, `desc`, `date`, `status`) VALUES ('$usid', '$usname', '$desc', '$date', '$status')");
				$lid = $db->LastInsert();
				$db->Query("INSERT INTO db_ticket_full (id_ticket, login, text, date, status) VALUES ('$lid', '$usname', '$text', '$date', '$status')");
				echo 'Ваш запрос отправлен!';
				header("Location: http://".$_SERVER['HTTP_HOST']."/account/ticket/id/".$lid);
			}else echo "<div class='error'><b>Ошибка!</b> Введите текст обращения!</div>";
		}else echo "<div class='error'><b>Ошибка!</b> Введите тему обращения!</div>";

}
?>


<form action="" method="post">
<table width="500" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td align="left" style="padding:3px;">Тема: <font color="#914A1F">*</font></td>
    <td align="left" style="padding:3px;"><input name="desc" type="text" size="25" /></td>


  <tr>
    <td colspan="2" align="left">&nbsp;</td>
    </tr>
  <tr>
    <td align="left" style="padding:3px;">Текст сообщения: <font color="#FF0000">*</font></td>
    <td align="left" style="padding:3px;"><textarea name="text" rows="10" cols="60"></textarea></td>
  </tr>




  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>


    <td colspan="2" align="center" style="padding:3px;"><input name="registr" type="submit" value="Отправить" class="btn_8" style="height: 30px;"></td>
  </tr>
</table>
</form>

<center><a href="/account/ticket">Мои тикеты</a> || <a href="/account/newticket">Создать тикет</a></center>

</div>
</div>
</div>
<div class="block3"></div>
<div class="clr"></div>
