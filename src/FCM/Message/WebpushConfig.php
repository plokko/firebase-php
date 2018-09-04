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
 * @property WebpushFcmOptions $fcm_options
 */
class WebpushConfig implements JsonSerializable
{
    private
        /** @var array **/
        $headers,

        /** @var array **/
        $data,

        /** @var WebPushNotification **/
        $notification,

        /** @var WebpushFcmOptions **/
        $fcm_options;

    function __get($k)
    {
        if ($k === 'notification') {
            if(!$this->notification) {
                $this->notification = new WebPushNotification();
            }
        }

        if ($k === 'fcm_options') {
            if(!$this->fcm_options) {
                $this->fcm_options = new WebpushFcmOptions();
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
            'fcm_options'   => $this->fcm_options,
        ]);
    }
}