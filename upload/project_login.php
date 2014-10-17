<?
define('ROOT_DIR', dirname(realpath(__FILE__)) . '/');

$name = str_replace('/', '', $_POST['project']);

if (!empty($_COOKIE[$name])) {
	// check session id in cookies
	session_id($_COOKIE[$name]);
}

session_start();


require_once (ROOT_DIR . 'system/core.php');


$passAuth = new PassAuth();

$passAuth->checkPass($_POST['password'], $name, 1);

header("HTTP/1.1 301 Moved Permanently");
header("Location: " . $_REQUEST['backUrl']);
exit();


