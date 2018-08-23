<?
$name = htmlspecialchars($_POST['serch']);
?>
<div class="block1
"><div class="h-title1
">Пользователь # - <?=$name; ?></div></div>

<div class="block2">	
<center>Поиск...</center>
<?
header('Refresh: 2;URL=/account/wall/'.$name);
?>
</div>
<div class="block3"></div>
<div class="clr"></div>	