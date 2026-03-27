<?php

require_once __DIR__ . "/../../libraries/functions.php";
require_once __DIR__ . "/../../libraries/monitoring.php"; // Pour utiliser MONITORING_APP_ID et MONITORING_TOKEN

function getIncident(): array
{
    // Construction de l'URL avec l'ID de l'application
    $url = "https://monitoring-app.on-forge.com/api/v1/applications/" . MONITORING_APP_ID . "/incidents";

    // Initialisation de cURL pour une requête GET
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Bearer ' . MONITORING_TOKEN
    ]);

    // Exécution de la requête
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $formattedIncidents = [];

    // Si la requête a réussi
    if ($httpCode === 200 && $response) {
        $apiIncidents = json_decode($response, true);
        
        /* * On boucle sur la réponse pour s'assurer de renvoyer exactement 
         * les champs demandés par votre consigne.
         * (Si l'API distante renvoie un format "{"data": [...]}", 
         * changez $apiIncidents par $apiIncidents['data'])
         */
        if (is_array($apiIncidents)) {
            foreach ($apiIncidents as $incident) {
                $formattedIncidents[] = [
                    "id"         => $incident['id'] ?? null,
                    "title"      => $incident['title'] ?? 'Titre inconnu',
                    "severity"   => $incident['severity'] ?? 'LOW',
                    "status"     => $incident['status'] ?? 'OPEN',
                    "start_date" => $incident['start_date'] ?? null
                ];
            }
        }
    }

    // Retourne le tableau formaté comme attendu par votre endpoint final
    return [
        "incidents"  => $formattedIncidents,
        "total"      => count($formattedIncidents),
        "checked_at" => getCheckedAt()
    ];
}