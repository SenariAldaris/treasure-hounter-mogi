<?PHP
$_OPTIMIZATION["title"] = "�������";
$_OPTIMIZATION["description"] = "������� ������������";
$_OPTIMIZATION["keywords"] = "�������, ������ �������, ������������";

# ���������� ������
if(!isset($_SESSION["user_id"])){ Header("Location: /"); return; }

if(isset($_GET["sel"])){
		
	$smenu = strval($_GET["sel"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // �������� ������
        case "credit": include("pages/account/_credit.php"); break; // ��������� �������         
        case "power": include("pages/account/_power.php"); break; // ��������(�������)       
        case "kazarma": include("pages/account/_kazarma.php"); break; // �������
        case "sklad": include("pages/account/_sklad.php"); break; // �����
        case "power1": include("pages/account/_power1.php"); break; // ���(�������)
        case "kazna": include("pages/account/_kazna.php"); break; // �����
        case "igrun": include("pages/account/_igrun.php"); break; // ����
		case "referals": include("pages/account/_referals.php"); break; // ��������
        case "shashlichnaya": include("pages/account/_shashlichnaya.php"); break; // ���������
        case "pole": include("pages/account/_pole.php"); break; // ����
        case "instruktor": include("pages/account/_instruktor.php"); break; // ����������
        case "pilorama": include("pages/account/_pilorama.php"); break; // ��������
        case "pivovarna": include("pages/account/_pivovarna.php"); break; // ���������
        case "kolbasniyceh": include("pages/account/_kolbasniyceh.php"); break; // ��������� ���
        case "melnica": include("pages/account/_melnica.php"); break; // ��������
		case "kirpichzavod": include("pages/account/_kirpichzavod.php"); break; // ����� ���������
		case "liteyniyzavod": include("pages/account/_liteyniyzavod.php"); break; // �������� �����
        case "pekarna": include("pages/account/_pekarna.php"); break; // �������
		case "trade": include("pages/account/_trade.php"); break; // �����
        case "farm": include("pages/account/_farm.php"); break; // ��� �����
		case "farm2": include("pages/account/_farm2.php"); break; // ��� �����2
		case "farm3": include("pages/account/_farm3.php"); break; // ��� �����3
		case "lotterym": include("pages/account/_m_lotery.php"); break; //���������� �������
        case "market": include("pages/account/_market.php"); break; // �����
        case "store": include("pages/account/_store.php"); break; // �����
		case "swap": include("pages/account/_swap.php"); break; // �������� �����
		case "payment": include("pages/account/_payment.php"); break; // �������
        case "wm_insert": include("pages/account/_wm_insert.php"); break; // ���������� ������� Qiwi
        case "insertp": include("pages/account/_insertp.php"); break; // ���������� ������� Payeer
		case "insertf": include("pages/account/_insertf.php"); break; // ���������� ������� Free-Kassa
        case "insertwm": include("pages/account/_insertwm.php"); break; // ���������� ������� WebMoney
		case "config": include("pages/account/_config.php"); break; // ���������
		case "bonus": include("pages/account/_bonus.php"); break; // ���������� �����
		case "ticket": include("pages/account/_ticket.php"); break; // ������
		case "swland": include("pages/account/_swland.php"); break; // swamp land
		case "new_ticket": include("pages/account/_new_ticket.php"); break; // ����� �����
		case "pm": include("pages/account/_pm.php"); break; // ���������� �����
		case "pin": include("pages/account/_pin.php"); break; // �������
		case "wall_serch": include("pages/account/_wall_serch.php"); break; // ����� ������������, ����� !
		case "wall": include("pages/account/_wall.php"); break; // ����� ������������
		case "chat": include("pages/account/_chat.php"); break; // ���
        case "kamikadze2": include("pages/account/_kamikadze2.php"); break; // ���������2
        case "youtube": include("pages/account/_youtube.php"); break; // �����
		case "coinflip": include("pages/account/_coinflip.php"); break; // ����-�����
		
		case "exit": @session_destroy(); Header("Location: /"); return; break; // �����

	# �������� ������
	default: @include("pages/_404.php"); break;

	}

}else @include("pages/account/_user_account.php");

?>