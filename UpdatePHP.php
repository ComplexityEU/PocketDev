<?php
declare(strict_types=1);

$basePhpBuild = "PHP-Windows-x64-";
$phpBuild = $basePhpBuild . "PM4";
if($argc === 2 && strtolower($argv[1]) === "-alpha") {
    $phpBuild = $basePhpBuild . "PM5";
}
$zipBuild = $phpBuild . ".zip";

@mkdir(__DIR__ . "/php-binaries");

$zipDirPath = getcwd() . "/php-binaries/{$zipBuild}";
$regDirPath = getcwd() . "/php-binaries/{$phpBuild}";

if(file_exists($zipDirPath)) {
    unlink($zipDirPath);
}
echo("    - Starting PHP Update -\n");
if(!copy("https://github.com/pmmp/PHP-Binaries/releases/latest/download/{$zipBuild}", $zipDirPath)) {
    throw new RuntimeException("Failed to download {$zipBuild}");
}

$zip = new ZipArchive();
if($zip->open("{$zipDirPath}", ZipArchive::CREATE)) {
    $zip->extractTo($regDirPath);
    $zip->close();

    echo("    - Successfully updated and extracted {$zipBuild} -\n");
} else {
    throw new RuntimeException("Failed to extract {$zipBuild}");
}