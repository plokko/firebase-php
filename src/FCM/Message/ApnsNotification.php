<?php
namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;

/**
 * Class ApnsNotification
 * @package Plokko\PhpFcmV1\Message
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#ApnsConfig
 */
class ApnsNotification implements JsonSerializable
{
    public
        /** @var ApnsAlertConfig|string */
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

    public function __construct()
    {
        /**
         * ApnsAlertConfig by default, but string
         * value is also valid.
         */
        $this->alert = new ApnsAlertConfig();
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