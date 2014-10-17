<?
/**
*
*/
class PassAuth extends core {
	private $project_id;
	private $password;
	private $is_authorized = false;

	function __construct() {
		$this->db_config = $this->getConfig('db_config');
		$this->db = $this->getDb();
	}

	public static function validProjectPass($id = false)
	{
		if (!empty($_SESSION[$id])) {

			return (bool) $_SESSION[$id];
		}
		return false;
	}

	public function checkPass($password, $name=false, $remember=false)
	{
		$pass = $this->passwordHash($password);

		$select = "SELECT name, pass FROM ?n WHERE pass = ?s AND name = ?s";

		$ret = $this->db->getRow($select, 'projects', $pass, $name);

		if (!$ret) {
			$this->is_authorized = false;
		} else {
			$this->is_authorized = true;
			$this->project_id = $ret['name'];
			$this->saveSession($remember);
		}

		return $this->is_authorized;
	}

	public function saveSession($remember = false, $http_only = true, $days = 7)
	{
		$_SESSION[$this->project_id] = $this->project_id;

		if ($remember) {
			// Save session id in cookies
			$sid = session_id();

			$expire = time() + $days * 24 * 3600;
			$domain = ""; // default domain
			$secure = false;
			$path = "/";

			$cookie = setcookie($this->project_id, $sid, $expire, $path, $domain, $secure, $http_only);
		}
	}

	public static function passwordHash($password, $iterations = 2)
	{
		$hash = md5(md5($password));

		for ($i = 0; $i < $iterations; ++$i) {
			$hash = md5(md5(sha1($hash)));
		}

		return $hash;
	}
}