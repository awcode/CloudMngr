<?
session_start();
if($_REQUEST['logout']){unset($_SESSION['admin']);}

if($_POST['login_email'] == "markw" && $_POST['login_pass'] == "chang"){
	$_SESSION['admin'] = "markw";
}

if($_SESSION['admin'] == ""){$page = "login";}
elseif($_GET['page']){$page = $_GET['page'];}
else{$page="main";}
//[TODO] Clean path from XSS etc.
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

	include($this->class_path."/content/".$page.".php");

	if($_SESSION['admin'] != ""){include("../template/temp-bott.php");}

	?>

      

    

  </body>
</html>
