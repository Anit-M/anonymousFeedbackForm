<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Subject</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="login.css">
	<?php
		$servername = "localhost";
		$user = "root";
		$pass = "";
		$dbname = "feedback";

		$conn = mysqli_connect($servername, $user, $pass, $dbname);
		if(!$conn)
		{
			die("Server Error");
		}

		$query = "SELECT * FROM userfeedback WHERE subjectCode = '".$_SESSION["subjectCode"]."'"; 
		$result = mysqli_query($conn, $query);
		$rowcount = mysqli_num_rows($result);
	?>
</head>
<body>
	<div  id="headBlock">
		<img align="right" src="logo.png">
		<h1 class="insName"> University Institue Of Engineering & Technology </h1>
		<h3 class="insName"> Panjab University, Chandigarh </h3>
		<h1 id="helpName"> Feedback Result </h1>
	</div>

	<div id="headBlock">
		<p> Number of feedback(s) submitted for Subject Code: "<?php echo $_SESSION["subjectCode"] ?>" is <?php echo $rowcount ?> </p>
		<table id="dataTable" align="center">
			<tr>
				<th>S.No</th>
				<th>QI 1</th>
				<th>QI 2</th>
				<th>QI 3</th>
				<th>QI 4</th>
				<th>QI 5</th>
				<th>QI 6</th>
				<th>QII 1</th>
				<th>QII 2</th>
				<th>QII 3</th>
				<th>QII 4</th>
				<th>QII 5</th>
				<th>QII 6</th>
				<th>QII 7</th>
				<th>QII 8</th>
				<th>QII 9</th>
				<th>QII 10</th>
			</tr>
			<?php
				$i = 1;
				while($row = mysqli_fetch_assoc($result))
				{ ?>
					<tr>
						<td><?php echo $i."." ?></td>
						<td><?php echo $row["QA1"] ?></td>
						<td><?php echo $row["QA2"] ?></td>
						<td><?php echo $row["QA3"] ?></td>
						<td><?php echo $row["QA4"] ?></td>
						<td><?php echo $row["QA5"] ?></td>
						<td><?php echo $row["QA6"] ?></td>
						<td><?php echo $row["QB1"] ?></td>
						<td><?php echo $row["QB2"] ?></td>
						<td><?php echo $row["QB3"] ?></td>
						<td><?php echo $row["QB4"] ?></td>
						<td><?php echo $row["QB5"] ?></td>
						<td><?php echo $row["QB6"] ?></td>
						<td><?php echo $row["QB7"] ?></td>
						<td><?php echo $row["QB8"] ?></td>
						<td><?php echo $row["QB9"] ?></td>
						<td><?php echo $row["QB10"] ?></td>
					</tr>
				<?php 
					$i++;
				} 
			?>
		</table>
	</div>

	<div class="clear"></div>
	<div class="footer">
		<form method="post" name="myform" action="logout.php">
			User Logged In: <?php echo $_SESSION["sessionUsername"] ?> <br />
			<input type="submit" name="" value="Logout?">
		</form>
	</div>
</body>