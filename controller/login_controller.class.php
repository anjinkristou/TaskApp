<?php


class LoginController extends Controller {

	public function authNeeded() {
		return false;
	}

	public function index() {
		$this->view->setHeaderTemplate("empty");
		$this->view->setContentTemplate("login");
		$this->view->show();
	}

	public function login() {
		$data = $_POST;
		$db = DB::getInstance();
		$sql = "SELECT ID FROM users ";
		$sql .= "WHERE email=:email AND password=md5(:password)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':email', $data['email']);
		$stmt->bindParam(':password', $data['password']);
		$stmt->execute();
		$result = $stmt->fetch();
		if(isset($result[0])) {
			Session::authenticateUser($result[0]);
			Router::Reroute("index");
		} else
			$this->view->showErrorMessage("Either username or password are incorrect");
	}

	public function logout() {
		Session::destroySession();
		Router::Reroute("login");
	}

}