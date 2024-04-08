<?php

$host = "localhost";
$username = "root";
$password = "admin";
$dbname = "tarakanita-recruitment";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;