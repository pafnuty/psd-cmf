<?
define('ROOT_DIR', dirname(realpath(__FILE__)) . '/');

require_once (ROOT_DIR . 'system/core.php');

$core = new core();

$output = false;
$name = str_replace('/', '', $_GET['name']);
$query = ($_GET['page']) ? $name . '/' . $_GET['page'] . '.html' : $name . '/';

switch ($_GET['do']) {
	case 'layout':

		$tpl['project'] = $core->getProjectItems($name);

		if (count($tpl['project']) > 0) {
			if (!empty($_COOKIE[$name])) {
				// check session id in cookies
				session_id($_COOKIE[$name]);
			}
			session_start();

			if (($tpl['project'][0]['pass'] && PassAuth::validProjectPass($name)) || $tpl['project'][0]['pass'] == '') {
				$output = $core->tpl->fetch('main.tpl', $tpl);
			} else {
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: /login/".$query);
				exit();
			}
		} else {
			$output = $core->tpl->fetch('error.tpl', $tpl);
		}



		break;

	case 'login':
			$tpl['project'] = $core->getProject($name);
			$tpl['project']['backUrl'] = $query;
			$output = $core->tpl->fetch('project_login.tpl', $tpl);

		break;

	default:
			$tpl['project'] = array();
			$output = $core->tpl->fetch('dummy.tpl', $tpl);

			// header("HTTP/1.1 301 Moved Permanently");
			// header("Location: /auth.php");
			// exit();
		break;

}

echo $output;






