<?PHP
$_OPTIMIZATION["title"] = "Новости";
$_OPTIMIZATION["description"] = "Новости проекта";
$_OPTIMIZATION["keywords"] = "Новости нашего проекта";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];
 $date = time();
$db->Query("SELECT * FROM ".$pref."_users_b WHERE id = '$usid' LIMIT 1");
$user_data = $db->FetchArray();
?>
<div class="block11
"><div class="h-title5
">Новости</div></div>

<div class="block22">
<br>
<?
############### Новость + комменты
if (isset($_GET['id'])) {

$eid = intval($_GET["id"]);

$db->Query("SELECT * FROM ".$pref."_news WHERE id = '$eid' LIMIT 1");

# Проверяем на существование
if($db->NumRows() != 1){ echo "<center><b>Указанная новость не найдена</b></center><BR />"; }
$newcom = $db->FetchArray();
?>


<table width="96%" border="0" align="center" class="ta" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left"><h3><?=$newcom["title"]; ?></h3></td>
    <td align="right"><strong><?=date("d.m.Y",$newcom["date_add"]); ?></strong></td>
  </tr>

  <tr>
    <td colspan="2"><?=$newcom["news"]; ?></td>
  </tr>
</table>
<div style="margin-top:10px;"> </div>
<center><font color="green" size="+1"><b>Комментарии:</b></font></center>
<div style="margin-top:20px;"> </div>

<script language="JavaScript">
function show(obj) {
if (document.getElementById(obj).style.display == 'none')
document.getElementById(obj).style.display = 'block';
else document.getElementById(obj).style.display = 'none';
}
</script>

<?php
if(!isset($_SESSION["user"])) {
	echo '';
} else {?>

<center>
<span onclick="show('1')"><a onclick="return false"><button class="btn" type="button">Оставить комментарий к данной новости</button></a></span><br />
</center><br />
<span class="sub" id="1" style="display: none;">
<?php
if(isset($_POST['comment'])) {

$com = strip_tags(htmlspecialchars($db->RealEscape($_POST['comment']), ENT_QUOTES, "cp1251"));//Фильтрация


$db->Query("SELECT * FROM ".$pref."_news_com WHERE user_id = '$usid' AND news_id='$eid'");
	if(!empty($com)) {
	$en = 10;
	if($en <= $user_data["money_b"]){
		if($db->NumRows() <= 0) {
$db->Query("INSERT INTO ".$pref."_news_com (user_id, login, date, text, news_id) VALUES ('$usid', '$usname', '$date', '$com', '$eid')");
		$db->Query("UPDATE ".$pref."_users_b SET money_b = money_b - 10 WHERE id = '$usid'");
		$ms = '<center><font color="#914A1F">Комментарий успешно оставлен!</font></center>';

		}else echo "<center><font color='red'>Разрешено оставлять только 1 комментарий!</font></center>";
		}else echo "<center><font color='red'>Недостаточно средств.</font></center>";
	}else echo "<center><font color='red'>Введите текст комментария.</font></center>";
 }
?>
<table class="ta" width="60%" align="center"><tr><td>
<form method="post" action="">
<label><b><center>Введите текст комментария (~ 150 символов)</b></center></label>
<br>
<textarea name="comment" rows="5" cols="40"></textarea>
<br /><center>
<input type="submit" class="btn" name="com_send" value="Добавить комментарий" /></center>
</form></td></tr>
<tr><td><center>За комментарий снимается 10 серебра.</center></td></tr>
</table>
<br><br>
</span>

<?php
}


//Delete Otziv
if(isset($_POST["delotz"]) AND isset($_POST["del_id"]))
{
	$idd = intval($_POST["del_id"]);
	if($usid == 1)
	{
		$db->Query("DELETE FROM ".$pref."_news_com WHERE news_id = '$eid' AND user_id = '$idd'");
		echo('<center>Комментарий успешно удалён!</center>');
	}
}



$db->Query("SELECT * FROM ".$pref."_news_com WHERE news_id = '$eid'");
if($db->NumRows() > 0) {

$num = 15;
$page = $_GET['page'];
$result00 = $db->Query("SELECT COUNT(*) FROM ".$pref."_news_com WHERE news_id = '$eid'");
$temp = $db->FetchArray($result00);
$posts = $temp[0];
$total = (($posts - 1) / $num) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num - $num;

$db->Query("SELECT * FROM ".$pref."_news_com WHERE news_id = '$eid' ORDER BY id DESC LIMIT $start, $num");

while($otziv = $db->FetchArray()) {
?>
<table width="550px" border="0" align="center" cellspacing="0" class="ta">
<tr>
<td valign="top" class="nobdr">
	&nbsp;
<?=date('d-m-Y H:i', $otziv['date']); ?> комментарий от
<b><a href='/account/wall/<?=$otziv['login']; ?>' target='_blank'><?=$otziv['login']; ?></a></b>
<br>
<div style="margin: 9px;"><?=$otziv['text']; ?></div>
<?php
$by_user_id = $otziv['user_id'];
if($usid == 1) { ?>
			<form action="" method="post">
			<input type="hidden" name="del_id" value="<?=$by_user_id;?>">
			<input type="submit" name="delotz" class="btn" value="Удалить" />
			</form>
	<?	}  ?>
</td>
</tr>
</table>
<tr>
<td colspan="2"><hr align="center" width="65%" color="green"></td>
</tr>



<?php
}
// Проверяем нужны ли стрелки назад
if ($page != 1) $pervpage = '<a href=?menu=news&id='.$eid.'&page=1>Первая</a> | <a href=?menu=news&id='.$eid.'&page='. ($page - 1) .'>Предыдущая</a> | ';
// Проверяем нужны ли стрелки вперед
if ($page != $total) $nextpage = ' | <a href=?menu=news&id='.$eid.'&page='. ($page + 1) .'>Следующая</a> | <a href=?menu=news&id='.$eid.'&page=' .$total. '>Последняя</a>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 5 > 0) $page5left = ' <a href=?menu=news&id='.$eid.'&page='. ($page - 5) .'>'. ($page - 5) .'</a> | ';
if($page - 4 > 0) $page4left = ' <a href=?menu=news&id='.$eid.'&page='. ($page - 4) .'>'. ($page - 4) .'</a> | ';
if($page - 3 > 0) $page3left = ' <a href=?menu=news&id='.$eid.'&page='. ($page - 3) .'>'. ($page - 3) .'</a> | ';
if($page - 2 > 0) $page2left = ' <a href=?menu=news&id='.$eid.'&page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
if($page - 1 > 0) $page1left = '<a href=?menu=news&id='.$eid.'&page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';

if($page + 5 <= $total) $page5right = ' | <a href=?menu=news&id='.$eid.'&page='. ($page + 5) .'>'. ($page + 5) .'</a>';
if($page + 4 <= $total) $page4right = ' | <a href=?menu=news&id='.$eid.'&page='. ($page + 4) .'>'. ($page + 4) .'</a>';
if($page + 3 <= $total) $page3right = ' | <a href=?menu=news&id='.$eid.'&page='. ($page + 3) .'>'. ($page + 3) .'</a>';
if($page + 2 <= $total) $page2right = ' | <a href=?menu=news&id='.$eid.'&page='. ($page + 2) .'>'. ($page + 2) .'</a>';
if($page + 1 <= $total) $page1right = ' | <a href=?menu=news&id='.$eid.'&page='. ($page + 1) .'>'. ($page + 1) .'</a>';

// Вывод меню если страниц больше одной

if ($total > 1)
{
echo "<div class=\"pstrnav\">";
echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
echo "</div>";
}
} else {
echo '<tr><td align="center" colspan="6"><font color="#914A1F" size="+1"><center><b>Комментариев еще не было!</b></center></font></td></tr><br />';
}
?>

</div>
<div class="block33"></div>
<div class="clr"></div>

<?PHP
return;
}

