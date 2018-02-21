<?php
namespace Plokko\Firebase\FCM\Message;

use ArrayAccess;
use JsonSerializable;

class Data implements ArrayAccess,JsonSerializable
{
    private
        $data=[];

    function __construct($data=[]){
        $this->data = $data;
    }

    function get($k){
        return $this->data[$k];
    }

    /**
     * @param $k
     * @param $v
     * @return $this
     */
    function set($k,$v){
        $this->data[$k]=$v;
        return $this;
    }



    function fill(array $data){
        $this->data=$data;
    }
    function clear(){
        $this->data=[];
    }

    function __set($k,$v){
        $this->set($k,$v);
    }
    function __get($k){
        return $this->get($k);
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }


    public function jsonSerialize()
    {
        // Force a string : string array
        return array_map(function($v){return ''.$v;},$this->data);
    }
}