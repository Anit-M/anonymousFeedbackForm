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
		$userErr = $passErr = $loginErr = "";
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
			$_SESSION["sessionUsername"] = $username;
			$userpass = $_POST["userpass"];
			if(empty($username))
			{
				$userErr = "Username Cannot be empty";				
			}
			if(!preg_match('/^[a-zA-Z0-9]{5,}$/', $username))
			{
				$userErr = "Invalid User ID";
			}
			if(empty($userpass))
			{
				$passErr = "Password cannot be empty";
			}
			else
			{
				$query = "SELECT * FROM userinfo WHERE username='".$username."'";
				$result = mysqli_query($conn, $query);
				$rowcount = mysqli_num_rows($result);
				
				if($rowcount == 1)
				{
					$row = mysqli_fetch_assoc($result);
					$hashedPass = $row["password"];
				}
				elseif($rowcount!== 1)
				{
					$userErr = "Either No users or Multiple Users with this User ID";
				}
				if(password_verify($userpass, $hashedPass))
				{
					redirect("feedback.php");
				}
				else
				{
					$passErr = "Wrong Password";
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
		<form action="login.php" method="POST">
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
			</table>
			<span><?php echo $loginErr; ?></span>
			<div align="center" id="submitButton"><input type="submit" name=""></div>
			<!-- <div id="passwordChange" align="center"> Forgot Password? <label> Reset Password</label></div> -->
			<br />
			<div align="center" style="color: #4C7FA6; font-weight: bold;">For Unregistered Users  <br /></div>
			<div align="center" id="submitButton"><a href="register.php"><input type="button" name="" value="Sign up"></a> </div>
		</form>
	</div>
</body>
</html>