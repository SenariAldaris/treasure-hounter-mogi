<?php
$db_host	  = 'localhost';
$db_user	  = 'root';
$db_pass      = 'K4zYqueX28T2pzBY';
$db_database  = 'case';

$bd = mysql_connect ($db_host,$db_user,$db_pass) or die(mysql_error());
mysql_select_db ($db_database,$bd)  or die(mysql_error());
mysql_query("set names utf8"); 
?>
