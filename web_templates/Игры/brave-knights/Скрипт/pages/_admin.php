<?PHP
$_OPTIMIZATION["title"] = "Административная панель";
$_OPTIMIZATION["description"] = "Аккаунт пользователя";
$_OPTIMIZATION["keywords"] = "Аккаунт, личный кабинет, пользователь";
$not_counters = true;
# Блокировка сессии
if(!isset($_SESSION["admin"])){ include("pages/admin/_login.php"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // Страница ошибки
		case "stats": include("pages/admin/_stats.php"); break; // Статистика
		case "config": include("pages/admin/_config.php"); break; // Настройки
		case "contacts": include("pages/admin/_contacts.php"); break; // Контакты
		case "rules": include("pages/admin/_rules.php"); break; // Правила
		case "about": include("pages/admin/_about.php"); break; // о ферме
		case "adm": include("pages/admin/_adm.php"); break; // Видео
		case "story_buy": include("pages/admin/_story_buy.php"); break; // История покупок деревьев
		case "story_swap": include("pages/admin/_story_swap.php"); break; // История обмена в обменнике
		case "story_insert": include("pages/admin/_story_insert.php"); break; // История пополнений баланса
		case "story_sell": include("pages/admin/_story_sell.php"); break; // История рынка
		case "news": include("pages/admin/_news_a.php"); break; // Новости
		case "users": include("pages/admin/_users.php"); break; // Список пользователей
		case "sender": include("pages/admin/_sender.php"); break; // Рассылка пользователям	
		case "payments": include("pages/admin/_payments.php"); break; // Запросы на выплаты WM
        case "youtube": include("pages/admin/_youtube.php"); break;
		case "ticket": include("pages/admin/_ticket.php"); break; // Тикеты
		case "pin": include("pages/admin/_pin.php"); break; // Запросы на выплаты WM
		case "torg": include("pages/admin/_torg.php"); break; // Аукцион товара	
	# Страница ошибки
	default: @include("pages/_404.php"); break;

	}

}else @include("pages/admin/_stats.php");

?>