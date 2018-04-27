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

<html>

<head>



</head>


<body>


<h1>Please Log In</h1>
<form method="post" action="Login.php">
<p>Username: <input type="text" name="UserName"></p>
<p>Password: <input type="password" name="Password"></p>
<p><input type="submit" name="submit" value="Log In"></p>
</form>

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


