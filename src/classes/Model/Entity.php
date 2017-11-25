<?php 

class Entity {
    public function __construct($array){
        if(is_array($array)){
            $this->hydrate($array);
        }
    }
    
    public function hydrate($array){
        foreach($array as $property => $value){
            $property = str_replace(' ', '', ucwords(strtolower(str_replace('_', ' ', $property))));
            call_user_func_array(array($this,"set".ucfirst($property)), array($value));
        }
    }
    
    public function __call($name, $arguments){
        if(method_exists($this, $name)){
            call_user_func_array(array($this,$name), $arguments);
        } else {
            if(strpos($name, "get") === 0){
                $property = lcfirst(substr($name, 3));
                
                if(property_exists($this, $property)){
                        return $this->$property;
                } else {
                    throw new Exception("Call to undefined method ".get_class($this)."::".$name."()");
                }
            } elseif(strpos($name, "set") === 0) {
                $property = lcfirst(substr($name, 3));
                
                if(property_exists($this, $property)){
                    $this->$property = $arguments[0];
                } else {
                    throw new Exception("Call to undefined method ".get_class($this)."::".$name."()");
                }
            } else {
                throw new Exception("Call to undefined method ".get_class($this)."::".$name."()");
            }
        }
    }
}