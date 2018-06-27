# Firebase php
Php implementation of Firebase API.

## Why
This package is built to be simple, scalable and configurable to allow easy integration in other packages or frameworks (ex: [laravel-firebase](https://github.com/plokko/laravel-firebase) ).

This package uses `google/auth` to generate OAuth2.0 tokens from the service account and `guzzlehttp/guzzle` as http library.
## Install
Install it with composer via 

`composer require plokko/firebase-php`

## Usage
All the calls on the API are made using a Firebase OAuth2.0 token, this token is generated using your ServiceAccount informations.
### Service Account
To use the API you need to authenticate the requests with your service account:
this is done by the `ServiceAccount` class that uses your Firebase ServiceAccount json credential file.
You can download your service account json file from the Firebase console in settings > service accounts, keep in mind to store this file in a secure non-public location.
```php 
use Plokko\Firebase\ServiceAccount;

//Use one of those methods:
$sa = new ServiceAccount('/path/to/your/serviceaccount/file.json');
$sa = new ServiceAccount('{"type":"service_account",..............}');
$sa = new ServiceAccount(['type'=>'service_account',/*...*/]);
```
Accepted methods for the constructor are:
- string: ServiceAccount file content (json string)
- string: path to the serviceAccount json file
- array: php-translated array of the service account content

You can also add a token cache handler via the `setCacheHandler` method that accepts an implementation of `CacheItemPoolInterface` to allow custom cache integrations.

see [google/auth MemoryCacheItemPool](https://github.com/google/google-auth-library-php/blob/master/src/Cache/MemoryCacheItemPool.php) for an example implementation:
```php
$handler = new Google\Auth\Cache\MemoryCacheItemPool\MemoryCacheItemPool();
$sa->setCacheHandler($handler);
```

### FCM
This package implements FCM Http v1 Api

[see FCM docs](docs/FCM.md)

### Real time database 
This package includes the Firebase Real time database API integration

[see Real time database docs](docs/DB.md)
