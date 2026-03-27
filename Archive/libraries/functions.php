<?php
ini_set('serialize_precision', -1);
function getHostnames(): string {
    return gethostname() ?: "unknown";
}

function getOS(): string {
    return strtolower(PHP_OS_FAMILY); 
}

function getPlatform(): string {
    if (getOS() === 'linux' && file_exists('/etc/os-release')) {
        $osInfo = parse_ini_file('/etc/os-release');
        return $osInfo['ID'] ?? 'linux';
    }
    return PHP_OS;
}

function getCheckedAt(): string {
    // Sun, 22 Jan 2026 22:29:16 CET
    return date('D, d M Y H:i:s T');
}
function getLogicalCores(): int
{
    return (int) shell_exec('sysctl -n hw.logicalcpu');
}

function getPhysicalCores(): int
{
    return (int) shell_exec('sysctl -n hw.physicalcpu');
}


function getTotalUsagePercent(): int
{
    $logicalCores = getLogicalCores();
    
    $psOutput = shell_exec("ps -A -o %cpu | awk '{s+=$1} END {print s}'");
    $totalUsage = (float) trim($psOutput);

    return ($logicalCores > 0) ? (int) round($totalUsage / $logicalCores) : 0;
}

function getTotalMemoryGB(): int
{
    // Commande macOS pour la RAM totale en octets
    $bytes = (float) shell_exec('sysctl -n hw.memsize');
    return (int) round($bytes / (1024 ** 3));
}

function getUsedMemoryGB(): float
{
    $vmStat = shell_exec('vm_stat');
    $pageSize = (int) shell_exec('pagesize');

    preg_match('/Pages active:\s+(\d+)\./', $vmStat, $active);
    preg_match('/Pages wired down:\s+(\d+)\./', $vmStat, $wired);
    preg_match('/Pages occupied by compressor:\s+(\d+)\./', $vmStat, $compressed);

    $pagesCount = (int)$active[1] + (int)$wired[1] + (int)$compressed[1];
    
    return ($pagesCount * $pageSize) / (1024 ** 3);
}

function getTotalDiskGB(): float
{
    $bytes = disk_total_space("/");
    return (float) number_format($bytes / (1024 ** 3), 2, '.', '');
}

function getFreeDiskGB(): float
{
    $bytes = disk_free_space("/");
    return (float) number_format($bytes / (1024 ** 3), 2, '.', '');
}

function getUsedDiskGB(): float
{
    $total = disk_total_space("/");
    $free = disk_free_space("/");
    $used = $total - $free;
    return (float) number_format($used / (1024 ** 3), 2, '.', '');
}

function getDiskUsedPercent(): float
{
    $total = disk_total_space("/");
    if ($total <= 0) return 0.0;
    
    $free = disk_free_space("/");
    $used = $total - $free;
    $percent = ($used / $total) * 100;
    
    return (float) number_format($percent, 2, '.', '');
}
