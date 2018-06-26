<?php
	session_start();
	function redirect($url) 
	{
	    ob_start();
	    header('Location: '.$url);
	    ob_end_flush();
	    die();
	}
	session_destroy();
	$_SESSION["registerFormSubmitted"] = "";
	$_SESSION["formSubmitted"] = "";
	$_SESSION["sessionUsername"] = "";
	redirect('login.php');
?>