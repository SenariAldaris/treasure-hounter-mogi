<?PHP
$_OPTIMIZATION["title"] = "Настройки";
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM ".$pref."_users_a WHERE id = '$usid'");
$user_data = $db->FetchArray();
?>

<div class="block1
"><div class="h-title1
">Настройки</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
	
<?

if (isset($_FILES['file'])) {
    $f_err     = 0; //вспомогательная переменная
    $types     = array(
		'.jpg',
		'.JPG',
		'.jpeg',
		'.gif',
		'.png'
    ); //поддерживаемые форматы загружаемых файлов
    $max_size  = 502050; //максимальный размер загружаемого файла (5000-МБ)
    $path      = 'avatar/'; //директория для загрузки
    $path_mini = 'avatar/'; //директория для загрузки миниатюры
    $fname     = $_FILES['file']['name'];
	//$fname = md5($fname);
    $ext       = substr($fname, strpos($fname, '.'), strlen($fname) - 1); //определяем тип загружаемого файла

    //проверка на соответствие формата
    if (!in_array($ext, $types)) {
        $f_err++;
        $mess = '<center><p style="color:red;">Загружаемый файл не является картинкой</p></center>';
    }

    //проверка размера файла
    if (filesize($_FILES['file']['tmp_name']) > $max_size) {
        $f_err++;
        $mess = '<center><p style="color:red;">Размер загружаемой картинки превышает 5 Mb</p></center>';
    }

    //если файл успешно прошел проверку
    //перемещаем его в заданную директорию из временной
    if ($f_err == 0) {
        move_uploaded_file($_FILES['file']['tmp_name'], $path . $fname);

        //путь к загруженному файлу
        $source_src = $path . $fname;

        //создаем путь и имя миниатюры
        $new_name     = md5($fname) . $ext;
        $resource_src = $path_mini . $new_name;

        //получаем параметры загруженного файла
        $params = getimagesize($source_src);

        switch ($params[2]) {
            case 1:
                $source = imagecreatefromgif($source_src);
                break;
            case 2:
                $source = imagecreatefromjpeg($source_src);
                break;
        }

        //если высота больше ширины
        //вычисляем новую ширину
        if ($params[1] > $params[0]) {
            $newheight = 150;
            $newwidth  = floor($newheight * $params[0] / $params[1]);
        }
        //если ширина больше высоты
        //вычисляем новую высоту
        if ($params[1] < $params[0]) {
            $newwidth  = 150;
            $newheight = floor($newwidth * $params[1] / $params[0]);
        }

//если они равны
        //вычисляем новую высоту
        if ($params[1] = $params[0]) {
            $newwidth  = 150;
    $newheight = 150;
            $newheight = floor($newwidth * $params[1] / $params[0]);
   $newwidth  = floor($newheight * $params[0] / $params[1]);
        }

        //создаем миниатюру загруженного изображения
        $resource = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($resource, $source, 0, 0, 0, 0, $newwidth, $newheight, $params[0], $params[1]);
        imagejpeg($resource, $resource_src, 80); //80 качество изображения

        //назначаем права доступа
        chmod("$source_src", 0644);
        chmod("$resource_src", 0644);

        //выводим сообщение
        $mess = '<center><br><p style="color:green;">Изображение загружено !</p></center>';
        $ok   = 1;
    }

//include("session.inc.php");
$file = str_replace($server['DOCUMENT_ROOT'], '/', $path_mini . $new_name); // получить путь вида '/img/avatars/15.jpg'
//mysql_query("UPDATE members SET avatar='$file' WHERE id='$userid';"); //Добавление в БД.
$db->Query("UPDATE ".$pref."_users_a SET ava = '$file' WHERE id = '$usid'");

header('Refresh: 1;URL=/account/config/');


}



if(empty($user_data['ava'])) {
echo '<center><img src="/img/c50.gif"></center>';
}else{
echo '<center><img src="/'.$user_data['ava'].'"></center>';
}
?>


<center><b>Настройки профиля</b></center>
<BR />
<?PHP
	if(isset($_POST["name"])){
	
		$name = $db->RealEscape($_POST['name']);
		$pol = intval($_POST['pol']);
		$db->Query("UPDATE ".$pref."_users_a SET name = '$name', pol = '$pol' WHERE id = '$usid'");
	
		echo "<center><font color = 'green'><b>Данные сохранены</b></font></center><BR />";
	}
