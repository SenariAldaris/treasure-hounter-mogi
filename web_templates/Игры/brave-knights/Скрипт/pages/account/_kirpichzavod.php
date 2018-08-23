<div class="block1
"><div class="h-title1
">Кирпичный завод</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<BR />
<?PHP
$_OPTIMIZATION["title"] = "Кирпичный завод";
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


<?php if($user_data["m_t"] == 0) { ?>

<center>
Для строительства кирпичного завода требуется запастись необходимым колличеством строительных материалов, которые можно купить в лавке. По достижению нужного уровня вы сможете сами изготавливать кирпичи, строить производства, или продавать стройматериалы в лавке с наценкой. </center>
<BR ><BR >

<?php echo $build->GetBuildingTable(0, "m_t"); ?>		
</br>
</br>
<?php echo $build->GetBuildProcess($usid, "m_t"); ?>
		

<?php } else { ?>
<center>
Это ваш кирпичный завод. Теперь вы можете самостоятельно изготавливать кирпичи для строительства домов или продажи в лавке. Загрузите в печь необходимое колличество глины и собирите готовые кирпичи спустя 24 часа. За каждую загрузку продукции снимается 2 ед. энергии, 2 единицы настроения и начисляется 2 ед. опыта. За каждый сбор снимается 1 ед. энергии и настроения, начисляется 3 ед. опыта.</center>

<?php
# загружаем ингридиенты во 2 бар
if(isset($_POST["load2"])){
$array_items2 = array(1 => "a_b");
$array_name2 = array(1 => "Глина");
$item = intval($_POST["load2"]);
$citem = $array_items2[$item];
if(strlen($citem) >= 3){
$need = $user_data[$citem];

if($need >= 200){

$need_en = 2; 
if($need_en <= $user_data["en"]){		

$need_ns = 2; 
if($need_ns <= $user_data["ns"]){

$db->Query("UPDATE db_users_b SET  en = en - 2, ns = ns - 2, $citem = $citem - 200, last_bar2 = IF(last_bar2 > 0, last_bar2, '".time()."') WHERE id = '$usid'");
 $db->Query("UPDATE db_users_b SET pbar2 = pbar2 + 1 WHERE id = '$usid'"); 
$db->Query("UPDATE db_users_a SET balls = balls + 2 WHERE id = '$usid'");
# Вносим запись о посадке в историю
$db->Query("INSERT INTO db_stats_pbar (user_id, user, bar, date_add, date_del) VALUES ('$usid','$usname','Кирпичи','".time()."','".(time()+60*60*24*30*6)."')");
$da = time();
$dd = $da + 60*60*24;
# загружаем
$db->Query("INSERT INTO db_bar (user, user_id, area, $citem, date_add, date_del) VALUES ('$usname', '$usid', '2', '1', '$da','$dd')");
echo "<center><font color = 'green'><b>Производство продукции успешно запущено.</b></font></center><BR />";
header( 'Refresh: 3; url=/account/kirpichzavod' );
}else echo "<center><font color = 'red'><b>Недостаточно настроения для загрузки продукции.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>Недостаточно энергии для загрузки продукции.</b></font></center><BR />";
}else echo "<center><font color = 'red'><b>Недостаточно ингридиентов для производства продукции. Купите их в лавке.</b></font></center><BR />";

}
}
?>		

<?PHP
# Сбор бар 2
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_bar WHERE area = 2 AND user_id = '$usid' LIMIT 1");
$derevo = $db->FetchArray();
$db->Query("SELECT * FROM db_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
$db->Query("SELECT * FROM db_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
if(isset($_POST["sbor2"])){
if($user_data["last_bar2"] < (time() - 60*60*24) ){

$need_en = 1;
if($need_en <= $user_data["en"]){

$need_ns = 1; 
if($need_ns <= $user_data["ns"]){

$db->Query("UPDATE db_users_b SET  en = en - 1, ns = ns - 1, f_b = f_b + 200,  last_bar2 = '".time()."' WHERE id = '$usid' LIMIT 1");
$db->Query("UPDATE db_users_a SET balls = balls + 3 WHERE id = '$usid'");
$db->Query("UPDATE db_bar SET sbor = sbor - 1 WHERE area = 2 AND user_id = '$usid' LIMIT 1");
	echo "<center><font color = 'green'><b>Вы успешно собрали продукцию.</b></font></center><BR />";
	header( 'Refresh: 3; url=/account/kirpichzavod' );
}else echo "<center><font color = 'red'><b>Недостаточно настроения для сбора продукции.</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>Недостаточно энергии.</b></font></center><BR />";
		}else echo "<center><font color = 'red'><b>Продукция не готова.</b></font></center><BR />";
	}
?>

<div class="fr-block">
<form action="" method="post">
<div class="cl-fr-lf">
<img src="/img/fruit/3.png" />
</div>
<div class="cl-fr-rg" style="padding-left:0px;">


<div class="fr-te-gr-title"><b>Кирпичный завод</b></div> 


<?PHP if ($user_data["pbar2"] < 1) { ?>
<? $db->Query("SELECT * FROM db_bar WHERE area = 2 AND user_id = '$usid' LIMIT 1");
 if($db->NumRows() == 0){  ?>
Для изготовления 200 кирпичей:<br />
Нужно - 200 кг. глины<br />


<form action="" method="post">
<input type="hidden" name="load2" value="1">
<input type="submit" class="btn_8" value="Изготовить" /></form><br />


<?PHP } } else {?>  
<?php 
$db->Query("SELECT * FROM db_bar WHERE area = 2 AND user_id = '$usid' LIMIT 1");
$fact = $db->FetchArray();
?>
<?PHP		
if ($fact["a_b"]==1) { ?>
<form action="" method="post">
Изготовление...<br />
<center><img src="/img/fruit/kirpichi.png" width="90" height="80" /><br /> Кирпичи: 200шт.<br /> </center>
<?PHP		
if ($fact["active"] < 0) { ?> <center><input type="submit" class="btn_8" name="sbor2" value="Собрать" /></center>
<?PHP	}	else { ?> <font color="red"><b><center>Не готовы</center></b></font>
<?PHP	} ?> </form>
<?PHP	} ?>
<?php 
$db->Query("SELECT * FROM db_bar WHERE area = 2 AND user_id = '$usid' LIMIT 1");
if($db->NumRows() == 0){  $db->Query("UPDATE db_users_b SET pbar2 = pbar2 - 1 WHERE id = '$usid'");  }
?>
<?PHP } ?>
</div></form></div>


<?php } ?>

<div class="clr"></div>
</div></div></div>
<div class="block3"></div>
<div class="clr"></div>	