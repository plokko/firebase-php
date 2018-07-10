<?php

namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;
use Plokko\Firebase\FCM\Message\Apns\ApnsPayload;

/**
 * Class ApnsConfig
 * @package Plokko\Firebase\FCM\Message
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#apnsconfig
 * @property array $headers
 * @property ApnsPayload $payload
 */
class ApnsConfig implements JsonSerializable
{
    private
        /**
         * @var array HTTP request headers defined in Apple Push Notification Service. Refer to APNs request headers for supported headers, e.g. "apns-priority": "10".
         * @see https://goo.gl/C6Yhia
         **/
        $headers=[],

        /** @var ApnsPayload **/
        $payload;

    function __get($k)
    {
        if ($k === 'payload') {
            if (!$this->payload) {
                $this->payload = new ApnsPayload();
            }
        }

        return $this->{$k};
    }

    function __set($k, $v)
    {
        $this->{$k}=$v;
    }

    public function jsonSerialize()
    {
        return array_filter([
            'headers' => $this->headers,
            'payload' => $this->payload,
        ]);
    }
}
