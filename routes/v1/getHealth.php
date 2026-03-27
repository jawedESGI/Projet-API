<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/v1/getHealth.php";



try {
    $health = getHealth();
    if($health) {
    echo jsonResponse(200, ["API" => "API"], 
        $health
);
    }else {
    echo jsonResponse(404, ["API" => "API"], [
        "error" => $exception->getMessage()
    ]);
    }

} catch (Exception $exception) {
    echo jsonResponse(500, ["API" => "API"], [
        "error" => "Unable to reach Endpoint",
        "status" => 500,
        "checked_at" => getCheckedAt()
    ]);
}