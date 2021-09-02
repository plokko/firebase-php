<?php
namespace Plokko\Firebase\FCM\Exceptions;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Throwable;

/**
 * FcmError exception
 * @package Plokko\Firebase\FCM\Exceptions
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/ErrorCode
 */
abstract class FcmErrorException extends Exception
{
    protected
        $status,
        $details;

    /**
     * Get the FCM ErrorCode enum
     * @see https://firebase.google.com/docs/reference/fcm/rest/v1/ErrorCode
     * @return string
     */
    function getErrorCode(){
        return $this->status;
    }

    /**
     * @return array
     */
    function getDetail(){
        return $this->details;
    }

    /**
     * @return string
     */
    function getDetailAsString(){
        return json_encode($this->details,JSON_PRETTY_PRINT);
    }

    function __construct($status,$code,$message,array $details=null,Throwable $previous = null)
    {
        $this->status = $status;
        $this->details = $details;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param RequestException $e
     * @return RequestException|FcmErrorException returns an FcmException or a generic http exception if provided error is not a valid FcmError
     */
    static function cast(RequestException $e){
        $response = $e->getResponse();
        if (empty($response)){
            return $e;
        }
        $json = json_decode($response->getBody(),true);

        if(!$json || empty($json['error']['status'])){
            //Not a valid FcmError
            return $e;
        }

        $status = $json['error']['status'];
        $code = isset($json['error']['code']) ? $json['error']['code'] : 0;
        $message = isset($json['error']['message']) ? $json['error']['message'] : null;
        $details = isset($json['error']['details']) ? $json['error']['details'] : null;

        switch ($status){            
            case 'UNSPECIFIED_ERROR':
                return new UnspecifiedErrorException($status,$code,$message,$details);
            case 'INVALID_ARGUMENT':
                return new InvalidArgumentException($status,$code,$message,$details);
            case 'UNREGISTERED':
                return new UnregisteredException($status,$code,$message,$details);
            case 'SENDER_ID_MISMATCH':
                return new SenderIdMismatchException($status,$code,$message,$details);
            case 'QUOTA_EXCEEDED':
                return new SenderIdMismatchException($status,$code,$message,$details);
            case 'APNS_AUTH_ERROR':
                return new ApnsAuthErrorException($status,$code,$message,$details);
            case 'UNAVAILABLE':
                return new UnavailableException($status,$code,$message,$details);
            case 'INTERNAL':
                return new InternalException($status,$code,$message,$details);
            case null:
                return $e;
            default:
                return new UnspecifiedErrorException($status,$code,$message,$details);;

        }
    }
}
