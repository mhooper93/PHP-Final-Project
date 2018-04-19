<?php

define('DATA_BASE_NAME', 'TeamDatabase');
define('DATA_BASE_HOST', 'localhost');
define('USER_NAME', 'DBAdmin');
define('USER_PASSWORD', 'DBApassword');




$db = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);


?>