<?php

class Consumer extends Common_Controller {
    
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        
    }
    
    function show_notification($consumer_id) {
        
        include CODE_BASE_DIR . '/consumer_notification.php';
        return;
    }
}