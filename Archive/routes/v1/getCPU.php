<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/v1/getCPU.php";



try {
    $cpu = getCPU();
    if($cpu) {
    echo jsonResponse(200, ["API" => "API"], 
        $cpu
);
    }else {
    echo jsonResponse(404, ["API" => "API"], [
        "error" => $exception->getMessage()
    ]);
    }

} catch (Exception $exception) {
    echo jsonResponse(500, ["API" => "API"], [
        "error" => "Unable to read CPU metrics",
        "status" => 500,
        "checked_at" => getCheckedAt()
    ]);
}