<? php

define('DATA_BASE_NAME', 'TeamDatabase');
define('DATA_BASE_HOST', 'localhost');
define('USER_NAME', 'Observers');
define('USER_PASSWORD', 'OBSpassword');


$db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

?>