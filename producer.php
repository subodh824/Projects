<?php

class Producer extends Common_Controller {
    
    var $consumers;
    
    function __construct() {
        parent::__construct();
        $this->consumers = array(1, 2); //consumer id
    }
    
    function index() {
        $methods = get_class_methods(get_class());
        echo 'Please specify producer function . Exiting ... <br><br>';
        foreach ($methods as $method) {
            if ($method == '__construct' || $method == 'index')                continue;
            echo $method . '<br>';
        } 
        die;
    }
    
    function clear_saved_notification($consumer_id = FALSE) {
        if ($consumer_id > 0) {
          $this->redis->del(get_redis_notification_prefix() . $consumer_id);
        } else {
            foreach ($this->consumers as $consumer_id) {
                $this->clear_saved_notification($consumer_id);
            }
        }
        return TRUE;
    }
    
    function populate_consumer_notification($id, $notificaiton_count_per_consumer = 10) {
        foreach ($this->consumers as $consumer_id) {
            if ($consumer_id != $id)                continue;
            echo '<pre>';
            echo 'Created Notification objects for Consumer ID : ' . $id .'.<br>';
            for ($i = 0; $i < $notificaiton_count_per_consumer; ++$i) {
               $notificaiton = $this->queue_notification($consumer_id, $i);
               print_r($notificaiton);
            }
        }
    }
    
    function generateRandomString($length = 10, $offset = 0) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function queue_notification($consumer_id, $offset = 0) {
        $ts = strtotime('now');
        $notification = array(
            'receiverId' => $consumer_id,
            'text' => $this->generateRandomString(rand(10, 20), $offset),
            'timestamp' => $ts
        );
        $notification_encoded = json_encode($notification);
        $consumer_notification_redis_key = get_redis_notification_prefix() . $consumer_id;
        $this->redis->rpush($consumer_notification_redis_key,  $notification_encoded);
        return $notification;
    }

}