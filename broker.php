<?php

class Broker extends Common_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        echo 'Please specify a valid method';
        die;
    }
    
    function get_notification($consumer_id, $previous_msg_acknowledged = FALSE) {
        $redis_key = get_redis_notification_prefix() . $consumer_id;
        if ($previous_msg_acknowledged) {
          $this->redis->lpop($redis_key);    
        }
        $notification = $this->redis->lindex($redis_key, 0);
        echo $notification ? $notification : '';
    }    
}