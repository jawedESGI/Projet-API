<?php

define('MONITORING_API_URL', 'https://monitoring-app.on-forge.com/api/v1/incidents');
define('MONITORING_APP_ID', '019d2ed3-b249-70c7-aaec-8923d0cd8174');
define('MONITORING_TOKEN', '61|7oaMAuOyJ8Zrfos8quOLDUva57HRnpGm9U4Gsz25dcaa279d');

/**
 * Détermine la sévérité en fonction du pourcentage
 */
function getSeverity($percent) {
    if ($percent > 90) return 'CRITICAL';
    if ($percent > 60) return 'HIGH';
    return 'LOW';
}

/**
 * Crée un incident via l'API de monitoring centralisée
 */
function triggerIncident($metricName, $percent) {
    $severity = getSeverity($percent);
    $hostname = gethostname(); 
    
    $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $formattedDateDesc = $now->format('D, d M Y H:i:s T');
    $formattedDateIso = $now->format('Y-m-d\TH:i:s');

    $payload = [
        "title" => "ALERTE {$metricName} — Utilisation à " . round($percent, 2) . "%",
        "description" => "Le serveur {$hostname} a détecté une utilisation {$metricName} anormale de " . round($percent, 2) . "% à {$formattedDateDesc}.",
        "application_id" => MONITORING_APP_ID,
        "status" => "OPEN",
        "severity" => $severity,
        "start_date" => $formattedDateIso
    ];

    $ch = curl_init(MONITORING_API_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . MONITORING_TOKEN
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        "metric" => $metricName,
        "percent" => round($percent, 2),
        "severity" => $severity,
        "incident_payload" => $payload,
        "monitoring_api_status" => $httpCode
    ];
}

function processAlerts($data, $type) {
    $incidents = [];
    $alertTriggered = false;

    // --- Vérification CPU ---
    if ($type === 'all' || $type === 'cpu') {
        // Gère le cas où la donnée est encapsulée ('cpu_info') ou directe
        $percent = $data['cpu_info']['total_usage_percent'] ?? $data['total_usage_percent'] ?? null;
        if ($percent !== null && $percent > 20) {
            $incidents[] = triggerIncident("CPU", $percent);
            $alertTriggered = true;
        }
    }

    // --- Vérification RAM ---
    if ($type === 'all' || $type === 'memory') {
        $percent = $data['memory_info']['used_percent'] ?? $data['used_percent'] ?? null;
        if ($percent !== null && $percent > 30) {
            $incidents[] = triggerIncident("RAM", $percent);
            $alertTriggered = true;
        }
    }

    // --- Vérification Disque ---
    if ($type === 'all' || $type === 'disk') {
        $percent = $data['disk_info']['used_percent'] ?? $data['used_percent'] ?? null;
        if ($percent !== null && $percent > 30) {
            $incidents[] = triggerIncident("Disque", $percent);
            $alertTriggered = true;
        }
    }

    // Ajout des indicateurs dans le tableau de réponse
    $data['alert_triggered'] = $alertTriggered;
    if ($alertTriggered) {
        $data['incidents'] = $incidents;
    }

    return $data;
}