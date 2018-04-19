<?php

$name = $_POST['name'];
$password = $_POST['password'];

if ((!isset($name)) || (!isset($password))) 
{




?>

<h1>Please Log In</h1>
<p>This page is secret.</p>
<form method="post" action="secret.php">
<p>Username: <input type="text" name="name"></p>
<p>Password: <input type="password" name="password"></p>
<p><input type="submit" name="submit" value="Log In"></p>
</form>

<?php

} else if(($name=="user") && ($password=="pass")) 
{


} else 
{

}
?>


