<?
session_start();
if($_REQUEST['logout']){unset($_SESSION['admin']);}

if($_SESSION['admin'] == ""){
	die();
}

include("../lib/CloudMngr/cloudmngr.core.class.php");

$CloudMngr = new CloudMngr($_GET['id']);

if($_GET['action'] == "launch"){
	include($CloudMngr->base_path."/cmd/add-load.php");
}elseif($_GET['action'] == "terminate"){
	include($CloudMngr->base_path."/cmd/terminate-load.php");
}

?>
