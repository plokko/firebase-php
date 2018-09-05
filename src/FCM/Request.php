<?php
namespace Plokko\Firebase\FCM;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Plokko\Firebase\FCM\Exceptions\FcmErrorException;
use Plokko\Firebase\ServiceAccount;

/**
 * FCM Request
 * @package Plokko\PhpFcmV1
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages/send#request-body
 */
class Request
{
    private
        /**@var ServiceAccount**/
        $serviceAccount,
        /**@var ClientInterface|null **/
        $client;

    public
        /**@var boolean Flag for testing the request without actually delivering the message. **/
        $validate_only = false;

    /**
     * Request constructor.
     * @param bool $validate_only Flag for testing the request without actually delivering the message.
     */
    function __construct(ServiceAccount $account,$validate_only=false,ClientInterface $client=null)
    {
        $this->serviceAccount = $account;
        $this->validate_only = $validate_only;
        $this->client = $client;
    }

    /**
     * Set a custom Http client (GuzzleHttp)
     * @param ClientInterface $client Client that will be used in the request
     */
    function setHttpClient(ClientInterface $client){
        $this->client = $client;
    }

    function validateOnly($validate=true){
        $this->validate_only = $validate;
    }


    private function getPayload(Message $message){
        return [
            'validate_only' => $this->validate_only,
            'message'       => $message->getPayload(),
        ];
    }

    /**
     * Submits a message
     * @param Message $message
     * @throws FcmErrorException
     * @throws GuzzleException
     * @return string|null submitted message name
     * @internal Only use Message submit
     */
    public function submit(Message $message){
        $payload = $this->getPayload($message);

        // Add OAuth 2.0 token to the request
        $client = $this->serviceAccount->authorize('https://www.googleapis.com/auth/firebase.messaging',$this->client);

        // FCM v1 Api URL
        $apiUrl = 'https://fcm.googleapis.com/v1/projects/'.$this->serviceAccount->getProjectId().'/messages:send';

        try{
            $rq = $client->request('POST',$apiUrl,['json' => $payload]);

            $json = json_decode($rq->getBody(),true);

            return ($json && isset($json['name']))?$json['name']:null;//Returns the message id

        }catch(RequestException $e){
            throw FcmErrorException::cast($e);
        }
    }
}