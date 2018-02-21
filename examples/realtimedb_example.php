<?php
$baseDir = dirname(__DIR__ );
require_once $baseDir.'/vendor/autoload.php';

use Plokko\Firebase\IO\Database;
use Plokko\Firebase\ServiceAccount;

;

//Service account credential file
$serviceCredentials = $baseDir.'/serviceAccountCredentials.json';

//-- Init the service account --//
$sa = new ServiceAccount($serviceCredentials);

//-- Get the database object --//
$db = new Database($sa);

//-- Get an object reference --//
$test = $db->getReference('test');
//-- Set an object value ---//
$test->aaaa = ['a'=>1,2=>'number id','ccc'=>['a'=>1,'b'=>2,'c'=>3]];

$test_123 = $test->getReference('123');

$test_123->set(['asdasdasd','ffff']);

//Get a reference value
print_r($test_123->get());
