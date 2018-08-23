<?
$time = time() - (60*60*24*29);
$pen = time() - (60*60*24);
$db->Query("SELECT * FROM db_users_b WHERE credit > 0 AND date_add <= '$time' AND date_peny <= '$pen'");
if($db->NumRows() > 0) {
while($cr = $db->FetchArray()) {
$tt = $time - $cr['date_add'];
$ttt = $tt / (60*60*24);
if($ttt > 30) {
$mon = $cr['credit_only'] * 0.1;
$date_peny = time() + (60*60*24);

$db->Query("UPDATE db_users_b SET credit = credit + '$mon', date_peny = '$date_peny' WHERE id = '".$cr['id']."'");
}
}
}else echo 'Нет записей';
?>