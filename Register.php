<?php

	session_start();
	//session_unset();
?>
<!DOCTYPE html>

<html>

<head>



</head>


<body>


<?php

require('DBconnection.php');
	
if ((!isset($_POST['UserName'])) || (!isset($_POST['Password'])))
{
	

?>

<h1>Enter a Username And Password to create an account</h1>

<form method="post" action="Register.php">
<p>Username: <input type="text" name="UserName"></p>
<p>Password: <input type="password" name= "Password"></p>
<p>Email: <input type="email" name= "Email"></p>
<p><input type="submit" name="submit" value="Log In"></p>
</form>

<?php
}
else 
{
	
	if(isset($_SESSION["Role_ID"]))
	{
		
		
		
	}
   
		if(mysqli_connect_error()== 0)
	{
		$UserName =  trim( preg_replace("/\t|\R/",' ',	$_POST['UserName']) );

		$Password =  trim( preg_replace("/\t|\R/",' ',	$_POST['Password']) );
		
		$Email =  trim( preg_replace("/\t|\R/",' ',	$_POST['Email']) );
		
		$Password = htmlspecialchars($Password);
		$UserName = htmlspecialchars($UserName);

		$Password = password_hash($Password, PASSWORD_DEFAULT);
		
		$query = "SELECT count(*)
				  FROM Users
				  WHERE Users.UserName = ? || Users.Email = ?";
		
		$stmt = $db->prepare($query);
		if($stmt === FALSE)
		{
			die('prepare() failed: ' . htmlspecialchars($db->error));
		}
		$stmt->bind_param('ss', $UserName, $Email);
		$stmt->execute();
		$stmt->store_result();
	
		$stmt->bind_result($count);

		$stmt->data_seek(0);
		$stmt->fetch();

		if($count > 0)
		{
		   echo ("<h1> That Username or Email is already in use, Please select a different one. </h1>");
		  

		}
		else
		{

			$query = "INSERT INTO Users SET 
				  UserName = ?,
				  Password = ?,
				  Email = ?,
				  Role = 'Observers'";

			
			
			
			$stmt = $db->prepare($query);
			$stmt->bind_param('sss', $UserName, $Password, $Email);
			$stmt->execute();
			
			$db->close();
			$stmt->close();

			$_SESSION["Role_ID"] = "Observers";
			$_SESSION["UserName"] = $UserName;
			$_SESSION["Email"] = $Email;

			header('Location: HomePage.php');
			exit();
		}
		
	}

	



	

}



?>



</body>

</html>