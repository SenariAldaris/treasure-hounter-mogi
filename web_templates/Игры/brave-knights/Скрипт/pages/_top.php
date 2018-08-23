<?PHP
$_OPTIMIZATION["title"] = "ТОП 100";
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>
<?PHP



$db->Query("SELECT * FROM db_users_a ORDER BY balls DESC LIMIT 100");

if($db->NumRows() > 0){

?>

<div class="block1
"><div class="h-title1
">TOP 100 по уровням</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
<table cellpadding='3' cellspacing='0' border='0' bordercolor='#336633' align='center' width='98%'>
 <tr height='25' valign=top align=center>
    <td class="m-tb">Место</td>
    <td class="m-tb">Пользователь</td>
	<td class="m-tb">Уровень</td>
  <td class="m-tb">Опыта</td>
  </tr>
  
<?PHP
$i = 0;
	while($data = $db->FetchArray()){
	$i=$i+1;


	?>
	<tr class="htt">
    <td align="center"><?=$i; ?></td>
    <td align="center"><?=$data["user"]; ?></td>
	<td align="center"><?php echo user_level::getInstance()->get_user_level($data['id']);?></td>
	<td align="center"><?=$data["balls"]; ?></td>
		
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP

}
?>

</div></div></div>
<div class="block3"></div>
<div class="clr"></div>	