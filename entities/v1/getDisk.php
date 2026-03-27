<?php

require_once __DIR__ . "/../../libraries/functions.php";

function getDisk(): array
{
    return [
        "total_gb"     => getTotalDiskGB(),
        "used_gb"      => getUsedDiskGB(),
        "free_gb"      => getFreeDiskGB(),
        "used_percent" => getDiskUsedPercent(),
        "checked_at"   => getCheckedAt()
    ];
}