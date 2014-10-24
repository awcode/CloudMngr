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

if($module != "" && file_exists($CloudMngr->class_path . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $module.'.php')){
	$action_file = $CloudMngr->class_path . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . "cmd" . DIRECTORY_SEPARATOR . $action .'.php';
echo("!");
	if(file_exists($action_file)){
echo("@");
		include($action_file);
	}
}else{
	echo($CloudMngr->class_path . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $module.'.php');
}

?>
