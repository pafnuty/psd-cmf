<?
define('ROOT_DIR', substr(dirname(realpath(__FILE__)), 0, -6) . '/');

// if (!empty($_COOKIE['sid'])) {
//     // check session id in cookies
//     session_id($_COOKIE['sid']);
// }
// session_start();

$name = str_replace('/', '', $_POST['project']);

error_reporting(E_ALL | E_STRICT);
require (ROOT_DIR . 'system/config.php');
require_once (ROOT_DIR . 'system/core.php');

// if (!$name) {
// 	header("HTTP/1.1 301 Moved Permanently");
// 	header("Location: /auth.php");
// 	exit();
// }


$upload = new core();
$upload_handler = new UploadHandler($upload->getUploadConfig($name));