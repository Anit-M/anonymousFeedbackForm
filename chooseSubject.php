<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Subject</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="login.css">
	<script src="jquery-3.3.1.min.js"></script>
	<?php
		$subErr = "";
		$subErrFlag = 0;

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

		$servername = "localhost";
		$user = "root";
		$pass = "";
		$dbname = "feedback";

		$conn = mysqli_connect($servername, $user, $pass, $dbname);
		if(!$conn)
		{
			die("Server Error");
		}

		$sql = "SELECT stream FROM rollvalidity WHERE rollno='".$_SESSION['sessionRollno']."'";
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		$stream = $row["stream"];

		$query = "SELECT subjectCode FROM {$stream}";
		$resultQ = mysqli_query($conn, $query);
		$rowcount = mysqli_num_rows($resultQ);

		$subjectCode = [];
		while ($rowQ = mysqli_fetch_assoc($resultQ))
		{
			$subjectCode[] = $rowQ["subjectCode"];
		}

		if ($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$selectedSubject = $_POST["subject"];
			if($selectedSubject == "choose")
			{
				$subErr = "Choose a Subject";
				$subErrFlag = 1;
			}
			if($subErrFlag == 0)
			{
				$_SESSION["subjectCode"] = $selectedSubject;
				$sql = "SELECT sid FROM {$stream} WHERE subjectCode = '".$selectedSubject."' ";
				$result = mysqli_query($conn, $sql);
				$rowSQ = mysqli_fetch_assoc($result);
				$sid = $rowSQ["sid"];
				$flagToTest = 's'.$sid.'feedbackFlag';
				$_SESSION["flag"] = $flagToTest;

				$query = "SELECT ".$flagToTest." FROM rollvalidity WHERE rollno='".$_SESSION['sessionRollno']."'";
				$resultQ = mysqli_query($conn, $query);
				$rowNQ = mysqli_fetch_assoc($resultQ);
				$finalFlag = $rowNQ["{$flagToTest}"];
				
				if($finalFlag != 0)
				{
					$subErr = "Feedback already submitted for this subject. Cannot be updated";
				}
				else
				{
					redirect('feedback.php');
				}
			}
		}
	?>
</head>
<body>
	<div  id="headBlock">
		<img align="right" src="logo.png">
		<h1 class="insName"> University Institue Of Engineering & Technology </h1>
		<h3 class="insName"> Panjab University, Chandigarh </h3>
		<h1 id="helpName"> Choose Subject </h1>
	</div>
	<div id="mainBlock">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<table id="loginTable" align="center" cellpadding="5">
				<tr>
					<td>Select Subject</td>
					<td>
						<select id="selectBox" name="subject">
							<option value="choose" selected="selected">Choose...</option>
							<?php
								for($i = 0; $i< $rowcount; $i++)
								{ ?>
									<option value="<?php echo $subjectCode[$i] ?>"><?php echo $subjectCode[$i] ?></option>
								<?php } ?>
							?>
						</select>
					</td>
					<td class="errOutput"><?php echo $subErr; ?></td>
				</tr>
			</table>
			<div align="center" id="submitButton"><input type="submit" name="" value="Submit"></div>
		</form>
	</div>
	<div class="clear"></div>
	<div class="footer">
		<form method="post" name="myform" action="logout.php">
			User Logged In: <?php echo $_SESSION["sessionUsername"] ?> <br /> 
			<input type="submit" name="" value="Logout?">
		</form>
	</div>
</body>