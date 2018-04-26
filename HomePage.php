<?php
session_start();
?>
<!DOCTYPE html>

<html>

<head>



</head>


<body>


<?php
if(isset($_SESSION["Role_ID"]))
{
	
	
	//echo "You are Logged in!!!!";
	//echo "<br/>";
	//echo "{$_SESSION['UserName']}";
	//echo "<br/>";
	
	//require('DBconnection.php');
	
	
	
?>

	<form method="post" action="Logout.php">

	<p><input type="submit" name="submit" value="Logout"></p>
	
	</form>
	
<?php

}
else
{
	
?>
	
<h1> Welcome To The Basketball Teams Database </h1>
<p1> Look around, check out stats of your favorite teams, players and their games! </p1>
	

	<form method="post" action="Login.php">

	<p><input type="submit" name="submit" value="Login"></p>
	
	</form>
	
	
	<form method="post" action="Register.php">

	<p><input type="submit" name="submit" value="Register"></p>
	
	</form>
	
<?php	

}
	
	
?>



</body>

</html>
	
	
	
	