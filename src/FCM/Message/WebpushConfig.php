<?php

namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;

/**
 * Class WebpushConfig
 * @package Plokko\PhpFcmV1\Message
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#WebpushConfig
 *
 * @property array $headers
 * @property array $data
 * @property WebPushNotification $notification
 */
class WebpushConfig implements JsonSerializable
{
    private
        /** @var array **/
        $headers,

        /** @var array **/
        $data,

        /** @var WebPushNotification **/
        $notification;

    function __get($k)
    {
        if ($k === 'notification') {
            if(!$this->notification) {
                $this->notification = new WebPushNotification();
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
            'headers'        => $this->headers,
            'data'           => $this->data,
            'notification'   => $this->notification,
        ]);
    }
}