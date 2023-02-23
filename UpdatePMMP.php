<?php
declare(strict_types=1);

$channel = "stable";
if($argc === 2 && strtolower($argv[1]) === "-alpha") {
    $channel = "alpha";
}
@mkdir(__DIR__ . "/server");
if(file_exists(getcwd() . "/server/PocketMine-MP.phar")){
    unlink(getcwd() . "/server/PocketMine-MP.phar");
}

$contents = json_decode(file_get_contents("https://update.pmmp.io/api?channel={$channel}"), true);
echo("    - Found PocketMine-MP {$contents["base_version"]} for MCPE v{$contents["mcpe_version"]} -\n");
if(!copy($contents["download_url"], getcwd() . "/server/PocketMine-MP.phar")){
    throw new \RuntimeException("Failed to download PocketMine-MP.phar");
}
echo("    - PocketMine-MP Update Completed -\n");
