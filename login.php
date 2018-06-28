<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login User</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="login.css">
	<script src="jquery-3.3.1.min.js"></script>
	<?php
		function redirect($url) 
		{
		    ob_start();
		    header('Location: '.$url);
		    ob_end_flush();
		    die();
		}

		$username = "";
		$userErr = $passErr = $loginErr = $roleErr = "";
		$userErrFlag = $passErrFlag = $roleErrFlag = 0;
		$hashedPass = "";
		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$servername = "localhost";
			$user = "root";
			$pass = "";
			$dbname = "feedback";

			$conn = mysqli_connect($servername, $user, $pass, $dbname);
			if(!$conn)
			{
				die("Server Error");
			}

			$username = $_POST["userid"];
			$userpass = $_POST["userpass"];
			$role = $_POST["role"];
			if(empty($username))
			{
				$userErr = "Username Cannot be empty";	
				$userErrFlag = 1;			
			}
			if(empty($userpass))
			{
				$passErr = "Password cannot be empty";
				$passErrFlag = 1;
			}
			if($role == "choose")
			{
				$roleErr = "Choose a Role";
				$roleErrFlag = 1;
			}

			if($userErrFlag == 0 and $passErrFlag == 0 and $roleErrFlag == 0)
			{
				$_SESSION["sessionUsername"] = $username;
				if($role == "student")
				{
					$query = "SELECT * FROM userinfo WHERE username='".$username."'";
					$result = mysqli_query($conn, $query);
					$rowcount = mysqli_num_rows($result);
					
					if($rowcount == 1)
					{
						$row = mysqli_fetch_assoc($result);
						$rollno = $row["rollno"];
						$hashedPass = $row["password"];
						if(password_verify($userpass, $hashedPass))
						{
							$_SESSION["sessionRollno"] = $rollno;
							redirect("chooseSubject.php");
						}
						else
						{
							$passErr = "Wrong Password";
						}
					}
					elseif($rowcount!== 1)
					{
						$userErr = "Either No users or Multiple Users with this User ID";
					}
				}
				elseif($role == "teacher")
				{
					$query = "SELECT * FROM teacherinfo WHERE username='".$username."'";
					$result = mysqli_query($conn, $query);
					$rowcount = mysqli_num_rows($result);
					
					if($rowcount == 1)
					{
						$row = mysqli_fetch_assoc($result);
						$teachingCode = $row["teachingCode"];
						$hashedPass = $row["password"];
						if(password_verify($userpass, $hashedPass))
						{
							$_SESSION["sessionTeachingCode"] = $teachingCode;
							redirect("subject.php");
						}
						else
						{
							$passErr = "Wrong Password";
						}
					}
					elseif($rowcount!== 1)
					{
						$userErr = "Either No users or Multiple Users with this User ID";
					}
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
		<h1 id="helpName"> Student Login {Feedback Form} </h1>
	</div>
	<div id="mainBlock">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			<table id="loginTable" align="center" cellpadding="5">
				<tr>
					<td>User ID</td>
					<td><input type="text" name="userid" value="<?php echo $username; ?>"></td>
					<td class="errOutput"><?php echo $userErr; ?></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="Password" name="userpass"></td>
					<td class="errOutput"><?php echo $passErr; ?></td>
				</tr>
				<tr>
					<td>Select Role</td>
					<td>
						<select id="selectBox" name="role">
							<option value="choose" selected="selected">Choose...</option>
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select>
					</td>
					<td class="errOutput"><?php echo $roleErr; ?></td>
				</tr>
			</table>
			<span><?php echo $loginErr; ?></span>
			<div align="center" id="submitButton"><input type="submit" name=""></div>
			<!-- <div id="passwordChange" align="center"> Forgot Password? <label> Reset Password</label></div> -->
			<br />
			<div align="center" style="color: #4C7FA6; font-weight: bold;">For Unregistered Students  <br /></div>
			<div align="center" id="submitButton"><a href="register.php"><input type="button" name="" value="Sign up"></a> </div>
		</form>
	</div>
</body>
</html>