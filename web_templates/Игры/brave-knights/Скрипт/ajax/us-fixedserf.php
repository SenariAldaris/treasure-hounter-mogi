<?php
/*
 * ������� ��� �����
 * ������: 1.00
 * SKYPE: sereega393
*/
define('TIME', time());
define('BASE_DIR', $_SERVER['DOCUMENT_ROOT']);

header("Content-type: text/html; charset=utf-8");

session_start();

if (!isset($_SESSION['user_id'])) { exit(); }

if (isset($_POST['p1']))
{
  function __autoload($name){ include(BASE_DIR."/classes/_class.".$name.".php");}

  $config = new config;

  $db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
  $db->Query("set names cp1251;");

  //$db->Query("SELECT * FROM db_users_a WHERE id = '".$_SESSION['user_id']."'");
  //$users_info = $db->FetchAssoc();

  $id = (int)$_POST['p1'];
  
  $db->Query("SELECT id FROM wmrush_serfing WHERE money >= price and status = '2' and id = '".$id."'");
  
  if ($db->NumRows())
  {
    echo 'account/serfing/view/'.$id.'';
  } 
}  
?>