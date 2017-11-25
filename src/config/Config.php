<?php

class Config {
    /**
     * Configuration object
     * @var stdClass
     */
    private $config;
    
    public function __construct($config_ini){
        $this->addIni($config_ini);
    }
    
    /**
     * Adds configuration ini to application configuration
     * If ini overlapse, the last ini will be the one taken
     * @param string $config_ini
     */
    public function addIni($config_ini){
        $config_array = parse_ini_file($config_ini, true);
        
        foreach($config_array as $section => $config_section){
            if(!isset($this->config->$section)){
                $this->config->$section = new stdClass();
            }
            
            foreach($config_section as $config_key => $config_value){
                $this->config->$section->$config_key = $config_value;
            }
        }
    }
    
    /**
     * Returns a specific configuration value, or section, or all configuration
     * @param String $section The section to search for. If empty, will return all configuration
     * @param String $config_key The config key to search for. If empty, will return all section
     * @return String|stdClass The configuration searched for, or null if no value matches section / config_key
     */
    public function getConfig($section = null, $config_key = null){
        if($section != null){
            if($config_key != null){
                return $this->config->$section->$config_key;
            } else {
                return $this->config->$section;
            }
        } else {
            return $this->config;
        }
    }
}