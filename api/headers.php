<?php

require '../config/database.php';
require '../helper/response.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        get();
        break;
    case 'DELETE':
        delete();
        break;
    default:
        apiFailure(400, "method is required");
        break;
}

function get()
{
    global $conn;
    $sqlHeader = "select * from headers order by created_at desc limit 5;";
    $resHeaders = $conn->query($sqlHeader);

    if ($resHeaders->num_rows > 0) {
        apiSuccess($resHeaders->fetch_all(MYSQLI_ASSOC));
    } else {
        apiSuccess(array());
    }
}

function delete()
{
    global $conn;
    if (isset($_GET['id'])) {
        $deleteId = $_GET['id'];
        $sqlDetail = "delete from details where header_id = " . $deleteId;
        $resDetails = $conn->query($sqlDetail);
        $sqlHeader = "delete from headers where id = " . $deleteId;
        $resHeaders = $conn->query($sqlHeader);

        if ($resDetails && $resHeaders) {
            apiSuccess(array());
        } else {
            apiFailure(500, "cannot delete header");

        }
    } else {
        apiFailure(400, "id is required");
    }
}

$conn->close();
