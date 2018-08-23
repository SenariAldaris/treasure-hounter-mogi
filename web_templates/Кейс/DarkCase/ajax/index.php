<?
//error_reporting(0);

include_once($_SERVER["DOCUMENT_ROOT"].'/t/random.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/ajax/classCases.php') ;
include_once($_SERVER["DOCUMENT_ROOT"].'/ajax/configCases.php') ;
include_once($_SERVER["DOCUMENT_ROOT"].'/config.php');

$token = $_COOKIE['token']; 

$users_shop = mysql_query("SELECT * FROM `users_shop` WHERE `token`='$token'",$db);
$token_count_count = mysql_num_rows($users_shop);
$users_shop_arr = mysql_fetch_assoc($users_shop);
if($token_count_count !== 1)exit('{"status":false,"msg":"authError"}');// Проверка на авторизацию


if(trim($_POST["action"]) == "addbalance"){
	include_once($_SERVER["DOCUMENT_ROOT"].'/ajax/configSettings.php');

	echo '{"status":"success","url":"https://primearea.ru/buy/'.$caseS["primearea"][trim($_POST["system"])].'"}';exit;
}

if(trim($_POST["action"]) == "paymentcode"){
include_once($_SERVER["DOCUMENT_ROOT"].'/config.php');
$datakey =  trim($_POST["data"]);
$ttext = trim($KEYPASS);
$key = explode("-",$datakey);
if($key[2] == md5($ttext.$key[1].$key[0])){
	$money_shop = mysql_query("SELECT * FROM `money_shop` WHERE `inv`='$datakey'",$db);
	$money_shop_count = mysql_num_rows($money_shop);
	$token = $_COOKIE['token']; 
	$uid = $_COOKIE['uid'];
	if($money_shop_count == "0" AND trim($uid) !== ""){
		$cnt_goods = $key[0];
		$date_pay = date("d.m.Y h:i:s");
		$inv = $datakey;
		mysql_query("UPDATE `users_shop` set `money` = money + $cnt_goods where `uid` = '$uid'");
        mysql_query("INSERT INTO `money_shop` (`inv`, `uid`,`date_pay`,`cnt_goods`) VALUES('$inv','$uid','$date_pay','$cnt_goods')") or die(mysql_error());
        echo '{"status":"success","msg":"Успешно"}';exit;
	}else{ echo '{"status":"error","msg":"Ключ активирован"}';exit;}
}else{
echo '{"status":"error","msg":"Неверный ключ"}';exit;
}

}


if(trim($_POST["action"]) == "sellORwait"){
	if($_POST["type"] == "wait"){echo '{"status":"success","msg":"Успешно"}';exit;}
	
	$answer = $users_shop_arr["id"];
	$id = trim($_POST["order_id"]);
	$sadas = mysql_query("SELECT * FROM `questions` WHERE `id`='$id' OR `answer`='$answer'",$db);
	$sadass = mysql_num_rows($sadas);
	$sell = mysql_fetch_assoc($sadas); 
	$sells = $sell["price"];
	$endsells = $sells + $users_shop_arr["money"];
if($sadass == "1"){

	
		$questions = mysql_query("DELETE FROM `questions` WHERE `id`='$id' OR `answer`='$answer'",$db);
		if($questions == "1"){
			mysql_query("UPDATE `users_shop` set `money` = money + $sells where `id` = '$answer'");
			echo '{"status":"success","msg":"Успешно","balance":"'.$endsells.'"}';exit;
		}else{
	    	echo '{"status":"error","msg":"#1"}';exit;
		}

	
}else{
		echo '{"status":"error","msg":"Не ваш кейс"}';exit;
	
}
}


$trade_url = $_POST["data"];

if(trim($_POST["action"]) == "saveLink"){// Сейв ссылок на трейд
if(!isset($user['error'])){
function arrstrpos($context, $text) { 
    $arr = str_replace($text, $text[0], $context);
    if (strpos($arr, $text[0]) === false) {
        return false;
    } else {
        return true;
    }
}
$params = $_POST + $_COOKIE;
$param = "";
foreach ($params as $key => $value) {
    $param .= $value;
}
	if (arrstrpos($param, array("'", "\""))) {
  	  if(!file_exists(__DIR__ . "/hackers.txt")) fopen(__DIR__ . "/hackers.txt", "a+");
 	   if(!strpos(file_get_contents(__DIR__ . "/hackers.txt"), $_SERVER['REMOTE_ADDR'])) {
			$logs = file_get_contents(__DIR__ . "/hackers.txt");
			$log = $_SERVER['REMOTE_ADDR']." | ".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']." | ".dates(). "\n";
			$outlog = $log.$logs;
 	       file_put_contents(__DIR__ . "/hackers.txt",  $outlog );
 	   }
 	   
	   echo '{"status":"error","msg":"Hack detected!"}';exit;
	}else{
		$st = mysql_query("UPDATE `users_shop` set `trade_url` = '$trade_url' where `token` = '$token'");
		if($st == "1"){
			echo '{"status":"success","msg":"Успешно"}';exit;
		}else{
			echo '{"status":"error","msg":"Не успешно"}';exit;
		}
	}
}   
}


