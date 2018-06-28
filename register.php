<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register User</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="register.css">
	<?php
	function redirect($url) 
	{
	    ob_start();
	    header('Location: '.$url);
	    ob_end_flush();
	    die();
	}

	$userError=$rollErr=$emailErr=$passErr=$confirmPassErr="";
	$userErrFlag=$rollErrFlag=$emailErrFlag=$passErrFlag=$confirmPassErrFlg=1;
	$userID=$rollno=$email="";

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		$servername="localhost";
		$username="root";
		$password="";
		$dbname="feedback";

		$conn = mysqli_connect($servername, $username, $password, $dbname);
		if(! $conn)
		{
			die("Server Error".mysqli_connect_error());
		}

		$userID = $_POST["user"];
		if(empty($userID))
		{
			$userError = $userError."User Id cannot be empty!";
		}
		if(!preg_match('/^[a-zA-Z0-9]{5,}$/', $userID))
		{
  			$userError = "User ID must contain atleast 5 characters and only numbers, english alphabets with no spaces!"; 
  		}
		else
		{
			$query = "SELECT * FROM userinfo WHERE username='$userID'";
			$result = mysqli_query($conn,$query); 
			if(mysqli_num_rows($result) > 0)
			{
				$userError = "User Id already taken. Choose Another";
			}
			else
			{
				$userErrFlag = 0;
			}
		}
	
		$rollno = $_POST["rollno"];
		if(empty($rollno))
		{
			$rollErr = "Roll No cannot be empty";
		}
		else
		{
			$query = "SELECT * FROM rollvalidity WHERE rollno='".$rollno."'";
			$result = mysqli_query($conn, $query);
			$rowcount = mysqli_num_rows($result);

			if($rowcount == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$rollFlag = $row["flag"];
				if($rollFlag != 0)
				{
					$rollErr = "User with Roll no already exists";
				}
				elseif ($rollFlag == 0) 
				{
					$rollErrFlag = 0;
				}
			}
			else
			{
				$rollErr = "Invalid Roll no";
			}
		}
	
		$email = $_POST["email"];
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			$emailErr = "Invalid email format"; 
		}
		else
		{
			$query = "SELECT * FROM userinfo WHERE email='$email'";
			$result = mysqli_query($conn,$query); 
			if(mysqli_num_rows($result) > 0)
			{
				$emailErr = "E-mail already taken";
			}
			else
			{
				$emailErrFlag = 0;
			}	
		}
		
		$password = $_POST["userPass"];
		if(empty($password))
		{
			$passErr = "Password cannot be empty";
		}
		else
		{
			if (strlen($password) < 8)
			{
        	$passErr = "Password too short!";
	    	}
	    	if (!preg_match("#[0-9]+#", $password)) 
	    	{
	        	$passErr = $passErr." Password must include at least one number!";
	    	}
	    	if (!preg_match("#[a-zA-Z]+#", $password)) 
	    	{
	        	$passErr = $passErr." Password must include at least one letter!";
	    	}
	    	else
    		{
    			$passErrFlag = 0;
    		}
		}

    	$confirmPassword = $_POST["userConfirmPass"];
    	if(empty($confirmPassword))
    	{
    		$confirmPassErr = "Confirm Password cannot be empty";
    	}
    	elseif($password !== $confirmPassword)
    	{
    		$confirmPassErr = "Password and Confirm Password do not match";
    	}     
    	else
    	{
    		$confirmPassErrFlg = 0;
    	}
    	    	
    	if($userErrFlag == 0 and $confirmPassErrFlg == 0 and $passErrFlag == 0 and $rollErrFlag == 0 and $emailErrFlag == 0 )
    	{
			$hashedPass = password_hash($password, PASSWORD_DEFAULT);
    		$sqlQuery = "INSERT INTO userinfo(username,rollno,email,password) VALUES ('".$userID."','".$rollno."','".$email."','".$hashedPass."');";
    		$sqlQuery .= "UPDATE rollvalidity SET flag=1 WHERE rollno='$rollno'";
    		if(! mysqli_multi_query($conn,$sqlQuery))
    		{
    			echo "Error while registering";
    		}
    		else
    		{
    			$_SESSION["registerFormSubmitted"] = "T";
    			redirect('successRegistration.php');
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
		<h1 id="helpName"> New User Registration {Feedback Form} </h1>
	</div>
	<div id="mainBlock">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<table id="registerTable" align="center" cellpadding="5">
				<tr>
					<td>User ID</td>
					<td><input type="text" id="username" name="user" placeholder="" value="<?php echo $userID; ?>"></td>
					<td class="errOutput"><?php echo $userError; ?></td>
				</tr>
				<tr>
					<td>Roll No</td>
					<td><input type="text" name="rollno" value="<?php echo $rollno ?>"></td>
					<td class="errOutput"><?php echo $rollErr; ?></td>
				</tr>
				<tr>
					<td>Email ID</td>
					<td><input type="text" name="email" value="<?php echo $email ?>"></td>
					<td class="errOutput"><?php echo $emailErr; ?></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="Password" name="userPass"></td>
					<td class="errOutput"><?php echo $passErr; ?></td>
				</tr>
				<tr>
					<td>Confirm Password</td>
					<td><input type="Password" name="userConfirmPass"></td>
					<td class="errOutput"><?php echo $confirmPassErr; ?></td>
				</tr>
			</table>
			<div align="center" id="submitButton"><input type="submit" name="" value="Submit"></div>
			<br />
			<div align="center" style="color: #4C7FA6; font-weight: bold;">Already Registered User?<br /></div>
			<div align="center" id="submitButton"><a href="login.php"><input type="button" name="" value="Login"></a> </div>
		</form>
	</div>
</body>
</html>