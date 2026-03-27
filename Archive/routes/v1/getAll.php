<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/v1/getAll.php";



try {
    $all = getAll();
    if($all) {
    echo jsonResponse(200, ["API" => "API"], 
        $all
);
    }else {
    echo jsonResponse(404, ["API" => "API"], [
        "error" => $exception->getMessage()
    ]);
    }

} catch (Exception $exception) {
    echo jsonResponse(500, ["API" => "API"], [
        "error" => "Unable to read endpoint",
        "status" => 500,
        "checked_at" => getCheckedAt()
    ]);
}