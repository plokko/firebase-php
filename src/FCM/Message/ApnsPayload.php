<?php
namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;

/**
 * ApnsConfig payload
 * @package Plokko\Firebase\FCM\Message
 * @see https://goo.gl/32Pl5W
 */
class ApnsPayload implements JsonSerializable
{
    public
        /** @var ApnsAlert|string */
        $alert,

        /** @var int */
        $badge,

        /** @var string */
        $sound,

        /** @var int */
        $content_available,

        /** @var string */
        $category,

        /** @var string */
        $thread_id;

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
            'alert' => $this->alert,
            'badge' => $this->badge,
            'sound' => $this->sound,
            'content-available' => $this->content_available,
            'category' => $this->category,
            'thread-id' => $this->thread_id,
        ]);
    }
}