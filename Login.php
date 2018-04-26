<?php

session_start();

require('DBconnection.php');

if ((!isset($_POST['UserName'])) || (!isset($_POST['Password'])) || (!isset($_SESSION['Role_ID']))) 
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
	if(isset($_SESSION["Role_ID"]))
	{
		header('Location: HomePage.php');
		exit();
	
	}
	else
	{
		
		$UserName =  trim( preg_replace("/\t|\R/",' ',	$_POST['UserName']) );
		$Password =  trim( preg_replace("/\t|\R/",' ',	$_POST['Password']) );
	
		$Password = htmlspecialchars($Password);
		$UserName = htmlspecialchars($UserName);
		
		$Password = password_hash($Password, PASSWORD_DEFAULT);
		
		$query = "SELECT UserName, Role, User_ID, count(*)
				  FROM Users
				  WHERE Users.UserName = ? && Users.Password = ?";
				  
		
		$stmt = $db->prepare($query);
		$stmt->bind_param('ss', $UserName, $Password);
		
		$stmt->execute();
		$stmt->bind_result($SessionUser, $SessionRole, $SessionUserId);
		
		$stmt->data_seek(0);
		$stmt->fetch();
		
		if($count == 1)
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
}
?>



</body>

</html>


