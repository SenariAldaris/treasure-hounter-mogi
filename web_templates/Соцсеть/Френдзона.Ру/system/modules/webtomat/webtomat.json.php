<?php
@session_start();
@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

define( 'DATALIFEENGINE', true );
define( 'ROOT_DIR', '../../..' );
define( 'ENGINE_DIR', ROOT_DIR . '/engine' );
require_once ENGINE_DIR.'/modules/functions.php';
include_once (ENGINE_DIR . '/classes/mysql.php');
include_once (ENGINE_DIR . '/data/dbconfig.php');
include_once (ENGINE_DIR . '/data/config.php');

$db->query( "SELECT * FROM " . PREFIX.'_'. "wtmodule" );
while ( $row = $db->get_row() ) $$row['params'] = $row['val'];

if ($_GET['uid'] and $_GET['token'] and md5($_GET['uid'].$wt_skey)==$_GET['token']){
	$id=$_GET['uid'];

    $db->query("SELECT name,fullname,user_id,foto FROM ".USERPREFIX."_users where user_id in($id)");
    $row=$db->get_row();
    $row['fullname']=iconv($config['charset'],"UTF-8",$row['fullname']);
    $row['name']=iconv($config['charset'],"UTF-8",$row['name']);
	
	$name = $row['fullname'] ? $row['fullname'] : $row['name'];
	$photo = $row['foto'] ? $config['http_home_url'].'uploads/fotos/'.$row['foto'] : '';
    
	echo '{"first_name":"'.$name.'","uid":"'.$row['user_id'].'","photo":"'.$photo.'","photo_big":"'.$photo.'"}';
}
?>