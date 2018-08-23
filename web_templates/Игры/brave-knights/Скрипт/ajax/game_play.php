<?php
session_start();
define('playCom', 0.1);
$usid = $_SESSION["user_id"];
$uname = $_SESSION["user"];
# Константа для Include
define("CONST_RUFUS", true);

# Автоподгрузка классов
function __autoload($name){ include($_SERVER['DOCUMENT_ROOT']."/classes/_class.".$name.".php");}

# Класс конфига 
$config = new config;
$pref = $config->BasePrefix;
# Функции
$func = new func;

# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

$db->Query('SELECT `money_b` FROM `'.$pref.'_users_b` WHERE id = '.$usid);
$u_balance = $db->FetchRow();
$db->Query("SELECT * FROM `".$pref."_games_knb` WHERE `id` = ".intval($_POST["id"]));

if($db->NumRows() == 0){
	echo "<script type='text/javascript'>
$('.play-".intval($_POST["id"])."').html('Игра не найдена');
</script>";
return;
}

$row = $db->FetchArray();

$err = NULL;
if($u_balance < round($row["summa"],2))
	$err .= "На Вашем балансе недостаточно средств. ";
if($_POST["item"] > 3 OR $_POST["item"] <1)
	$err .= "Выберите предмет. ";
	
if($err != NULL){
	echo "<script type='text/javascript'>
$('.play-".intval($_POST["id"])."').html('".$err."');
</script>";
	return;
}
$id_knb = intval($_POST['id']);

if($row["item"] == intval($_POST["item"])){
			$db->Query("UPDATE `".$pref."_users_b` SET `money_b` = `money_b` + ".$row["summa"]." WHERE `user`  = '".$row["login"]."'");			
			$db->Query("DELETE FROM `".$pref."_games_knb` WHERE `id` = ".intval($_POST["id"]));
			$db->Query("UPDATE `".$pref."_stats_knb` SET `status` = 3 WHERE `id` = '$id_knb'");
			
			echo "<script type='text/javascript'>$('.play-".intval($_POST["id"])."').html('Ничья');</script>";
			
		}elseif(($row["item"] == 1 AND $_POST["item"] == 2) OR ($row["item"] == 2 AND $_POST["item"] == 3) OR ($row["item"] == 3 AND $_POST["item"] == 1)){
			$db->Query("UPDATE `".$pref."_users_b` SET `money_b` = `money_b` - ".$row["summa"]." WHERE `user`  = '".$uname."'");
			$db->Query("UPDATE `".$pref."_users_b` SET `money_b` = `money_b` + ".round(($row["summa"] + $row["summa"]*(1-playCom)) ,2)." WHERE `user`  = '".$row["login"]."'");	
$db->Query("UPDATE `".$pref."_stats_knb` SET `status` = 1 WHERE `id` = '$id_knb'");			
			
			$db->Query("DELETE FROM `".$pref."_games_knb` WHERE `id` = ".intval($_POST["id"]));
			echo "<script type='text/javascript'>$('.play-".intval($_POST["id"])."').html('<font color=\"#f00\">Поражение</font>');
</script>";
		}else{
						
			$db->Query("UPDATE `".$pref."_users_b` SET `money_b` = `money_b` + ".round($row["summa"]*(1-playCom),2)." WHERE `user`  = '".$uname."'");						
			$db->Query("DELETE FROM `".$pref."_games_knb` WHERE `id` = ".intval($_POST["id"]));
			$db->Query("UPDATE `".$pref."_stats_knb` SET `status` = 2 WHERE `id` = '$id_knb'");
			echo "<script type='text/javascript'>$('.play-".intval($_POST["id"])."').html('<font color=\"#0F680B\">Победа</font>');</script>";
		}
?>