
<div class="block1
"><div class="h-title1
">Орел-решка</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<div style="margin-top: -5px;" class="bgmainb2">
Орел-решка очень популярная и простая в понимании игра. Если выпадет сторона монеты, которую вы выбрали - вы умножите свою ставку на два!.
<br>
<br>

<?



# Заглушка от халявщиков
$db->Query("SELECT (k_t + l_t + m_t + n_t + o_t + p_t + q_t + r_t + s_t + t_t + i_t) all_trees FROM db_users_b WHERE id = {$_SESSION["user_id"]}");
$data = $db->FetchArray();


if($data['all_trees'] == 0){?>
	<div style="color: red;text-align: center;font-size: 12pt;margin-top: 10px;display: block;font-weight: bold;">Играть могут только пользователи, у которых есть хотябы одна постройка!</div>



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
<center><div id="flash" style="background: #FFF;border: 2px dotted #0e82a7;padding: 3px 0px 3px 0px;border-radius: 5px 5px 5px 5px;"><embed type="application/x-shockwave-flash" src="/coinflip/coinflip.swf" width="542" height="445" style="" id="flash" name="flash" quality="high"></div></center>

<script type="text/javascript">
var so = new SWFObject('/coinflip/coinflip.swf', 'flash', '542', '445', 9);
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
    <td align="center" class="m-tb">Выигрыш</td>
  </tr>
  <?PHP
  
  $db->Query("SELECT * FROM db_games_coinflip ORDER BY id DESC LIMIT 20");
  
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
<?}?>
</div></div></div></div>
<div class="block3"></div>
<div class="clr"></div>	
