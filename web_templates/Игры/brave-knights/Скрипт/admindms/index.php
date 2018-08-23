<?PHP

function TimerSet(){
	list($seconds, $microSeconds) = explode(' ', microtime());
	return $seconds + (float) $microSeconds;
}

$_timer_a = TimerSet();

# ����� ������
@session_start();

# ����� ������
@ob_start();



# ��������� ��� Include
define("CONST_RUFUS", true);

# ������������� �������
function __autoload($name){ include("../classes/_class.".$name.".php");}

# ����� ������� 
$config = new config;

# �������
$func = new func;


# ���� ������
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

$pref = $config->BasePrefix;
$admFolder = $config->FolderAdmin;


$_OPTIMIZATION["title"] = "���������������� ������";
$_OPTIMIZATION["description"] = "������� ������������";
$_OPTIMIZATION["keywords"] = "�������, ������ �������, ������������";
//$not_counters = true;



# �����
@include("inc/_header.php");
# ���������� ������
if(!isset($_SESSION["admin"])){ include("pages/_login.php"); return; }

if(isset($_GET["menu"])){
		
	$smenu = strval($_GET["menu"]);
			
	switch($smenu){
		
		case "404": include("pages/_404.php"); break; // �������� ������
		case "stats": include("pages/_stats.php"); break; // ����������
		case "config": include("pages/_config.php"); break; // ���������
		case "contacts": include("pages/_contacts.php"); break; // ��������
		case "rules": include("pages/_rules.php"); break; // �������
		case "about": include("pages/_about.php"); break; // � �����
		case "top": include("pages/_top.php"); break; // ���
		case "story_buy": include("pages/_story_buy.php"); break; // ������� ������� 
        case "story_buy2": include("pages/_story_buy2.php"); break; // ������� ������� ������� 
        case "story_buy3": include("pages/_story_buy3.php"); break; // ������� ������� �������
        case "story_buy4": include("pages/_story_buy4.php"); break; // ������� ������� ���������
		case "story_swap": include("pages/_story_swap.php"); break; // ������� ������ � ���������
		case "story_insert": include("pages/_story_insert.php"); break; // ������� ���������� �������
		case "story_sell": include("pages/_story_sell.php"); break; // ������� �����
		case "news": include("pages/_news_a.php"); break; // �������
		case "users": include("pages/_users.php"); break; // ������ �������������
		case "sender": include("pages/_sender.php"); break; // �������� �������������	
		case "payments": include("pages/_payments.php"); break; // ������� �� ������� WM
		case "ticket": include("pages/_ticket.php"); break; // ������� �� ������� WM
        case "torg": include("pages/_torg.php"); break; // ���
		case "pin": include("pages/_pin.php"); break; // ������� �� ������� WM
		case "pay_auto": include("pages/_pay_auto.php"); break; // ������� �� ������� WM
		case "compconfig": include("pages/_compconfig.php"); break; // ���������� ����������
        case "qiwi_insert": include("pages/_qiwi_insert.php"); break; // ���������� ����� QiWI

		case "exit": @session_destroy(); Header("Location: /"); return; break; // �����

	# �������� ������
	default: @include("pages/_404.php"); break;

	}

}else @include("pages/_stats.php");

# ������
@include("inc/_footer.php");

# ������� ������� � ����������
$content = ob_get_contents();

# ������� �����
ob_end_clean();
	
	# �������� ������
	$content = str_replace("{!TITLE!}",$_OPTIMIZATION["title"],$content);
	$content = str_replace('{!DESCRIPTION!}',$_OPTIMIZATION["description"],$content);
	$content = str_replace('{!KEYWORDS!}',$_OPTIMIZATION["keywords"],$content);
	$content = str_replace('{!GEN_PAGE!}', sprintf("%.5f", (TimerSet() - $_timer_a)) ,$content);
	
// ������� �������
echo $content;

?>