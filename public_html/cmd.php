<?
session_start();
if($_REQUEST['logout']){unset($_SESSION['admin']);}

if($_SESSION['admin'] == ""){
	die();
}

include("../lib/CloudMngr/cloudmngr.core.class.php");

$CloudMngr = new CloudMngr($_GET['id']);

$module = $_POST['module'];//{TODO input filertering
$action = $_POST['action'];

if($module != ""){
	$mod = $CloudMngr->module($_POST['module']);
	$mod->getModulePage("cmd" . DIRECTORY_SEPARATOR . $action);
}

?>
