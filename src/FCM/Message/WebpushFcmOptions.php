<?php

namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;

/**
 * Class WebpushFcmOptions
 * @package Plokko\PhpFcmV1\Message
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#WebpushFcmOptions
 *
 * @property string $link
 */
class WebpushFcmOptions implements JsonSerializable
{
    private
        /** @var string **/
        $link;

    function __get($k)
    {
        return $this->{$k};
    }

    function __set($k, $v)
    {
        $this->{$k}=$v;
    }

    public function jsonSerialize()
    {
        return array_filter([
            'link' => $this->link,
        ]);
    }
}