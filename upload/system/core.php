<?php
if (!defined('ROOT_DIR')) exit('Access denied');

require_once(ROOT_DIR . 'system/classes/Fenom.php');
\Fenom::registerAutoload(ROOT_DIR . 'system/classes/');

/**
* Основной класс
*/
class core {

	public $db_config = array();
	public $config = array();
	public $tpl;
	public $db;
	const ROOT_DIR = ROOT_DIR;

	function __construct() {
		$this->db_config = $this->getConfig('db_config');
		$this->config = $this->getConfig();

		$this->tpl = Fenom::factory(
			ROOT_DIR . '/templates/',
			ROOT_DIR . '/cache/'

		);
		$this->tpl->setOptions($this->config['tplOptions']);

		$this->db = $this->getDb();
	}

	public function getConfig($config='config')	{
		return include(ROOT_DIR . '/system/' . $config . '.php');
	}
	public function getDb() {
		return SafeMySQL::getInstanse(array(
			'dbhost' => $this->db_config['dbhost'],
			'user' => $this->db_config['dbuser'],
			'pass' => $this->db_config['dbpass'],
			'db' => $this->db_config['dbname'],
			'charset' => $this->db_config['dbcharset']
		));
	}

	public function getProjectItems($name, $type = false) {
		$type = (!$type) ? 1 : $type ;

		$typeSelect = ' AND type = ?i ';

		if ($type == 'all') {
			$typeSelect = false;
		}

		$select = "SELECT p.name, p.title, p.pass, i.id, i.element_id, i.name as src, i.type, i.sort_index FROM ?n p LEFT JOIN ?n i ON (p.id=i.element_id) WHERE p.name=?s " . $typeSelect . " ORDER BY sort_index ASC";
		if ($type == 'all') {
			$ret = $this->db->getAll($select, 'projects', 'images', $name);
		} else {
			$ret = $this->db->getAll($select, 'projects', 'images', $name, $type);
		}

		return $ret;
	}
	public function getProject($name) {
		$select = "SELECT * FROM ?n WHERE name=?s";
		$ret = $this->db->getRow($select, 'projects', $name);

		return $ret;
	}
	public function getProjects($pageNum = 1, $perPage = 2) {
		$ret['projects'] = array();

		$totalCount = $this->db->getOne('SELECT COUNT(*) as count FROM ?n', 'projects');
		$startFrom = ($pageNum >= 1) ? ($perPage * ($pageNum - 1)) : 0;
		$ret['totalCount'] = $totalCount;
		$ret['perPage'] = $perPage;
		$ret['currentPage'] = $pageNum;

		$select = 'SELECT * FROM ?n ORDER BY id ASC LIMIT ?i, ?i';
		$selectImage = 'SELECT * FROM ?n WHERE element_id = ?i AND type = ?i ORDER BY sort_index ASC';

		$projects = $this->db->getInd('id', $select, 'projects', $startFrom, $perPage);
		foreach ($projects as $key => $project) {
			$projects[$key]['images'] = $this->db->getAll($selectImage, 'images', $project['id'], 1);
		}
		$ret['projects'] = $projects;

		return $ret;
	}

	public function addProject($arr) {
		$pass = new PassAuth();
		$query = 'INSERT INTO ?n SET ?u';
		$result = array();
		$data = array(
			'name' => $arr['name'],
			'title' => $arr['title'],
			'pass' => ($arr['pass']) ? $pass::passwordHash($arr['pass']) : false,
		);
		$result['success'] = $this->db->query($query, 'projects', $data);
		if ($result['success']) {
			$result['text'] = 'Проект ' . $arr['title'] . ' успешно создан!';
		}
		return $result;
	}


	public function addImages($arr, $project_id) {
		$query = 'INSERT INTO ?n SET ?u';
		$result = array();
		foreach ($arr as $key => $value) {
			$data = array(
				'element_id' => $project_id,
				'name' => $value['name'],
				'type' => $value['type'],
				'sort_index' => $value['sort_index'],
			);
			$result[] = $this->db->query($query, 'images', $data);
		}
		return $result;
	}

	public function editImages($arr, $project_name, $delete) {
		$query = 'UPDATE ?n SET ?u WHERE id = ?i';
		$deleteQuery = 'DELETE FROM ?n WHERE id = ?i';
		$result = array();
		if (count($delete) > 0) {
			foreach ($delete as $key => $value) {

			}
		}
		foreach ($arr as $key => $value) {
			$data = array(
				'type' => $value['type'],
				'sort_index' => $value['sort_index'],
			);

			if ($delete[$key] == $key) {
				$result[] = $this->db->query($deleteQuery, 'images', $key);
				@unlink(ROOT_DIR . $this->config['uploadFolder'] . '/' . $project_name .'/' . $value['name']);
				@unlink(ROOT_DIR . $this->config['uploadFolder'] . '/' . $project_name . '/thumbnail/' . $value['name']);
			} else {
				$result[] = $this->db->query($query, 'images', $data, $key);
			}
			$result[] = ROOT_DIR . $this->config['uploadFolder'] . '/' . $project_name .'/' . $value['name'];
		}
		return $result;
	}

	/**
	 * Получаем полный адрес страницы
	 * @param  boolean $strip текст, удаляемый из адреса перед его возвращением
	 * @return string         Адрес сайта с протоколом и портом
	 */
	public function getFullUrl($strip = false) {

		$https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
			!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
				strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
		$url =
			($https ? 'https://' : 'http://').
			(!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
			(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
			($https && $_SERVER['SERVER_PORT'] === 443 ||
			$_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
			substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));

		return ($strip) ? str_replace($strip, '', $url) : $url ;
	}


	public function getUploadConfig($subfolder = false) {
		$uploadConfigArr = array(
			// 'script_url' => '/admin/index.php',
			'upload_dir' => ROOT_DIR . $this->config['uploadFolder'] . '/' . $subfolder. '/',
			'upload_url' => '/' . $this->config['uploadFolder'] . '/' . $subfolder. '/',
			'accept_file_types' => '/\.(gif|jpe?g|png)$/i',
			'thumbnail' => array(
				'max_width' => $this->config['thumbSize'],
				'max_height' => $this->config['thumbSize'],
				'upload_dir' => ROOT_DIR . $this->config['uploadFolder'] . '/' . $subfolder . '/' . 'thumbs/',
				'upload_url' => '/' . $this->config['uploadFolder'] . '/' . $subfolder . '/' . 'thumbs/',
				'crop' => true,
			),
		);
		return $uploadConfigArr;
	}

	public function getImageSize($path = false) {
		if (!function_exists('getimagesize')) {
			error_log('Function not found: getimagesize');
			return false;
		}
		return @getimagesize(ROOT_DIR . $path);
	}


}

?>