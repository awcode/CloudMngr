<?php
include("../lib/CloudMngr/cloudmngr.core.class.php");

$CloudMngr = new CloudMngr;

session_start();
if($_REQUEST['logout']){unset($_SESSION['admin']);}

if($_POST['login_email'] == "markw" && $_POST['login_pass'] == "chang"){
	$_SESSION['admin'] = "markw";
}

if($_SESSION['admin'] == ""){$page = "login";}
elseif($_GET['page']){$page = $_GET['page'];}
else{$page="main";}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>CloudMngr Control Panel</title>
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
    <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
    <link href="styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>  
  </head>
  <body id="<?=$page?>">



	<? 
	if($_SESSION['admin'] != ""){include("../template/temp-top.php");}
	//[TODO] Clean path from XSS etc.
	if($_GET['module']!=""){
		include($CloudMngr->class_path."/modules/".$_GET['module']."/".$page.".php");
	}else{
		include($CloudMngr->class_path."/content/".$page.".php");
	}

	if($_SESSION['admin'] != ""){include("../template/temp-bott.php");}

	?>

      

    

  </body>
</html>
