<?php

/**
 * @todo Переписать на свой класс работы с БД.
 */
class User extends core
{
	private $id;
	private $username;
	private $dbPDO;
	private $user_id;

	private $is_authorized = false;

	public function __construct($username = null, $password = null)
	{
		$this->db_config = $this->getconfig('db_config');
		$this->username = $username;
		$this->connectDb($this->db_config['dbname'], $this->db_config['dbuser'], $this->db_config['dbpass'], $this->db_config['dbhost']);
	}

	public function __destruct()
	{
		$this->dbPDO = null;
	}

	public static function isAuthorized()
	{
		if (!empty($_SESSION["user_id"])) {
			return (bool) $_SESSION["user_id"];
		}
		return false;
	}

	public function passwordHash($password, $salt = null, $iterations = 10)
	{
		$salt || $salt = uniqid();
		$hash = md5(md5($password . md5(sha1($salt))));

		for ($i = 0; $i < $iterations; ++$i) {
			$hash = md5(md5(sha1($hash)));
		}

		return array('hash' => $hash, 'salt' => $salt);
	}

	public function getSalt($username) {
		$query = "select salt from users where username = :username limit 1";
		$sth = $this->dbPDO->prepare($query);
		$sth->execute(
			array(
				":username" => $username
			)
		);
		$row = $sth->fetch();
		if (!$row) {
			return false;
		}
		return $row["salt"];
	}

	public function getUser()
	{
		if ($this->isAuthorized()) {
			$query = "select id, username from users where
            id = :id limit 1";
        	$sth = $this->dbPDO->prepare($query);
        	$sth->execute(
				array(
					":id" => $_SESSION['user_id'],
				)
			);
			$user = $sth->fetch();

			return $user;
		}
		return false;
	}

	public function authorize($username, $password, $remember=false)
	{
		$query = "select id, username from users where
			username = :username and password = :password limit 1";
		$sth = $this->dbPDO->prepare($query);
		$salt = $this->getSalt($username);

		if (!$salt) {
			return false;
		}

		$hashes = $this->passwordHash($password, $salt);
		$sth->execute(
			array(
				":username" => $username,
				":password" => $hashes['hash'],
			)
		);
		$this->user = $sth->fetch();

		if (!$this->user) {
			$this->is_authorized = false;
		} else {
			$this->is_authorized = true;
			$this->user_id = $this->user['id'];
			$this->saveSession($remember);
		}

		return $this->is_authorized;
	}

	public function logout()
	{
		if (!empty($_SESSION["user_id"])) {
			unset($_SESSION["user_id"]);
		}
	}

	public function saveSession($remember = false, $http_only = true, $days = 7)
	{
		$_SESSION["user_id"] = $this->user_id;

		if ($remember) {
			// Save session id in cookies
			$sid = session_id();

			$expire = time() + $days * 24 * 3600;
			$domain = ""; // default domain
			$secure = false;
			$path = "/";

			$cookie = setcookie("sid", $sid, $expire, $path, $domain, $secure, $http_only);
		}
	}

	public function create($username, $password) {
		$user_exists = $this->getSalt($username);

		if ($user_exists) {
			throw new \Exception("User exists: " . $username, 1);
		}

		$query = "insert into users (username, password, salt)
			values (:username, :password, :salt)";
		$hashes = $this->passwordHash($password);
		$sth = $this->dbPDO->prepare($query);

		try {
			$this->dbPDO->beginTransaction();
			$result = $sth->execute(
				array(
					':username' => $username,
					':password' => $hashes['hash'],
					':salt' => $hashes['salt'],
				)
			);
			$this->dbPDO->commit();
		} catch (\PDOException $e) {
			$this->dbPDO->rollback();
			echo "Database error: " . $e->getMessage();
			die();
		}

		if (!$result) {
			$info = $sth->errorInfo();
			printf("Database error %d %s", $info[1], $info[2]);
			die();
		}

		return $result;
	}

	public function connectDb($db_name, $db_user, $db_pass, $db_host = "localhost")
	{
		try {
			$this->dbPDO = new \pdo("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
		} catch (\pdoexception $e) {
			echo "database error: " . $e->getmessage();
			die();
		}
		$this->dbPDO->query('set names utf8');

		return $this;
	}
}