?>


<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td><b>Имя:</b></td>
    <td align="center"><input type="text" name="name" value="<?=$user_data['name']; ?>"/></td>
  </tr>
  <tr>
    <td><b>Пол:</b></td>
    <td align="center"><select name="pol">
	<option value="1">Муж
	<option value="2">Жен
	</select></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="Сохранить" class="btn_8"/></td>
  </tr>
</table>
</form>
<hr>
<center><br><h3>Загрузка аватара</h3></center>
<!--вывод сообщений--><?= $mess ?>
<center>(Не более 150*150px)<br>     
<p><form method="POST"  enctype="multipart/form-data" name="form33">
<table id="upload1" ><tr><td>
</td> <td><span class="psevdoFile"><input id="psevdoFileValue" class="inputFileText" value="выберете файл" style="color:#828282;" type="text"/>
    <input class="fileInput" type="file" size="1" onchange="document.getElementById('psevdoFileValue').value = this.value" name="file"/>
    </span></td></tr></tr>
</table>

<table>
<tr><td><br><input type='submit' name='submit' class="btn_8" value='Загрузить'></a></td></tr>
</table></form></p>
</center>

<hr>

<center><b>Установка кошелька</b></center>
<BR />
<?PHP
	if(isset($_POST["purse"])){
	$purse = $func->ViewPurse($_POST["purse"]);
	$db->Query("SELECT purse FROM ".$pref."_users_a WHERE purse = '$purse'");
	$pr = $db->NumRows();
	
	$db->Query("SELECT purse FROM ".$pref."_users_a WHERE id = '$usid'");
	$prr = $db->FetchArray();
	
		
		
		
			if($purse !== false){
				if($pr == 0) {
					if(empty($prr['purse'])) {
			
					
						$db->Query("UPDATE ".$pref."_users_a SET purse = '$purse' WHERE id = '$usid'");
						
						echo "<center><font color = 'green'><b>Кошелек установлен</b></font></center><BR />";
					
					}else echo "<center><font color = 'red'><b>Вы уже изменяли кошелек!</b></font></center><BR />";
				}else echo "<center><font color = 'red'><b>Данный кошелек уже зарегистрирован</b></font></center><BR />";
			}else echo "<center><font color = 'red'><b>Кошелек имеет не верный формат</b></font></center><BR />";
		
	}
?>


<form action="" method="post">
<table width="530" border="0" align="center">
  <tr>
    <td><b>Кошелек Payeer.com (P1234567):</b></td>
    <td align="center"><input type="text" name="purse" value="<?=$user_data['purse']; ?>" /></td>
  </tr>
  
  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="Сохранить" class="btn_8"/></td>
  </tr>
</table>
</form>

<hr>

<center><b>Смена пароля</b></center>
<BR />
<?PHP
	if(isset($_POST["old"])){
	
	
		$old = $func->md5Password($_POST["old"]);
		$new = $func->md5Password($_POST["new"]);
		
			if($old !== false AND strtolower($old) == strtolower($user_data["pass"])){
			
				if($new !== false){
				
					if( strtolower($new) == strtolower($func->md5Password($_POST["re_new"]))){
					
						$db->Query("UPDATE ".$pref."_users_a SET pass = '$new' WHERE id = '$usid'");
						
						echo "<center><font color = 'green'><b>Новый пароль успешно установлен</b></font></center><BR />";
					
					}else echo "<center><font color = 'red'><b>Пароль и повтор пароля не совпадают</b></font></center><BR />";
				
				}else echo "<center><font color = 'red'><b>Новый пароль имеет неверный формат</b></font></center><BR />";
			
			}else echo "<center><font color = 'red'><b>Старый паполь заполнен неверно</b></font></center><BR />";
		
	}
?>


<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td><b>Старый пароль:</b></td>
    <td align="center"><input type="password" name="old" /></td>
  </tr>
  <tr>
    <td><b>Новый пароль:</b></td>
    <td align="center"><input type="password" name="new" /></td>
  </tr>
  <tr>
    <td><b>Повтор пароля:</b></td>
    <td align="center"><input type="password" name="re_new" /></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="Сменить пароль" class="btn_8"/></td>
  </tr>
</table>
</form>
Поле Пароль должно иметь от 6 до 20 символов (только англ. символы)

</div></div></div>
<div class="block3"></div>
<div class="clr"></div>	