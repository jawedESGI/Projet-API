<?php

require_once __DIR__ . "/../../libraries/functions.php";
require_once __DIR__ . "/getRAM.php";
require_once __DIR__ . "/getCPU.php";
require_once __DIR__ . "/getDisk.php";
require_once __DIR__ . "/getHealth.php";

/**
 * Retourne l'intégralité des informations système formatées
 */
function getAll(): array
{
    // On récupère les données via les fonctions déjà créées
    $host   = getHealth();  // La fonction qui fait le ping et l'OS
    $cpu    = getCPU();     // La fonction avec usage, logical et physical
    $memory = getRAM();  // La fonction RAM
    $disk   = getDisk();    // La fonction Espace Disque

    return [
        "host_info" => [
            "status"     => $host['status'],
            "hostname"   => $host['hostname'],
            "os"         => $host['os'],
            "platform"   => $host['platform'],
            "checked_at" => $host['checked_at']
        ],
        "cpu_info" => [
            "total_usage_percent" => $cpu['total_usage_percent'],
            "logical_cores"       => $cpu['logical_cores'],
            "physical_cores"      => $cpu['physical_cores'],
            "checked_at"          => $cpu['checked_at']
        ],
        "memory_info" => [
            "total_gb"     => $memory['total_gb'],
            "used_gb"      => $memory['used_gb'],
            "available_gb" => $memory['free_gb'], // On renomme free_gb en available_gb ici
            "used_percent" => $memory['used_percent'],
            "checked_at"   => $memory['checked_at']
        ],
        "disk_info" => [
            "total_gb"     => $disk['total_gb'],
            "used_gb"      => $disk['used_gb'],
            "free_gb"      => $disk['free_gb'],
            "used_percent" => $disk['used_percent'],
            "checked_at"   => $disk['checked_at']
        ]
    ];
}