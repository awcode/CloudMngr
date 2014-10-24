<?
if($_SESSION['admin'] == ""){die();}

if(($_POST['region'] != "") && ($_POST['group'] != "")){

	$CloudMngr->setGroup($_POST['group']);
	$CloudMngr->setRegion($_POST['region']);

	//$group = $CloudMngr->group()->getGroup();
	//$region = $CloudMngr->region()->getRegion();

	$load = $CloudMngr->module("LoadBalancerNginx")->getRegion($_POST['region']);

	$CloudMngr->module("LoadBalancerNginx")->terminate($_POST['instance_id']);
}

?>