if(trim($_POST["action"]) == "openCase"){// Открытие кейса
$uprice = $_POST["upchancePrice"];

if(isset($case[$_POST["case"]]["price"])){
	$price = $case[$_POST["case"]]["price"];
	if($uprice < 0){echo '{"status":"error","msg":"Не успешно"}';exit;}
	$money = $uprice + $price; 
	$endmoney = $users_shop_arr["money"] - $money;
	if($users_shop_arr["money"] < $money)exit('{"status":"error","msg":"balanceError","balance":"' .$users_shop_arr["money"]. '"}');
	if($case[$_POST["case"]]["open"] == false)exit($case[$_POST["case"]]["open"]);
	$st = mysql_query("UPDATE `users_shop` set `money` = '$endmoney' where `token` = '$token'");
		if($st !== "1"){


$case = $arr[$_POST["case"]];//$case = $case[steamRandom($uprice,$case,$arr)];
$caseID  = "0";
if($admincase == $users_shop_arr["id"])$caseID  = "45w3453";
$case = $case[steamRandom($caseID,$_POST["case"],$caseR)];

$b=1;

while ($b)if(trim($case[3]) !== ""){$b=0;}else{$case = $case[steamRandom($caseID,$_POST["case"],$caseR)];}
$type = $case[2];
$firstName = $case[0];
$secondName = $case[1];
if($type !=="rare"){
	$secondName = explode("|",$case[1]);
	$secondName = $secondName[1];
}
$fullName = $firstName." | ".$case[1];

$image = $case[3];
$stattrack = false;
if(rand(1,10) == 1){
	$stattrack = true; //Cтартрек
	$stattracklog = "StatTrak™";
}
$question_categories = mysql_query("SELECT * FROM `question_categories` WHERE `title`='$type'",$db);
$question_categories = mysql_fetch_assoc($question_categories);

$category = $question_categories["id"];
$answerer =$users_shop_arr["id"];
$title = '['.$_POST["case"].'] '.$fullName . $stattracklog;
$text ="";
$answer ="";
$created = date("d.m.Y H:i:s");
$changed ="1";
$answered ="1"; 
$author = $users_shop_arr["id"];
$shown ="0";

if($users_shop_arr["network"] == "steam"){
					 $request = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=47F82A866F31B5F7E07BC86FE4A3C265&steamids=' . $users_shop_arr['uid'];
				 $response = file_get_contents($request);
				 $info = json_decode($response,true);
				 $img = $info["response"]["players"]["0"]["avatar"];
				  $v_nickname = $info["response"]["players"]["0"]["personaname"];
	
}else{
	
	$v_nickname = $users_shop_arr["first_name"]  . " ".  $users_shop_arr["last_name"];
}
$arrs=json_decode(file_get_contents("cron_info.php"),true);

$new_tmp = array("id" => $arrs[0]["id"]+1,"fake_nickname" =>"$v_nickname","fake" =>"0","image" =>"$image","type" =>"$type","firstName" =>"$firstName","v_nickname" =>"$v_nickname","from_social" =>"vk");

$arrsse[] = $new_tmp;
for($i=0;$i<9;$i++)$arrsse[] = $arrs[$i];
file_put_contents("cron_info.php", "");
$file_hendle = fopen("cron_info.php", "w"); 
fputs($file_hendle,json_encode($arrsse));
fclose($file_hendle); 



$st1 = mysql_query("INSERT INTO `questions`(`price`,`category`, `answerer`, `title`, `text`, `answer`, `created`, `changed`, `answered`, `author`, `shown`) VALUES ('$pricesell','$category','$answerer','$title','$text','$answer','$created','$changed','$answered','$author','$shown')")or die(mysql_error());



$kundeid=mysql_insert_id(); 


$echoCase = '{"status":"success",
"weapon":{ 
"fullName":"'.$fullName.'",
"firstName":"'.$firstName.'",
"secondName":"'.$secondName.'", 
"type":"'.$type.'",
"image":"'.$image.'", 	
"price": '.$pricesell.',
"stattrack":"'.$stattrack.'",
"id":'.$kundeid.'
},
"balance":' . $endmoney . '
}';

exit($echoCase);
		}
}else{
exit("ERR #11");
}
}

function getRealIpAddr()
{
if (!empty($_SERVER['HTTP_CLIENT_IP'])){$ip=$_SERVER['HTTP_CLIENT_IP'];
}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}else{ $ip=$_SERVER['REMOTE_ADDR'];}
return $ip;
}
exit("ERR #0");
?>
