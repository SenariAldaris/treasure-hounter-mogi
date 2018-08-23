<?
if(trim($_COOKIE["token"]) !== ""){
$token = $_COOKIE["token"];

include_once($_SERVER["DOCUMENT_ROOT"].'/config.php');
$users_shop = mysql_query("SELECT * FROM `users_shop` WHERE `token`='$token'",$db);
$users_shop_arr = mysql_fetch_assoc($users_shop);
if($users_shop_arr['id'] !== "$ADMIN_ID"){
	include_once($_SERVER["DOCUMENT_ROOT"].'/ajax/errHTML.php');exit;
}
}else{
	   header('Location: http://'.$_SERVER["HTTP_HOST"]);

}
?>
<!doctype html>
<html lang="ru" ng-app="admin">
<head>
  <meta charset="utf-8">
  <title>Admin page - Questions</title>
  <link rel="stylesheet" href="css/app.css"/>
  <link rel="stylesheet" href="css/bootstrap.css"/>
  <link rel="stylesheet" href="css/bootstrap-responsive.css"/>
</head>
<body>
  <div ng-view></div>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write(unescape('%3Cscript src="/js/jquery.js"%3E%3C/script%3E'))</script>
  <script src="lib/angular/angular.js"></script>
  <script src="lib/angular/angular-resource.js"></script>
  <script src="js/app.js"></script>
  <script src="js/services.js"></script>
  <script src="js/controllers.js"></script>
  <script src="js/filters.js"></script>
  <script src="js/directives.js"></script>
</body>
</html>
