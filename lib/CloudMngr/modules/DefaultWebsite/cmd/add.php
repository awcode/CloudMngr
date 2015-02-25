<?
if($_SESSION['admin'] == ""){die();}

if($_POST['group'] != ""){
	$this->setGroup($_POST['group']);
	
	$this->getData();

	$this->addNew($_POST);
}

?>
