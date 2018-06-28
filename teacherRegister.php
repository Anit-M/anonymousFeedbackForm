<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register Teacher</title>
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

	$userError=$codeErr=$emailErr=$passErr=$confirmPassErr="";
	$userErrFlag=$codeErrFlag=$emailErrFlag=$passErrFlag=$confirmPassErrFlg=1;
	$userID=$code=$email="";

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
			$query = "SELECT * FROM teacherinfo WHERE username='$userID'";
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
	
		$code= $_POST["code"];
		if(empty($code))
		{
			$codeErr = "Teaching Code cannot be empty";
		}
		else
		{
			$query = "SELECT * FROM codevalidity WHERE teachingCode='".$code."'";
			$result = mysqli_query($conn, $query);
			$rowcount = mysqli_num_rows($result);

			if($rowcount == 1)
			{
				$row = mysqli_fetch_assoc($result);
				$codeFlag = $row["teachingCode"];
				if($codeFlag != 0)
				{
					$codeErr = "User with Teaching Code already exists";
				}
				elseif ($codeFlag == 0) 
				{
					$codeErrFlag = 0;
				}
			}
			else
			{
				$codeErr = "Invalid Teaching Code";
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
    	    	
    	if($userErrFlag == 0 and $confirmPassErrFlg == 0 and $passErrFlag == 0 and $codeErrFlag == 0 and $emailErrFlag == 0 )
    	{
			$hashedPass = password_hash($password, PASSWORD_DEFAULT);
    		$sqlQuery = "INSERT INTO teacherinfo(username,teachingCode,email,password) VALUES ('".$userID."','".$code."','".$email."','".$hashedPass."');";
    		$sqlQuery .= "UPDATE codevalidity SET flag=1 WHERE teachingCode='$code'";
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
					<td><input type="text" id="username" name="user" placeholder="Choose unique User ID" value="<?php echo $userID; ?>"></td>
					<td class="errOutput"><?php echo $userError; ?></td>
				</tr>
				<tr>
					<td>Teaching Code</td>
					<td><input type="text" name="code" placeholder="Contact Admin to get Code" value="<?php echo $code ?>"></td>
					<td class="errOutput"><?php echo $codeErr; ?></td>
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