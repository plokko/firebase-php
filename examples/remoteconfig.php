<?php
$baseDir = dirname(__DIR__ );
require_once $baseDir.'/vendor/autoload.php';

use Plokko\Firebase\RemoteConfig\RemoteConfig;
use Plokko\Firebase\ServiceAccount;

//Service account credential file
$serviceCredentials = $baseDir.'/serviceAccountCredentials.json';

$sa = new ServiceAccount($serviceCredentials);

// NOTE: RemoteConfig API is still NOT AVAILABLE: this is just a stub!
$config = new RemoteConfig($sa);
$config->setDebug(true);

try{
    $rconfig = $config->getConfig();
    var_dump($rconfig);
}catch(\GuzzleHttp\Exception\ClientException $e){
    $response = $e->getResponse();
    echo $e;
    echo $response->getBody();
}