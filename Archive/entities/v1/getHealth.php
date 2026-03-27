<?php

require_once __DIR__ . "/../../libraries/functions.php";

function getHealth(): array
{
    $result = null;
    $output = [];
    // Le ping teste la connectivité locale
    exec("ping -c 1 -W 1 " . escapeshellarg("localhost"), $output, $result);

    // On prépare le tableau de réponse
    return [
        "status"     => ($result === 0) ? "UP" : "DOWN",
        "hostname"   => getHostnames(),
        "os"         => getOS(),
        "platform"   => getPlatform(),
        "checked_at" => getCheckedAt()
    ];
}
