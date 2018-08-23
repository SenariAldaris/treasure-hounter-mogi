<?PHP
$_OPTIMIZATION["title"] = "Правила";
$_OPTIMIZATION["description"] = "Общие правила проекта";
$_OPTIMIZATION["keywords"] = "Правила, помятка пользователя, правила проекта";
?>
<div class="block11
"><div class="h-title5
">Правила</div></div>
<div class="block22"><br>	
<?PHP

$db->Query("SELECT rules FROM ".$pref."_conabrul WHERE id = '1'");
$xt = $db->FetchRow();
echo $xt;
?>

</div>
<div class="block33"></div>
<div class="clr"></div>	