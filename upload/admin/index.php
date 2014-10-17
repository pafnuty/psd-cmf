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

$admin = new core();

switch ($_GET['do']) {
	case 'add':
		$tpl['admin'] = array();

		if (!$_REQUEST['name']) {
			$output = $admin->tpl->fetch('/admin/add.tpl', $tpl);
		}
		if ($_REQUEST['name']) {
			$tpl['admin']['project'] = $_REQUEST['name'];
			$output = $admin->tpl->fetch('/admin/addproject.tpl', $tpl);
		}

		break;
	case 'edit':
		$tpl['project'] = array();

		if ($_REQUEST['name']) {
			$tpl['project'] = $admin->getProjectItems($_REQUEST['name'], 'all');

			$output = $admin->tpl->fetch('/admin/editproject.tpl', $tpl);
		}

		break;

	default:
			$tpl['projects'] = $admin->getProjects($_REQUEST['page'], 10);
			$tpl['pagination'] = false;
			if ($tpl['projects']['totalCount'] > 10) {
				$pagerConfig = array(
					'total_items'    => $tpl['projects']['totalCount'],
					'items_per_page' => $tpl['projects']['perPage'],
					'style'          => 'digg',
					'base_url'          => null,
					'current_page'   => $tpl['projects']['currentPage'],
				);
				$pagination = new Pager($pagerConfig);
				$tpl['pagination']  = $pagination->render();
			}

			$output = $admin->tpl->fetch('/admin/main.tpl', $tpl);
		break;

}

echo $output;