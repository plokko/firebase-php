<?php
namespace Plokko\Firebase\FCM\Message\Apns;

use JsonSerializable;

/**
 * ApnsConfig payload
 * @package Plokko\Firebase\FCM\Message
 * @see https://developer.apple.com/library/archive/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/CreatingtheNotificationPayload.html#//apple_ref/doc/uid/TP40008194-CH10-SW1
 *
 * @property-read ApsData $aps
 */
class ApnsPayload implements JsonSerializable
{
    private
        /** @var ApsData */
        $aps;
    private
        /**@var array Custom data for app (acme)**/
        $app_data=[];

    function __get($k)
    {
        if($k==='aps'){
            if(!$this->aps)
                $this->aps = new ApsData();
            return $this->aps;
        }
        return array_key_exists($k,$this->app_data)?$this->app_data[$k]:null;
    }

    function __set($k, $v)
    {
        if($k==='aps'){
            throw new \InvalidArgumentException('aps is a reserved keyword');
        }
        $this->app_data[$k] = $v;
    }

    public function jsonSerialize()
    {
        return array_filter(array_merge($this->app_data,[
            'aps'=>$this->aps,
        ]));
    }
}