<?php
namespace Plokko\Firebase\RemoteConfig;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Plokko\Firebase\ServiceAccount;

class RemoteConfig
{
    private
        $serviceAccount,
        /**@var ClientInterface**/
        $client,
        $debug=true;


    function __construct(ServiceAccount $serviceAccount)
    {
        $this->serviceAccount = $serviceAccount;
        $this->baseUrl = 'https://firebaseremoteconfig.googleapis.com/v1/projects/'.$serviceAccount->getProjectId().'/remoteConfig';
    }


    /**
     * Get the http client instance
     * @return \GuzzleHttp\ClientInterface
     */
    private function getClient(){
        if(!$this->client){
            $this->client = $this->serviceAccount->authorize(
                    [
                        'https://www.googleapis.com/auth/firebase.remoteconfig'
                    ],
                    new Client(['debug'=>$this->debug])
                );
        }
        return $this->client;
    }

    private function getUri( $path,$validateOnly=false){
        $query = ($validateOnly)?'?validateOnly=1':'';
        return $this->baseUrl.$query;
    }

    function putConfig(\Plokko\Firebase\RemoteConfig\Models\RemoteConfig $config){
        $client = $this->getClient();
        $client->request('PUT',$this->getUri(''),[
           'json' => $config,
        ]);
    }
    function getConfig(){
        $client = $this->getClient();
        $result = $client->request('GET',$this->getUri(''));
        $json = json_decode($result->getBody(),true);
        return $json;
    }



    /**
     * Enable or disable http debugging on request
     * @param bool $debug
     */
    function setDebug($debug=false){
        $this->debug=$debug;
        $this->client=null;
    }
}