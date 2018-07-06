<?php

namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;

/**
 * Class ApnsAlertConfig
 * @package Plokko\Firebase\FCM\Message
 *
 * Representation of "alert" property
 * on apple notification.
 *
 * @see https://developer.apple.com/library/archive/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/PayloadKeyReference.html
 */
class ApnsAlertConfig implements JsonSerializable
{
    private
        /** @var string **/
        $title,

        /** @var string **/
        $body,

        /** @var string|null **/
        $title_loc_key,

        /** @var array|null **/
        $title_loc_args,

        /** @var string|null **/
        $action_loc_key,

        /** @var string **/
        $loc_key,

        /** @var array **/
        $loc_args,

        /** @var string **/
        $launch_image;

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
            'title' => $this->title,
            'body' => $this->body,
            'title-loc-key' => $this->title_loc_key,
            'title-loc-args' => $this->title_loc_args,
            'action-loc-key' => $this->action_loc_key,
            'loc-key' => $this->loc_key,
            'loc-args' => $this->loc_args,
            'launch-image' => $this->launch_image,
        ]);
    }
}