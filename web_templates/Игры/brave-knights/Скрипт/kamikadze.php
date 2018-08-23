<?
//error_reporting(E_ALL);
//ini_set('display_errors',1);
//ini_set('error_reporting',999);

# Старт сессии
@session_start();

# Константа для Include
define("CONST_RUFUS", true);

# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}
# Класс конфига 
$config = new config;
# Подключение к базе данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
# Подключение просента отдачи от 0 до 100 Чем больше цифра тем меньше получат выигрыш пользователи
# Рекомендую использовать 10

$ba = array();
# Ставка 100
$ba[1][0] = 100;
$ba[1][1] = 120;
$ba[1][2] = 150;
$ba[1][3] = 190;
$ba[1][4] = 250;
$ba[1][5] = 330;
$ba[1][6] = 440;
$ba[1][7] = 600;
$ba[1][8] = 800;
$ba[1][9] = 1200;
$ba[1][10] = 1600;
$ba[1][11] = 2500;
$ba[1][12] = 4500;
$ba[1][13] = 7500;
# Ставка 500
$ba[2][0] = 500;
$ba[2][1] = 600;
$ba[2][2] = 750;
$ba[2][3] = 950;
$ba[2][4] = 1250;
$ba[2][5] = 1650;
$ba[2][6] = 2200;
$ba[2][7] = 3000;
$ba[2][8] = 4000;
$ba[2][9] = 6000;
$ba[2][10] = 8000;
$ba[2][11] = 12500;
$ba[2][12] = 22500;
$ba[2][13] = 37500;
# Ставка 10000
$ba[3][0] = 1000;
$ba[3][1] = 1200;
$ba[3][2] = 1500;
$ba[3][3] = 1900;
$ba[3][4] = 2500;
$ba[3][5] = 3300;
$ba[3][6] = 4400;
$ba[3][7] = 6000;
$ba[3][8] = 8000;
$ba[3][9] = 12000;
$ba[3][10] = 16000;
$ba[3][11] = 25000;
$ba[3][12] = 45000;
$ba[3][13] = 75000;
if(!empty($_GET)){	
	if(isset($_GET['bet'])) $bet = intval($_GET['bet']); else $bet = 0;
	if($bet >= 1 && $bet <= 3 && money() >= $ba[$bet][0]){
	$uistep=$_SESSION['kamikadze']['step']+1;
	$uimax=$ba[$bet][$uistep];
}
}
$db->Query("SELECT kamikadze FROM db_stats WHERE id = '2'");
	$datakam = $db->FetchArray();
	
$ui = $datakam["kamikadze"];

if($ui <= $uimax){
function game(){

$rs = 1;
	if($rs != 1) return true; else return false;
}
} else {
function game(){

$rs = rand(1,4);
	if($rs != 1) return true; else return false;
}
}
$db->Query("SELECT (k_t + l_t + m_t + n_t + o_t + p_t + q_t + r_t + s_t + t_t) all_trees FROM db_users_b WHERE id = {$_SESSION["user_id"]}");
$data = $db->FetchArray();
if($data['all_trees'] == 0) $halava = true; else $halava = false; 


if($_SESSION['game_schet'] != 'in' && $_SESSION['game_schet'] != 'out') $_SESSION['game_schet'] = 'in';

function money(){
	global $db;
	$user_id = $_SESSION["user_id"];
	$db->Query("SELECT money_b, money_p FROM db_users_b WHERE id = '$user_id'");
	$data = $db->FetchArray();
	//return intval($data['money_b']);
	if($_SESSION['game_schet'] == 'in')
		return floatval($data['money_b']);
	if($_SESSION['game_schet'] == 'out')
		return floatval($data['money_p']);
}

function ok_money($money,$bet=0,$stavka=0,$ok=false){
	global $db;
	$money = floatval($money);
	$user_id = $_SESSION["user_id"];
	if($_SESSION['game_schet'] == 'in')
		$db->Query("UPDATE db_users_b SET money_b = {$money} WHERE id = '$user_id'");
	if($_SESSION['game_schet'] == 'out')
		$db->Query("UPDATE db_users_b SET money_p = {$money} WHERE id = '$user_id'");
	if($ok){
		$db->Query("SELECT user FROM db_users_a WHERE id = '$user_id'");
		$user_name = $db->FetchArray();
		$user_name = $user_name['user'];
		$db->Query("INSERT INTO db_games_kamikadze SET 
			date='".time()."',
			sum = {$bet},
			user_id = {$user_id},
			user_name = '{$user_name}',
			stavka = '{$stavka}'
		");
	}	
}



//if(isset($_GET['stop'])) $_SESSION['kamikadze']['start'] = false;
if(isset($_SESSION["user_id"]) && !$halava){
    if(!empty($_GET)){	
	if(isset($_GET['bet'])) $bet = intval($_GET['bet']); else $bet = 0;
	if(isset($_GET['r']))   $r   = intval($_GET['r']);   else $r   = 0;
	if($bet >= 1 && $bet <= 3 && money() >= $ba[$bet][0]){
		if($_GET['start'] == 'true') $_SESSION['kamikadze']['start'] = true;
		if(isset($_SESSION['kamikadze']['start'])){
			if(!isset($_SESSION['kamikadze']['step'])){
				$_SESSION['kamikadze']['step']   = 1;
				$_SESSION['kamikadze']['money']  = money();
				$_SESSION['kamikadze']['money'] -= $ba[$bet][0];
				$_SESSION['kamikadze']['stavka'] = $ba[$bet][0];
				$_SESSION['kamikadze']['chet'] = $_SESSION['game_schet'];
				$moneyplus=0.9*$ba[$bet][0];
    $moneykomissiya=0.1*$ba[$bet][0];
 $db->Query("UPDATE db_stats SET kamikadze = kamikadze+'$moneyplus', kamikadze_komis = kamikadze_komis+'$moneykomissiya' WHERE id = '2'");
			}
			if($_SESSION['kamikadze']['start'] == true){
				if($_GET['act'] == 'takeMoney'){
					$money = $_SESSION['kamikadze']['money'] + $ba[$bet][$_SESSION['kamikadze']['step']-1];
					$moneyminus=$ba[$bet][$_SESSION['kamikadze']['step']-1];
					$db->Query("UPDATE db_stats SET kamikadze = kamikadze-'$moneyminus' WHERE id = '2'");
					
					if($_SESSION['kamikadze']['chet'] == $_SESSION['game_schet'])
						ok_money($money,$ba[$bet][$_SESSION['kamikadze']['step']-1],$_SESSION['kamikadze']['stavka'],true);
					echo '!!END-'.intval($money);
					unset($_SESSION['kamikadze']);
				}else{
					if(game($_GET['r'])){
						echo '!!OK';
						$_SESSION['kamikadze']['step']++;
					}else{
						ok_money($_SESSION['kamikadze']['money']);
						echo '!!LOSE-'.intval($_SESSION['kamikadze']['money']);
						unset($_SESSION['kamikadze']);
					}				
				}
			}else{
				echo 'error session';
			}
		}else{
			echo 'game stop';
		}
	}else{
		echo 'error bet';
	}
   }else{
   	echo money();
   }	
}else{
	echo 'error autorization';
}

?>