
<?
$_OPTIMIZATION["title"] = "Стена пользователя";
 $usname = $_SESSION["user"];
 $usid = $_SESSION["user_id"];
 $date = time();


 $db->Query("SELECT ava FROM db_users_a WHERE id = '$usid'");
 $ava = $db->FetchArray();
 $avva = $ava['ava'];

 if(isset($_GET['name'])) {
 $name = strip_tags(htmlspecialchars($db->RealEscape($_GET['name']), ENT_QUOTES, "cp1251"));
 $q = $db->Query("SELECT * FROM db_users_a WHERE user = '$name'");
 $us_inf = $db->FetchArray($q);
 $us = $us_inf['id'];
 $db->Query("SELECT * FROM db_users_b WHERE user = '$name'");
 $dat = $db->FetchArray();

 if(isset($_POST['comment'])) {
$type = intval($_POST['type']);

$com = strip_tags(htmlspecialchars($db->RealEscape($_POST['comment']), ENT_QUOTES, "cp1251"));//Фильтрация

$db->Query("SELECT * FROM db_wall WHERE user_id = '$us' AND login = '$usname'");
	if(!empty($com)) {
		if($type == 1 or $type == 2 or $type == 3) {
		if($usname != $name) {
		if($db->NumRows() <= 2) {
$db->Query("INSERT INTO db_wall (user_id, login, date, type, text, ava) VALUES ('$us', '$usname', '$date', '$type', '$com', '$avva')");
		$db->Query("UPDATE db_users_b SET en = en - 1 WHERE id = '$usid'");
		$ms = '<div class="success message">Отзыв успешно оставлен!</div>';
		header('Refresh: 1;URL=/account/wall/'.$name);
		}else echo "<div class='warning message'>Разрешено оставлять не более 3-х отзывов одному пользователю!</div>";
		}else echo "<div class='warning message'>Оставлять отзывы самому себе запрещено!</div>";
		}else echo "<div class='warning message'>Выберите тип отзыва.</div>";

	}else echo "<div class='error message'>Введите текст отзывы.</div>";
 }

 ?>
<?php
$voinov = $dat["a_t"] + $dat["b_t"] + $dat["c_t"] + $dat["d_t"] + $dat["e_t"] + $dat["f_t"];

$fabrick = $dat["k_t"] + $dat["l_t"] + $dat["m_t"] + $dat["n_t"] + $dat["o_t"] + $dat["p_t"] + $dat["r_t"] + $dat["q_t"] + $dat["s_t"] + $dat["t_t"];
?>
<div class="block1
"><div class="h-title1
">№<?=$us_inf['id']; ?> - <?=$name; ?></div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">


<table border="0">
<tbody>
<tr>
<td align="center" valign="center">
<div colspan="3"><img src="/img/fruit/dom.png" name="slide_show"></div>
</td>
<td valign="top">
<h3><span style="color: #754116; font-family: 'Comic Sans MS', cursive; font-size: 11pt;"> &nbsp; Это ваша домашняя страница. Здесь можно посмотреть и изменить личную информацию, написать письмо другу, отслеживать колличество ваших партнеров. </span></h3>
</td>
</tr>
</tbody>
</table>
<hr>

<?PHP
$user_id = $_SESSION["user_id"];
$db->Query("SELECT * FROM db_users_a, db_users_b WHERE db_users_a.id = db_users_b.id AND db_users_a.id = '$user_id'");
$data = $db->FetchArray();
?>

<table border='0' align="center">
<tr>
<td></td>
<?
if($us_inf['pol'] == 1) {$pol = 'Мужской';}elseif($us_inf['pol'] == 2) {$pol = 'Женский';}else{$pol = 'Средний ;)'; }

?>
<td style='border-top: 1px solid #98C1D7;border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Имя</b></center></td>
<td style='border-top: 1px solid #98C1D7;border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><?=$us_inf['name']; ?></center></td>
<td style='border-top: 1px solid #98C1D7;border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Пол</b></center></td>
<td style='border-top: 1px solid #98C1D7;border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;border-right: 1px solid #98C1D7;'><center><?=$pol; ?></center></td>
</tr>
<tr>
<td></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Псевдоним</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><?=$us_inf['user']; ?></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Уровень</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;border-right: 1px solid #98C1D7;'><center><a href="/top"><?php echo user_level::getInstance()->get_user_level($data['id']);?></a></center></td>
</tr>
<tr>
<td></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Партнёров</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><?=$us_inf['referals']; ?> чел.</center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Реферер</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;border-right: 1px solid #98C1D7;'><center><a href="<?=$us_inf['referer']; ?>"><?=$us_inf['referer']; ?></a></center></td>
</tr>
<tr>
<td></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Рыцарей</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><?=$voinov; ?> шт.</center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Построек</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;border-right: 1px solid #98C1D7;'><center><?=$fabrick; ?>  шт.</center></td>
</tr>
<tr>
<td></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Регистрация</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><?=date('d-m-Y', $us_inf['date_reg']); ?>г.</center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Заходил</b></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;border-right: 1px solid #98C1D7;'><center><?=date('d-m-Y', $us_inf['date_login']); ?>г.</center></td>
</tr>
<tr>
<td></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Ввел денег</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><?=$dat['insert_sum']; ?> руб.</center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Вывел денег</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;border-right: 1px solid #98C1D7;'><center><?=$dat['payment_sum']; ?> руб.</center></td>
</tr>
<tr>
<td></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Принес рефереру</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><?=$dat['to_referer']; ?> зол.</center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;'><center><b>Принесли партнеры</b></center></td>
<td style='border-bottom: 1px solid #98C1D7;border-left: 1px solid #98C1D7;border-right: 1px solid #98C1D7;'><center><?=$dat['from_referals']; ?> зол.</center></td>
</tr>
</table>



<script language="JavaScript">
function show(obj) {
if (document.getElementById(obj).style.display == 'none')
document.getElementById(obj).style.display = 'block';
else document.getElementById(obj).style.display = 'none';
}
</script>

<br>
<?


	$db->Query("SELECT * FROM ".$pref."_pm WHERE user_id_in = '$usid' AND status = 0 AND inbox = 1");
	$sk = $db->NumRows();
	if ($sk > 0) {$pmm = '<font color="red">('.$sk.')</font>';} else {$pmm = '<font color="red">(0)</font>';}

?>



<center><?=$ms; ?>
<table width="500px" align="center"><tr>
<td>
<span onclick="show('2')"><a onclick="return false"><button class="btn_9" type="button">Стена</button></a></span>
</td>
<td>
<span onclick="show('1')"><a onclick="return false"><button class="btn_9" type="button">Отзыв</button></a></span>
</td>

<td>
<a href="/account/pm"><button class="btn_9" type="button">Письма <?=$pmm; ?></button></a>
</td>
<td>
<a href="/account/config"><button class="btn_9" type="button">Настройки</button></a>
</td>
</tr></table>
<center><table width="130px" align="center"><tr>
<td>
<a href="/account/referals"><button class="btn_9" type="button">Партнеры</button></a>
</td></tr></table></center>
<br><br>

<span class="sub" id="1" style="display: none;">
<form method="post" action="">
<label>Тип отзыва</label>
<select name="type" size="1">
<option value="1" selected>Нейтральный</option>
<option value="2">Положительный</option>
<option value="3">Отрицательный</option>
</select>
<br>
<br>
<textarea name="comment" rows="5" cols="40"></textarea>
<br />
<input type="submit" class="btn_9" name="com_send" value="Добавить" />
</form>
За отзыв снимается 1 энергия.
<br>
<br>
</span>
</center>

<div class="acc-title">Отзывы</div>
<hr>
<?
$num_p = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"]) -1) : 0;
$lim = $num_p * 10;
$db->Query("SELECT * FROM db_wall WHERE user_id = '$us' ORDER BY id DESC LIMIT {$lim}, 10");

if($db->NumRows() > 0){

while($rt = $db->FetchArray()) {
$ll = $rt['login'];

if($rt['type'] == 1) {$type = '<font color="#5E6068">Нейтральный отзыв от</font>'; }elseif($rt['type'] == 2) {$type = '<font color="#008000">Положительный отзыв от</font>';} elseif($rt['type'] == 3) {$type = '<font color="#FF0000">Отрицательный отзыв от</font>';}
?>
<table width="100%"  border="0" align="center" cellspacing="0" class="ta">
<tr>

<td width="70px" style="margin: 5px;"><img align="top" width="70px" src="/<?=$rt['ava']; ?>" border="0"></td>
<td valign="top" class="nobdr">
	&nbsp;
<?=date('d-m-Y H:i', $rt['date']); ?>  <b><?=$type; ?></b>
<b><a href='/account/wall/<?=$rt['login']; ?>' target='_blank'><?=$rt['login']; ?></a></b>

<br>
<div style="margin: 9px;"><?=$rt['text']; ?></div>

</td>
</tr> </table>
<tr>
<td colspan="2"><hr></td>
</tr>
<? } ?>
<?PHP
}else echo "<center><b>Пользователю пока что ни кто не оставил отзыва.</b></center><BR />";
?>

<?PHP
$db->Query("SELECT COUNT(*) FROM db_wall WHERE user_id = '$us'");
$all_pages = $db->FetchRow();
	if($all_pages > 10){

	$nav = new navigator;
	$page = (isset($_GET["page"]) AND intval($_GET["page"]) < 1000 AND intval($_GET["page"]) >= 1) ? (intval($_GET["page"])) : 1;

	echo "<BR /><center>".$nav->Navigation(10, $page, ceil($all_pages / 10), "/?menu=account&sel=wall&name=".$name."&page="), "</center>";

	}
?>




<br>
<span class="sub" id="2" style="display: none;">
<table align="center">
<form method="post" action="/account/wall_serch">
<tr><td>Кого ищем? (логин)</td><td><input type="text" name="serch"></td></tr>
<tr align="center"><td colspan="2"><input type="submit" value="Найти" style="height: 30px;"class="btn_8"></td></tr>
<tr><td colspan="2"><hr></td></tr>
</form>
</table>
Стена пользователя, это уникальная возможность быстро связаться с пользователем, стать его рефералом если еще не зарегистрированы и наблюдать за его честностью на проекте.
Надеемся, что это поможет вам не прогадать с человеком и отблагодарить реферала на проекте положительным отзывчиком.<br>
Стоимость отправки комментария на стену любого учатсника не зависимо от его типа, всего 10 зол.</span>

<? } else {?>

<div class="silver-bk">
<div class="acc-title">Стена пользователя</div>

Стена пользователя, это уникальная возможность быстро связаться с пользователем, наблюдать за его честностью на проекте или просто посмотреть его достижения.
Надеемся, что это поможет вам найти новых друзей на проекте или отблагодарить реферала положительным отзывчиком.<br><br>
Стоимость отзыва на стене любого учатсника не зависимо от его типа, всего 1 ед. энергии.<br><br>

 <br>
</div>
<? } ?>
</div></div>
</div><div class="block3"></div>
