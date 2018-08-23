<?PHP
$_OPTIMIZATION["title"] = "Контакты";
$_OPTIMIZATION["description"] = "Связь с администрацией";
$_OPTIMIZATION["keywords"] = "Связь с администрацией проекта";
?>

<div class="block11
"><div class="h-title5
">Контакты</div></div>

<div class="block22">
<br>	
<?PHP

$db->Query("SELECT contacts FROM ".$pref."_conabrul WHERE id = '1'");
$xt = $db->FetchRow();
echo $xt;
?>

</div>
<div class="block33"></div>
<div class="clr"></div>	