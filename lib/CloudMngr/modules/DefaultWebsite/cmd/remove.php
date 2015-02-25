<?
if($_SESSION['admin'] == ""){die();}

if($_POST['group'] != ""){
	$this->setGroup($_POST['group']);

	$this->getData();

	$this->remove($_POST['web_key']);
}

?>
