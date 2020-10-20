<?php
namespace Plokko\Firebase\FCM\Message;

use InvalidArgumentException;
use JsonSerializable;

/**
 * Class AndroidConfig
 * @package Plokko\PhpFcmV1\Message
 * @see https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#AndroidConfig
 *
 * @property string $collapse_key
 * @property string $priority
 * @property string $ttl
 * @property string $restricted_package_name
 * @property Data $data
 * @property AndroidNotification $notification
 */
class AndroidConfig implements JsonSerializable
{
    const
        PRIORITY_NORMAL='normal',
        PRIORITY_HIGH='high';


    private
        $collapse_key,
        $priority = self::PRIORITY_NORMAL,
        $ttl,
        $restricted_package_name,
        $data,
        $notification;


    /**
     * Sets how long (in seconds) the message should be kept in FCM storage if the device is offline.
     * If not set by default it will be 4 weeks.
     *
     * @param string $ttl Ttl expressed as string (ex: '3.5s')
     * @return $this
     */
    function ttl($ttl){
        $this->ttl=$ttl;
        return $this;
    }

    function __get($k){
        switch($k){
            case 'data':
                if(!$this->data)
                    $this->data = new Data();
                break;
            case 'notification':
                if(!$this->notification)
                    $this->notification = new AndroidNotification();
                break;
            default:
        }
        return $this->{$k};
    }

    function __set($k,$v){
        switch($k){
            case 'priority':
                $this->setPriority($v);
                break;
            default:
        }
        $this->{$k}=$v;
    }

    /**
     * @param string $p
     * @throws InvalidArgumentException
     * @return AndroidConfig
     */
    function setPriority($p){
        switch ($p){
            default:
                throw new InvalidArgumentException('Invalid Android message priority!');
            case self::PRIORITY_NORMAL:
            case self::PRIORITY_HIGH:
                $this->priority=$p;
        }
        return $this;
    }

    function setPriorityHigh(){
        $this->priority = self::PRIORITY_HIGH;
        return $this;
    }

    function setPriorityNormal(){
        $this->priority = self::PRIORITY_NORMAL;
        return $this;
    }

    public function jsonSerialize()
    {
        return array_filter([
            'collapse_key'  => $this->collapse_key,
            'priority'      => $this->priority,
            'ttl'           => $this->ttl,
            'restricted_package_name' => $this->restricted_package_name,
            'data'          => $this->data,
            'notification'  => $this->notification,
        ]);
    }
}
