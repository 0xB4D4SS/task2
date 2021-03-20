<?php

error_reporting(E_ALL);
require_once("application/Application.php");

function router($params) {
    $app = new Application();
    $method = $params["method"];
    switch ($method) {
        case "save": return $app->saveData($params); // saves data to db
        case "upload": return $app->uploadData($params); // upload data from db (>18yo) to google sheets
        default: return false;
    }
}

function answer($data) {
    if ($data) {
        return array(
            "result" => "ok",
            "data" => $data
        );
    }
    return array(
        "result" => "error",
        "error" => array(
            "code" => 999,
            "text" => "unknown error"
        )
    );
}

echo json_encode(answer(router($_GET)));