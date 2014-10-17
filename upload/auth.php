<?

if (!empty($_COOKIE['sid'])) {
		// check session id in cookies
		session_id($_COOKIE['sid']);
}

session_start();

define('ROOT_DIR', dirname(realpath(__FILE__)) . '/');

require (ROOT_DIR . 'system/config.php');
require_once (ROOT_DIR . 'system/core.php');

if (User::isAuthorized()) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /admin/index.php?do=list");
	exit();
}

$core = new core();

$tpl['url'] = $core->getFullUrl();

$output = $core->tpl->fetch('auth.tpl', $tpl);

echo $output;
