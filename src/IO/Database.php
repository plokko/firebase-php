<?php
namespace Plokko\Firebase\IO;

use GuzzleHttp\Client;
use Plokko\Firebase\ServiceAccount;

class Database{
    /**@var \Plokko\Firebase\ServiceAccount **/
    private $serviceAccount;
    /**@var string **/
    private $baseUrl;

    /**@var \GuzzleHttp\ClientInterface **/
    private $client;
    private $debug=false;

    function __construct(ServiceAccount $serviceAccount)
    {
        $this->serviceAccount = $serviceAccount;
        $this->baseUrl = 'https://'.$serviceAccount->getProjectId().'.firebaseio.com/';
    }

    /**
     * @param $path
     * @return Reference
     */
    function getReference($path){
        return new Reference($this,$path);
    }

    function __get($path){
        return $this->getReference($path);
    }
    function __set($path,$value){

    }

    /**
     * Get the http client instance
     * @return \GuzzleHttp\ClientInterface
     */
    private function getClient(){
        if(!$this->client){
            $this->client = $this->serviceAccount->authorize(['https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/firebase.database'], new Client(['debug'=>$this->debug]));
        }
        return $this->client;
    }

    private function getUriPath($path){
        return $this->baseUrl.trim($path,'/').'.json';
    }

    function get($path){
        $response =  $this->getClient()->request('GET',$this->getUriPath($path));
        return json_decode($response->getBody(),true);
    }

    function set($path,$value){
        $this->getClient()->request('PUT',$this->getUriPath($path),['json'=>$value]);
    }

    function update($path,$value){
        $this->getClient()->request('PATCH',$this->getUriPath($path),['json'=>$value]);
    }

    function delete($path){
        $this->getClient()->request('DELETE',$this->getUriPath($path),[]);
    }


    function setDebug($debug=false){
        $this->debug=$debug;
        $this->client=null;
    }
}
