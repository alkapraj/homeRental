<?php
require_once "sanitize.php";
require_once 'logindata.php';
$conn = new mysqli($hn,$un,$pw,$db);
require_once 'user.php';

if (isset($_POST['username']) && isset($_POST['password']))
{

	$username 		= 	sanitizeMySql($conn,$_POST['username']);
	$password	 	= 	sanitizeMySql($conn,$_POST['password']);
	$fail  		 		= 	validate_username($username);
	$fail  				.= validate_password($password);
		
	if ($fail == "")
	{		
		//echo "Form data validated successfully<br>";
	}else{
		echo $fail.'<br>';
		exit;
	}
}else{
	echo("Technical Error");
	exit;
}

	$token = "1234";
	if($conn->connect_error) die("Error establishing connection");
	// Match password to db 	
	$user 	= new User("$username");
	$error 	= $user->get_error();
	
	if($error!=""){		
		echo $error;
		//header("Location: Login Page.php");
		exit;
	}
	
	$correct_pw = $user->get_password();
	
	if($correct_pw!=$token) die("Wrong Password!!");
	else {
		session_start();
		$_SESSION['username']      = $username;
		$_SESSION['fullname'] 		= $user->get_fullname();
		$_SESSION['login'] 				= TRUE;
		$filename							= $_POST['filename'];
		$file = explode("/",$filename);
		$count = count($file);
		$filename = $file[$count-1];
		echo $filename;
		if(empty($filename))
		header("Location: Home Page.php");
		else header("Location: $filename");
	}
//	$result->close();
	$conn->close();	
	
	//field validations
	function validate_username($string){
	return emptyField($string,'Username');
	}
	function validate_password($string){
	return emptyField($string,'Password');
	}
	function emptyField($string,$fieldtext){
	return ($string == "") ? "No $fieldtext was entered.\n" : "";
	}
?>