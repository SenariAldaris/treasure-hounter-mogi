<div class="block1
"><div class="h-title1
">Партнерская программа</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Партнерская программа";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT COUNT(*) FROM ".$pref."_users_a WHERE referer_id = '$user_id'");
$refs = $db->FetchRow();
?>  
<center>
Приглашайте в игру своих друзей и знакомых, Вы будете получать 10% от каждого пополнения баланса  
приглашенным Вами человеком. Доход ни чем не ограничен. Даже несколько приглашенных могут 
принести вам более 100 000 серебра. 
Ниже представлена ссылка для привлечения и количество приглашенных Вами людей.<br /><br />
<img src="/img/piar-link.png" style="vertical-align:-2px; margin-right:5px;" /><textarea onmouseover="this.select()" style="width: 243px; height: 19px;">http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?></textarea>
</center>
<br>
<br>
<center>
<img src="/img/baner468.gif">
<br>
<textarea onmouseover="this.select()" style="width: 495px; height: 55px;">&lt;a href="http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?>" target="_blank"&gt;
&lt;img src="http://<?=$_SERVER['HTTP_HOST']; ?>/img/baner468.gif" /&gt;&lt;/a&gt;
</textarea>
<br>
</center>
<br>
<br>
<center>
<img src="/img/baner200.gif">
<br>
<textarea onmouseover="this.select()" style="width: 495px; height: 55px;">&lt;a href="http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?>" target="_blank"&gt;
&lt;img src="http://<?=$_SERVER['HTTP_HOST']; ?>/img/baner200.gif" /&gt;&lt;/a&gt;
</textarea>
<br>
</center>
<br>
<br>
<center>
<img src="/img/baner100.gif">
<br>
<textarea onmouseover="this.select()" style="width: 495px; height: 55px;">&lt;a href="http://<?=$_SERVER['HTTP_HOST']; ?>/?i=<?=$_SESSION["user_id"]; ?>" target="_blank"&gt;
&lt;img src="http://<?=$_SERVER['HTTP_HOST']; ?>/img/baner100.gif" /&gt;&lt;/a&gt;
</textarea>
<br>
</center>
<br>
<br>

<p><center>Количество ваших рефералов: <font color="#914A1F"><?=$refs; ?> чел.</font></center></p>

<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width='98%'>
<tr height='25' valign=top align=center>
	<td class="m-tb"> Логин </td>
	<td class="m-tb"> Дата регистрации </td>
	<td class="m-tb"> Доход от партнера </td>
</tr>

<?PHP
  $all_money = 0;
  $db->Query("SELECT ".$pref."_users_a.user, ".$pref."_users_a.date_reg, ".$pref."_users_b.to_referer FROM ".$pref."_users_a, ".$pref."_users_b 
  WHERE ".$pref."_users_a.id = ".$pref."_users_b.id AND ".$pref."_users_a.referer_id = '$user_id' ORDER BY to_referer DESC");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
		?>
		<tr height="25" class="htt" valign="top" align="center">
			<td align="center"> <?=$ref["user"]; ?> </td>
			<td align="center"> <?=date("d.m.Y в H:i:s",$ref["date_reg"]); ?> </td>
			<td align="center"> <?=sprintf("%.2f",$ref["to_referer"]); ?> </td>
		</tr>

		<?PHP
		$all_money += $ref["to_referer"];
		}
  
	}else echo '<tr><td align="center" colspan="3">У вас нет рефералов</td></tr>'
  ?>

</table>
</div></div>
</div>
<div class="block3"></div>
<div class="clr"></div>		