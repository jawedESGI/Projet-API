<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/v1/getRAM.php";



try {
    $ram = getRAM();
    if($ram) {
    echo jsonResponse(200, ["API" => "API"], 
        $ram
);
    }else {
    echo jsonResponse(404, ["API" => "API"], [
        "error" => $exception->getMessage()
    ]);
    }

} catch (Exception $exception) {
    echo jsonResponse(500, ["API" => "API"], [
        "error" => "Unable to read RAM metrics",
        "status" => 500,
        "checked_at" => getCheckedAt()
    ]);
}