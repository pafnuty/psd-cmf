<?
define('ROOT_DIR', substr(dirname(realpath(__FILE__)), 0, -6) . '/');
if (!empty($_COOKIE['sid'])) {
        // check session id in cookies
        session_id($_COOKIE['sid']);
}

session_start();

require (ROOT_DIR . 'system/config.php');
require_once (ROOT_DIR . 'system/core.php');

if (!User::isAuthorized()) {
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: /auth.php");
	exit();
}

$core = new core();

$project = $core->getProject($_REQUEST['project']['name']);
if ($project['id'] > 0) {
	if ($_REQUEST['add_new'] == 'y') {
		$done = $core->addImages($_REQUEST['image'], $project['id']);
	}
	if ($_REQUEST['edit'] == 'y') {
		$done = $core->editImages($_REQUEST['image'], $project['name'], $_REQUEST['delete']);
	}

	if ($_REQUEST['addproject'] == 'y') {
		$done = json_encode(array('error' => 'Такой проект уже существует'));
	}

} else {
	if ($_REQUEST['addproject'] == 'y') {
		$done = $core->addProject($_REQUEST['project']);
		$done = json_encode($done);
	}
}

echo $done;

die();