<?php

require_once __DIR__ . "/../../libraries/functions.php";

function getRAM(): array
{
    $total = getTotalMemoryGB();
    $used = getUsedMemoryGB();
    $free = $total - $used;
    
    $percent = ($total > 0) ? round(($used / $total) * 100, 2) : 0;

    return [
        "total_gb"     => $total,
        "used_gb"      => $used,
        "free_gb"      => $free,
        "used_percent" => $percent,
        "checked_at"   => getCheckedAt()
    ];
}