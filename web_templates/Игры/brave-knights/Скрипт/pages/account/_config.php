<?PHP
$_OPTIMIZATION["title"] = "���������";
$usid = $_SESSION["user_id"];
$db->Query("SELECT * FROM ".$pref."_users_a WHERE id = '$usid'");
$user_data = $db->FetchArray();
?>

<div class="block1
"><div class="h-title1
">���������</div></div>

<div class="block2">
<div class="some-content-related-div">
<div id="inner-content-div">
	
<?

if (isset($_FILES['file'])) {
    $f_err     = 0; //��������������� ����������
    $types     = array(
		'.jpg',
		'.JPG',
		'.jpeg',
		'.gif',
		'.png'
    ); //�������������� ������� ����������� ������
    $max_size  = 502050; //������������ ������ ������������ ����� (5000-��)
    $path      = 'avatar/'; //���������� ��� ��������
    $path_mini = 'avatar/'; //���������� ��� �������� ���������
    $fname     = $_FILES['file']['name'];
	//$fname = md5($fname);
    $ext       = substr($fname, strpos($fname, '.'), strlen($fname) - 1); //���������� ��� ������������ �����

    //�������� �� ������������ �������
    if (!in_array($ext, $types)) {
        $f_err++;
        $mess = '<center><p style="color:red;">����������� ���� �� �������� ���������</p></center>';
    }

    //�������� ������� �����
    if (filesize($_FILES['file']['tmp_name']) > $max_size) {
        $f_err++;
        $mess = '<center><p style="color:red;">������ ����������� �������� ��������� 5 Mb</p></center>';
    }

    //���� ���� ������� ������ ��������
    //���������� ��� � �������� ���������� �� ���������
    if ($f_err == 0) {
        move_uploaded_file($_FILES['file']['tmp_name'], $path . $fname);

        //���� � ������������ �����
        $source_src = $path . $fname;

        //������� ���� � ��� ���������
        $new_name     = md5($fname) . $ext;
        $resource_src = $path_mini . $new_name;

        //�������� ��������� ������������ �����
        $params = getimagesize($source_src);

        switch ($params[2]) {
            case 1:
                $source = imagecreatefromgif($source_src);
                break;
            case 2:
                $source = imagecreatefromjpeg($source_src);
                break;
        }

        //���� ������ ������ ������
        //��������� ����� ������
        if ($params[1] > $params[0]) {
            $newheight = 150;
            $newwidth  = floor($newheight * $params[0] / $params[1]);
        }
        //���� ������ ������ ������
        //��������� ����� ������
        if ($params[1] < $params[0]) {
            $newwidth  = 150;
            $newheight = floor($newwidth * $params[1] / $params[0]);
        }

//���� ��� �����
        //��������� ����� ������
        if ($params[1] = $params[0]) {
            $newwidth  = 150;
    $newheight = 150;
            $newheight = floor($newwidth * $params[1] / $params[0]);
   $newwidth  = floor($newheight * $params[0] / $params[1]);
        }

        //������� ��������� ������������ �����������
        $resource = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($resource, $source, 0, 0, 0, 0, $newwidth, $newheight, $params[0], $params[1]);
        imagejpeg($resource, $resource_src, 80); //80 �������� �����������

        //��������� ����� �������
        chmod("$source_src", 0644);
        chmod("$resource_src", 0644);

        //������� ���������
        $mess = '<center><br><p style="color:green;">����������� ��������� !</p></center>';
        $ok   = 1;
    }

//include("session.inc.php");
$file = str_replace($server['DOCUMENT_ROOT'], '/', $path_mini . $new_name); // �������� ���� ���� '/img/avatars/15.jpg'
//mysql_query("UPDATE members SET avatar='$file' WHERE id='$userid';"); //���������� � ��.
$db->Query("UPDATE ".$pref."_users_a SET ava = '$file' WHERE id = '$usid'");

header('Refresh: 1;URL=/account/config/');


}



if(empty($user_data['ava'])) {
echo '<center><img src="/img/c50.gif"></center>';
}else{
echo '<center><img src="/'.$user_data['ava'].'"></center>';
}
?>


