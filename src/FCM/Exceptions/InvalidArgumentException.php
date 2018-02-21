<?php
namespace Plokko\Firebase\FCM\Exceptions;


use Throwable;

class InvalidArgumentException extends FcmErrorException
{
    private
        $detailsAsString='';

    function __construct($status, $code, $message, array $details = null, Throwable $previous = null)
    {

        if($details){
            $badRequests = array_filter($details,function ($v){
                return $v['@type'] === 'type.googleapis.com/google.rpc.BadRequest';
            });
            $violations=[];
            foreach($badRequests AS $br){
                foreach($br['fieldViolations'] AS $violation){
                    $violations[] = $violation['description'].' in '.$violation['field'];
                }
            }
            if(count($violations)>0){
                $this->detailsAsString = implode(', ',$violations);
                $message.=' ( '.$this->detailsAsString.' )';
            }
        }


        parent::__construct($status, $code, $message, $details, $previous);
    }


    function getDetailAsString()
    {
        return $this->detailsAsString;
    }
}