$db->Query("SELECT * FROM ".$pref."_news");
if($db->NumRows() > 0) {

######### Список всех новостей
$num2 = 10;
$page = $_GET['page'];
$result00 = $db->Query("SELECT COUNT(`id`) FROM ".$pref."_news");
$temp = $db->FetchArray($result00);
$posts = $temp[0];
$total = (($posts - 1) / $num2) + 1;
$total =  intval($total);
$page = intval($page);
if(empty($page) or $page < 0) $page = 1;
if($page > $total) $page = $total;
$start = $page * $num2 - $num2;

$db->Query("SELECT * FROM ".$pref."_news ORDER BY id DESC LIMIT $start, $num2");



while($news = $db->FetchArray()) {

	?>


<table width="96%" border="0" align="center" class="ta" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left"><h3><?=$news["title"]; ?></h3></td>
    <td align="right"><strong><?=date("d.m.Y",$news["date_add"]); ?></strong></td>
  </tr>

  <tr>
    <td colspan="2"><?=$news["news"]; ?></td>
  </tr>
  <tr>
    <td colspan="2"><a href="/?menu=news&id=<?=$news["id"];?>&page=1">Комментарии >></a></td>
  </tr>


</table>


<BR />

<?PHP

}

// Проверяем нужны ли стрелки назад
if ($page != 1) $pervpage = '<a href=/?menu=news&page=1>Первая</a> | <a href=/?menu=news&page='. ($page - 1) .'>Предыдущая</a> | ';
// Проверяем нужны ли стрелки вперед
if ($page != $total) $nextpage = ' | <a href=/?menu=news&page='. ($page + 1) .'>Следующая</a> | <a href=/?menu=news&page=' .$total. '>Последняя</a>';

// Находим две ближайшие станицы с обоих краев, если они есть
if($page - 5 > 0) $page5left = ' <a href=/?menu=news&page='. ($page - 5) .'>'. ($page - 5) .'</a> | ';
if($page - 4 > 0) $page4left = ' <a href=/?menu=news&page='. ($page - 4) .'>'. ($page - 4) .'</a> | ';
if($page - 3 > 0) $page3left = ' <a href=/?menu=news&page='. ($page - 3) .'>'. ($page - 3) .'</a> | ';
if($page - 2 > 0) $page2left = ' <a href=/?menu=news&page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
if($page - 1 > 0) $page1left = '<a href=/?menu=news&page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';

if($page + 5 <= $total) $page5right = ' | <a href=/?menu=news&page='. ($page + 5) .'>'. ($page + 5) .'</a>';
if($page + 4 <= $total) $page4right = ' | <a href=/?menu=news&page='. ($page + 4) .'>'. ($page + 4) .'</a>';
if($page + 3 <= $total) $page3right = ' | <a href=/?menu=news&page='. ($page + 3) .'>'. ($page + 3) .'</a>';
if($page + 2 <= $total) $page2right = ' | <a href=/?menu=news&page='. ($page + 2) .'>'. ($page + 2) .'</a>';
if($page + 1 <= $total) $page1right = ' | <a href=/?menu=news&page='. ($page + 1) .'>'. ($page + 1) .'</a>';

// Вывод меню если страниц больше одной

if ($total > 1)
{
echo "<div class=\"pstrnav\">";
echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$page3right.$page4right.$page5right.$nextpage;
echo "</div>";
}

}else echo "<center>Новостей нет :(</center>";
?>


</div>
<div class="block33"></div>
<div class="clr"></div>