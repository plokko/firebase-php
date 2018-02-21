<?php
namespace Plokko\Firebase\FCM\Message;

use JsonSerializable;

/**
 * Class AndroidNotification
 * @package Plokko\PhpFcmV1\Message
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#AndroidNotification
 */
class AndroidNotification implements JsonSerializable
{
    public
        /**@var string**/
        $title,
        /**@var string**/
        $body,
        /**@var string**/
        $icon,
        /**@var string**/
        $color,
        /**@var string**/
        $sound,
        /**@var string**/
        $tag,
        /**@var string**/
        $click_action,
        /**@var string**/
        $body_loc_key,
        /**@var array**/
        $body_loc_args,
        /**@var string**/
        $title_loc_key,
        /**@var array**/
        $title_loc_args;

    function __get($k){return $this->{$k};}
    function __set($k,$v){$this->{$k}=$v;}

    public function jsonSerialize()
    {
        return array_filter([
            'title' => $this->title,
            'body' => $this->body,
            'icon' => $this->icon,
            'color' => $this->color,
            'sound' => $this->sound,
            'tag' => $this->tag,
            'click_action' => $this->click_action,
            'body_loc_key' => $this->body_loc_key,
            'body_loc_args' => $this->body_loc_args,
            'title_loc_key' => $this->title_loc_key,
            'title_loc_args' => $this->title_loc_args,
        ]);
    }
}