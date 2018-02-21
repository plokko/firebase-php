<?php
$baseDir = dirname(__DIR__ );
require_once $baseDir.'/vendor/autoload.php';

use Plokko\Firebase\ServiceAccount;

//Service account credential file
$serviceCredentials = $baseDir.'/serviceAccountCredentials.json';

//-- Init the service account --//
$sa = new ServiceAccount($serviceCredentials);


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
        $this->save($item);//we don't implement deferred
        return true;
    }

    public function commit()
    {
        return true;
    }
}

$handler = new MyCustomCache();
$sa->setCacheHandler($handler);