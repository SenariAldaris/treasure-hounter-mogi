<div class="block1
"><div class="h-title1
">���������� �������</div></div>

<div class="block2">	
<BR />
<?PHP
$_OPTIMIZATION["title"] = "������� - ���������� �������";
$usid = $_SESSION["user_id"];
$usname = $_SESSION["user"];

$db->Query("SELECT * FROM ".$pref."_config WHERE id = '1' LIMIT 1");
$sonfig_site = $db->FetchArray();
?>

<center>
<span style="color: #914A1F; font-family: 'Comic Sans MS', cursive; font-size: 13pt;text-shadow: #000 0 1px 1px;"><strong><font color = "#000">�����:</font> ��� ������ ���������� ������� +50% � �������.</strong></span>
<br>
<font color=orange> <img title='Free Kassa' src='/img/Freekassa1.gif'></font>
<br>
</center>
<center>���� ������� ������: 1 ����� (<?=$config->VAL; ?>) = <?=$sonfig_site["ser_per_wmr"]; ?> �������.
<p>���� �������  � ������� ��������� ��������� 
������: Yandex ������, ���������� ����, SMS, ����������, �������� ��������� � �.�.</p>
<p>������ � ���������� ������� �� ������ ������������ � �������������� ������.</p> 
<p>������� ����� � ������, ������� �� ������ ��������� �� ������. <BR />
����� ���������� ��� ����� ���������� �������.<br /></p>


<?

$fk_merchant_id = '22202'; //merchant_id ID �������� � free-kassa.ru http://free-kassa.ru/merchant/cabinet/help/
$fk_merchant_key = 'z46j38fr'; //��������� ����� http://free-kassa.ru/merchant/cabinet/profile/tech.php


?>
<script type="text/javascript">
var min = 1;
var ser_pr = 100;
function calculate(st_q) {
    
	var sum_insert = parseInt(st_q);
	$('#res_sum').html( (sum_insert * ser_pr) );
	
	var re = /[^0-9\.]/gi;
    var url = window.location.href;
    var desc = '<?=$usid;?>';
    var sum = $('#sum').val();
    if (re.test(sum)) {
        sum = sum.replace(re, '');
        $('#oa').val(sum);
    }
    if (sum < min) {
        $('#error').html('����� ������ ���� ������ '+min);
		$('#submit').attr("disabled", "disabled");
        return false;
    } else {
        $('#error').html('');
    }

    $.get('/free-kassa-data.php?prepare_once=1&l='+desc+'&oa='+sum, function(data) {
         var re_anwer = /<hash>([0-9a-z]+)<\/hash>/gi;
         $('#s').val(re_anwer.exec(data)[1]);
         $('#submit').removeAttr("disabled");
    });
}
	
</script>

<div id="error3"></div>
<form method=GET action="http://www.free-kassa.ru/merchant/cash.php">
    <input type="hidden" name="m" value="<?=$fk_merchant_id?>">
������� ����� [<?=$config->VAL; ?>]:  <input type="text" name="oa" id="sum" value="100" size="7" id="oa" onchange="calculate(this.value)" onkeyup="calculate(this.value)" onfocusout="calculate(this.value)" onactivate="calculate(this.value)" ondeactivate="calculate(this.value)"> 
    <input type="hidden" name="s" id="s" value="0"> �� �������� <span id="res_sum">100</span> �������
	<input type="hidden" name="us_id" id="us_id" value="<?=$usid;?>">
    <br>
    <input type="hidden" name="o" id="desc" value="<?=$usid;?>" />
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" id="submit" value="���������" class="btn_8">
</form>
<script type="text/javascript">
calculate(100);
</script></center>



</div>
<div class="block3"></div>
<div class="clr"></div>		


