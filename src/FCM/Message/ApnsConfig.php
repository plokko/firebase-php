<?php

namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;

/**
 * Class ApnsConfig
 * @package Plokko\Firebase\FCM\Message
 *
 * @property array $headers
 * @property ApnsNotification $payload
 */
class ApnsConfig implements JsonSerializable
{
    private
        /** @var array **/
        $headers,

        /** @var ApnsNotification **/
        $payload;

    function __get($k)
    {
        if ($k === 'payload') {
            if (!$this->payload) {
                $this->payload = new ApnsNotification();
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