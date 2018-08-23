<?
header("Content-Type: text/html; charset=utf-8");
include_once($_SERVER["DOCUMENT_ROOT"].'/ajax/configSettings.php');
include_once($_SERVER["DOCUMENT_ROOT"].'/config.php');
$pimeriaHtml = <<<HTML
	<div style="text-align: center; font-size: 19px; color: #D3A23A; text-transform: uppercase; padding-bottom: 3px;">Пополнение через Primearea.ru(Webmoney):</div>
	<div style="text-align: center; font-size: 13px; margin-top: -8px; padding-bottom: 10px; color: #CBCBCB;"><h4>Выберите сумму пополнения</h4> (после оплаты вы получите код, который надо ввести ниже)</div>	
	<div style="text-align: center; font-size: 13px; margin-top: -8px; padding-bottom: 10px; color: #CBCBCB;">
	<div class="paytype" data-system="10" style="margin-left: 12%; width: 189px;"><center><img src="./img/10rub.png" style="width: auto; margin-top: 1px; margin-right: 0px; opacity: 0.6;"></center></div>
	<div class="paytype" data-system="100" style="width: 189px;"><center><img src="./img/100rub.png" style="width: auto; margin-top: 1px; margin-right: 0px; opacity: 0.6;"></center></div>
	<div class="paytype" data-system="500" style="margin-left: 12%; width: 189px;"><center><img src="./img/500rub.png" style="width: auto; margin-top: 1px; margin-right: 0px; opacity: 0.6;"></center></div>
	<div class="paytype" data-system="1000" style="width: 189px;"><center><img src="./img/1000rub.png" style="width: auto; margin-top: 1px; margin-right: 0px; opacity: 0.6;"></center></div>
HTML;
$disingerHtml = <<<HTML
	<div style="text-align: center; font-size: 19px; color: #D3A23A; text-transform: uppercase; padding-bottom: 3px;">Пополнение через Autokassir.ru(Robokassa):</div>
	<div style="text-align: center; font-size: 13px; margin-top: -8px; padding-bottom: 10px; color: #CBCBCB;"><div class="form-group" style="margin-top: 15px;margin-left:38%;">
					<div class="input-group">
					<div class="addbal"><a href="http://100procentovnerazvod.tk/autokassir.php">Пополнить</a></div>
					</div>
				</div></div>	
	 
HTML;
if($caseS["digiseller"]["on"] == "1"){$payHtml .=$disingerHtml;}
if($caseS["primearea"]["on"] == "1"){$payHtml .=$pimeriaHtml;}


