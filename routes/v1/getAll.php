<?php
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/monitoring.php"; // Nouvelle ligne
require_once __DIR__ . "/../../entities/v1/getAll.php";

try {
    $all = getAll();
    if ($all) {
        $all = processAlerts($all, 'all'); // Traitement magique factorisé
        echo jsonResponse(200, ["API" => "API"], $all);
    } else {
        echo jsonResponse(404, ["API" => "API"], ["error" => "Aucune donnée trouvée"]);
    }
} catch (Exception $exception) {
    echo jsonResponse(500, ["API" => "API"], [
        "error" => "Unable to read endpoint: " . $exception->getMessage(),
        "status" => 500,
        "checked_at" => date('c')
    ]);
}