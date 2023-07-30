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
    $headerId = isset($_GET["header_id"]) ? $_GET["header_id"] : null;

    if (!isset($headerId)) {
        apiFailure(400, "header_id is required");
        return;
    }

    $sqlDetail = "select * from details where header_id = $headerId order by created_at desc;";
    $resDetails = $conn->query($sqlDetail);

    if ($resDetails->num_rows > 0) {
        apiSuccess($resDetails->fetch_all(MYSQLI_ASSOC));
    } else {
        apiSuccess(array());
    }
}

function delete()
{
    global $conn;
    if (isset($_GET['id'])) {
        $deleteId = $_GET['id'];
        $sqlDetail = "delete from details where id = " . $deleteId;
        $resDetails = $conn->query($sqlDetail);

        if ($resDetails) {
            apiSuccess(array());
        } else {
            apiFailure(500, "cannot delete detail");

        }
    } else {
        apiFailure(400, "id is required");
    }
}

$conn->close();
