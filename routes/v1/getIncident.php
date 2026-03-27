<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/monitoring.php";
require_once __DIR__ . "/../../entities/v1/getIncident.php";

try {
    $incident = getIncident();
    if ($incident) {
        echo jsonResponse(200, ["API" => "API"], $incident);
    } else {
        echo jsonResponse(404, ["API" => "API"], ["error" => "Aucun incident trouvé"]);
    }
} catch (Exception $exception) {
    echo jsonResponse(500, ["API" => "API"], [
        "error" => "Unable to read Incident",
        "status" => 500,
        "checked_at" => date('c')
    ]);
}