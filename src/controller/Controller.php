<?php
class Controller{
    public static $deps;
    
    public function __construct(Slim\Container $deps){
        Controller::$deps = $deps;
    }
}