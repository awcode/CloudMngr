<?
if($_SESSION['admin'] == ""){die();}

if(($_POST['region'] != "") && ($_POST['group'] != "")){
	$CloudMngr->setGroup($_POST['group']);
	$CloudMngr->setRegion($_POST['region']);

	$load = $CloudMngr->module($module)->getRegion($_POST['region']);

	$CloudMngr->module($module)->terminate($_POST['instance_id']);
}

?>
