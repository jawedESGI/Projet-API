<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/monitoring.php";
require_once __DIR__ . "/../../entities/v1/getDisk.php";

try {
    $disk = getDisk();
    if ($disk) {
        $disk = processAlerts($disk, 'disk');
        echo jsonResponse(200, ["API" => "API"], $disk);
    } else {
        echo jsonResponse(404, ["API" => "API"], ["error" => "Aucune donnée Disque trouvée"]);
    }
} catch (Exception $exception) {
    echo jsonResponse(500, ["API" => "API"], [
        "error" => "Unable to read Disk metrics",
        "status" => 500,
        "checked_at" => date('c')
    ]);
}