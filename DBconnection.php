<?php

define('DATA_BASE_NAME', 'TeamDatabase');
define('DATA_BASE_HOST', 'localhost');
$Roles = array("DBAdmin" => "DBAdmin", "Coaches" => "Coaches", "Observers" => "Observers");
$Passwords = array("DBAdmin" => "DBApassword", "Coaches" => "COApassword", "Observers" => "OBSpassword");
	

if(!isset($_SESSION["Role_ID"]))
{
	//echo "In first if statement";
	$db = new mysqli(DATA_BASE_HOST, $Roles["DBAdmin"], $Passwords["DBAdmin"], DATA_BASE_NAME);
	
	
}
else
{
	print_r($_SESSION);
	echo ("<br/>");
	echo ($Roles[$_SESSION["Role_ID"]]);
	echo ("<br/>");
	echo ($Passwords[$_SESSION["Role_ID"]]);
	$db = new mysqli(DATA_BASE_HOST, $Roles[$_SESSION["Role_ID"]], $Passwords[$_SESSION["Role_ID"]], DATA_BASE_NAME);
	//echo "in second";
}

?>