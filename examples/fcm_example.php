<?php
$baseDir = dirname(__DIR__ );
require_once $baseDir.'/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Plokko\Firebase\FCM\Exceptions\FcmErrorException;
use Plokko\Firebase\FCM\Message;
use Plokko\Firebase\FCM\Request;
use Plokko\Firebase\FCM\Targets\Token;
use Plokko\Firebase\ServiceAccount;

//Service account credential file
$serviceCredentials = $baseDir.'/serviceAccountCredentials.json';

//-- Init the service account --//
$sa = new ServiceAccount($serviceCredentials);

//-- Create a new FCM message --//
$message = new Message();

//- Add a notification -//

$message->notification
            ->setTitle('Notification title')
            ->setBody('notification body');

//- Add data payload -//
// Note: the payload only accepts string values, all the values will be automatically cast to string
// Various method of filling data
$message->data->fill([
   'key1'=>'value1'
]);
$message->data->set('key2','value2');
$message->data->key3 = 'value3';
$message->data['key4'] = 4;// will be automatically cast to string

//- Device specific configuration -//
// you can set device-specific configuration via android, webpush and apns proprieties
$message->android->ttl = '10.4s';
$message->android->setPriorityHigh();
$message->android->data->fill(['android-specific'=>'data']);

//- Set the target -//
$target = new Token('my-device-token');// or Topic('topic-name') or Group('group-name');
$message->setTarget($target);


//- Submit the message -//
//you can set an (optional) custom client
$client = new Client(['debug'=>true]);
//If true the validate_only is set to true the message will not be submitted but just checked with FCM
$validate_only = true;
//Create a request
$rq = new Request($sa,$validate_only,$client);

try{
    //Use the request to submit the message
    $message->send($rq);

    //You can force the validate_only flag via the validate method, the request will be left intact
    $message->validate($rq);
}
/** Catch all the exceptions @see https://firebase.google.com/docs/reference/fcm/rest/v1/ErrorCode **/
//Like this
catch(FcmErrorException $e){
    switch($e->getErrorCode()){
        default:
        case 'UNSPECIFIED_ERROR':
        case 'INVALID_ARGUMENT':
        case 'UNREGISTERED':
        case 'SENDER_ID_MISMATCH':
        case 'QUOTA_EXCEEDED':
        case 'APNS_AUTH_ERROR':
        case 'UNAVAILABLE':
        case 'INTERNAL':
    }
    echo 'FCM error ['.$e->getErrorCode().']: ',$e->getMessage();
}
// OR like this:
/*
catch(UnregisteredException $e){
    //Token no longer valid: we should delete it from our db
}catch(InvalidArgumentException $e){
    //We did something wrong with the data
}catch(SenderIdMismatchException $e){
    //Something is wrong with auth info
}catch(ApnsAuthErrorException $e){
    //Something is wrong with apn auth
}catch( QuotaExceededException  $e){
    //Too much messages!
}catch(UnavailableException $e){
    //The server is overloaded.
}catch( UnspecifiedErrorException  $e){
    //No more information is available about this error.
}catch( InternalException  $e){
    //An unknown FCM internal error occurred.
}
//*/
// Catch generic http errors:
catch(RequestException $e){
    //HTTP response error
    $response = $e->getResponse();
    echo 'Got an http response error:',$response->getStatusCode(),':',$response->getReasonPhrase();
}
catch(GuzzleException $e){
    //GuzzleHttp generic error
    echo 'Got an http error:',$e->getMessage();
}