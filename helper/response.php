<?php

function apiFailure($status, $message)
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8", true, $status);
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $res = [
        "status" => "error",
        "data" => null,
        "message" => $message
    ];
    echo json_encode($res);
}

function apiSuccess($data)
{
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8", true, 200);
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    $res = [
        "status" => "success",
        "data" => $data,
        "message" => null
    ];
    echo json_encode($res);
}
