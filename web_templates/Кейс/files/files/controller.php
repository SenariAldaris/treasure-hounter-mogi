<?php
/* File:	BitDrop - controller.php - v1.4
 * Date:	June 17, 2013
 * Copyright (C) 2013 by http://codeeverywhere.ca
 */
session_start();

require('bitdrop.class.php');

switch($_GET['method'])
{
	case "flag":
	if( $bitdrop->flag($_POST['shortURL']) )
		echo "File {$_POST['shortURL']} has been flagged";
	else
		echo $bitdrop->errorMessage;;
	break;
	
	case "api":
	if( enableAPI )
		echo $bitdrop->getData('total');
	else
		echo '{ error : "api access disabled"}';
	break;
	
	case "delete":
	if( $_SESSION['auth'] !== true) { echo '{ error : "not authenticated" }'; break; }
	if( $bitdrop->delete($_POST['shortURL']))
		echo "File {$_POST['shortURL']} was deleted successfully";
	else
		echo $bitdrop->errorMessage;
	break;
	
	
	case "deleteAllExpired":
	if( $_SESSION['auth'] !== true) { echo '{ error : "not authenticated" }'; break; }
	if( $bitdrop->deleteAllExpired() )
		echo "All expired files deleted successfully";
	else
		echo $bitdrop->errorMessage;
	break;
	
	
	case "reset":
	if( $_SESSION['auth'] !== true) { echo '{ error : "not authenticated" }'; break; }
	if( $bitdrop->reset($_POST['shortURL']))
		echo "File {$_POST['shortURL']} was reset successfully";
	else
		echo $bitdrop->errorMessage;
	break;
	
	
	case "logs":
	if( $_SESSION['auth'] !== true) { echo '{ error : "not authenticated" }'; break; }
	echo $bitdrop->getLog();
	break;
	
	
	case "history":
	if( $_SESSION['auth'] !== true) { echo '{ error : "not authenticated" }'; break; }
	echo $bitdrop->getLog($_POST['shortURL']);
	break;
	
	
	default:
	echo '{ error : "no method supplied"}';
}
?>