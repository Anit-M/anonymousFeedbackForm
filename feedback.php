<?php
	session_start();
?>
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

	 	if(!isset($_SESSION["sessionUsername"]))
	 	{
	 		redirect('login.php');
	 	}
	 	else
	 	{
	 		if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$selectedRating = $_POST["rating"];
				echo $selectedRating;

				$servername = "localhost";
				$user = "root";
				$pass = "";
				$dbname = "feedback";

				$conn = mysqli_connect($servername, $user, $pass, $dbname);
				if(!$conn)
				{
					die("Server Error");
				}
				$username = $_SESSION["sessionUsername"];
				$query = "SELECT feedbackFlag FROM userinfo WHERE username='".$username."'";
				$result = mysqli_query($conn, $query);
				if(!result)
				{
					die('Error');
				}

				if($rowcount !== 1)
				{
					die('Error');
				}
				else
				{
					$row = mysqli_fetch_assoc($result);
					$flag = $row["feedbackFlag"];
				}
				if($flag == 0)
				{
					$sqlQuery = "INSERT INTO userfeedback(first) VALUES ('".$selectedRating."');";	
					$sqlQuery .= "INSERT INTO userinfo(feedbackFlag) VALUES ('1') WHERE username='".$username."'";
					$result = mysqli_multi_query($conn, $sqlQuery);
					if(!$result)
					{
						die('Error');
					}
					else
					{
						redirect('success.php');
					}
				}
				else
				{
					die('Feedback Already given');
				}
			}
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
	<div class="footer">User Logged In: <?php echo $_SESSION["sessionUsername"] ?> </div>
</body>
</html>