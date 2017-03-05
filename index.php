<?php

define('CODE_BASE_DIR', realpath(dirname(__FILE__)));
include CODE_BASE_DIR . '/common_controller.php';

$load_class = 'Common_Controller';

$request_uri = explode('/', trim($_SERVER['REQUEST_URI']));


function get_redis_notification_prefix() {
    return 'notification:consumer:';
}

function show_404() {
    $message = "The page you requested was not found.";

    echo $message;
    exit;
}

if (isset($request_uri[1]) && $request_uri[1] == 'producer') {
  $load_class = 'Producer';  
} else if (isset($request_uri[1]) && $request_uri[1] == 'consumer') {
    $load_class = 'Consumer';
} else if (isset($request_uri[1]) && $request_uri[1] == 'broker') {
    $load_class = 'Broker';
} else {
    show_404();
}


include CODE_BASE_DIR. '/'. strtolower($load_class).'.php';
$CI = new $load_class();
$CI->redis = $CI->setup_redis_connection();

$methods = get_class_methods($load_class);

$method = isset($request_uri[2]) && in_array($request_uri[2], $methods) ? $request_uri[2] : '';
if ( ! $method) {
    show_404();
}


call_user_func_array(array(&$CI, $method), array_slice($request_uri, 3));