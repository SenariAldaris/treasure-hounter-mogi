<?PHP

function TimerSet(){
	list($seconds, $microSeconds) = explode(' ', microtime());
	return $seconds + (float) $microSeconds;
}

$_timer_a = TimerSet();

# Старт сессии
@session_start();

# Старт буфера
@ob_start();



# Константа для Include
define("CONST_RUFUS", true);

# Автоподгрузка классов
function __autoload($name){ include("../classes/_class.".$name.".php");}

# Класс конфига 
$config = new config;

# Функции
$func = new func;


# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

$pref = $config->BasePrefix;
$admFolder = $config->FolderAdmin;


$_OPTIMIZATION["title"] = "Административная панель";
$_OPTIMIZATION["description"] = "Аккаунт пользователя";
$_OPTIMIZATION["keywords"] = "Аккаунт, личный кабинет, пользователь";
//$not_counters = true;



# Шапка
@include("inc/_header.php");
# Блокировка сессии
if(!isset($_SESSION["admin"])){ include("pages/_login.php"); return; }

if(isset($_GET["menu"])){
		
	$smenu = strval($_GET["menu"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // Страница ошибки
		case "stats": include("pages/_stats.php"); break; // Статистика
		case "config": include("pages/_config.php"); break; // Настройки
		case "contacts": include("pages/_contacts.php"); break; // Контакты
		case "rules": include("pages/_rules.php"); break; // Правила
		case "about": include("pages/_about.php"); break; // о ферме
		case "top": include("pages/_top.php"); break; // Топ
		case "story_buy": include("pages/_story_buy.php"); break; // История покупок 
        case "story_buy2": include("pages/_story_buy2.php"); break; // История оптовых закупок 
        case "story_buy3": include("pages/_story_buy3.php"); break; // История покупок бизнеса
        case "story_buy4": include("pages/_story_buy4.php"); break; // История покупок продукции
		case "story_swap": include("pages/_story_swap.php"); break; // История обмена в обменнике
		case "story_insert": include("pages/_story_insert.php"); break; // История пополнений баланса
		case "story_sell": include("pages/_story_sell.php"); break; // История рынка
		case "news": include("pages/_news_a.php"); break; // Новости
		case "users": include("pages/_users.php"); break; // Список пользователей
		case "sender": include("pages/_sender.php"); break; // Рассылка пользователям	
		case "payments": include("pages/_payments.php"); break; // Запросы на выплаты WM
		case "ticket": include("pages/_ticket.php"); break; // Запросы на выплаты WM
        case "torg": include("pages/_torg.php"); break; // аук
		case "pin": include("pages/_pin.php"); break; // Запросы на выплаты WM
		case "pay_auto": include("pages/_pay_auto.php"); break; // Запросы на выплаты WM
		case "compconfig": include("pages/_compconfig.php"); break; // Управление конкурсами
        case "qiwi_insert": include("pages/_qiwi_insert.php"); break; // Пополнения через QiWI

		case "exit": @session_destroy(); Header("Location: /"); return; break; // Выход

	# Страница ошибки
	default: @include("pages/_404.php"); break;

	}

}else @include("pages/_stats.php");

# Подвал
@include("inc/_footer.php");

# Заносим контент в переменную
$content = ob_get_contents();

# Очищаем буфер
ob_end_clean();
	
	# Заменяем данные
	$content = str_replace("{!TITLE!}",$_OPTIMIZATION["title"],$content);
	$content = str_replace('{!DESCRIPTION!}',$_OPTIMIZATION["description"],$content);
	$content = str_replace('{!KEYWORDS!}',$_OPTIMIZATION["keywords"],$content);
	$content = str_replace('{!GEN_PAGE!}', sprintf("%.5f", (TimerSet() - $_timer_a)) ,$content);
	
// Выводим контент
echo $content;

?>