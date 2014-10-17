<?php
define('BASEPATH', substr(dirname(realpath(__FILE__)), 0, -12) . '/');

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}

session_start();

require_once '../classes/Auth.class.php';
if (!User::isAuthorized()) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /admin/");
    exit();
}
require (BASEPATH . 'system/config.php');
require_once (BASEPATH . 'system/core.php');

$save = json_encode(saveModule());
die($save);


// header("HTTP/1.1 301 Moved Permanently");
// header("Location: /admin/");
// exit();

