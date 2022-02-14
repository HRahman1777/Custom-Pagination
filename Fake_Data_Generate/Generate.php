<?php

require_once 'vendor/autoload.php';
$faker = Faker\Factory::create();

$number_of_data = 210;

$hostname = 'localhost';
$username = 'root';
$password = '';
$db_name = 'orangetoolz_db';
$connection = mysqli_connect($hostname, $username, $password);
mysqli_select_db($connection, $db_name);


function generate($data, $fake_data, $conn)
{

    for ($i = 0; $i < $data; $i++) {

        $name = "$fake_data->firstName $fake_data->lastName";
        $email = $fake_data->email;

        $sql_query = "INSERT INTO users (name, email) VALUE ('$name', '$email')";

        if (mysqli_query($conn, $sql_query)) {
            echo "$i Generated... <br>";
        } else {
            echo "$i Something went wrong!!! <br>";
        }
    }
}

generate($number_of_data, $faker, $connection);
