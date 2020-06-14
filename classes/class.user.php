<?php

include('class.password.php');

class User extends Password{

    private $db;

	function __construct($db){
		parent::__construct();

		$this->_db = $db;
	}

	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}

	private function get_user_hash($username){

		try {

			$stmt = $this->_db->getRow('SELECT user_id, username, password, access_lv, fullname FROM user_login WHERE username = :username',array('username' => $username));

			return $stmt;

		} catch(PDOException $e) {
		    echo '<p class="error">'.$e->getMessage().'</p>';
		}
	}

	public function signup($username,$password,$lv = 2){

		$check = $this->_db->getRow('SELECT username FROM user_login WHERE username = :username', array(':username' => $username));

		if(!isset($check['username'])){

			$hashedpassword = $this->password_hash($password, PASSWORD_BCRYPT);

				try {

					//insert into database
					$stmt = $this->_db->insertRow('INSERT INTO user_login (username,password,access_lv) VALUES (:username, :password, :access_lv)',array(
						':username' => $username,
						':password' => $hashedpassword,
						':access_lv' => $lv
					)) ;
					return true;

				} catch(PDOException $e) {
				    return false;
				}
		}else{
			return false;
		}
	}


	public function login($username,$password){

		$user = $this->get_user_hash($username);

		if($this->password_verify($password,$user['password']) == 1){

		    $_SESSION['loggedin'] = true;
		    $_SESSION['user_id'] = $user['user_id'];
		    $_SESSION['username'] = $user['username'];
		    $_SESSION['fullname'] = $user['fullname'];
 		    $_SESSION['access_lv'] = $user['access_lv'];
 		    return true;
		}
	}


	public function logout(){
		session_unset();
		session_destroy();
		setcookie('PHPSESSID', 0, time() - 3600);
		setcookie('username', 0, time() - (60 * 60 * 24), '/');
	}

}


?>
