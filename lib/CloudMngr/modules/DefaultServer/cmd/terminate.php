<?php

if($_SESSION['admin'] == ""){die();}

if(($_POST['region'] != "") && ($_POST['group'] != "")){
	$this->setGroup($_POST['group']);
	$this->setRegion($_POST['region']);

	$this->terminate($_POST['instance_id']);
}

?>
