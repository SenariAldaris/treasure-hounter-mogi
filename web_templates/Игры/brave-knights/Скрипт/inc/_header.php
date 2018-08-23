<html>
	<head>
		<title>Brave Knights - {!TITLE!}</title>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
		<meta name="description" content="{!DESCRIPTION!}">
		<meta name="keywords" content="{!KEYWORDS!}">
		<link href="/style/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>
		<script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>

  <script type="text/javascript" src="/js/easyTooltip.js"> </script>
                 
         <script src="/js/jquery.bxSlider.js" type="text/javascript"></script>
<script src="/jquery.bxSlider.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#slider1').bxSlider();

  });

</script>   
<?
# контролируем бизнес и бары
$da = time();
$db->Query("DELETE FROM db_bar WHERE active < 0 AND sbor = 0");
$da = time();
$db->Query("UPDATE db_bar SET active = active - 1 WHERE date_del < '$da'");
# контролируем продажу продукции
$db->Query("DELETE FROM db_power WHERE kolvo = 0");
?>
<?
# контролируем бизнес пива
$da = time();
$db->Query("DELETE FROM db_bar2 WHERE active < 0 AND sbor = 0");
$da = time();
$db->Query("UPDATE db_bar2 SET active = active - 1 WHERE date_del < '$da'");
# контролируем продажу продукции
$db->Query("DELETE FROM db_power2 WHERE kolvo = 0");
?>

<script type="text/javascript" src="/jquery.slimscroll.min.js"></script>
       
        
	</head>
	<body>
	<div class="wrap">

		<div class="header">

				<?PHP include("inc/_menu_top.php"); ?>

		</div>

				<div class="content">
					<div class="cl-left"><?PHP include("inc/_menu_left.php"); ?></div>
					<div class="cl-right">