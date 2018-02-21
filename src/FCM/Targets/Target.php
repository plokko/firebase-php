<?php
namespace Plokko\Firebase\FCM\Targets;
use JsonSerializable;
use ReflectionClass;

/**
 * Generic FCM message target
 * @package Plokko\PhpFcmV1\Targets
 */
abstract class Target implements JsonSerializable
{
    protected
        $value;

    /**
     * Target constructor.
     * @param $value string
     */
    final function __construct($value)
    {
        $this->value = $value;
    }

    public function jsonSerialize(){
        return [ strtolower((new ReflectionClass($this))->getShortName()) => $this->value ];
    }

}