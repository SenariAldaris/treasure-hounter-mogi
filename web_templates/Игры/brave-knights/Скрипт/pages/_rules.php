<?PHP
$_OPTIMIZATION["title"] = "�������";
$_OPTIMIZATION["description"] = "����� ������� �������";
$_OPTIMIZATION["keywords"] = "�������, ������� ������������, ������� �������";
?>
<div class="block11
"><div class="h-title5
">�������</div></div>
<div class="block22"><br>	
<?PHP

$db->Query("SELECT rules FROM ".$pref."_conabrul WHERE id = '1'");
$xt = $db->FetchRow();
echo $xt;
?>

</div>
<div class="block33"></div>
<div class="clr"></div>	