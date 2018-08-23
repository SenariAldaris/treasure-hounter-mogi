<?PHP

	if(isset($_SESSION["user"])){ 
		
		include("inc/_user_menu.php");
		
	}else include("inc/_login.php");

include("inc/_user_menu2.php");
include("inc/_stats.php");
?>