<div class="block1
"><div class="h-title1
">Шашлычная</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<BR />
<?PHP
$_OPTIMIZATION["title"] = "Шашлычная";
$usid = $_SESSION["user_id"];

$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();

?>
<?PHP
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

//if($user_data["last_sbor"] == 0 OR $user_data["last_sbor"] > ( time() - 60*20) )
	//{
		echo $build->Build($usid,$_POST["item"]);

 
	
	//}
	//else echo "<center><font color = 'red'><b>Перед тем как купить стройку следует собрать ресурсы на складе!</b></font></center><BR />";

}

?>


<?php if($user_data["t_t"] == 0) { ?>

<center>
Для строительства шашлычной требуется запастись необходимым колличеством строительных материалов, которые можно купить в лавке. По достижению нужного уровня вы сможете готовить шашлык и поставлять его под реализацию в главную столовую.</center>

<BR ><BR >
<?php echo $build->GetBuildingTable(0, "t_t"); ?>	
</br>
</br>
<?php echo $build->GetBuildProcess($usid, "t_t"); ?>

<?php } else { ?>
<center>
Это ваша шашлычная. Теперь вы можете самостоятельно приготовить шашлык из баранины. Его можно поставлять на реализацию в главную столовую. Погрузите необходимое колличество мяса в печку и шашлык будет готов спустя 24 часа. За каждую загрузку продукции снимается 2 ед. энергии, 2 единицы настроения и начисляется 2 ед. опыта. За каждый сбор снимается 1 ед. энергии и настроения, начисляется 3 ед. опыта.</center>

		
<?php
# загружаем ингридиенты в 6 бар
if(isset($_POST["load6"])){
$array_items2 = array(1 => "u_b"); 
$array_name2 = array(1 => "Баранина");
$item = intval($_POST["load6"]);
$citem = $array_items2[$item];
if(strlen($citem) >= 3){
$need = $user_data[$citem];

if($need >= 100){	

$need_en = 2;
if($need_en <= $user_data["en"]){

$need_ns = 2; 
if($need_ns <= $user_data["ns"]){
	

$db->Query("UPDATE db_users_b SET  en = en - 2, ns = ns - 2, $citem = $citem - 100, last_bar6 = IF(last_bar6 > 0, last_bar6, '".time()."') WHERE id = '$usid'");
 $db->Query("UPDATE db_users_b SET pbar6 = pbar6 + 1 WHERE id = '$usid'"); 
$db->Query("UPDATE db_users_a SET balls = balls + 2 WHERE id = '$usid'");
# Вносим запись о посадке в историю
$db->Query("INSERT INTO db_stats_pbar (user_id, user, bar, date_add, date_del) VALUES ('$usid','$usname','Шашлык','".time()."','".(time()+60*60*24*15)."')");
$da = time();
$dd = $da + 60*60*24;
# загружаем
$db->Query("INSERT INTO db_bar (user, user_id, area, $citem, date_add, date_del) VALUES ('$usname', '$usid', '6', '1', '$da','$dd')");
echo "<center><font color = 'green'><b>Производство продукции успешно запущено.</b></font></center><BR />";
header( 'Refresh: 3; url=/account/shashlichnaya' );
}else echo "<center><font color = 'red'><b>Недостаточно настроения для загрузки продукции.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>Недостаточно энергии для загрузки продукции.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>Недостаточно ингридиентов для производства продукции. Купите их в лавке.</b></font></center><BR />";
}
}
?>

<?PHP
# Сбор бар 6
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_bar WHERE area = 6 AND user_id = '$usid' LIMIT 1");
$derevo = $db->FetchArray();
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
if(isset($_POST["sbor6"])){
if($user_data["last_bar6"] < (time() - 60*60*24) ){

$need_en = 1;
if($need_en <= $user_data["en"]){

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){

$db->Query("UPDATE db_users_b SET  en = en - 1, ns = ns - 1, coctel_b = coctel_b + 100,  last_bar6 = '".time()."' WHERE id = '$usid' LIMIT 1");
$db->Query("UPDATE db_users_a SET balls = balls + 3 WHERE id = '$usid'");
$db->Query("UPDATE db_bar SET sbor = sbor - 1 WHERE area = 6 AND user_id = '$usid' LIMIT 1");
	echo "<center><font color = 'green'><b>Вы успешно собрали продукцию.</b></font></center><BR />";
	header( 'Refresh: 3; url=/account/shashlichnaya' );
}else echo "<center><font color = 'red'><b>Недостаточно настроения для сбора продукции.</b></font></center><BR />";
			}else echo "<center><font color = 'red'><b>Недостаточно энергии.</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>Продукция не готова.</b></font></center><BR />";
	}
?>




<div class="fr-block">
<form action="" method="post">
<div class="cl-fr-lf">
<img src="/img/fruit/10.png" />
</div>
<div class="cl-fr-rg" style="padding-left:10px;">

<div class="fr-te-gr-title"><b>Шашлычная</b></div> 


<?PHP if ($user_data["pbar6"] < 1) { ?>
<? $db->Query("SELECT * FROM db_bar WHERE area = 6 AND user_id = '$usid' LIMIT 1");
 if($db->NumRows() == 0){  ?>

Для  100 шашлыков:<br />
Нужно - 100 кг. баранины<br />


<form action="" method="post">
<input type="hidden" name="load6" value="1">
<input type="submit" class="btn_8" value="Приготовить" /></form><br />

<?PHP } } else {?>  
<?php 
$db->Query("SELECT * FROM db_bar WHERE area = 6 AND user_id = '$usid' LIMIT 1");
$fact = $db->FetchArray();
?>
<?PHP		
if ($fact["u_b"]==1) { ?>
<form action="" method="post">
Приготовление... <br />
<center><img src="/img/fruit/shashlik.png" width="90" height="80" /><br />Шашлык: 100шт.<br /></center> 
<?PHP		
if ($fact["active"] < 0) { ?>  <center><input type="submit" class="btn_8" name="sbor6" value="Собрать" /></center>
<?PHP	}	else { ?> <font color="red"><b><center>Не готов</center></b></font>
<?PHP	} ?> </form>
<?PHP	} ?>
<?php 
$db->Query("SELECT * FROM db_bar WHERE area = 6 AND user_id = '$usid' LIMIT 1");
if($db->NumRows() == 0){  $db->Query("UPDATE db_users_b SET pbar6 = pbar6 - 1 WHERE id = '$usid'");  }
?>
<?PHP } ?> 
</div></form></div>


		



<?php } ?>

<div class="clr"></div>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>		