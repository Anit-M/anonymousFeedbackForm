<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="successRegistration.css">
	<?php
		function redirect($url) 
		{
		    ob_start();
		    header('Location: '.$url);
		    ob_end_flush();
		    die();
		}
		if($_SESSION["registerFormSubmitted"] != "T") 
		{	
			session_destroy();
			$_SESSION["registerFormSubmitted"] = "";
			redirect('login.php');
		}
		else
		{
			$_SESSION["registerFormSubmitted"] = "";
		}
	?>
</head>
<body>
	<div  id="headBlock">
		<h1 class="insName"> Successful Registered </h1>
	</div>
	<div align="center" id="submitButton"><a href="login.php"><input type="button" name="" value="Login"></a> </div>
</body>
</html>