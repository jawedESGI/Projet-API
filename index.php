<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);

require_once __DIR__ . "/libraries/path.php";
require_once __DIR__ . "/libraries/method.php";
require_once __DIR__ . "/libraries/response.php";

// Routes Avis
if (isPath("api/v1/health")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/v1/getHealth.php";
        die();
    }
}

if (isPath("api/v1/cpu")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/v1/getCPU.php";
        die();
    }
}

if (isPath("api/v1/memory")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/v1/getRAM.php";
        die();
    }
}

if (isPath("api/v1/disk")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/v1/getDisk.php";
        die();
    }
}

if (isPath("api/v1/all")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/v1/getAll.php";
        die();
    }
}

if (isPath("api/v1/incident")) {
    if (isGetMethod()) {
        require_once __DIR__ . "/routes/v1/getIncident.php";
        die();
    }
}