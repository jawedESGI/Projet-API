<?php

require_once __DIR__ . "/../../libraries/functions.php";

function getCPU(): array
{
    return [
        "total_usage_percent" => getTotalUsagePercent(),
        "logical_cores"       => getLogicalCores(),
        "physical_cores"      => getPhysicalCores(),
        "checked_at"          => getCheckedAt()
    ];
}