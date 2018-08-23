<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Ежедневный бонус";
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];

?>
<div class="block1
"><div class="h-title1
">Ежедневный бонус</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<table border="0">
<tbody>
<tr>
<td align="center" width="50%">
<div colspan="3"><img src="/img/fruit/fond.png" name="slide_show"></div>   
</td>
<td align="center" width="50%">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; Это Государственный Фонд. Здесь можно получить государственную помощь на строительство или производство продукции. Выдается она один раз в 24 часа серебром. 
Сумма помощи генерируется случайно от <b><?=$bonus_min;?></b> до <b><?=$bonus_max;?></b> серебра.
</span></h3>

</td>
</tr>
</tbody>
</table>
<hr>


<?PHP
$ddel = time() + 60*60*24;
$dadd = time();
$db->Query("SELECT COUNT(*) FROM ".$pref."_bonus_list WHERE user_id = '$usid' AND date_del > '$dadd'");

$hide_form = false;

	if($db->FetchRow() == 0){
	
		# Выдача бонуса
		if(isset($_POST["bonus"])){
		
			$sum = rand($bonus_min, rand($bonus_min, $bonus_max) );
			
			# Зачилсяем юзверю
			$db->Query("UPDATE ".$pref."_users_b SET money_b = money_b + '$sum' WHERE id = '$usid'");
			
			# Вносим запись в список бонусов
			
			
			$db->Query("INSERT INTO ".$pref."_bonus_list (user, user_id, sum, date_add, date_del) VALUES ('$uname','$usid','$sum','$dadd','$ddel')");
			
			# Случайная очистка устаревших записей
			$db->Query("DELETE FROM ".$pref."_bonus_list WHERE date_del < '$dadd'");
			
			echo "<center><font color = '#914A1F'><b>На Ваш счет для покупок зачислен бонус в размере {$sum} серебра</b></font></center><BR />";
			
			$hide_form = true;
			
		}
			
			# Показывать или нет форму
			if(!$hide_form){
?>

<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td align="center"></td>
  </tr>
  <tr>
    <td align="center"><input type="submit" name="bonus" value="Получить бонус" style="height: 30px; margin-top:10px;" class="btn_8"></td>
  </tr>
</table>
</form>

<?PHP 

			}

	}else echo "<center><font color = 'red'><b>Вы уже получали бонус за последние 24 часа</b></font></center><BR />"; ?>


<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
<?PHP
$db->Query("SELECT * FROM db_bonus_list WHERE user = '$uname' LIMIT 1");
if($db->NumRows() > 0){
while($data_bonus = $db->FetchArray()){
?>
<center><font color = 'green'><b>Бонус будет доступен для сбора: <?=date("d.m в H:i:s",$data_bonus["date_del"]) ;?> </b></font></center>
 <?PHP
}
}else echo "<center><font color = 'cadetblue'><b>Вы давно не получали бонус, нажмите кнопку, чтобы получить.</b></font></center>";
?>
<br>
  <tr>
    <td colspan="5" align="center"><h4>Последние 20 бонусов</h4></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">ID</td>
    <td align="center" class="m-tb">Пользователь</td>
	<td align="center" class="m-tb">Сумма</td>
	<td align="center" class="m-tb">Дата</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM ".$pref."_bonus_list ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($bon = $db->FetchArray()){
		
		?>
		<tr class="htt">
    		<td align="center"><?=$bon["id"]; ?></td>
    		<td align="center"><?=$bon["user"]; ?></td>
    		<td align="center"><img src="/img/fruit/serebro.png" width="28" height="30" style=" margin-top: 0px; margin-left: -30px"/><div class="fr-te-gr" style=" margin-top: -27px; margin-left: 30px" /><font color="#914A1F"><?=$bon["sum"]; ?></font></td>
			<td align="center"><?=date("d.m.Y",$bon["date_add"]); ?></td>
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">Нет записей</td></tr>'
  ?>

  
</table>

</div></div></div>
<div class="block3"></div>