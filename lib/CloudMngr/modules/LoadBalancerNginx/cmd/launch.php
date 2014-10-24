.<?
if($_SESSION['admin'] == ""){die();}
echo("1");
if(($_POST['region'] != "") && ($_POST['group'] != "")){
echo("2");
	$CloudMngr->setGroup($_POST['group']);
	$CloudMngr->setRegion($_POST['region']);

	//$group = $CloudMngr->group()->getGroup();
	//$region = $CloudMngr->region()->getRegion();

	$load = $CloudMngr->module("LoadBalancerNginx")->getRegion($_POST['region']);

	$CloudMngr->module("LoadBalancerNginx")->launchNew($load);
}

?>
