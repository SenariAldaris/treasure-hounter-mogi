<?
if(trim($_COOKIE["token"]) !== ""){
$token = $_COOKIE["token"];

include_once($_SERVER["DOCUMENT_ROOT"].'/config.php');
$users_shop = mysql_query("SELECT * FROM `users_shop` WHERE `token`='$token'",$db);
$users_shop_arr = mysql_fetch_assoc($users_shop);
if($users_shop_arr['id'] !== "$ADMIN_ID"){
	include_once($_SERVER["DOCUMENT_ROOT"].'/ajax/errHTML.php');exit;
}
}else{
	   header('Location: http://'.$_SERVER["HTTP_HOST"]);

}
$urlFile = trim($_SERVER{QUERY_STRING});

if($urlFile !== "" )
{  $uuu = $_SERVER["DOCUMENT_ROOT"]."/".$urlFile.".php";
	include_once($uuu);
}else{
	 $uuu = $_SERVER["DOCUMENT_ROOT"]."/user.php";
	include_once($uuu);
}
?> 