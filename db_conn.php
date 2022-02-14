<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$db_name = 'orangetoolz_db';

$connection = mysqli_connect($hostname, $username, $password) or die("DB Connection Error!");
mysqli_select_db($connection, $db_name);
