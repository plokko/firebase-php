# FCM
This plugin integrates Firebase Cloud Messaging Http v1 api, the API, as in the docs, supports only sending messages.

The basic building block of the message is the `Message` class
```php
use Plokko\Firebase\FCM\Message;
$message = new Message();
```
This class contains all the API V1 objects like `Notification`
```
//Set the message notification
$message->notification
    ->setTitle('My notification title')
    ->setBody('My notification body....');
```
The `Data` payload
```php
$message->data->fill([
    'a'=>1,
    'b'=>'2',
]);
$message->data->set('x','value');
$messsage->data->y='Same as above';
```
And system-specific configuration like `AndroidConfig`, `WebpushConfig` and `ApnsConfig`.

The message require that the `Target` parameter is specified with either a single device (`Token`) `Topic` or `Condition`
```php
$message->setTarget(new Token('your-fcm-device-token'));
//Or
$message->setTarget(new Topic('your-fcm-topic'));
//Or
$message->setTarget(new Condition('your-fcm-conditions'));
```
If this value is not set the message will throw an error before submitting.


Before submitting we need to downloaded a JSON file with your service account credentials (see https://firebase.google.com/docs/admin/setup#initialize_the_sdk ).

This file is needed to initialize the class `ServiceAccount` that's used to generate an OAuth2 token for the FCM request.
```php
// Prepare service account
$sa = new ServiceAccount('path/to/your/firebase-credentials.json');
```

The `ServiceAccount` will not be used directly to submit the message but to build the `Request`:
```php
$request = new Request($sa);
```
For testing purpuses you can also set the `validate_only` parameter to test the message in Firebase without submitting it to the device;
the Request's http client can also be overriddent with a custom GuzzleHttp client.
```php
//Custom http client
$myClient = new Client(['debug'=>true]);

$request->setHttpClient($myClient);
$request->validate_only = true; 
//or
$request->validateOnly(true);
```

To send the `Message` use the `send` method:
```php
$message->send($request);
```
If the function will not throw a `FcmError`, `BadRequest` or a generic `GuzzleException` the message has been successfully sent and, if it's not a validate_only request, the message name will be populated.

```php
//after submitting:
echo 'my message name:'.$message->name; 
``

If you want to use the validate_only without modifying the request the `validate` method will force the validate_only flag on the request.
```php
$request->validateOnly(false);
$message->validate($request);//will be a validate_only request anyway
```
### Error handling
The `send` methods throw a `FcmErrorException` implementation:
you can either catch a generic `FcmErrorException` and switch throught the error codes
```php
try{
    $message->send($rq);
}catch(FcmErrorException $e){
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
```
Or directly catch the implementation

you can either catch a generic `FcmErrorException` and switch throught the error codes
```php
try{
    $message->send($rq);
}catch(UnregisteredException $e){
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
```

### Examples

[full example](/examples/fcm_example.php)


## Trubleshooting:
If you get a 403 error _"Firebase Cloud Messaging API has not been used in project <project_name> before..."_ that's because the new v1 API is not enabled automatically (even if you genereated the credentials from Firebase Console and the legacy Api works).

You need to enable it from this page: https://console.developers.google.com/apis/api/fcm.googleapis.com/overview
