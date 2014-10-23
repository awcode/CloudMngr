<?
if($_SESSION['admin'] == ""){die();}

if(($_POST['region'] != "") && ($_POST['group'] != "")){
	$CloudMngr->setGroup($_POST['group']);
	$CloudMngr->setRegion($_POST['region']);

	//$group = $CloudMngr->group()->getGroup();
	//$region = $CloudMngr->region()->getRegion();

	$load = $CloudMngr->loadBalancer()->getRegion($_POST['region']);

	$CloudMngr->loadBalancer()->launchNew($load);
}

?>