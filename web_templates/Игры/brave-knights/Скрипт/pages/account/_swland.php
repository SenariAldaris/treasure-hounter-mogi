<?PHP
$_OPTIMIZATION["title"] = "Swamp Land";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

?>
<div class="block1
"><div class="h-title1
">Swamp Land</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<BR />
<style>
.hkuv:hover { background-color:#0004DD; }

.alert {
text-align:center;
padding: 15px;
margin-bottom: 10px;
border: 1px solid transparent;
border-radius: 4px;
}

.bg-success {
 color: black;
 background: #8ccb5e !important;
}
.bg-error{
 color: black;
 background: #f9243f !important;
}
.bg-warning {
 color: black;
 background: #ffb53e !important;
}
</style>

<?PHP
if (isset($_GET['id'])) {
$eid = intval($_GET["id"]);
$db->Query("SELECT * FROM db_swamp_land WHERE id = '$eid' AND status <= 7 AND user = '$usname'");
# Проверяем на существование
if($db->NumRows() != 1){ echo "<div class='alert bg-error' role='alert'>Данной игры не существует!</div>"; return; }
$second = $db->FetchArray();

//Играем
if(isset($_POST["go"])){ 
	$idkr = intval($_POST["go"]); //Записали в какую Ячейку прыгнул пользователь
	
	if ($second["line_".$second["status"]."_".$idkr] == 1) { //Проверяем есть ли там крокодил
		//Если есть, то закрываем игру
		$db->Query("UPDATE db_swamp_land SET status = 7, vin = 0 WHERE id = '$eid'");
		echo "<div class='alert bg-error' role='alert'>К сожалению, вы наткнулись на крокодила</div>";
		header( 'Refresh: 1; url=/account/swland/'.$eid );
	} else {
		
		//Иначе переходим на следующий уровень
		$db->Query("UPDATE db_swamp_land SET status = status + 1 WHERE id = '$eid'");
			$db->Query("SELECT * FROM db_swamp_land WHERE id = '$eid' AND status <= 7 AND user = '$usname'");
			$theend = $db->FetchArray();
			
			if ($theend["status"] == 6) { //Проверяем прошёл ли пользователь всё поле
				$endvin = $theend["sum"]*2;
					//Зачисляем средства пользователю
					$db->Query("UPDATE db_users_b SET money_b = money_b + $endvin WHERE id = '$usid'");
					//Закрываем игру
					$db->Query("UPDATE db_swamp_land SET status = 6, vin = $endvin WHERE id = '$eid'");
					echo "<div class='alert bg-success' role='alert'>Вы прошли все болото! Ваш выигрыш - {$endvin} Серебра</div>";
			} else echo "<div class='alert bg-success' role='alert'>Крокодил остался без обеда! Секундочку...</div>";
			
		header( 'Refresh: 0; url=/account/swland/'.$eid );
	}
}

//Забираем деньги
if(isset($_POST["mymoney"])){
	//Зачисляем денежку
	$db->Query("SELECT * FROM db_swamp_land WHERE id = '$eid' AND status = 5 AND user = '$usname'");
	if($db->NumRows() == 1){
		$getmoney = $db->FetchArray();
	
			$vinner = $getmoney["sum"]*1.8;
			//ЗачислЯем средства пользователю
			$db->Query("UPDATE db_users_b SET money_b = money_b + $vinner WHERE id = '$usid'");
			
			//Закрываем игру
			$db->Query("UPDATE db_swamp_land SET status = 6, vin = $vinner WHERE id = '$eid'");
			
		echo "<div class='alert bg-success' role='alert'>Вы забрали ваш выигрыш - {$vinner} Серебра</div>";
		header( 'Refresh: 2; url=/account/swland/'.$eid );
	}else echo "<div class='alert bg-error' role='alert'>Ошибка заявки! Попробуйте еще раз!</div>";
}
?>

<style>
.wtf {
	background :transparent url("/img/list2.gif") no-repeat;
	width :79px;
	height :79px;
	border :0;
	cursor :pointer;
}
</style>


<? if ($second["status"] == 6) { ?>
<div class='alert bg-success' role='alert'>Вам удалось обхитрить крокодила!</div><br />
	<table width="65%" align="Center">
	<tr><td><b>Ставка: </b></td><td><?=$second["sum"];?></td></tr>
	<tr><td><b>Время начала игры:</b> </td><td><?=date("d.m.Y H:i:s",$second["date_add"]); ?></td></tr>
	<tr><td><b>Время удаления игры: </b></td><td><?=date("d.m.Y H:i:s",$second["date_del"]); ?></td></tr>
	</table><br />
<?} elseif ($second["status"] ==7) { ?>
<div class='alert bg-error' role='alert'>К сожалению вы стали обедом крокодила!</div><br />
	<table width="65%" align="Center">
	<tr><td><b>Ставка: </b></td><td><?=$second["sum"];?></td></tr>
	<tr><td><b>Время начала игры: </b></td><td><?=date("d.m.Y H:i:s",$second["date_add"]); ?></td></tr>
	<tr><td><b>Время удаления игры: </b></td><td><?=date("d.m.Y H:i:s",$second["date_del"]); ?></td></tr>
	</table><br />
<?}?>
<hr>
<center><a href="/account/swland"><button class="btng">Назад</button></a> - <a href="/account/swland/<?=$second["id"];?>"><button class="btng">Обновить</button></a></center>
<hr>
<table cellspacing="0" cellpadding="0" align="Center">
<tr height="395px">
<td width="135px"><img src="/img/bgswland.jpg" /></td>
<td width="395" style="border-radius:0px;" bgcolor="#0004f9">

<table height="100%" width="100%" cellspacing="0" cellpadding="0">
<? if ($second["status"] == 5) { ?>
<tr class="hkuv" height="20%">
<form action="" method="post">
	<td width="20%"><input name="go" value="1" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="2" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="3" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="4" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="5" type="submit" class="wtf" /></td>
</form>
</tr>
<? } elseif ($second["status"] > 5) {?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="<? if ($second["line_5_1"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_5_2"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_5_3"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_5_4"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_5_5"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
</tr>
<? } else { ?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
</tr>
<? }?>

<? if ($second["status"] == 4) { ?>
<tr class="hkuv" height="20%">
<form action="" method="post">
	<td width="20%"><input name="go" value="1" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="2" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="3" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="4" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="5" type="submit" class="wtf" /></td>
</form>
</tr>
<? } elseif ($second["status"] > 4) {?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="<? if ($second["line_4_1"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_4_2"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_4_3"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_4_4"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_4_5"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
</tr>
<? } else { ?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
</tr>
<? }?>

<? if ($second["status"] == 3) { ?>
<tr class="hkuv" height="20%">
<form action="" method="post">
	<td width="20%"><input name="go" value="1" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="2" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="3" type="submit" class="wtf"  /></td>
	<td width="20%"><input name="go" value="4" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="5" type="submit" class="wtf" /></td>
</form>
</tr>
<? } elseif ($second["status"] > 3) {?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="<? if ($second["line_3_1"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_3_2"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_3_3"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_3_4"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_3_5"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
</tr>
<? } else { ?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
</tr>
<? }?>

<? if ($second["status"] == 2) { ?>
<tr class="hkuv" height="20%">
<form action="" method="post">
	<td width="20%"><input name="go" value="1" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="2" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="3" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="4" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="5" type="submit" class="wtf" /></td>
</form>
</tr>
<? } elseif ($second["status"] > 2) {?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="<? if ($second["line_2_1"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_2_2"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_2_3"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_2_4"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_2_5"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
</tr>
<? } else { ?>
<tr class="hkuv" height="20%">
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
	<td width="20%"><img src="/img/list1.gif" width="79px" height="79px" /></td>
</tr>
<? }?>



<? if ($second["status"] == 1) { ?>
<tr class="hkuv" height="20%">
<form action="" method="post">
	<td width="20%"><input name="go" value="1" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="2" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="3" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="4" type="submit" class="wtf" /></td>
	<td width="20%"><input name="go" value="5" type="submit" class="wtf" /></td>
</form>
</tr>
<? } elseif ($second["status"] > 1) {?>

<tr class="hkuv" height="20%">
	<td width="20%"><img src="<? if ($second["line_1_1"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_1_2"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_1_3"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_1_4"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
	<td width="20%"><img src="<? if ($second["line_1_5"] == 1){?>/img/croco.gif<? } else { ?>/img/list1.gif<?}?>" width="79px" height="79px" /></td>
</tr>

<? } ?>
</table>


</td>
</tr>
<tr><td colspan="2" align="center">
<? if ($second["status"] == 5) {?>
<form action="" method="post">
<input name="go" value="1" type="submit" name="mymoney" value="Забрать выигрыш" class="btnb"/>
</form>
<? } ?>
</td></tr>
</table>
</div></div></div>
<div class="block3"></div>

<? return; } ?>



<?
if(isset($_POST["game"])){
	//Проверяем не начата ли уже игра у данного пользователЯ
	$db->Query("SELECT * FROM db_swamp_land WHERE user='$usname' AND status < 6");
	if($db->NumRows() == 0){
			//Проверяем достаточно ли средств для игры
			$summa = intval($_POST['summa']);
			if ($summa > 0) {
			if($summa <= $user_data["money_b"]){
				
				//Снимаем средства у пользователя
			    $db->Query("UPDATE db_users_b SET money_b = money_b - $summa WHERE id = '$usid'");
				
				//Генерируем игру
				$kr1 = rand(1,5); //Рандомим крокодила на 1 линии
				$kr2 = rand(1,5); //Рандомим крокодила на 2 линии
				$kr3 = rand(1,5); //Рандомим крокодила на 3 линии
				$kr4 = rand(1,5); //Рандомим крокодила на 4 линии
				$kr5 = rand(1,5); //Рандомим крокодила на 5 линии
				
				$ddel = time() + 60*60*48;  //Время для очистки - 48 часов
				$dadd = time();		    //Время начала игры
//Создаем игру
$db->Query("INSERT INTO db_swamp_land (user, user_id, sum, status, line_1_".$kr1.", line_2_".$kr2.", line_3_".$kr3.", line_4_".$kr4.", line_5_".$kr5.", date_add, date_del) 
			VALUES ('$usname', '$usid', '$summa', '1', '1', '1', '1', '1', '1', '$dadd', '$ddel' )");
			
			echo "<div class='alert bg-success' role='alert'>Вы успешно начали игру. Загружаем крокодилов :)</div>";
			$db->Query("SELECT id FROM db_swamp_land WHERE user='$usname' AND status = 1");
			$secondgame = $db->FetchArray();
			
			//чистим историю
			$db->Query("DELETE FROM db_swamp_land WHERE date_del < '$dadd'");
			
			header( 'Refresh: 0; url=/account/swland/'.$secondgame["id"] );
			
			}else echo "<div class='alert bg-error' role='alert'>Недостаточно средств!</div>";
		
		}else echo "<div class='alert bg-error' role='alert'>Ошибка ставки!</div>";
		
		}else {
			$game = $db->FetchArray();
			echo "<div class='alert bg-success' role='alert'>У вас уже начата игра!</div>";
			header( 'Refresh: 0; url=/account/swland/'.$game["id"] );
		}
	}
?>

<center>Есть болото с 5 рядами кувшинок, в каждом ряду по 1 крокодилу. Провести лягушку как можно выше, двигаясь снизу вверх. Начиная с 4 ряда, начисляется выигрыш, согласно коэффициентам в таблице. Пройдя 5 рядов, игрок получает максимальный выигрыш!</center><BR />
<center><font color="Red"><b>Внимание!</b>
Начатая игра должна быть закончена в течение 48 часов. Если Вы не успели завершить игру, она будет завершена автоматически. Ставки не возвращаются на счет.</font></center>
<br /><br />

<form action="" method="post">
<table cellspacing="0" cellpadding="0" align="Center">
<tr>
	<td colspan="2" align="center">
	<b>Выберите ставку:</b>
	<select name="summa">
		<option value="100">100 Серебра</option>
		<option value="500">500 Серебра</option>
		<option value="1000">1000 Серебра</option>
		<option value="3000">3000 Серебра</option>
		<option value="6000">6000 Серебра</option>
	</select>
	<input type="submit" name="game" class="btng" value="Играть" />
	</td>
</tr>
</table>
</form>


<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><font color="brown" size="+1">Последниe 20 игр</font></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">Пользователь</td>
	<td align="center" class="m-tb">Ставка</td>
	<td align="center" class="m-tb">Результат</td>
	<td align="center" class="m-tb">Дата начала игры</td>
  </tr>
<?PHP $db->Query("SELECT * FROM db_swamp_land ORDER BY id DESC LIMIT 20");
	if($db->NumRows() > 0){
  		while($ref = $db->FetchArray()){ ?>
		<tr class="htt">
			<td align="center"><?=$ref["user"]; ?></td>
			<td align="center"><?=$ref["sum"]; ?></td>
			<td align="center">
			<? if($ref["status"] == 7) {?><font color="Red">Съеден</font>
			<? } elseif ($ref["status"] == 6) { ?><font color="green">Выиграл <?=$ref["vin"];?> Серебра</font>
			<? } else {?><font color="brown">Играет [<?=$ref["status"];?> линия]</font><?}?>
			</td>
			<td align="center"><?=date("d.m.Y H:i:s",$ref["date_add"]); ?></td>
  		</tr>
		<?PHP
		}
	}else echo '<tr><td align="center" colspan="5">Нет записей.</div></td></tr>'
 ?>
</table>


<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" align="center"><font color="brown" size="+1">Ваши последние 10 игр</font></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">Посмотреть</td>
	<td align="center" class="m-tb">Ставка</td>
	<td align="center" class="m-tb">Результат</td>
	<td align="center" class="m-tb">Дата начала игры</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM db_swamp_land WHERE user='$usname' ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
		?>
		<tr class="htt">
			<td align="center"><a href="/account/swland/<?=$ref["id"]; ?>">Посмотреть</a></td>
			<td align="center"><?=$ref["sum"]; ?></td>
			<td align="center">
			
			<? if($ref["status"] == 7) {?><font color="Red">Съеден</font>
			<? } elseif ($ref["status"] == 6) { ?><font color="green">Выиграл <?=$ref["vin"];?> Серебра</font>
			<? } else {?><font color="brown">Играет [<?=$ref["status"];?> линия]</font><?}?>
			
			</td>
			<td align="center"><?=date("d.m.Y H:i:s",$ref["date_add"]); ?></td>
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">Нет записей.</div></td></tr>'
  ?>
</table>

</div></div></div>
<div class="block3"></div>