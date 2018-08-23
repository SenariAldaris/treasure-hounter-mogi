<div class="block1
"><div class="h-title1
">Камикадзе</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<div style="margin-top: -15px;" class="bgmainb2">

<p>В игре 13 ступеней, чем выше поднялся Камикадзе, тем больше коэффициент выигрыша. 
На каждой ступени на голову нашего героя падает 4 груды камней, а чем выше, тем ступени уже. 
Остановиться можно в любой момент, нажав на кнопку внизу и, тем самым, завершив игру победой!<br>
<br>
Если в процессе игры Вы потеряли соединенние с интернетом, Ваша ставка будет возвращена на баланс.
<br><br>

<?

# Заглушка от халявщиков
$db->Query("SELECT (k_t + l_t + m_t + n_t + o_t + p_t + q_t + r_t + s_t + t_t) all_trees FROM  db_users_b WHERE id = {$_SESSION["user_id"]}");
$data = $db->FetchArray();
if($data['all_trees'] == 0){?>
	<div style="color: red;text-align: center;font-size: 12pt;margin-top: 10px;display: block;font-weight: bold;">Играть могут только пользователи, у которых есть хотябы одна постройка!</div></div>
<?}else{?>


<?
	if(!isset($_SESSION['game_schet'])) $_SESSION['game_schet'] = 'in';
	
	if(!empty($_POST)){
		if(isset($_POST['game_schet'])){
			if($_POST['game_schet'] == 'in' || $_POST['game_schet'] == 'out'){
				$_SESSION['game_schet'] = $_POST['game_schet'];
			}else{
				$_SESSION['game_schet'] = 'in';
			}	
		}
	}
?>
<center><div style="border: 2px dotted #0e82a7;padding: 5px 10px 2px 10px;border-radius: 5px 5px 5px 5px;height: 32px;">
<center>
	<form method="POST">
		
		<select name="game_schet" style="font-weight: bold;  height: 28px;  font-size: 15px;" onChange="this.form.submit()">
			<option value="in" <?if($_SESSION['game_schet']=='in')echo 'selected';?>>Играть на счет для оплаты</option>
			<option value="out" <?if($_SESSION['game_schet']=='out')echo 'selected';?>>Играть на счет для вывода</option>
		</select>
	</form>
	</center>
</div>
</center>
<br>

<script type="text/javascript" src="/thimble/swfobject.js"></script>
<center><div id="flash" style="background: #FFF;border: 2px dotted #0e82a7;padding: 3px 0px 0px 0px;border-radius: 5px 5px 5px 5px;"><embed type="application/x-shockwave-flash" src="/kamikadze2/kamikadze.swf" width="601" height="550" style="" id="flash" name="flash" quality="high"></div></center>

<script type="text/javascript">
var so = new SWFObject('/kamikadze2/kamikadze.swf', 'flash', '542', '492', 9);
so.write("flash");
</script>
<center>
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width="99%">
  <tr>
    <td colspan="5" style="padding: 8px;" align="center"><h4>Список последних 20 победителей</h4></td>
    </tr>
  <tr>
    <td align="center" class="m-tb">Дата</td>
    <td align="center" class="m-tb">Пользователь</td>
    <td align="center" class="m-tb">Ставка</td>
    <td align="center" class="m-tb">Сумма выигрыша</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM db_games_kamikadze ORDER BY id DESC LIMIT 20");
  
	if($db->NumRows() > 0){
  
  		while($ref = $db->FetchArray()){
		
		?>
		<tr class="htt">
    		<td class="xe-tb" align="center"><?=date("d.m.Y в H:i:s",$ref["date"]); ?></td>
    		<td class="xe-tb" align="center"><?=$ref["user_name"]; ?></td>
    		<td class="xe-tb" align="center"><?=$ref["stavka"]; ?></td>
    		<td class="xe-tb" align="center"><?=$ref["sum"]; ?></td>
  		</tr>
		<?PHP
		
		}
  
	}else echo '<tr><td align="center" colspan="5">Нет записей</td></tr>'
  
  ?>

  
</table>
</center>

</div>
<div class="clr"></div>	

<?}?>	

</div></div></div>
	

<div class="clr"></div>	<div class="block3"></div>