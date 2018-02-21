# Firebase php
Php implementation of Firebase API.

## Why
There are othe package that implements Firebase services but they are not using the latest API or over-complicated;
this package is built to be simple, scalable and configurable to allow easy integration in other packages or frameworks.

This package uses `google/auth` to generate OAuth2.0 tokens from the service account and `guzzlehttp/guzzle` as http library.
## Install
Install it with composer via 

`composer require plokko\firebase-php`

## Usage

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
```php
//NOTE: this is just an example, not a real implementation
class MyCustomCache implements \Psr\Cache\CacheItemPoolInterface{
    private
        $cache=[];
    
    public function getItem($key)
    {
        if(!isset($this->cache[$key]))
            throw new InvalidArgumentException("Item $key not found in cache!");
        return $this->cache[$key];
    }
    public function getItems(array $keys = array())
    {
        $data = [];
        foreach($keys AS $k){
            $data[$k] = $this->getItem($k);
        }
        return $data;
    }

    public function hasItem($key)
    {
        return isset($this->cache[$key]);
    }

    public function clear()
    {
        $this->cache=[];
    }

    public function deleteItem($key)
    {
        unset($this->cache[$key]);
    }

    public function deleteItems(array $keys)
    {
        foreach ($keys AS $k){
            $this->deleteItem($k);
        }
    }

    public function save(\Psr\Cache\CacheItemInterface $item)
    {
        $this->cache[$item->getKey()] = $item;
        return true;
    }


    public function saveDeferred(\Psr\Cache\CacheItemInterface $item)
    {
        $this->save($item);
        return true;
    }

    public function commit()
    {
        return true;
    }
}

$handler = new MyCustomCache();
$sa->setCacheHandler($handler);
```

### FCM
wip
### Realt time database 
wip

