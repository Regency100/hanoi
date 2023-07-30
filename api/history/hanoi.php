<?php

require '../../config/database.php';
require '../../helper/response.php';
global $conn;

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        get();
        break;
    default:
        apiFailure(400, "method is required");
        break;
}

function get()
{
    global $conn;
    $typeId = isset($_GET["type_id"]) ? $_GET["type_id"] : null;
    $lastDay = isset($_GET["last_day"]) ? $_GET["last_day"] : 30;

    if (!isset($typeId)) {
        apiFailure(400, "type_id is required");
        return;
    }

    $sqlHeader = "select *
            from headers h where date(h.created_at) >= (curdate() - INTERVAL $lastDay day)
            order by h.created_at desc;";
    $resHeaders = $conn->query($sqlHeader);

    $sqlDetail = "select h.id, h.created_at, t.name, var_1, var_2, d.created_at
            from headers h
                     join details d on h.id = d.header_id
                     join types t on t.id = d.type_id
            where date(h.created_at) >= (curdate() - INTERVAL $lastDay day) and t.id = $typeId
            order by d.created_at desc;";
    $resDetails = $conn->query($sqlDetail);
    $details = $resDetails->fetch_assoc();

    if ($resHeaders->num_rows > 0 && $resDetails->num_rows > 0) {
        $mapHeaders = array();
        while ($header = $resHeaders->fetch_assoc()) {
            $mapDetails = array();

            if ($details["id"] == $header["id"]) {
                $mapDetails[] = $details;
            }

            if (count($mapDetails) > 0) {
                $header["details"] = $mapDetails;
                $mapHeaders[] = $header;
            }
        }
        apiSuccess($mapHeaders);
    } else {
        apiSuccess(array());
    }
}

$conn->close();
