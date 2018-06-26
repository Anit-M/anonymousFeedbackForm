<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="success.css">
	<?php
		function redirect($url) 
		{
		    ob_start();
		    header('Location: '.$url);
		    ob_end_flush();
		    die();
		}
		if($_SESSION["formSubmitted"] != "T") 
		{	
			redirect('login.php');
		}
		else
		{
			$_SESSION["formSubmitted"] = "";
		}
  	?>
</head>
<body>
	<div  id="headBlock">
		<h1 class="insName"> Successful Submission</h1>
	</div>
</body>
</html>