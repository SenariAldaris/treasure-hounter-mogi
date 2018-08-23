<div class="s-bk-lf">
	<div class="acc-title">Аукцион фруктов</div>
</div>

<div class="silver-bk"><div class="clr"></div>	
Обращаем Ваше внимание, что в аукционе одновременно принимать участие может только один лот! Не создавайте больше одного лота. Дождитесь завершения первого!<br><br>
Выберите фрукт, который хотите продавать: <br>
<form action="" method="post">
<select name="fruit">
		<option value="a_t">Лайм</option>
		<option value="b_t">Вишня</option>
		<option value="c_t">Клубника</option>
		<option value="d_t">Киви</option>
		<option value="e_t">Апельсин</option>
</select>
<br><br>
Укажите желаемую стоимость, продаваемого фрукта (серебро): <br>
<input type="text" name="pay" value="99" style="width: 30%;"/>
<br><br>
Укажите шаг между торгами <br>(на какую сумму будет увеличиваться стоимость фрукта, после бронирования<br> Эта же сумма будет отниматься у пользователя, который забронировал фрукт):<br>
<input type="text" name="shag" value="5" style="width: 30%;"/>
<br><br>
Укажите период проведения торгов: <br>
<select name="period">
		<option value="1">1 час</option>
		<option value="3">3 часа</option>
		<option value="6">6 часов</option>
		<option value="12">12 часов</option>
		<option value="24">24 часа</option>
</select>
<br><br>
<input type="submit" name="save" value="Добавить" style="height: 30px; margin-top:10px;" />
</form>
<?php
$date_add = time();
if(isset($_POST['save'])) {
$db->Query("SELECT * FROM wmrush_torg");
if($db->NumRows() < 1){
	if (intval($_POST['pay']) > 0 ){
	if (intval($_POST['shag']) > 0 ){
		$fruit = $_POST['fruit'];
		$period = $_POST['period'];
		$pay = $_POST['pay'];
		$shag = $_POST['shag'];
		$date_del = time() + 60 * 60 * $period;
		echo "Запись добавлена в торги";
		
		$db->Query("INSERT INTO `wmrush_torg`(`fruit`,`pay`,`date_add`,`shag`,`date_del`) VALUES ('$fruit','$pay','".time()."','$shag','$date_del')");
	} else echo "Неверно введен шаг";
	} else echo "<br><br>Неверно введена стоимость<br>";
}else echo "Дождитесь завершения лота!";
}
?>


</div><div class='clr'></div>
