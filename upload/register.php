<?
/**
 * Для деактивации регистрации раскомментить строку ниже.
 */

// $disableRegister = true;

if ($disableRegister) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /auth.php");
	exit();
}

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}

session_start();

define('ROOT_DIR', dirname(realpath(__FILE__)) . '/');

require (ROOT_DIR . 'system/config.php');
require_once (ROOT_DIR . 'system/core.php');


$core = new core();

$tpl['url'] = $core->getFullUrl();

$output = $core->tpl->fetch('register.tpl', $tpl);

echo $output;
