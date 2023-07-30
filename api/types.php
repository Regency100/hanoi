<?php

require '../config/database.php';
global $conn;

$sql = "SELECT * FROM types";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} else {
    echo json_encode(array());
}

$conn->close();
