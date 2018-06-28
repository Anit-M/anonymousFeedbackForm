<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="register.css">
	<?php
		function redirect($url) 
		{
		    ob_start();
		    header('Location: '.$url);
		    ob_end_flush();
		    die();
		}
		if($_SESSION["registerFormSubmitted"] == "T") 
		{	
			$_SESSION["registerFormSubmitted"] = "F";
			session_destroy();
			session_unset();
		}
		else
		{
			redirect('login.php');
		}
	?>
</head>
<body>
	<div  id="headBlock">
		<h1 class="insName"> Successfully Registered </h1>
	</div>
	<div align="center" id="submitButton"><a href="login.php"><input type="button" name="" value="Login"></a> </div>
</body>
</html>