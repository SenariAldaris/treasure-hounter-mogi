<?PHP
$_OPTIMIZATION["title"] = "Конкурс рефералов";
$_OPTIMIZATION["description"] = "Конкурс рефералов";
$_OPTIMIZATION["keywords"] = "Конкурс, конкурс рефералов";
?>
<div class="block1
"><div class="h-title1
">Конкурс рефералов</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
	
<center><a href="/competition" class="stn">Текущие конкурсы</a> || <a href="/competition/list" class="stn">Завершенные</a></center><BR />
<?PHP

# Список конкурсов
if(isset($_GET["list"])){


	# Список пользователей
	$db->Query("SELECT * FROM ".$pref."_competition WHERE status > 0");
	if($db->NumRows() > 0){
	
	?>
	
	
	<?PHP
		while($data = $db->FetchArray()){
		
		?>
			<table width="99%" border="0" align="center">
			<tr bgcolor="#efefef">
				<td align="center" width="75" class="m-tb">ID</td>
				<td align="center" class="m-tb">Начат</td>
				<td align="center" class="m-tb">Завершен</td>
				<td align="center" class="m-tb">Фонд</td>
			</tr>
			<tr class="htt" >
				<td align="center"><?=$data["id"]; ?></td>
				<td align="center"><?=date("d.m.Y", $data["date_add"]); ?></td>
				<td align="center"><?=date("d.m.Y", $data["date_end"]); ?></td>
				<td align="center"><?=$data["1m"]+$data["2m"]+$data["3m"]; ?> RUB</td>
		 	</tr>
			<tr bgcolor="#efefef">
				<td align="center" width="75" class="m-tb">Статус</td>
				<td align="center" class="m-tb">1 место / приз</td>
				<td align="center" class="m-tb">2 место / приз</td>
				<td align="center" class="m-tb">3 место / приз</td>
			</tr>
			<tr class="htt" >
				<td align="center"><?=($data["status"] > 1) ? "Отменен" : "Завершен"; ?></td>
				<td align="center"><?=$data["user_1"]; ?> / <?=$data["1m"]; ?></td>
				<td align="center"><?=$data["user_2"]; ?> / <?=$data["2m"]; ?></td>
				<td align="center"><?=$data["user_3"]; ?> / <?=$data["3m"]; ?></td>
		 	</tr>
			</table>
		<BR /><BR />
		<?PHP
		}

	}else echo "<center><b><font color = 'red'>Нет завершенных конкурсов</font></b></center><BR />";


?>
</div></div></div><div class="block3"></div>
<div class="clr"></div>	
<?PHP

return;
}


$db->Query("SELECT * FROM ".$pref."_competition WHERE status = 0 LIMIT 1");
if($db->NumRows() == 1){
$comp = $db->FetchArray();	
	?>
<center>
<b>Конкурс рефералов № <?=$comp["id"]; ?> с общим призовым фондом <?=$comp["1m"]+$comp["2m"]+$comp["3m"]; ?> RUB<BR /><BR /></b>
Старт конкурса: <?=date("d.m.Y в H:i:s", $comp["date_add"]); ?> <BR />Завершение: <?=date("d.m.Y в H:i:s", $comp["date_end"]); ?>
<BR /><BR />

<font color = '#914A1F'><b><u>Призовые места:</u><BR />
1 - <?=$comp["1m"]; ?> RUB <BR />
2 - <?=$comp["2m"]; ?> RUB <BR />
3 - <?=$comp["3m"]; ?> RUB <BR /><BR /></b></font>

В конкурсе учитываются только активные рефералы, которые зарегистрировались после запуска конкурса. <BR />За каждое пополнение баланса Вашим рефералом Вам начисляются баллы, 1 RUB = 1 баллу. Чем больше баллов, тем больше шанс победить в конкурсе. <BR /><BR />
</center>
	<?PHP
	
	# Список пользователей
	$db->Query("SELECT * FROM ".$pref."_competition_users ORDER BY points DESC LIMIT 100");
	if($db->NumRows() > 0){
	
	?>
	<center><b>Таблица лидеров</b></center>
<table width="99%" border="0" align="center">
  <tr bgcolor="#efefef">
    <td align="center" width="75" class="m-tb">Позиция</td>
    <td align="center" class="m-tb">Пользователь</td>
    <td align="center" class="m-tb">Баллов</td>
	<td align="center" class="m-tb">Приз</td>
  </tr>
	<?PHP
		$position = 1;
		while($data = $db->FetchArray()){
		
		?>
			<tr class="htt" >
				<td align="center" width="75"><?=$position; ?></td>
				<td align="center"><?=$data["user"]; ?></td>
				<td align="center"><?=sprintf("%.0f",$data["points"]); ?></td>
				<td align="center"><?=(intval($comp["{$position}m"]) > 0) ? $comp["{$position}m"]." RUB" : "-" ?></td>
		 	</tr>
		<?PHP
		$position++;
		}
	
	?>
</table>
<BR />
	<?PHP
	
	}else echo "<center><b><font color = 'red'>Нет участников в конкурсе</font></b></center><BR />";

}else echo "<center><b><font color = 'red'>В данный момент конкурс не проводится</font></b></center><BR />";

?>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>


<style>
.block2 {background: url('/img/block2.png') repeat-y;
    position: relative;
    z-index: 10;
    left: 50%;
    margin-left: -160px;
    padding: 0px 50px 10px 50px;
    float: center;
    height: 450px;
    overflow: auto;
    color: #000000;
    font-family: 'Comic Sans MS', cursive;
    font-size: 11pt;
    width: 560px;}
</style>