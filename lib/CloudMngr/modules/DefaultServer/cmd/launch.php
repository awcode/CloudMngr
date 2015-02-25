<?
if($_SESSION['admin'] == ""){die();}

if(($_POST['region'] != "") && ($_POST['group'] != "")){
	$this->setGroup($_POST['group']);
	$this->setRegion($_POST['region']);
	
	$load = $this->getRegion($_POST['region']);

	$this->launchNew($load);
}

?>
