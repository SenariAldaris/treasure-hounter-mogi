<?php

define('ROOT_DIR', dirname (__FILE__));

define('ENGINE_DIR', ROOT_DIR.'/system');

@include ENGINE_DIR.'/data/config.php';

if(!$config['home_url']) die("TO Not installed");

header('Content-type: text/html; charset=utf-8');

?>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>

<script type="text/javascript" src="<?php echo $config['home_url']; ?>js/index.js"></script>

<style>

#pfm_radio{
	padding:10px;
	width: 180px;
}

#pfm_info{
	float: left;
	margin-top: -160px;
	color: #FFF;
	font-weight: bold;
	margin-left: 200px;
}

#pfm_text{
	font-size:25px;
}

.pfm_color_red{color:#D6E248;}

.pfm_color_red:hover{color:#C25930;}

a {text-decoration: none; color: #C25930;}

a:hover {text-decoration: none; color: #D6E248;}

</style>

<body>
<!--noindex--><div id="grattis_35498"><script type="text/javascript">
(function(){var func=function(){GRATTIS.section(35498)};
if(typeof GRATTIS==='undefined'){var s=document.createElement('script');
s.type='text/javascript';s.src='//cdn'+Math.round((Math.random() * 3) + 1)+'.grattis.ru/publicdata/code.js?r='+(Math.random()*1000|0);
var i=setInterval(function(){if(typeof GRATTIS!=='undefined'){func();clearInterval(i)}},100);
document.getElementsByTagName('head')[0].appendChild(s)
}else{func()}})();</script></div><!--/noindex-->

</body>

</html>