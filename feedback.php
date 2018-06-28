<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Feedback Form</title>
	<link rel="stylesheet" type="text/css" href="feedback.css">
	<?php
		$errOutput = "";
		$errFlag = 0;
		function redirect($url) 
		{
		    ob_start();
		    header('Location: '.$url);
		    ob_end_flush();
		    die();
		}

	 	if(!isset($_SESSION["sessionUsername"]) or !isset($_SESSION['sessionRollno']))
	 	{
	 		redirect('login.php');
	 	}
	 	elseif(!isset($_SESSION["flag"]) or !isset($_SESSION["subjectCode"]))
	 	{
	 		redirect('chooseSubject.php');
	 	}
	 	else
	 	{
	 		if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				if($_SESSION["token"] != "T")
				{
					redirect('logout.php');
				}
				for ( $i = 1; $i <=10; $i++)
				{
					if(!isset($_POST["QA".$i]) and $i <= 6)
					{
						$errOutput = " Empty field(s)";
						$errFlag = 1;
						break;
					}
					if(!isset($_POST["QB".$i]))
					{
						$errOutput = " Empty field(s)";
						$errFlag = 1;
						break;
					}
				}

				
				if ($errFlag == 0)
				{
					for ( $i = 1; $i <=10; $i++)
					{
						if ( $i <= 6)
						{
							${"QA".$i} = $_POST["QA".$i];
						}
						${"QB".$i} = $_POST["QB".$i];
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
					if($_SESSION["token"] != "T")
					{
						redirect('logout.php');
					}
					else
					{
						$sql = "  INSERT INTO userfeedback(QA1,QA2,QA3,QA4,QA5,QA6,QB1,QB2,QB3,QB4,QB5,QB6,QB7,QB8,QB9,QB10,subjectCode) VALUES ('".$QA1."','".$QA2."','".$QA3."','".$QA4."','".$QA5."','".$QA6."','".$QB1."','".$QB2."','".$QB3."','".$QB4."','".$QB5."','".$QB6."','".$QB7."','".$QB8."','".$QB9."','".$QB10."','".$_SESSION["subjectCode"]."');  ";
						$sql .= "  UPDATE rollvalidity SET ".$_SESSION["flag"]." = 1 WHERE rollno='".$_SESSION["sessionRollno"]."'  ";
						$result = mysqli_multi_query($conn, $sql);
						if(!$result)
						{
							die('Failed');
						}
						else
						{
							$_SESSION["token"] = "";
							$_SESSION["formSubmitted"] = "T";
							redirect('success.php');
						}
					}
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
		<h1 id="helpName"> Student Feedback Form </h1>
	</div>

	<div id="mainBlock">
		<p>Note: </p>
		<ol>
			<li> This form is to be filled only by students having at least 65% attendance.</li>
			<li> The information provided by you will be kept confidential and will be used only for student participation in quality enhancement.</li>
		</ol>
		<form method="post" name="myform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<h2 align="center"> Feedback(Curriculum, Teaching, Learning & Evaluation)</h2 	>
			<p class="errOut"><?php echo $errOutput ?></p>
			<ol type="I">
				<li class="boldClass">For each of the question, you are required to indicate your opinion by encircling the letter a, b, c or d.</li><br />
				<ol>
					<li class="boldClassQ">Course Content:</li> 
						<input type="radio" name="QA1" value="a"> a) Can be covered in one semester<br />
						<input type="radio" name="QA1" value="b"> b) Too much to be adequately covered in one semester<br />
						<input type="radio" name="QA1" value="c"> c) Not enough for one semester<br />
						<input type="radio" name="QA1" value="d"> d) Difficult to comment<br />
					<br />
					<li class="boldClassQ">Relevance of the course in the overall structure of program</li>
						<input type="radio" name="QA2" value="a"> a) <br />
						<input type="radio" name="QA2" value="b"> b) Reasonably relevant<br />
						<input type="radio" name="QA2" value="c"> c) Not at all relevant<br />
						<input type="radio" name="QA2" value="d"> d) Difficult to comment<br />
					<br />
					<li class="boldClassQ">Overlap with other courses</li>
						<input type="radio" name="QA3" value="a"> a) No overlap<br />
						<input type="radio" name="QA3" value="b"> b) Some overlap<br />
						<input type="radio" name="QA3" value="c"> c) Repetition of several topics<br />
						<input type="radio" name="QA3" value="d"> d) Difficult to comment<br />
					<br />
					<li class="boldClassQ">Recommended Reading material was</li>
						<input type="radio" name="QA4" value="a"> a) Adequate and relevant<br />
						<input type="radio" name="QA4" value="b"> b) To some extent adequate and relevant<br />
						<input type="radio" name="QA4" value="c"> c) Mostly inadequate<br />
						<input type="radio" name="QA4" value="d"> d) Cannot comment<br />
					<br />
					<li class="boldClassQ">Class tests/mid-semester tests were conducted</li>
						<input type="radio" name="QA5" value="a"> a) As per schedule and satisfactorily<br />
						<input type="radio" name="QA5" value="b"> b) Never<br />
						<input type="radio" name="QA5" value="c"> c) In an unsatisfactory manner<br />
						<input type="radio" name="QA5" value="d"> d) But were inadequate<br />
					<br />
					<li class="boldClassQ">The class tests/mid-term tests were</li>
						<input type="radio" name="QA6" value="a"> a) Difficult<br />
						<input type="radio" name="QA6" value="b"> b) Easy<br />
						<input type="radio" name="QA6" value="c"> c) Balanced<br />
						<input type="radio" name="QA6" value="d"> d) Out of Syllabus<br />
					<br />
				</ol>
				<li class="boldClass">Using the rating scale below, please tick that best value that expresses your opinion.<br />
					(1-strongly disagree, 2-disagree, 3-neither agree nor disagree, 4-agree, 5-strongly agree)</li><br /><br />
				<ol>
					<li class="boldClassQ">The teacher completes the entire syllabus in time</li>
						<input type="radio" name="QB1" value="1">1
						<input type="radio" name="QB1" value="2">2
						<input type="radio" name="QB1" value="3">3
						<input type="radio" name="QB1" value="4">4
						<input type="radio" name="QB1" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher has subject knowledge</li>
						<input type="radio" name="QB2" value="1">1
						<input type="radio" name="QB2" value="2">2
						<input type="radio" name="QB2" value="3">3
						<input type="radio" name="QB2" value="4">4
						<input type="radio" name="QB2" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher communicates clearly and inspires me by his/her teaching </li>
						<input type="radio" name="QB3" value="1">1
						<input type="radio" name="QB3" value="2">2
						<input type="radio" name="QB3" value="3">3
						<input type="radio" name="QB3" value="4">4
						<input type="radio" name="QB3" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher is punctual in the class</li>
						<input type="radio" name="QB4" value="1">1
						<input type="radio" name="QB4" value="2">2
						<input type="radio" name="QB4" value="3">3
						<input type="radio" name="QB4" value="4">4
						<input type="radio" name="QB4" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher comes well prepared for the class</li>
						<input type="radio" name="QB5" value="1">1
						<input type="radio" name="QB5" value="2">2
						<input type="radio" name="QB5" value="3">3
						<input type="radio" name="QB5" value="4">4
						<input type="radio" name="QB5" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher encourages participation and discussion in class</li>
						<input type="radio" name="QB6" value="1">1
						<input type="radio" name="QB6" value="2">2
						<input type="radio" name="QB6" value="3">3
						<input type="radio" name="QB6" value="4">4
						<input type="radio" name="QB6" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher uses teaching aids, handouts, gives suitable references, make presentations and conducts seminars/tutorials, etc.</li>
						<input type="radio" name="QB7" value="1">1
						<input type="radio" name="QB7" value="2">2
						<input type="radio" name="QB7" value="3">3
						<input type="radio" name="QB7" value="4">4
						<input type="radio" name="QB7" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher’s attitude towards students is friendly & helpful</li>
						<input type="radio" name="QB8" value="1">1
						<input type="radio" name="QB8" value="2">2
						<input type="radio" name="QB8" value="3">3
						<input type="radio" name="QB8" value="4">4
						<input type="radio" name="QB8" value="5">5<br />
					<br />
					<li class="boldClassQ">The teacher is available and accessible in the Department</li>
						<input type="radio" name="QB9" value="1">1
						<input type="radio" name="QB9" value="2">2
						<input type="radio" name="QB9" value="3">3
						<input type="radio" name="QB9" value="4">4
						<input type="radio" name="QB9" value="5">5<br />
					<br />
					<li class="boldClassQ">The evaluation process is fair and unbiased</li>
						<input type="radio" name="QB10" value="1">1
						<input type="radio" name="QB10" value="2">2
						<input type="radio" name="QB10" value="3">3
						<input type="radio" name="QB10" value="4">4
						<input type="radio" name="QB10" value="5">5<br />
					<br />
				</li>
			</ol>
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
</html>