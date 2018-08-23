


<div class="block1
"><div class="h-title1
">Строительство</div></div>


<div class="block2">

<div class="some-content-related-div">
<div id="inner-content-div">



<center>Это макеты строительства. Чтобы построить любое здание, необходимо закупить нужное колличество строительных материалов. Время стройки зависит от вида и сложности работ. За каждую постройку снимается 3 ед. энергии и начисляется 3 ед. опыта.</center>
 <BR > <BR />     
<?PHP
$_OPTIMIZATION["title"] = "Аккаунт - Строительство";
$usid = $_SESSION["user_id"];
$refid = $_SESSION["referer_id"];
$usname = $_SESSION["user"];
$name_tree = $build->GetNames($_POST["item"]);
    $price = $build->GetPriceAndResource($_POST["item"]);
    $price = $price['price'];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();


# Покупка нового дерева
if(isset($_POST["item"])){
$need_en = 5;
if($need_en <= $user_data["en"]){
//if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) )
	//{
		echo $build->Build($usid,$_POST["item"]);
$db->Query("UPDATE db_users_b SET  en = en - 3  WHERE id = '$usid'");
					$db->Query("UPDATE db_users_a SET balls = balls + 3 WHERE id = '$usid'");		
 $db->Query("INSERT INTO ".$pref."_stats_btree (user_id, user, tree_name, amount, date_add, date_del) 
    VALUES ('$usid','$usname','$name_tree','$price','".time()."','".(time()+60*60*24*15)."')");
	
	//}
	//else echo "<center><font color = 'red'><b>Перед тем как купить стройку следует собрать ресурсы на складе!</b></font></center><BR />";
}else echo "<div class='error message'>Недостаточно энергии.</div>";
}

	
	





?>
<?php echo $build->GetBuildingTable(1, "k_t"); ?>
<?php echo $build->GetBuildingTable(1, "l_t"); ?>
<BR >


<?php echo $build->GetBuildingTable(); ?>


<BR >
<h4> В процессе строительства:</h4>

<?php echo $build->GetBuildProcess($usid); ?>

<div class="clr"></div>
</div>

</div>

</div>
<div class="block3"></div>
<div class="clr"></div>	






