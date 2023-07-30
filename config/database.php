<?php

$servername = "localhost";
$username = "root";
$password = "Welcome1";
$dbname = "hanoi";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}