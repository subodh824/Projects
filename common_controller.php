<?php

class Common_Controller {
    private static $instance;
    var $notification_redis_key_prefix;
    
    public function __construct() {
        self::$instance = &$this;
    }
    
    public static function &get_instance() {
        return self::$instance;
    }
    
    public function setup_redis_connection() {
        require CODE_BASE_DIR . '/Predis/autoload.php';
        Predis\Autoloader::register();
        $redis = new Predis\Client(array(
            "scheme" => "tcp",
            "host" => "127.0.0.1",
            "port" => 6379)); 
        return $redis;
    }
    
}