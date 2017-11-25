<?php
class Controller{
    public static $deps;
    
    /**
     * Logger général
     * @var \Monolog\Logger
     */
    public static $logger;
    
    /**
     * Configuration
     * @var Config
     */
    public static $conf;
    
    public function __construct(Slim\Container $deps){
        Controller::$deps = $deps;
        Controller::$logger = $deps->logger;
        Controller::$conf = $deps->conf;
        
        global $smarty;
        if(isset($_SESSION['user'])){
            $user = AppUser::findAppUserById($_SESSION['user']);
            $smarty->assignByRef("user", $user);
        }
    }
}