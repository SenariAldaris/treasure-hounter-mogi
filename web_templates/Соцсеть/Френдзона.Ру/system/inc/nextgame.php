<?php
if(!defined('MOZG'))
	die('Hacking attempt!');
require(ENGINE_DIR."/data/nextgame.config.php");
//Если сохраянем
if(isset($_POST['saveconf'])){
	$saves = $_POST['save'];

	$find[] = "'\r'";
	$replace[] = "";
	$find[] = "'\n'";
	$replace[] = "";
	
	$handler = fopen(ENGINE_DIR.'/data/nextgame.config.php', "w");
	fwrite($handler, "<?php \n\n//System Configurations\n\n\$nextgame = array (\n\n");

	foreach($saves as $name => $value ) {
	
		if($name != "message_invite"){
			$value = trim(stripslashes($value));
			$value = htmlspecialchars($value, ENT_QUOTES);
			$value = preg_replace($find, $replace, $value);
			
			$name = trim(stripslashes($name));
			$name = htmlspecialchars($name, ENT_QUOTES);
			$name = preg_replace($find, $replace, $name);
		}
		
		$value = str_replace("$", "&#036;", $value);
		$value = str_replace("{", "&#123;", $value);
		$value = str_replace("}", "&#125;", $value);
		
		$name = str_replace("$", "&#036;", $name);
		$name = str_replace("{", "&#123;", $name);
		$name = str_replace("}", "&#125;", $name);
		
		$value = $db->safesql($value);
		
		fwrite($handler, "'{$name}' => \"{$value}\",\n\n");
	}
	fwrite($handler, ");\n\n?>" );
	fclose($handler);
	
	msgbox('Настройки сохранены', 'Настройки конфигурации были успешно сохранены!', '?mod=nextgame');
} else {
	echoheader();
	echohtmlstart('Общие настройки');
 //site_player
	$for_select_site_player = installationSelected($nextgame['site_player'], '<option value="yes">Да</option><option value="no">Нет</option>'); 
  
 //open_type
	$for_select_open_type = installationSelected($nextgame['open_type'], '<option value="link">Ссылка в виде названия</option><option value="iframe">Фрейм 760 пикселей</option>');  
	echo <<<HTML
<style type="text/css" media="all">
.inpu{width:300px;}
textarea{width:300px;height:100px;}
</style>

<form method="POST" action="">

<div class="fllogall">Ключ API:</div><input type="text" name="save[api_key]" class="inpu" value="{$nextgame['api_key']}" /><div class="mgcler"></div>

<div class="fllogall">ID Площадки:</div><input type="text" name="save[site_id]" class="inpu" value="{$nextgame['site_id']}" /><div class="mgcler"></div>

<div class="fllogall">Период кэширования данных :</div><input type="text" name="save[cache_time]" class="inpu" value="{$nextgame['cache_time']}" /><div class="mgcler"></div>

<div class="fllogall">Игр на страницу :</div><input type="text" name="save[per_page]" class="inpu" value="{$nextgame['per_page']}" /><div class="mgcler"></div>

<div class="fllogall">Игр в блоке ("Новые игры") :</div><input type="text" name="save[num_new]" class="inpu" value="{$nextgame['num_new']}" /><div class="mgcler"></div>

<div class="fllogall">Значение маски ("Рекомендуемые игры") :</div><input type="text" name="save[mask_recomend]" class="inpu" value="{$nextgame['mask_recomend']}" /><div class="mgcler"></div>

<div class="fllogall">Игр в блоке ("Рекомендуемые игры") :</div><input type="text" name="save[num_recomend]" class="inpu" value="{$nextgame['num_recomend']}" /><div class="mgcler"></div>

<div class="fllogall">Играть используя учетную записью сайта  :</div><select name="save[site_player]" class="inpu" style="width:auto">{$for_select_site_player}</select><div class="mgcler"></div>

<div class="fllogall">Ссылка на API :</div><input type="text" name="save[api_url]" class="inpu" value="{$nextgame['api_url']}" /><div class="mgcler"></div>

<div class="fllogall">Тема ПС при отправки с игры:</div><input type="text" name="save[subj_pm]" class="inpu" value="{$nextgame['subj_pm']}" /><div class="mgcler"></div>

<div class="fllogall">Тема ПС при отправки приглашения в игру :</div><input type="text" name="save[subj_invite]" class="inpu" value="{$nextgame['subj_invite']}" /><div class="mgcler"></div>

<div class="fllogall">Сообщение ПС при отправки приглашения в игру :</div><textarea class="inpu" name="save[message_invite]">{$nextgame['message_invite']}</textarea>

<div class="fllogall">Запуск приложения  : :</div><select name="save[open_type]" class="inpu" style="width:auto">{$for_select_open_type}</select><div class="mgcler"></div>
HTML;

	echo <<<HTML

<div class="fllogall">&nbsp;</div><input type="submit" value="Сохранить" name="saveconf" class="inp" style="margin-top:0px" />

</form>
HTML;

	htmlclear();
	echohtmlend();
}
?>

