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
	session_unset();
	redirect('login.php');
?>