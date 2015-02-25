<?
echo("a");
if($_SESSION['admin'] == ""){die();}
echo("1");
if(($_POST['region'] != "") && ($_POST['group'] != "")){
	$this->setGroup($_POST['group']);
	$this->setRegion($_POST['region']);
echo("2");
	$this->terminate($_POST['instance_id']);
}

?>