<center><b>��������� �������</b></center>
<BR />
<?PHP
	if(isset($_POST["name"])){
	
		$name = $db->RealEscape($_POST['name']);
		$pol = intval($_POST['pol']);
		$db->Query("UPDATE ".$pref."_users_a SET name = '$name', pol = '$pol' WHERE id = '$usid'");
	
		echo "<center><font color = 'green'><b>������ ���������</b></font></center><BR />";
	}
?>


<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td><b>���:</b></td>
    <td align="center"><input type="text" name="name" value="<?=$user_data['name']; ?>"/></td>
  </tr>
  <tr>
    <td><b>���:</b></td>
    <td align="center"><select name="pol">
	<option value="1">���
	<option value="2">���
	</select></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="���������" class="btn_8"/></td>
  </tr>
</table>
</form>
<hr>
<center><br><h3>�������� �������</h3></center>
<!--����� ���������--><?= $mess ?>
<center>(�� ����� 150*150px)<br>     
<p><form method="POST"  enctype="multipart/form-data" name="form33">
<table id="upload1" ><tr><td>
</td> <td><span class="psevdoFile"><input id="psevdoFileValue" class="inputFileText" value="�������� ����" style="color:#828282;" type="text"/>
    <input class="fileInput" type="file" size="1" onchange="document.getElementById('psevdoFileValue').value = this.value" name="file"/>
    </span></td></tr></tr>
</table>

<table>
<tr><td><br><input type='submit' name='submit' class="btn_8" value='���������'></a></td></tr>
</table></form></p>
</center>

<hr>

<center><b>��������� ��������</b></center>
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
						
						echo "<center><font color = 'green'><b>������� ����������</b></font></center><BR />";
					
					}else echo "<center><font color = 'red'><b>�� ��� �������� �������!</b></font></center><BR />";
				}else echo "<center><font color = 'red'><b>������ ������� ��� ���������������</b></font></center><BR />";
			}else echo "<center><font color = 'red'><b>������� ����� �� ������ ������</b></font></center><BR />";
		
	}
?>


<form action="" method="post">
<table width="530" border="0" align="center">
  <tr>
    <td><b>������� Payeer.com (P1234567):</b></td>
    <td align="center"><input type="text" name="purse" value="<?=$user_data['purse']; ?>" /></td>
  </tr>
  
  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="���������" class="btn_8"/></td>
  </tr>
</table>
</form>

<hr>

<center><b>����� ������</b></center>
<BR />
<?PHP
	if(isset($_POST["old"])){
	
	
		$old = $func->md5Password($_POST["old"]);
		$new = $func->md5Password($_POST["new"]);
		
			if($old !== false AND strtolower($old) == strtolower($user_data["pass"])){
			
				if($new !== false){
				
					if( strtolower($new) == strtolower($func->md5Password($_POST["re_new"]))){
					
						$db->Query("UPDATE ".$pref."_users_a SET pass = '$new' WHERE id = '$usid'");
						
						echo "<center><font color = 'green'><b>����� ������ ������� ����������</b></font></center><BR />";
					
					}else echo "<center><font color = 'red'><b>������ � ������ ������ �� ���������</b></font></center><BR />";
				
				}else echo "<center><font color = 'red'><b>����� ������ ����� �������� ������</b></font></center><BR />";
			
			}else echo "<center><font color = 'red'><b>������ ������ �������� �������</b></font></center><BR />";
		
	}
?>


<form action="" method="post">
<table width="330" border="0" align="center">
  <tr>
    <td><b>������ ������:</b></td>
    <td align="center"><input type="password" name="old" /></td>
  </tr>
  <tr>
    <td><b>����� ������:</b></td>
    <td align="center"><input type="password" name="new" /></td>
  </tr>
  <tr>
    <td><b>������ ������:</b></td>
    <td align="center"><input type="password" name="re_new" /></td>
  </tr>
  <tr>
    <td align="center" colspan="2"><BR /><input type="submit" value="������� ������" class="btn_8"/></td>
  </tr>
</table>
</form>
���� ������ ������ ����� �� 6 �� 20 �������� (������ ����. �������)

</div></div></div>
<div class="block3"></div>
<div class="clr"></div>	