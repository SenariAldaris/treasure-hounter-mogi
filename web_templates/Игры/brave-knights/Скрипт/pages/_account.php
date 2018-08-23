<?PHP
$_OPTIMIZATION["title"] = "Аккаунт";
$_OPTIMIZATION["description"] = "Аккаунт пользователя";
$_OPTIMIZATION["keywords"] = "Аккаунт, личный кабинет, пользователь";

# Блокировка сессии
if(!isset($_SESSION["user_id"])){ Header("Location: /"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // Страница ошибки
        case "credit": include("pages/account/_credit.php"); break; // Кредитная система         
        case "power": include("pages/account/_power.php"); break; // Столовая(энергия)       
        case "kazarma": include("pages/account/_kazarma.php"); break; // Казарма
        case "sklad": include("pages/account/_sklad.php"); break; // Склад
        case "power1": include("pages/account/_power1.php"); break; // Бар(энергия)
        case "kazna": include("pages/account/_kazna.php"); break; // Казна
        case "igrun": include("pages/account/_igrun.php"); break; // Игры
		case "referals": include("pages/account/_referals.php"); break; // Рефералы
        case "shashlichnaya": include("pages/account/_shashlichnaya.php"); break; // Шашлычная
        case "pole": include("pages/account/_pole.php"); break; // Поле
        case "instruktor": include("pages/account/_instruktor.php"); break; // Инструкция
        case "pilorama": include("pages/account/_pilorama.php"); break; // Пилорама
        case "pivovarna": include("pages/account/_pivovarna.php"); break; // Пивоварня
        case "kolbasniyceh": include("pages/account/_kolbasniyceh.php"); break; // Колбасный цех
        case "melnica": include("pages/account/_melnica.php"); break; // Мельница
		case "kirpichzavod": include("pages/account/_kirpichzavod.php"); break; // Завод кирпичный
		case "liteyniyzavod": include("pages/account/_liteyniyzavod.php"); break; // Литейный завод
        case "pekarna": include("pages/account/_pekarna.php"); break; // Пекарня
		case "trade": include("pages/account/_trade.php"); break; // Лавка
        case "farm": include("pages/account/_farm.php"); break; // Моя ферма
		case "farm2": include("pages/account/_farm2.php"); break; // Моя ферма2
		case "farm3": include("pages/account/_farm3.php"); break; // Моя ферма3
		case "lotterym": include("pages/account/_m_lotery.php"); break; //Мгновенная лотерея
        case "market": include("pages/account/_market.php"); break; // Рынок
        case "store": include("pages/account/_store.php"); break; // Склад
		case "swap": include("pages/account/_swap.php"); break; // Обменный пункт
		case "payment": include("pages/account/_payment.php"); break; // Выплаты
        case "wm_insert": include("pages/account/_wm_insert.php"); break; // Пополнение баланса Qiwi
        case "insertp": include("pages/account/_insertp.php"); break; // Пополнение баланса Payeer
		case "insertf": include("pages/account/_insertf.php"); break; // Пополнение баланса Free-Kassa
        case "insertwm": include("pages/account/_insertwm.php"); break; // Пополнение баланса WebMoney
		case "config": include("pages/account/_config.php"); break; // Настройки
		case "bonus": include("pages/account/_bonus.php"); break; // Ежедневный бонус
		case "ticket": include("pages/account/_ticket.php"); break; // Тикеты
		case "swland": include("pages/account/_swland.php"); break; // swamp land
		case "new_ticket": include("pages/account/_new_ticket.php"); break; // Новый тикет
		case "pm": include("pages/account/_pm.php"); break; // Внутренняя почта
		case "pin": include("pages/account/_pin.php"); break; // Пинкоды
		case "wall_serch": include("pages/account/_wall_serch.php"); break; // Стена пользывателя, поиск !
		case "wall": include("pages/account/_wall.php"); break; // Стена пользывателя
		case "chat": include("pages/account/_chat.php"); break; // Чат
        case "kamikadze2": include("pages/account/_kamikadze2.php"); break; // Камикадзе2
        case "youtube": include("pages/account/_youtube.php"); break; // Видео
		case "coinflip": include("pages/account/_coinflip.php"); break; // Орел-решка
		
		case "exit": @session_destroy(); Header("Location: /"); return; break; // Выход

	# Страница ошибки
	default: @include("pages/_404.php"); break;

	}

}else @include("pages/account/_user_account.php");

?>