if($caseS{site_on} == "0"){echo <<<HTML
<html lang="en"><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><head>
<link rel="icon" href="/css/dallary.png" type="image/x-icon">
<link rel="shortcut icon" href="/css/dallary.png" type="image/x-icon">
<title>Технические работы на сайте! Попробуйте зайти позже.</title>
<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body { 
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal; 
}

h1 {
	color: #444;
	background-color:rgba(239, 239, 239, 1);
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1>Проводятся технические работы</h1>
		<p> <b>В настоящее время сайт недоступен в связи с техническими работами. Об окончании работ не известно так что ждите.</b></p></div>


</body></html>
HTML;
exit;
}
//open: "true" - Включить кейс, false - Выключить кейс
//price: цена на кейс
//Если вы выключили некоторые кейсы и они теперь они не ровные то найдите в файле index.php строку неровного кейса и в классе class="item-wrapper small" удалите small

$echo =<<<HTML

<div style="width: 400px; float: left; padding-top: 30px; text-transform: uppercase;">
		<div style="font-size: 21px; font-weight: bold; padding-bottom: 4px; color: #D3A23A;">2 веские причины покупать у нас:</div>
		<div style="font-size: 16px; color: #c5c4c4;">- У нас дешевле, чем в Steam</div>
		<div style="font-size: 16px; color: #c5c4c4; padding-bottom: 3px;">- Выше шанс выпадения дорогих предметов</div>
		<hr class="style-two" style="margin: 0;">
	</div>
	
	<div class="pull-right" style="padding-top: 15px; padding-right: 25px;">
		<div style="padding-top: 9px; font-size: 14px; text-align: center;">
								  <script src="//ulogin.ru/js/ulogin.js"></script>
								  <ul class="nav navbar-nav" style="float: right">
								  <li style="float: center"><span style="font-size: 16px;">Авторизация через </span></li>
								  
								  <div style="padding-top: 9px; font-size: 14px; text-align: center;">
			
		</div>
								  <center>
								  <li style="float: center;margin-top:10px"><div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name;providers=steam,vkontakte;hidden=;redirect_uri=http%3A%2F%2F{$_SERVER["HTTP_HOST"]}%2F"></div></li>
</center>
		</div>
		</div>
HTML;
if(isset($_GET["uniquecode"]))include_once($_SERVER["DOCUMENT_ROOT"].'/t/index_auto.php');
     if($_SERVER["QUERY_STRING"] == "logout"){
		    echo  '
		   <script type="text/javascript">
		   var date = new Date( new Date().getTime() + 1*1000 );
           document.cookie="token=; path=/; expires="+date.toUTCString();
           document.cookie="uid=; path=/; expires="+date.toUTCString();
		   </script> 
		   ';
		   $_COOKIE["token"]="";
     	   exit('<script language="JavaScript"> 
  window.location.href = "http://'.$_SERVER["HTTP_HOST"].'" 
</script>');
    }else{
	 
	} 
if(isset($_POST['token']) || trim($_COOKIE["token"]) !== ""){


if(!isset($_POST["token"])){
$token = $_COOKIE["token"];

include "config.php";
$users_shop = mysql_query("SELECT * FROM `users_shop` WHERE `token`='$token'",$db);
$users_shop_arr = mysql_fetch_assoc($users_shop);
$token_count = mysql_num_rows($users_shop);
$users_shop_count = mysql_num_rows($users_shop);

$trade_url = $users_shop_arr["trade_url"];
$user = $users_shop_arr;
}else{
	
$token = $_POST['token'];
$s = file_get_contents('http://ulogin.ru/token.php?token=' . $token . '&host=' . $_SERVER['HTTP_HOST']);
$user = json_decode($s, "true");
$uid = $user["uid"];
 echo <<<HTML
		   <script type="text/javascript">
		   var date = new Date( new Date().getTime() + 1440*1000 );
           document.cookie="token=$token; path=/; expires="+date.toUTCString();
           document.cookie="uid=$uid; path=/; expires="+date.toUTCString();
		   </script> 
HTML;

 if(!isset($user["error"])){
 echo <<<HTML
		   <script type="text/javascript">
		   var date = new Date( new Date().getTime() + 1440*1000 );
           document.cookie="token=$token; path=/; expires="+date.toUTCString();
           document.cookie="uid=$uid; path=/; expires="+date.toUTCString();
		   </script> 
HTML;
 
include "config.php";
$uid = $user["uid"];
$network = $user["network"];	
$identity = $user["identity"];	
$first_name = htmlspecialchars($user["first_name"]);	
$last_name = htmlspecialchars($user["last_name"]);	
$i = $user["last_name"];	
$users_shop = mysql_query("SELECT * FROM `users_shop` WHERE `uid`='$uid'",$db);
$st = mysql_query("UPDATE `users_shop` set `token` = '$token' where `uid` = '$uid'");
$users_shop_count = mysql_num_rows($users_shop);
$users_shop_arr = mysql_fetch_assoc($users_shop);
$trade_url = $users_shop_arr["trade_url"];
$token_count = 1;

	       	switch ($network) {
			  case "vkontakte":
				 $request = 'http://api.vkontakte.ru/method/users.get?uids=' . $user['uid'] . '&fields=photo';
				 $response = file_get_contents($request);
				 $info = array_shift(json_decode($response)->response);
				 $img = $info->photo;
			     break;
			  case "steam": 

 //Прежде всего вам понадобится apikey. Зарегистрировать его можно здесь http://steamcommunity.com/dev/apikey (Заменить F925B1D0540A6C7DCE6413FC3DB23039)
				 $request = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=F925B1D0540A6C7DCE6413FC3DB23039&steamids=' . $user['uid'];
				 $response = file_get_contents($request);
				 $info = json_decode($response,"true");
				 $img = $info["response"]["players"]["0"]["avatar"];
				 $personanam = $info["response"]["players"]["0"]["personaname"];
			     break; 
			}   
			$user = $users_shop_arr;

 echo <<<HTML
		   <script type="text/javascript">
		   var date = new Date( new Date().getTime() + 14400*1000 );
           document.cookie="token=$token; path=/; expires="+date.toUTCString();
           document.cookie="uid=$uid; path=/; expires="+date.toUTCString();
		   </script> 
HTML;
			
}
} 



if($token_count == "1"){ 
$moneybalance = $users_shop_arr["money"];

			

				 
                    //$user['network'] - соц. сеть, через которую авторизовался пользователь
                    //$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
                    //$user['first_name'] - имя пользователя
                    //$user['last_name'] - фамилия пользователя
				    //$user = Array ( [uid] => 76561198159117767 [network] => steam [identity] => http://steamcommunity.com/openid/id/76561198159117767 [first_name] => HakerHelp [last_name] => Кожич [manual] => last_name [profile] => http://steamcommunity.com/openid/id/76561198159117767 )
			     	//$user = Array ( [identity] => http://vk.com/id166340246 [profile] => http://vk.com/id166340246 [first_name] => Евгений [uid] => 166340246 [network] => vkontakte [last_name] => Кожич )

	       	switch ($users_shop_arr["network"]) {
			  case "vkontakte":
				 $request = 'http://api.vkontakte.ru/method/users.get?uids=' . $user['uid'] . '&fields=photo';
				 $response = file_get_contents($request);
				 $info = array_shift(json_decode($response)->response);
				 $img = $info->photo;
			     break;
			  case "steam": 

 //Прежде всего вам понадобится apikey. Зарегистрировать его можно здесь http://steamcommunity.com/dev/apikey (Заменить F925B1D0540A6C7DCE6413FC3DB23039)
				 $request = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=F925B1D0540A6C7DCE6413FC3DB23039&steamids=' . $user['uid'];
				 $response = file_get_contents($request);
				 $info = json_decode($response,"true");
				 $img = $info["response"]["players"]["0"]["avatar"];
				  $personanam = $info["response"]["players"]["0"]["personaname"];
			     break; 
			}   
				 if($users_shop_count == "0"){
					$tokens=md5(time());
				 	$result2 = mysql_query("INSERT INTO `users_shop` (`uid`, `network`,`img`,`last_name`,`first_name`,`identity`,`token`) VALUES('$uid','$network','$img','$last_name','$first_name','$identity','$tokens')") or die(mysql_error());
				 	$users_shop = mysql_query("SELECT * FROM `users_shop` WHERE `uid`='$uid'",$db);
				 	$users_shop_count = mysql_num_rows($users_shop);
				 	$users_shop_arr = mysql_fetch_assoc($users_shop);
				 }
				 
####################################################################################################
$refLink = $_SERVER["HTTP_HOST"]."/?r={$users_shop_arr['id']}";
$randchance = "";//'<a style=" font-size: 15px; color: #FF2D2D;" data-modal="#randchance" href="#">[Рандомный шанс: 0%]</a>';//2DFF40
if(trim($user['first_name']) == "")$user['first_name'] = $user['last_name'];
if($users_shop_arr['id'] == $ADMIN_ID)$adm_cd = '<a href="/admin.php">[Админка]</a> ';
			switch ($users_shop_arr["network"]) {
			  case "vkontakte":
               
				 				 $echo =<<<HTML
								  
								 	<div style="float: right; padding-top: 10px; margin-right: 25px;">
		 
			<div class="userinfobox">
				<div style="float: left"><img width="26" src="$img">   {$users_shop_arr['first_name']} {$users_shop_arr['last_name']} #{$users_shop_arr['id']} $randchance {$adm_cd}<a href="/?logout">[Выйти]</a></div>
<!-- <div class="orderhistory">История покупок</div> --!>
				
			</div>		
		     
			<div style="float: left; font-size: 21px; color: #EEE;">Ваш баланс: <span class="userBalance">$moneybalance</span> руб</div>

			<div style="float: right; margin-left: 15px; margin-top: -2px;">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group">
					<div class="addbal"><a data-modal="#paySystems" href="#">Пополнить</a></div>
					</div>
				</div>
				</form>
				
			</div>
			
			<div class="clearfix"></div>
			
			<div class="tradelinkbox">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group" style="background: #212121; border-color: #434343;">
					<input type="text" class="linkInput" placeholder="Введите вашу ссылку на обмен" value="$trade_url">
					<a class="utlink">Сохранить</a>
					</div>
				</div>
				</form>
				<a class="llink" data-modal="#tradelinkInstruction" href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">Как узнать ссылку на обмен?</a>
				<span class="userPanelError"></span>
			</div>
			
		</div>
		
	 
HTML;
			  
			     break;
			  case "steam": 
				 				 $echo =<<<HTML
								 
								 	<div style="float: right; padding-top: 10px; margin-right: 25px;">
		
			<div class="userinfobox">
				<div style="float: left"><img width="26" src="$img">   {$personanam} #{$users_shop_arr['id']} {$adm_cd}<a href="/?logout">[Выйти]</a></div>
		
			</div>		
		     $randchance
			<div style="float: left; font-size: 21px; color: #EEE;">Ваш баланс: <span class="userBalance">$moneybalance</span> руб</div>
		
			<div style="float: right; margin-left: 15px; margin-top: -3px;">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group">
					<div class="addbal"><a data-modal="#paySystems" href="#">Пополнить</a></div>
					</div>
				</div>
				</form>
				
			</div>
			
			<div class="clearfix"></div>
			
			<div class="tradelinkbox">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group" style="background: #212121; border-color: #434343;">
					<input type="text" class="linkInput" placeholder="Введите вашу ссылку на обмен" value="$trade_url">
					<a class="utlink">Сохранить</a>
					</div>
				</div>
				</form>
				<a class="llink" data-modal="#tradelinkInstruction" href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">Как узнать ссылку на обмен?</a>
				<span class="userPanelError"></span>
			</div>
			
		</div>
		
	 
HTML;
			     break; 
            }

  			  if($users_shop_arr["ban"] == 1)$echo =<<<HTML


<div style="float: right; padding-top: 10px; margin-right: 25px;">
		
			<div class="userinfobox">
				<div style="float: left"><img width="26" src="$img">   {$users_shop_arr["first_name"]} {$users_shop_arr["last_name"]} #{$users_shop_arr['id']} <a href="/?logout">[Выйти]</a></div>
		
			</div>	
		
<span class="userPanelError">Вы заблокированы!</span>
			
		</div>



			  
HTML;

}else{
$echo =<<<HTML

<div style="width: 400px; float: left; padding-top: 30px; text-transform: uppercase;">
		<div style="font-size: 21px; font-weight: bold; padding-bottom: 4px; color: #D3A23A;">2 веские причины покупать у нас:</div>
		<div style="font-size: 16px; color: #c5c4c4;">- У нас дешевле, чем в Steam</div>
		<div style="font-size: 16px; color: #c5c4c4; padding-bottom: 3px;">- Выше шанс выпадения дорогих предметов</div>
		<hr class="style-two" style="margin: 0;">
	</div>
	
	<div class="pull-right" style="padding-top: 15px; padding-right: 25px;">
		<div style="padding-top: 9px; font-size: 14px; text-align: center;">
								  <script src="//ulogin.ru/js/ulogin.js"></script>
								  <ul class="nav navbar-nav" style="float: right">
								  <li style="float: center"><span style="font-size: 16px;">Авторизация через </span> </li>
								  <hr class="style-two" style="margin-top: 5;">
								  <center><li style="float: center;margin-top:10px"><div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name;providers=steam,vkontakte;hidden=;redirect_uri=http%3A%2F%2F{$_SERVER["HTTP_HOST"]}%2F"></div></li></center>
<hr class="style-two" style="margin-top: 5;">
		</div>
		</div>
HTML;
	
} 
}
        
?> 


<html><head>
<link rel="icon" href="/css/dallary.png" type="image/x-icon">
<link rel="shortcut icon" href="/css/dallary.png" type="image/x-icon">
<script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>
<script type="text/javascript" async="" src="http://mc.yandex.ru/metrika/watch.js"></script><script type="text/javascript" async="" src="http://mc.yandex.ru/metrika/watch.js"></script><script type="text/javascript" async="" src="http://mc.yandex.ru/metrika/watch.js"></script><script type="text/javascript" src="/BCF6B6283D00456D879F84529267A253/B92C4F79-AD03-D946-9FA1-8422376142A6/main.js" charset="UTF-8"></script><script type="text/javascript" async="" src="http://mc.yandex.ru/metrika/watch.js"></script><script type="text/javascript" src="/BCF6B6283D00456D879F84529267A253/EB8C7105-09AE-8E49-999A-F47D7E4CB006/main.js" charset="UTF-8"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?echo $caseS["site_name"];?></title>
	<meta name="description" content="<?echo $caseS["metadescr"];?>">
	<meta name="keywords" content="<?echo $caseS["sitedescription"];?>">
	<link rel="shortcut icon" type="image/x-icon" href="<?echo "http://".$_SERVER["HTTP_HOST"];?>images/csicon.png">
	<!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<link href="./css/style.css" rel="stylesheet">
	<link href="./css/styles.css" rel="stylesheet">
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<link href="./css/jquery.arcticmodal-0.3.css" rel="stylesheet" media="screen">
	
	<link href="//fonts.googleapis.com/css?family=Roboto:400,300,500,700&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
	<link href="//fonts.googleapis.com/css?family=Ubuntu&amp;subset=latin,cyrillic" rel="stylesheet" type="text/css">
	

	
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script> 
	<script type="text/javascript" src="//vk.com/js/api/share.js?90"></script>
	<script type="text/javascript" src="http://cdn.socket.io/socket.io-1.3.4.js"></script> 
	<script src="/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/jquery.arcticmodal-0.3.min.js"></script>
	<script type="text/javascript">
		if (!navigator.cookieEnabled) {
  		alert('Включите cookie для комфортной работы с этим сайтом');
		}

	</script>
	<script type="text/javascript" src="/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="/js/cases.js"></script>
	<script type="text/javascript" src="/js/server.js"></script> 
	<script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script> 
<style type="text/css">.kisb .kl_abmenu { font-size:12px; font-family: "Segoe UI", Arial, sans-serif; color: #FFFFFF; float: left; padding: 8px; border: 1px solid #FFFFFF; background: #057662; background: -moz-linear-gradient(#057662, #1a8171);background: -ms-linear-gradient(#057662, #1a8171);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #057662), color-stop(100%, #1a8171)); background: -webkit-linear-gradient(#057662, #1a8171); background: -o-linear-gradient(#057662, #1a8171);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#057662", endColorstr="#1a8171"); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr="#057662", endColorstr="#1a8171")";background: linear-gradient(#057662, #1a8171);border-radius: 8px;}</style><style type="text/css">.kisb .kl_abmenu { font-size:12px; font-family: "Segoe UI", Arial, sans-serif; color: #FFFFFF; float: left; padding: 8px; border: 1px solid #FFFFFF; background: #057662; background: -moz-linear-gradient(#057662, #1a8171);background: -ms-linear-gradient(#057662, #1a8171);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #057662), color-stop(100%, #1a8171)); background: -webkit-linear-gradient(#057662, #1a8171); background: -o-linear-gradient(#057662, #1a8171);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#057662", endColorstr="#1a8171"); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr="#057662", endColorstr="#1a8171")";background: linear-gradient(#057662, #1a8171);border-radius: 8px;}</style><style type="text/css">.kisb .kl_abmenu { font-size:12px; font-family: "Segoe UI", Arial, sans-serif; color: #FFFFFF; float: left; padding: 8px; border: 1px solid #FFFFFF; background: #057662; background: -moz-linear-gradient(#057662, #1a8171);background: -ms-linear-gradient(#057662, #1a8171);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #057662), color-stop(100%, #1a8171)); background: -webkit-linear-gradient(#057662, #1a8171); background: -o-linear-gradient(#057662, #1a8171);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#057662", endColorstr="#1a8171"); -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr="#057662", endColorstr="#1a8171")";background: linear-gradient(#057662, #1a8171);border-radius: 8px;}</style></head>

<body style="overflow: visible; margin-right: 0px;">
<div class="wrapper" style="width: 1125px; padding-top: 5px;">
	<div class="row" style="margin-left: 5px;">
		<div class="brand-wrapper" style="width: 388px; float: left;">
		<div class="clearfix">
			<div class="pull-left">
				<a href="<?echo "http://".$_SERVER["HTTP_HOST"];?>"><img src="./css/csgomslogo.png" alt="<?echo $_SERVER["HTTP_HOST"];?>" ></a>
			</div>
			
<div class="lnav" >
			<hr class="style-two" style="marin-top: 0px; margin-bottom: 1px;">
			<a data-modal="#siteGuarantee" href="#" style="margin-right: 4px;">гарантии</a>
			<!-- <a data-modal="#siteGuarantee" href="#" style="margin-right: 4px;">ГАРАНТИИ</a>-->
			</div>

		</div>   
	</div>
	
	<?echo $echo;?>
	

	
	

	

	
</div>
<div class="stone containero">
<div class="item-wrapper small" style="display:<?if($case["Falchion Case"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Falchion Case" data-price="<?echo $case["Falchion Case"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Армейское</span>
			</div>
		</div> 
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/falchion.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Falchion Case"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Chroma Case"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Chroma Case" data-price="<?echo $case["Chroma Case"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Запрещенное</span>
			</div>
		</div> 
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/chroma_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Chroma Case"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Knife Case"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Knife Case" data-price="<?echo $case["Knife Case"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Knife Case</span>
			</div>
		</div> 
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/knife.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Knife Case"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Chroma 2 Case"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Chroma 2 Case" data-price="<?echo $case["Chroma 2 Case"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Засекреченное</span>
			</div>
		</div> 
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/chroma22.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Chroma 2 Case"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Operation Phoenix"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Operation Phoenix" data-price="<?echo $case["Operation Phoenix"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Тайное</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/fenix_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Operation Phoenix"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Operation Breakout"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Operation Breakout" data-price="<?echo $case["Operation Breakout"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Кейс операции "Прорыв"</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/proriv_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Operation Breakout"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Operation Vanguard"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Operation Vanguard" data-price="<?echo $case["Operation Vanguard"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Кейс операции "Авангард"</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/avangard_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Operation Vanguard"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Operation Bravo"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Operation Bravo" data-price="<?echo $case["Operation Bravo"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Кейс операции "Браво"</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/bravo_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Operation Bravo"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["CS:GO Weapon"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="CS:GO Weapon" data-price="<?echo $case["CS:GO Weapon"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Оружейный кейс</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/orujeiniy_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["CS:GO Weapon"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Winter Offensive"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Winter Offensive" data-price="<?echo $case["Winter Offensive"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Кейс "Winter Offensive"</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/winter_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Winter Offensive"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small" style="display:<?if($case["Huntsman Weapon"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="Huntsman Weapon" data-price="<?echo $case["Huntsman Weapon"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Охотничий оружейный кейс</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/ohotnichiy_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["Huntsman Weapon"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper small"  style="display:<?if($case["CS:GO Weapon #2"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="CS:GO Weapon #2" data-price="<?echo $case["CS:GO Weapon #2"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Оружейный кейс: Тираж #2</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/orujeiniy2_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["CS:GO Weapon #2"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper"  style="display:<?if($case["CS:GO Weapon #3"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="CS:GO Weapon #3" data-price="<?echo $case["CS:GO Weapon #3"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Оружейный кейс: Тираж #3</span>
			</div>
		</div>
		
		<div class="img-wrapper small">
			<a class="item-link">
				<img src="./css/orujeiniy3_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["CS:GO Weapon #3"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper"  style="display:<?if($case["eSports 2013"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="eSports 2013" data-price="<?echo $case["eSports 2013"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Кейс eSports 2013</span>
			</div>
		</div>
		
		<div class="img-wrapper small">
			<a class="item-link">
				<img src="./css/esports2013_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["eSports 2013"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper"  style="display:<?if($case["eSports 2013 Winter"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="eSports 2013 Winter" data-price="<?echo $case["eSports 2013 Winter"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Кейс eSports Winter</span>
			</div>
		</div>
		
		<div class="img-wrapper small">
			<a class="item-link">
				<img src="./css/esportsw2013_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["eSports 2013 Winter"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
<div class="item-wrapper"  style="display:<?if($case["eSports 2014 Summer"]["open"] !== "true")echo "none"?>;">
	<div class="item" data-key="eSports 2014 Summer" data-price="<?echo $case["eSports 2014 Summer"]["price"];?>">
		<div class="desc">
			<div class="name">
				Cлучайное оружие из<br>
				<span>Кейс eSports 2014</span>
			</div>
		</div>
		
		<div class="img-wrapper">
			<a class="item-link">
				<img src="./css/esports2014_case.png" width="189px" class="itemsimg" >
			</a>
		</div>
		<img src="./css/stand.png" class="stand" >
		<div class="cost">
			<img src="./css/money.png" > <?echo $case["eSports 2014 Summer"]["price"];?> рублей
		</div>
		<div class="buyb">
			<img src="./css/ook.png" style="margin-top: -3px;" > Открыть
		</div>
	</div>
</div>
</div>	
<div class="clearfix"></div>

<div id="recent_wins2"></div>

<div id="reviews">
	<hr class="style-two">
</div>
<div class="clearfix"></div>

<div style="width: 700px; margin: 0 auto; ">


<div class="stone" style="font-size: 13px;
line-height: 15px;
color: #eaeaea;
padding: 10px;
margin-left: -10px;
margin-right: -10px;
margin-bottom: 5px;
text-align: center;">
	<div style="color: #FF0000; padding-top: 5px;">
	Инвентарь бота <a data-modal="http://csgo.com" href="http://csgojackpoti.esy.es/Inventory.html/" style="color: #EFDA08;">Открыть</a></a>
	</div>
	
<!--<div style="padding-top: 10px; color: red; font-size: 16px;">Комментарии закрываем до утра из-за большого количества спама.<br>Откроем комментарии в 08:00 по мск</div> -->
</div>
<!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

<script type="text/javascript">
  VK.init({apiId: <? echo  $caseS["apiId"]?>, onlyWidgets: true});
</script>

<!-- Put this div tag to the place, where the Comments block will be -->
<div id="vk_comments"></div>
<script type="text/javascript">
VK.Widgets.Comments("vk_comments", {limit: 20, width: "700", attach: "*"});
</script>
<br>
<!-- <div style="padding: 10px; font-size: 14px;">ВНИМНИЕ! Перезажгружаем сервер. Если вам вдруг не пришли предметы или деньги на счет - не волнуйтесь, как сервер перезагрузиться - все придет!</div> -->

</div></div>
<div style="">

</div>
<!-- modals-start -->
<div style="display: none;">
<div id="contacts" class="itemmodal" style="width: 650px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Контакты
</div>	
<hr class="style-two">

<div style="line-height: 14px; font-size: 13px;">
	<div style="padding-top: 10px;">
	В случае если у вас появились проблемы или вы хотите рассказать о своем выигрыше, то пишите в нашу группу ВК:<br>
	сюда -  <a href="<? echo  $caseS["support"]?>" target="_blank"><? echo  $caseS["support"]?></a>
	</div>

</div>

</div>
</div>
<!-- modals-end -->
<!-- modals-start -->
<div style="display: none;">
<div id="info" class="itemmodal" style="width: 650px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
О НАС
</div>	
<hr class="style-two">
	<div style="padding: 10px 10px 0px 15px;font-size: 14px; line-height: 20px; color:#EAEAEA; padding-bottom: 3px;">
					</div>

</div>

</div>
</div>
<!-- modals-end -->


<!-- modals-start -->
<div style="display: none;">
<div id="itemmodal" class="itemmodal">
	<div class="box-modal_close arcticmodal-close"></div>
	
	<div id="scrollerContainer">
		<div id="caruselLine"></div>
		<div id="caruselOver"></div>
		<div id="aCanvas">
			<div id="casesCarusel" style="margin-left: 0px;"><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTBi4-7cNcWdKy_q4LFlC-9tWTLbAvYdkfFpSFDv-GZQz14kM4hvVUfcHfoCu61C3qOGhYDRHpqzpSkLCZ-uw8KMc6tY0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Поверхностная закалка</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9QnTDyY27fhvXdC-44QKKE644ZyUMuF-NY4eHJWEWv6Hbgys6E0-g6JZfZONqCK-3ivtaDwJDRHp-j0MhqbZ7VLOXRkn/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Градиент</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTDygg68Jna9u_8LMSFlC-9tWTLbF5NdpOGsmGUqTSYFv-uUk8gvIIe8eL9Cq-1Srgb2dcCBLsqGxVmuWZ-uw8pT4tNB0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Патина</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTBi4-7cNcWdKy_q4LFlC-9tWTLbAvYdkfFpSFDv-GZQz14kM4hvVUfcHfoCu61C3qOGhYDRHpqzpSkLCZ-uw8KMc6tY0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Поверхностная закалка</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTDygg68Jna9u_8LMSFlC-9tWTLbF5NdpOGsmGUqTSYFv-uUk8gvIIe8eL9Cq-1Srgb2dcCBLsqGxVmuWZ-uw8pT4tNB0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Патина</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></div><div class="weaponblock weaponblock2 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div><div class="weaponblock weaponblock2 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9QnTDyY27fhvXdC-44QKKE644ZyUMuF-NY4eHJWEWv6Hbgys6E0-g6JZfZONqCK-3ivtaDwJDRHp-j0MhqbZ7VLOXRkn/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Градиент</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></div><div class="weaponblock weaponblock2 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></div><div class="weaponblock weaponblock2 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></div><div class="weaponblock weaponblock2 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></div></div>
		</div>
	</div>
		
		<div style="text-align: center;
		padding: 5px 0px 1px 0px;
		font-size: 14px;
		color: #D3A23A;">
			Вы можете увеличить шанс выпадения дорогих предметов:
		</div>
		
		<div style="width: 275px; margin: 0 auto;">
			<div class="upchance upc10" data-price="10">ШАНС +10%</div>
			<div class="upchance upc20" data-price="20">ШАНС +20%</div>
			<div class="upchance upc30" data-price="30">ШАНС +30%</div>
			<div class="clearfix"></div>
		</div>
		
		<div style="text-align: center; padding-top: 13px">

			<button id="openCase" class="OpenCaseBtn">Открыть кейс</button>
			<button class="priceCaseBtn" disabled="disabled"><span id="currentCaseprice">89</span><span id="upchanceprice"></span> рублей</button>
			<div class="clearfix"></div>

		</div>
		
		<div style="text-align: center; padding-top: 5px;">
		<span style="color: #eaeaea; font-size: 13px;">Открывая кейс вы соглашаетесь <a style="cursor: pointer;" data-modal="#rules">с условиями покупки</a></span>
		</div>
		
		<hr class="style-two" style="margin-bottom: 7px;">
		
		<div class="clearfix"></div>
		
<!-- ОШИБКИ-СТАРТ -->
		
		<div id="authError" class="syserrbox" style="display: none; margin-bottom: 10px;">
			<center style="font-size: 16px; color: #C78080; line-height: 20px;">Для того, чтобы открывать кейсы, вам нужно выполнить вход на сайт:</center>
			<div style="position: relative; left:40%" >
			 <div style="float: center;margin-top:10px">
<div  class="" style="float: center;" id="uLogines" data-ulogin="display=panel;fields=first_name,last_name;providers=steam,vkontakte;hidden=;redirect_uri=http%3A%2F%2F<?echo $_SERVER["HTTP_HOST"];?>%2F"></div>
</div>

			</div>
		</div>
		
		<div id="balanceError" class="syserrbox" style="display: none; margin-bottom: 10px;">
			<center style="font-size: 16px; color: #C78080;">Вам нужно пополнить баланс:</center>
			<div style="font-size: 20px; color: #FCFCFC; text-align: center;">
				Ваш баланс: <span class="userBalance">10000</span> руб
			</div>
			<div style="margin-left: 35%;  margin-top: 7px;">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group">
					<div class="addbal"><a data-modal="#paySystems" href="#">Пополнить</a></div>
					</div>
				</div>
				</form>
				<span class="userPanelError" style="float: none"></span>
				<div class="clearfix"></div>
			</div>
		</div>
		
		<div id="linkError" class="syserrbox" style="display: none; width: 500px; padding-bottom: 5px; margin-bottom: 10px;">
			<center style="font-size: 16px; color: #C78080;">Вам нужно ввести вашу ссылку на обмен:</center>
			<div class="tradelinkbox" style="padding-top: 6px;">
				<form class="form-inline">
				<div class="form-group">
					<div class="input-group" style="background: #212121; border-color: #434343;">
					<input type="text" class="form-control linkInput" placeholder="Введите вашу ссылку на обмен" style="width: 360px; padding: 0px 10px; height: 30px;  background: #212121; border-color: #434343; margin: 1px 0;
					outline:0;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6);">
					<a class="utlink" style="padding: 0px 13px;">Сохранить</a>
					</div>
				</div>
				</form>
				<a class="llink" data-modal="#tradelinkInstruction" href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">Как узнать ссылку на обмен?</a>
				<span class="userPanelError"></span>
				<div class="clearfix"></div>
			</div>
		</div>
		
<!-- ОШИБКИ-ЕНД -->
		
		<div style="text-align: center; color: #83B6C2; font-size: 13px; margin-bottom: -7px;">Предметы, которые могут вам выпасть с <span id="curCaseName" style="color: #D3A23A; font-size: 15px;">Кейс операции "Прорыв"</span></div>
	
	<ul id="caseItems"><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52JLSKMyJYfxSVTKNRUfg7-gzpGxg-4cBrQOi69qkBLBLtsoKSMOYuN95JTMjTDPGDM1ipuxg90fMJKcDfpCvn2ni4OD0IWxvi5CtazxCLTIoO/125fx125f"><div class="weaponblockinfo"><span>MP7<br>Городская опасность</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51MeSwJghkZzvMBKdbSsou_RztBzQm59Vua9u_8LMSFlC-9tWTLeV-N4odS5PXX6PVNFv8uE9r1PdeKsff8i_s3SXhPW0LCUG--2pXyuaZ-uw8UAQJFkg/125fx125f"><div class="weaponblockinfo"><span>Negev<br>Пустынная атака</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5zP_PnYGc3TQfXPrAMDKVqywH6BjUr18tqU9-iyLcHO1u6qoCXN7d-MdweGsmDD_GPYAD47EI9iPIILpba8izv2yzuO2oCDRTs-2oa2LjQxpZttMo/125fx125f"><div class="weaponblockinfo"><span>P2000<br>Слоновая кость</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5oJ-TlaAhmYzvOBLZXXeEy9QbTBS414NNcWNak8L5IeVjv59fCMbV-NdtLG8bUWKKGMgiruB1sgPJdesaPoy66jyXsPW5cCQ2rpDx0zn4ssg/125fx125f"><div class="weaponblockinfo"><span>SSG 08<br>Пучина</span></div></li><li class="weaponblock weaponblock1 milspec"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5uOfPhZQhvazvOCK5bT8o15gniDiIN5M5kXMOJ-7oULlnx4ILGN-V9M9BFHcPWD_DQNwypu0lugKRYKsTbpXjs2i_qaDpcWBW_-3VExrHui8poXg/125fx125f"><div class="weaponblockinfo"><span>UMP-45<br>Лабиринт</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz55Pfm6PghkZzvACLpRUrg15wH-ADQN5M5kXMOJ-7oULlnxtoTPZrAvZdkdS8XZUqSBYFipuEMwhKZdK8aN9i7niSrrPzxfCRa9qXVExrECS2z-2w/125fx125f"><div class="weaponblockinfo"><span>ПП-19 Бизон<br>Осирис</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz54LrTgMQhkZzvBVvVfEeEz8w3-Nis77893a9u35bwDZ17osYaUNuErM4tEScKCWPaBbw3_vxk4hKcIecHb9C68jHm8OmoPWhD1ujVToYhPwzE/125fx125f"><div class="weaponblockinfo"><span>CZ75-Auto<br>Тигр</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz51O_W0DzRyTQrNF6FhV_ozywTlDi8m18tiRtCzueleKg-54YLFZbcvNopIF5SFD_eGMwio4kNth6YMfJWLoSntiX67a2gUG028humfMw0/125fx125f"><div class="weaponblockinfo"><span>Nova<br>Карп кои</span></div></li><li class="weaponblock weaponblock1 restricted"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rZrblDzRyTQbLFbRbTuYt8Q34Nis77893a9u35bwDZwTs59bCO7kqOIxLFsTRWKOGNV__6Eg70qkILp2PoCi5iy_uM25bDxf1ujVTlZEMO3Y/125fx125f"><div class="weaponblockinfo"><span>P250<br>Сверхновая</span></div></li><li class="weaponblock weaponblock1 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5_MeKyPDJYcRH9BaVfW_k_ywn5GyIn-_hvXdC-44QKKE644ZzBZeErNthJGJOCWvPQZFqsuEM6ifMIK5GB9ivt3Xy8P2oKXBLurmtRhqbZ7Tllk6hd/125fx125f"><div class="weaponblockinfo"><span>Desert Eagle<br>Заговор</span></div></li><li class="weaponblock weaponblock1 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz59PfWwIzJxdwr9ALFhCaIF8g3tHS83-tRcWN6x_685JV2t49fYYuElNNoaHciEX6DSbg_17E870qRZfcSJ8ynu2irpOToCCRXq_2wBnPjH5OWhSCyC7g/125fx125f"><div class="weaponblockinfo"><span>Five-SeveN<br>Птичьи игры</span></div></li><li class="weaponblock weaponblock1 classified"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/125fx125f"><div class="weaponblockinfo"><span>Glock-18<br>Водяной</span></div></li><li class="weaponblock weaponblock1 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5rbbOKMyJYYl2STKFNVfw3-x7TBS414NNcWNak8L5IeV--s9TBZeMsM9ofFsiDX6XVYwn7uRhs1ahffZaK9S_n3iu4Mj8CUw2rpDw1YXWUJg/125fx125f"><div class="weaponblockinfo"><span>P90<br>Азимов</span></div></li><li class="weaponblock weaponblock1 covert"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz52YOLkDyRufgHMAqVMY_YvywW4CHYh18R6RtKuyLcPLlSr296Xced5LtlIG5LUWvOFM1v66Rk80aVaeZ2IoiK6j3_pb2YKU0fjr2kMzuPVs-F1wjFBLhxWp7I/125fx125f"><div class="weaponblockinfo"><span>M4A1-S<br>Сайрекс</span></div></li><li class="weaponblock weaponblock1 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9QnTDyY27fhvXdC-44QKKE644ZyUMuF-NY4eHJWEWv6Hbgys6E0-g6JZfZONqCK-3ivtaDwJDRHp-j0MhqbZ7VLOXRkn/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Градиент</span></div></li><li class="weaponblock weaponblock1 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTBi4-7cNcWdKy_q4LFlC-9tWTLbAvYdkfFpSFDv-GZQz14kM4hvVUfcHfoCu61C3qOGhYDRHpqzpSkLCZ-uw8KMc6tY0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Поверхностная закалка</span></div></li><li class="weaponblock weaponblock1 rare"><img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz5wOuqzNQhlZxDWBLJYUOwF9RnTDygg68Jna9u_8LMSFlC-9tWTLbF5NdpOGsmGUqTSYFv-uUk8gvIIe8eL9Cq-1Srgb2dcCBLsqGxVmuWZ-uw8pT4tNB0/125fx125f"><div class="weaponblockinfo"><span>? Нож-бабочка<br>Патина</span></div></li></ul>
	<div class="clearfix"></div>
</div>
</div>
<!-- modals-end -->

<!-- modals-start -->
<div style="display: none;">
<div id="orderHistory" class="itemmodal" style="min-width: 560px; position: relative; padding: 30px 25px 5px 25px; border-radius: 6px; border: 1px solid #4F3D18;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
	
	<div style="padding: 5px 10px; font-size: 14px; border: 1px solid #555; margin-bottom: 5px;">
	<span style="margin-right: 4px; color:#D3A22C; font-size: 16px;"><span class="fa fa-th-list" aria-hidden=""true""></span></span> Вы можете забрать ваши предметы на <a style="margin-left: 3px; color:#D3A22C;" href="http://steamcommunity.com/id/me/tradeoffers/" target="_blank">странице предложений обмена в Steam</a>
	</div>
	
	
	<div style="padding: 10px 10px; line-height: 15px; font-size: 13px; border: 1px solid #D55252; background: rgba(213, 82, 82, 0.14); margin-bottom: 5px; width: 573px;">
		Steam ввел новые ограничения и поэтому сейчас наши боты не могут сразу отправлять предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span>
		<div style="padding-top: 3px;">
		Сейчас моментально отправляются только <span style="color: rgb(228, 174, 57);">Ножи</span> и предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span>
		</div>
		<div style="padding-top: 3px;">
		Полную информацию <a style="cursor: pointer; text-decoration: underline;" data-modal="#rules">читать здесь</a>
		</div>
		<div style="padding-top: 5px; padding-left: 15px;">
			Мы можем выкупать у вас предметы Армейского качества по рыночной цене торговой площадки Steam и зачислить возвращенные средства на ваш баланс на нашем сайте.
			<div style="padding-top: 5px;">
			Или же вы можете подождать пока разрешиться проблема и наши боты снова попробуют отправить вам данный предмет (минимальный срок ожидания – 7 дней)
			</div>
		</div>
	</div>
	
	<table class="table table-bordered" style="background: rgba(0, 0, 0, 0.29);">
		<thead style="font-weight: bold; font-size: 11px; text-transform: uppercase;">
		<tr>
			<th>ID заказа</th>
			<th>Дата</th>
			<th>Кейс</th>
			<th>Предмет</th>
			<th>Статус</th>
		</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="5" style="text-align: center;">Подождите...</td>
			</tr>
		</tbody>
	</table>
</div>
</div>
<!-- modals-end -->


<!-- modal-start -->
<div style="display: none;">
<div id="weaponBlock" class="itemmodal">
	<div class="box-modal_close arcticmodal-close mini"></div>
	<div class="recweaptitle">
		<span class="stattrack">StatTrak™</span> <span class="name">Glock-18 | Водяной</span>
	</div>
	
	<div class="recweap classified">
		<img src="//steamcommunity-a.akamaihd.net/economy/image/fWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag/384fx384f" >
	</div>
	
	<div style="width: 410px; margin: 0 auto;">
		<div class="shareBtn"><a href="http://vk.com/share.php?url=http%3A%2F%2Fcrackedlix.ru%2F%3Futm_source%3Dvkshare%26title%3D%25D0%259A%25D0%25B5%25D0%25B9%25D1%2581%25D1%258B%2520CS%3AGO%2520-%2520%25D0%259E%25D1%2582%25D0%25BA%25D1%2580%25D1%258B%25D0%25B2%25D0%25B0%25D0%25B9%2520%25D1%2581%2520%25D0%25B2%25D1%258B%25D0%25B3%25D0%25BE%25D0%25B4%25D0%25BE%25D0%25B9%2F%26description%3D%25D0%25AF%2520%25D0%25B2%25D1%258B%25D0%25B8%25D0%25B3%25D1%2580%25D0%25B0%25D0%25BB%2520Glock-18%2520%257C%2520%25D0%2592%25D0%25BE%25D0%25B4%25D1%258F%25D0%25BD%25D0%25BE%25D0%25B9%2F%26image%3Dhttp%3A%2F%2Fsteamcommunity-a.akamaihd.net%2Feconomy%2Fimage%2FfWFc82js0fmoRAP-qOIPu5THSWqfSmTELLqcUywGkijVjZYMUrsm1j-9xgEObwgfEh_nvjlWhNzZCveCDfIBj98xqodQ2CZknz58OOy2OwhkZzvFDa9dV7g2_Rn5DDQx7cl3a9u_8LMSFlC-9tWTLbEpMY1FGsSFDvLXM1__4hhr06RYe5Xa8S692S64PToDXRfvrGgCybWZ-uw8dna1jag%2F360fx360f%2F%26noparse%3D"true"" onmouseup="this._btn=event.button;this.blur();" onclick="return VK.Share.click(1, this);" style="display:inline-block;text-decoration:none;"><span style="position: relative; padding:0;"><img src="<?echo "http://".$_SERVER["HTTP_HOST"];?>images/vk_icon.png"><span>Поделиться результатом</span></span></a></div>
	
		<div id="sellBlock" class="recweapinfo" style="font-size: 13px; line-height: 15px; display: none;">
		Steam ввел новые ограничения и поэтому сейчас наши боты не могут сразу отправлять предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span>
			<div style="padding-top: 3px;">
			Сейчас моментально отправляются только <span style="color: rgb(228, 174, 57);">Ножи</span> и предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span>
			</div>
			<div style="padding-top: 3px;">
			Полную информацию <a style="cursor: pointer; text-decoration: underline;" data-modal="#rules">читать здесь</a>
			</div>
			<div style="padding-top: 5px; padding-left: 15px;">
				1. Мы можем выкупить данный предмет по рыночной цене торговой площадки Steam и зачислить возвращенные средства на ваш баланс на нашем сайте.
				<div style="padding-top: 5px;">
				2. Подождать пока разрешиться проблема и наши боты снова попробуют отправить вам данный предмет (минимальный срок – 7 дней)
				</div>
			</div>
			<div class="wpmillBtn sellBtn" style="margin-left: 21px;">Продать<br><span><span class="sellprice">12</span> руб (цена на маркете)</span></div>
			<div class="wpmillBtn waitBtn" style="margin-left: 25px;">Подождать<br><span>ждать от 7 дней</span></div>
		</div>
	
		<div id="aftersellBlock1" style="display: none;">
			<div class="recweapinfo" style="padding: 6px; line-height: 15px; font-size: 16px; margin-top: 10px;">
			Сумма в размере <span style="color: #D3A23A"><span class="sellprice">12 рублей</span></span> была успешно зачислена на ваш баланс
			</div>		
			<div class="TryAgainBtn arcticmodal-close">Попробовать еще раз</div>
		</div>
	
		<div id="aftersellBlock2" style="display: none;">
			<div class="recweapinfo" style="font-size: 14px; line-height: 15px;">
			Как только разрешиться проблема с ограничением наши боты снова попробуют отправить вам данный предмет.<br>
			Минимальный срок ожидания - 7 дней.<br>
			Просим прощение за неудобства.
			<div style="padding-top: 10px;">
			Напоминае, что <u>это ограничение у нас распостраняется только на предметы <span style="color: rgb(75, 105, 255);">Армейского качества!</span></u><br>
			<span style="color: rgb(228, 174, 57);">Ножи</span> и предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span> <u>отправляются моментально после покупки</u>!
			</div>
			</div>
			<div class="TryAgainBtn arcticmodal-close">Попробовать еще раз</div>
		</div>

		<div id="aftersellBlock3" style="display: block;">
			<div class="recweapinfo" style="padding: 3px 3px 3px 5px; line-height: 15px; font-size: 15px; margin-top: 10px;">
			<span style="color: #D3A23A">Поздравляем!</span> Предмет вам уже отправлен. Вы можете получить ваш предмет <a href="http://steamcommunity.com/id/me/tradeoffers/" target="_blank">на странице предложений обмена в Steam</a>
			</div>		
			<div class="TryAgainBtn arcticmodal-close">Попробовать еще раз</div>
		</div>		
		
		<div class="clearfix"></div>
	</div>
</div>
<!-- modals-end -->

<!-- modals-start -->
<div style="display: none;">
<div id="paySystems" class="itemmodal" style="width: 552px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
	<div style="text-align: center; font-size: 16px; line-height: 14px; color: #CBCBCB; text-transform: uppercase; padding-bottom: 5px;">
	Пополнение баланса <br>
	</div>
	<hr class="style-two">

<?
echo $payHtml;
?>
	<div class="clearfix"></div>
	<div style="text-align: center; font-size: 19px; color: #D3A23A; text-transform: uppercase; padding-bottom: 3px;">Либо введите код:</div><br>
	<span class="paymentError"></span>

		<form class="form-inline">
				<div class="form-group">
					<div class="input-group" style="background: #212121; border-color: #434343;">
					<input type="text" class="balanceInput " placeholder="Введите код пополнения" style="">
					<a class="paymentcode" style="background-color: #304452;">Отправить</a>
					</div>
				</div> 
				</form>
	
	<div class="clearfix"></div><br>
	<div style="text-align: center; font-size: 19px; color: #D3A23A; text-transform: uppercase; padding-bottom: 3px;">Реферальная ссылка:</div>
	<div style="text-align: center; font-size: 13px; margin-top: -8px; padding-bottom: 10px; color: #CBCBCB;">(получайте 50%(!) за каждое пополнение баланса вашего друга)</div>
	<div style="text-align: center; font-size: 24px;"><?echo $refLink;?></div>
	<div class="clearfix"></div>
</div></form>
</div>
</div>
<!-- modals-end -->
 
<!-- modals-start -->
<div style="display: none;">
<div id="tradelinkInstruction" class="itemmodal" style="width: 660px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Как узнать ссылку на обмен в Стиме
</div>	
<hr class="style-two">
<div style="font-size: 14px; color:#EAEAEA; padding-bottom: 3px;">

<div style="padding-bottom: 5px;">
<span style="font-size: 16px; color:#D3A22C; font-weight: bold;">1.</span> Зайти на ваш аккаунт в Steam <a href="https://steamcommunity.com/login/home/" target="_blank">steamcommunity.com/login/home/</a>
</div>
<div style="padding-bottom: 15px;">
<span style="font-size: 16px; color:#D3A22C; font-weight: bold;">2.</span> Перейти по ссылке <a href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url</a>
<br>и там внизу вы увидите вашу ссылку на обмен - скопируйте ее.
</div>


<div style="padding-bottom: 3px;
color: #D3A22C;
font-size: 15px;">
Пример того, как выглядит ссылка на обмен:
</div>
<div style="background-color: rgba( 0, 0, 0, 0.2 );
border-radius: 3px;
border: 1px solid #000;
box-shadow: 1px 1px 0 0 rgba( 91, 132, 181, 0.2 );
color: #C6D4DF;
margin-bottom: 25px;
outline: none;
font-size: 14px;
padding: 4px 6px;">
https://steamcommunity.com/tradeoffer/new/?partner=********&amp;token=********
</div>

<div style="padding-bottom: 0px;">
<span style="font-size: 16px; color:#D3A22C; font-weight: bold;">ВАЖНО!:</span> Чтобы бот смог отправить вам предмет - ваш инвентарь должен быть открытым!
<br>
По стандарту он открыт, но если вы скрывали - откройте его в настройках приватности: <a href="http://steamcommunity.com/id/me/edit/settings/#inventoryPrivacySetting_public" target="_blank">steamcommunity.com/id/me/edit/settings/#inventoryPrivacySetting_public</a>
</div>
</div>
</div>
</div>
<!-- modals-end -->


<!-- modals-start -->
<div style="display: none;">
<div id="siteInstruction" class="itemmodal" style="width: 720px; position: relative; padding: 20px 20px 0px 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Инструкция по сайту
</div>	
<hr class="style-two">

</div>
</div>
<!-- modals-end -->

<!-- modals-start -->
<div style="display: none;">
<div id="randchance" class="itemmodal" style="width: 720px; position: relative; padding: 20px 20px 0px 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Рандомный шанс
</div>	
<hr class="style-two">

<div style="line-height: 14px; font-size: 13px;">

	<div style="padding-top: 5px;">
	Вы можете купить «<span style="color: rgb(136, 71, 255);">Р</span><span style="color: rgb(235, 75, 75);">а</span><span style="color: rgb(136, 71, 255);">н</span><span style="color: rgb(235, 75, 75);">д</span><span style="color: rgb(211, 44, 230);">о</span><span style="color: rgb(235, 75, 75);">м</span><span style="color: rgb(235, 75, 75);">н</span><span style="color: rgb(136, 71, 255);">ы</span><span style="color: rgb(228, 174, 57);">й</span><span style="color: rgb(211, 44, 230);"> </span><span style="color: rgb(211, 44, 230);">ш</span><span style="color: rgb(211, 44, 230);">а</span><span style="color: rgb(136, 71, 255);">н</span><span style="color: rgb(228, 174, 57);">с</span>».
	
	<div style="padding-top: 5px;">
	Стоимость: 200р.<br>
    Использование: Открытие кейса.<br>
	<span style="color: red">Поле открытия кейса шанс обнуляется.</span> <br>
Шанс: от 30% до 80% - Это шанс что вам выпадет предмет редкости <span style="color: rgb(235, 75, 75);">Тайное</span> или <span style="color: rgb(228, 174, 57);">Нож</span>

	</div>
		<div style="padding-left: 20px;">
			<div style="padding-top: 10px;">
			1. В случае если вы его купили, то вам выпадаут предметы данной редкости : <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span>, а также <span style="color: rgb(228, 174, 57);">Ножи</span>
			</div>
			<div style="padding-top: 5px;">
			2. Предметы  <span style="color: rgb(75, 105, 255);">Армейского качества</span> НЕ будут выпадать!
			</div>
		</div>
	</div>
	
	<div style="padding-top: 10px;">
	<div>«<span style="color: rgb(136, 71, 255);">Р</span><span style="color: rgb(235, 75, 75);">а</span><span style="color: rgb(136, 71, 255);">н</span><span style="color: rgb(235, 75, 75);">д</span><span style="color: rgb(211, 44, 230);">о</span><span style="color: rgb(235, 75, 75);">м</span><span style="color: rgb(235, 75, 75);">н</span><span style="color: rgb(136, 71, 255);">ы</span><span style="color: rgb(228, 174, 57);">й</span><span style="color: rgb(211, 44, 230);"> </span><span style="color: rgb(211, 44, 230);">ш</span><span style="color: rgb(211, 44, 230);">а</span><span style="color: rgb(136, 71, 255);">н</span><span style="color: rgb(228, 174, 57);">с</span>» может суммироваться с <span style="font-size: 14px;color: #D3A23A;">шансом выпадения дорогих предметов</span>  <span style="color:rgb(91, 192, 222)">+10%</span> <span style="color:rgb(240, 173, 78);">+20%</span> <span style="color:rgb(217, 83, 79);">+30%</span></div>
		<div style="padding-top: 5px;">
		<br>
		</div>
	</div>

</div>

</div>
</div>
<!-- modals-end -->
<!-- modals-end -->



<!-- modals-start -->
<div style="display: none;">
<div id="siteFAQ" class="itemmodal" style="width: 660px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
	<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">Помощь по сайту</div>
	<hr class="style-two">
	<div style="font-size: 14px; line-height: 20px; color:#EAEAEA; padding-bottom: 3px;">
	<div style="margin-bottom: 10px;" id="accordion" role="tablist" aria-multiselectable=""true"">
			<div style="margin-top: 15px;">
				<div class="collapsetitle" role="tab" id="headingOne">
					<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#Q1">Где я нахожусь?</a></h4>
				</div>
				<div id="Q1" class="panel-collapse collapse in">
					<div style="padding: 10px 10px 0px 15px;">
						<?echo $_SERVER["HTTP_HOST"];?> - абсолютно точный аналог системы открывания кейсов как и в самой игре Counter Strike: Global Offensive, но только стоимость кейса у нас получается в несколько раз меньше, а шанс выпадения дорогих предметов до 80% больше.<br>
					</div>
				</div>
			</div>
			<div style="margin-top: 15px;">
				<div class="collapsetitle" role="tab" id="headingTwo">
					<h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#Q2">Как тут покупать?</a></h4>
				</div>
				<div id="Q2" class="panel-collapse collapse">
					<div style="padding: 10px 10px 0px 15px;">
						<span style="font-size: 16px; color:#D3A22C; font-weight: bold;">1.</span> Авторизируйтесь на сайте удобным для вас способом (VK или Steam)
						<div style="padding-left: 17px; padding-top: 2px; font-size: 12px; line-height: 13px;">(!вы проходите авторизацию именно через сайты Вконтакте или Steam, никаких персональных данных от вас при авторизации мы не получаем!);</div>
						<span style="font-size: 16px; color:#D3A22C; font-weight: bold;">2.</span> Пополните баланс на желаемую сумму удобным для вас способом;
						<br><span style="font-size: 16px; color:#D3A22C; font-weight: bold;">3.</span> Укажите вашу ссылку на обмен в Стиме;
						<br><span style="font-size: 16px; color:#D3A22C; font-weight: bold;">4.</span> Выберите кейс, который хотите купить;
						<br><span style="font-size: 16px; color:#D3A22C; font-weight: bold;">5.</span> Нажмите кнопку "Открыть кейс" и в течении 10 секунд наша система абсолютно рандомно выберет вам предмет из кейса и наш бот моментально его вам отправит по вашей ссылке на обмен в Steam
					</div>
				</div>
			</div>
			<div style="margin-top: 15px;">
				<div class="collapsetitle" role="tab" id="headingThree">
					<h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#Q3">Как узнать ссылку на обмен?</a></h4>
				</div>
				<div id="Q3" class="panel-collapse collapse">
					<div style="padding: 10px 10px 0px 15px;">
						<span style="font-size: 16px; color:#D3A22C; font-weight: bold;">1.</span> Зайдите на ваш аккаунт в Steam <a href="https://steamcommunity.com/login/home/" target="_blank">steamcommunity.com/login/home/</a>
						<br><span style="font-size: 16px; color:#D3A22C; font-weight: bold;">2.</span> Перейдите по ссылке <a href="http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" target="_blank">steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url</a>
						и там внизу вы увидите вашу ссылку на обмен.
					</div>
				</div>
			</div>
			<div style="margin-top: 15px;">
				<div class="collapsetitle" role="tab" id="headingThree">
					<h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#Q4">Сколько времени занимает отправка предмета?</a></h4>
				</div>
				<div id="Q4" class="panel-collapse collapse">
					<div style="padding: 10px 10px 0px 15px;">
						После открытия кейса предмет моментантально отправиться вам нашим ботом по вашей ссылке на обмен в Steam.
					</div>
				</div>
			</div>
			<div style="margin-top: 15px;">
				<div class="collapsetitle" role="tab" id="headingThree">
					<h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#Q5">Куда мне придет выигранный предмет?</a></h4>
				</div>
				<div id="Q5" class="panel-collapse collapse">
					<div style="padding: 10px 10px 0px 15px;">
						Предметы отправляются в "предложения об обмене" в Steam
						<br><a href="http://steamcommunity.com/id/me/tradeoffers/" target="_blank">http://steamcommunity.com/id/me/tradeoffers/</a>
						<br>Вам останется лишь принять обмен от нашего бота.
					</div>
				</div>
			</div>
			<div style="margin-top: 15px;">
				<div class="collapsetitle" role="tab" id="headingThree">
					<h4 class="panel-title"><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#Q6">Мне не пришел обмен, что делать?</a></h4>
				</div>
				<div id="Q6" class="panel-collapse collapse">
					<div style="padding: 10px 10px 0px 15px;">
						Если вам не пришел обмен - значит проблема на вашей стороне (скрыт инвентарь, выключен Steam Guard/не прошло 15 дней со времени включения Steam Guard и еще много всяких причин)
						<br>Проверяте ваши покупки в "История покупок" на сайте (в правом верхнем углу).
						<br>Если там будет в статусе заказа будет написано "ошибка", тогда наведите курсом на нее и в появившемся окне вам покажет ту самую ошибку.
						<br>Ошибка значит, что у вас стоит ограничение на обмен. Как у вас пройдет ограничение на обмен - наш бот автоматически отправит вам предмет снова.
					</div>
				</div>
			</div>
	</div>
</div>
</div>
</div>
<!-- modals-end -->

<!-- modals-start -->
<div style="display: none;">
<div id="siteFree" class="itemmodal" style="width: 660px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
	<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 30px; text-transform: uppercase; padding-bottom: 5px;">Разрещение http://vk.com/thedarkfire3dd!</div>
</div>
</div>
</div>
<!-- modals-end -->

<!-- modals-start -->
<div style="display: none;">
<div id="siteGuarantee" class="itemmodal" style="width: 660px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Наши гарантии
</div>	
<hr class="style-two">
<div style="font-size: 16px; color: #D3A22C; padding-bottom: 3px;">

<div style="padding-bottom: 10px;">
<span style="margin-right: 3px; color:#D3A22C; font-size: 18px;"><span class="fa fa-star" aria-hidden=""true""></span></span> Верифицированный аккаунт Digiseller и RoboKassa
<div style="font-size: 13px;
margin-left: 25px;
line-height: 17px;
color: #EAEAEA;">
Мы принимаем оплату через платежные системы Oplata.Info и RoboKassa.<br>
Верифицированный аккаунт - значит что мы прошли полную проверку личности и магазина перед добавлением в платежные системы.
</div>
</div>

<div style="padding-bottom: 10px;">
<span style="margin-right: 5px; color:#D3A22C;"><span class="fa fa-user" aria-hidden=""true""></span></span> Персональный аттестат Webmoney
<div style="font-size: 13px;
margin-left: 25px;
line-height: 17px;
color: #EAEAEA;">
Персональный аттестат WebMoney - цифровое удостоверение личности заверенное аналогом собственноручной подписи участника системы WebMoney Transfer, в котором записаны личные данные его обладателя: ФИО, паспортная и контактная информация.
</div>
</div>

<div style="padding-bottom: 10px;">
<span style="margin-right: 5px; color:#D3A22C;"><span class="fa fa-ok" aria-hidden=""true""></span></span> Полная идентификация в системах QIWI и Яндекс.Деньги
<div style="font-size: 13px;
margin-left: 25px;
line-height: 17px;
color: #EAEAEA;">
Мы принимаем оплату на этом сайте на наши идентифицированные счета<br>
Полная идентификация выдаются магазинам только после личной встречи в пунктах партнеров QIWI или дополнительных офисах Киви банк (ЗАО) и после полной полной проверки магазина.<br>
</div>
</div>

<div style="padding-bottom: 10px;">
<span style="margin-right: 4px; color:#D3A22C; font-size: 17px;"><span class="fa fa-lock" aria-hidden=""true""></span></span> Идентификационные данные нашего сайта
<div style="font-size: 13px;
margin-left: 25px;
line-height: 17px;
color: #EAEAEA;">
<div style="padding-bottom: 5px;">
Соединение с сайтом <?echo $_SERVER["HTTP_HOST"];?> зашифровано с использованием 128-разрядного TLS.
</div>
<div style="padding-bottom: 5px;">
В этом подключении используется протокол TSL 1.2.
</div>
<div style="padding-bottom: 5px;">
Соединение защищено и проверено с помощью AES_128_GSM. В качестве механизма обмена ключами используется ECDHE_RSA.
</div>
Подробнее о том, что это значит, можете прочитать в <a href="https://support.google.com/chrome/answer/95617?p=ui_security_indicator&amp;rd=1" target="_blank">справочнике Google</a>
</div>
</div>

<div style="">
<span style="margin-right: 3px; color:#D3A22C; font-size: 18px;"><span class="fa fa-cog" aria-hidden=""true""></span></span> Контроль честности MD5
<div style="font-size: 13px;
margin-left: 25px;
line-height: 17px;
color: #EAEAEA;">
<div style="padding-bottom: 5px;">
Это, пожалуй, самая главная причина доверять нам.<br>
Наш сайт используют опцию контроля честности (КЧ) MD5. <br>
Этот специальный алгоритм позволяет наглядно продемонстрировать пользователю, что результат каждого открытия кейсов происходит случайным образом.<br>
Пользователь может достоверно убедиться в том, что на работу рандомайзера никто и ничто не влияет извне.<br>
КЧ MD5 является изобретением и собственностью компании RSA Data Security, Inc.
</div>

</div>
</div>

</div>
</div>
</div>
<!-- modals-end -->


<!-- modals-start -->
<div style="display: none;">
<div id="rules2" class="itemmodal" style="width: 650px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Условия покупки
</div>	
<hr class="style-two">

<div style="line-height: 14px; font-size: 13px;">

	<div style="padding-top: 5px;">
	Steam ввел ограничение на обмен купленных вещей на торговой площадке, поэтому сейчас наши боты не могут сразу отправить некоторые предметы, а именно предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span>.
	<div style="padding-top: 5px;">
	Поэтому в случае если вы открыли кейс и Вам выпал предмет <span style="color: rgb(75, 105, 255);">Армейского качества</span> – вам будет предложено 2 варианта:
	</div>
		<div style="padding-left: 20px;">
			<div style="padding-top: 10px;">
			1. Выкупить данный предмет по рыночной цене торговой площадки Steam и закислить возвращенные средства на ваш баланс на нашем сайте, на которые вы сможете продолжать совершать попупки.
			</div>
			<div style="padding-top: 5px;">
			2. Подождать пока разрешиться проблема и наши боты снова смогут отправлять предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span> без ограничений (может занять неограниченное время, минимальный срок – 7 дней)
			</div>
		</div>
	</div>
	
	<div style="padding-top: 10px;">
		<div style="padding-top: 5px;">
		В случае если вы открыли кейс и Вам выпал <span style="color: rgb(228, 174, 57);">Нож</span> или предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> или <span style="color: rgb(235, 75, 75);">Тайное</span>
		тогда предмет Вам будет моментально отправлен нашим ботом без каких-либо задержек.
		</div>
		<div style="padding-top: 5px;">
		Так происходит потому что предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span> покупаются напрямую в Steam, а предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span>, а также <span style="color: rgb(228, 174, 57);">Ножи</span> скупаются на других источниках и поэтому на них не распостраняется новое правило на ограничения обмена. 
		</div>
	</div>

</div>

</div>
</div>
<!-- modals-end -->

<!-- modals-start -->
<div style="display: none;">
<div id="rules" class="itemmodal" style="width: 650px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Условия покупки
</div>	
<hr class="style-two">

<div style="line-height: 15px; font-size: 13px; color: #eaeaea;">

		<div style="padding-top: 5px; font-size: 14px;">
		В случае если вы открыли кейс и Вам выпал <span style="color: rgb(228, 174, 57);">Нож</span> или предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> или <span style="color: rgb(235, 75, 75);">Тайное</span>
		тогда вам будет <u>моментально отправлен предмет нашим ботом без каких-либо задержек</u>.<br>
		А теперь подробнее о том, если вам выпал предмет  <span style="color: rgb(75, 105, 255);">Армейского качества</span>:
		</div>

	<div style="padding-top: 10px;">
	Steam ввел ограничение на обмен купленных вещей на торговой площадке, поэтому <u>сейчас наши боты не могут сразу отправлять предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span></u>.
	<div style="padding-top: 5px;">
	Поэтому в случае если вы открыли кейс и Вам выпал предмет Армейского качества – вам будет предложено 2 варианта:
	</div>
		<div style="padding-left: 20px;">
			<div style="padding-top: 10px;">
			1. Мы можем выкупить данный предмет по рыночной цене торговой площадки Steam и зачислить возвращенные средства на ваш баланс на нашем сайте.
			</div>
			<div style="padding-top: 5px;">
			2. Подождать пока разрешиться проблема и наши боты снова смогут отправлять предметы Армейского качества без ограничений (минимальный срок – 7 дней)
			</div>
		</div>
	</div>
	
	<div style="padding-top: 10px; font-size: 14px;">
		Так происходит потому что предметы <span style="color: rgb(75, 105, 255);">Армейского качества</span> покупаются напрямую в Steam, а предметы редкости <span style="color: rgb(136, 71, 255);">Запрещенное</span>, <span style="color: rgb(211, 44, 230);">Засекреченное</span> и <span style="color: rgb(235, 75, 75);">Тайное</span>, а также <span style="color: rgb(228, 174, 57);">Ножи</span> скупаются на других источниках и поэтому на них не распостраняется новое правило на ограничения обмена.
	</div>

</div>

</div>
</div>
<!-- modals-end -->

<!-- modals-start -->
<div style="display: none;">
<div id="siteComRules" class="itemmodal" style="width: 600px; position: relative; padding: 20px; border-radius: 6px; border: 1px solid #4F3D18; display: inline-block;">
	<div class="box-modal_close arcticmodal-close mini"></div>
	
<div style="text-align: center; color: #D3A22C; font-weight: bold; font-size: 20px; text-transform: uppercase; padding-bottom: 5px;">
Правила поведения на сайте
</div>	
<hr class="style-two">
<div style="font-size: 13px; line-height: 17px;">
	<div style="">
	1. Спам, флуд, просьбы дать денег или скинуть предметов по вашей ссылке на обмен, не цензурная лексика, ссылки на вредоносные источники - ЗАПРЕЩЕНЫ, карается занесением в черный список, без возможности обжаловать решение!
	</div>
	<div style="padding-top: 10px;">
	2. Запрещено писать в поддержку с вопросами "откуда у вас столько вещей?", "дайте кредит", "разрешите открыть 1 кейс бесплатно" и тому подобные сообщения.
	</div>
	<div style="padding-top: 10px;">
	В случае если у вас появились проблемы, пишите нашим саппортам в ВК:<br>
	сюда <a href="<? echo  $caseS["support"]?>" target="_blank"><? echo  $caseS["support"]?></a>
	</div>
	<?echo $data_link_tmp;?>
</div>
</div>
</div>
<!-- modals-end -->
</div><div class="kisb" id="balloon_parent_div_ab" style="visibility: hidden; position: absolute; left: 855px; top: 920px;"><div class="kl_abmenu">Add to Anti-Banner</div></div></body></html>