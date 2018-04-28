<?php

session_start();

if(isset($_SESSION["Role_ID"]))
{
		header('Location: HomePage.php');
		exit();
	
}
	
require('DBconnection.php');

if ((!isset($_POST['UserName'])) || (!isset($_POST['Password'])))
{


?>

<!DOCTYPE html>

<head>
	<link rel="stylesheets" href="login_page.css">
	<style>
		body{
			margin 0 auto;
			background: url(img/lebron_james_5-wallpaper-1680x1050.jpg) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
		h1{
			color: #FFFFFF;
			font-family: "pt-sans";
		}
		.container{
			width: 400px;
			height 800px;
			text-align: center;
			margin-top: 150px;
			margin-left: 100px;
			background-color: rgba(190, 190, 190, 0.5);
			border-radius: 4px;
			padding-top: 20px;
			padding-bottom: 60px;
		}
		.container img{
			width: 200px;
			height: 200px;
			margin-top: 20px;
			opacity: .9;
		}
		input[type="text"],input[type="password"] {
			height: 45px;
			width: 300px;
			font-size: 18px;
			margin-bottom: 20px;
			padding-left: 30px;
			border: none;
		}
		input:focus{
			outline: 3px solid darkred;
		}
		
		.form-input::before{
			position: absolute;
			text-align: center;
			
			font-size: 18px; 
		}  
		.btn-login{
			border: none;
			border-radius: 4px;
			padding: 15px 30px;
			background: #000000;
			color: aliceblue;
			border-bottom: 2px solid white;
		}
		.btn-login:hover{
			background: darkred;
			color: aliceblue;
			border-bottom: 2px solid white;
		}
		
	</style>
</head>


<body>
<div class="container">
	<img src="img/icon2.png">
	<form method="post" action="Login.php">
		<div class="form-input">
			<input type="text" name="UserName" placeholder="Username">
		</div>
		<div class="form-input">
			<input type="password" name="Password" placeholder="Password">
		</div>
		 <input class="btn-login" type="submit" name="submit" value="LOGIN">
	</form>
	
</div>

<?php

}
else
{
			
		$UserName =  trim( preg_replace("/\t|\R/",' ',	$_POST['UserName']) );
		$Password =  trim( preg_replace("/\t|\R/",' ',	$_POST['Password']) );
	
		$Password = htmlspecialchars($Password);
		$UserName = htmlspecialchars($UserName);
		
		$query = "SELECT count(*), UserName, Role, User_ID, Email, Password
				  FROM Users
				  WHERE Users.UserName = ?";
				  
		
		$stmt = $db->prepare($query);
		if($stmt === FALSE)
		{
			die('prepare() failed: ' . htmlspecialchars($db->error));
		}
		$stmt->bind_param('s', $UserName);

		$stmt->execute();
		$stmt->bind_result($count, $SessionUser, $SessionRole, $SessionUserId, $Email, $PHash);
	
		
		$stmt->data_seek(0);
		$stmt->fetch();

		if($count == 1 && password_verify($Password, $PHash))
		{
		
			$_SESSION['UserName'] = $SessionUser;
			$_SESSION['Role_ID'] = $SessionRole;
			$_SESSION['User_ID'] = $SessionUserId;
			
			$stmt->close();
			$db->close();
			
			header('Location: HomePage.php');
			exit();
		
		}
		else
		{
			echo "<p> The UserName or Password that you have entered is incorrect </p>";
			
		}
	
	
	
}
?>



</body>

</html>


