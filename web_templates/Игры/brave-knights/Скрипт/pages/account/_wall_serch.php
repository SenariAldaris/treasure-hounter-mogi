<?
$name = htmlspecialchars($_POST['serch']);
?>
<div class="block1
"><div class="h-title1
">������������ # - <?=$name; ?></div></div>

<div class="block2">	
<center>�����...</center>
<?
header('Refresh: 2;URL=/account/wall/'.$name);
?>
</div>
<div class="block3"></div>
<div class="clr"></div>	