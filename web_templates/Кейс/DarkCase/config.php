<?
// Данный скрипт писал нубокодер по жизни и у меня были сроки сделать за 3 дня!
//бд настройки крч )
$server         	= "mysql.hostinger.com.ua";       //host         
$db_user        	= "u484573066_1";       //user                             
$user_pass        	= "123123";       //password
$database       	= "u484573066_1"; 		//dbname


$ADMIN_ID =1; //id админа
$KEYPASS = "betterchange";
include ($_SERVER["DOCUMENT_ROOT"].'/ajax/configSettings.php');
// ID товара - уникальный товар с нефиксированной ценой в сервисе Digiseller.ru
// название товара: Пополнение баланса
// единица товара: 1
// название единицы: руб
// цена: 1 руб
// ограничения: по минимальному и (или) максимальному количеству единиц: мин 5 макс 50000
// проверка уникального кода: http://site.ru
// описание товара: Пополнение баланса в магазине

/*
milspec синие
restricted фиолетовое
classified розовое
covert красное
rare ножи
*/
 
//Цена продажи товра от и до //(Не изменять тут ничего) ID товара задать тут http://gamesbuys.ru/admin.php?settings
$priceTMP = explode("-",trim(str_replace("","",$caseS{pricesell})));
if($priceTMP[0] == ""){$priceTMP[0] = "0";$priceTMP[1] = "1";}
$pricesell = rand($priceTMP[0],$priceTMP[1]);


include ($_SERVER["DOCUMENT_ROOT"].'/ajax/configCases.php');

$db = mysql_connect($server, $db_user, $user_pass);
	mysql_select_db($database, $db) or die("<center>Ошибка mysql.</center>");
	mysql_query("set character_set_results=utf8;",$db);
	mysql_query("set character_set_connection=utf8;",$db);
	mysql_query("set character_set_client=utf8;",$db);
	mysql_query("set character_set_database=utf8;",$db);

	/*
	$case["eSports 2014 Summer"] = array("open" => true,"Price" => "1000"); 
$case["eSports 2013 Winter"] = array("open" => true,"Price" => "200");
$case["Chroma 2 Case"] = array("open" => true,"Price" => "100");
$case["Knife Case"] = array("open" => true,"Price" => "100");
$case["eSports 2013"] = array("open" => true,"Price" => "100"); 
$case["CS:GO Weapon #3"] = array("open" => true,"Price" => "100"); 
$case["CS:GO Weapon"] = array("open" => true,"Price" => "100"); 
$case["Operation Bravo"] = array("open" => true,"Price" => "100"); 
$case["Chroma Case1"] = array("open" => true,"Price" => "100"); 
$case["Operation Breakout"] = array("open" => true,"Price" => "100"); 
$case["Huntsman Weapon"] = array("open" => true,"Price" => "100"); 
$case["Operation Phoenix"] = array("open" => true,"Price" => "100"); 
$case["Operation Vanguard"] = array("open" => true,"Price" => "100"); 
$case["Winter Offensive"] = array("open" => true,"Price" => "100"); 
$case["CS:GO Weapon #2"] = array("open" => true,"Price" => "100"); 
$case["CS:GO Weapon 2"] = array("open" => true,"Price" => "100"); 
	*/
	?>