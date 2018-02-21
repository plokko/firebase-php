<?php
namespace Plokko\Firebase\IO;

use JsonSerializable;

class Reference implements JsonSerializable
{
    private
        $db,
        $path,

        $data=null;

    function __construct(Database $db,$path)
    {
        $this->db = $db;
        $this->path=trim($path,'/');
    }

    /**
     * Return current path
     * @param $path string optional sub path to concatenate
     * @return string
     */
    function getPath($path=''){
        return $this->path.'/'.trim($path,'/');
    }

    private function getData(){
        if(!$this->data){
            $this->data=$this->get();
        }
        return $this->data;
    }

    public function fetch(){
        $this->data=$this->get();
    }

    /**
     * @param $path
     * @return Reference
     */
    function getReference($path){
        return new Reference($this->db,$this->path.'/'.$path);
    }

    function get($path=''){
        return $this->db->get($this->getPath($path));
    }

    function set($value){
        $this->db->set($this->path,$value);
    }

    function update($path,$value){
        $this->db->update($this->getPath($path),$value);
    }

    function delete($path=''){
        $this->db->delete($this->getPath($path));
    }



    function __get($k){
        $this->getData()[$k];
    }

    function __set($path,$value){
        $this->update($this->getPath($path),$value);
    }


    function toArray(){
        return $this->getData();
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}