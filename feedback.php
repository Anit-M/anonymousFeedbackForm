<!DOCTYPE html>
<html>
<head>
	<title>Feedback Form</title>
	<link rel="stylesheet" type="text/css" href="feedback.css">
	<?php
		function redirect($url) 
		{
		    ob_start();
		    header('Location: '.$url);
		    ob_end_flush();
		    die();
		}
		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$selectedRating = $_POST["rating"];
			redirect("success.php");
		}
	?>
</head>
<body>
	<div id="headBlock">
		<img align="right" src="logo.png">
		<h1 class="insName"> University Institue Of Engineering & Technology </h1>
		<h3 class="insName"> Panjab University, Chandigarh </h3>
		<h1 id="helpName"> Feedback Form </h1>
	</div>

	<div id="mainBlock">
		<form method="post" name="myform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<p> Give your Feedback 
				<input type="radio" name="rating" value="5">5
				<input type="radio" name="rating" value="4">4
				<input type="radio" name="rating" value="3">3
				<input type="radio" name="rating" value="2">2
				<input type="radio" name="rating" value="1">1
			</p>
			<div align="center" id="submitButton"><input type="submit" name=""></div>
		</form>
	</div>
	<!-- <div align="center" id="submitButton"><input type="submit" name=""></div> -->

</body>
</html>
