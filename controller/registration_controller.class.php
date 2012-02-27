<?php

class RegistrationController extends Controller {

	public function authNeeded() {
		return false;
	}

	public function index() {
		$this->view->showOnlyContent("registration");
	}

	public function register() {
		$data = $_POST;
		// validate form data
		if(!$this->isEmailValid($data['email'])) {
			$this->view->showErrorMessage("Invalid e-mail address!");
			return;
		}
		if(!$this->isPasswordValid($data['password'])) {
			$this->view->showErrorMessage("Invalid password!");
			return;
		}
		// create new user
		$db = DB::getInstance();
		$sql = "INSERT INTO users (email, password) ";
		$sql .= "VALUES (:email, md5(:password))";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':email', $data['email']);
		$stmt->bindParam(':password', $data['password']);
		if($stmt->execute()) {
			$this->view->setHeaderTemplate("empty");
			$this->view->setContentTemplate("login");
			$this->view->show();
		} else {
			throw new Exception("Problem while inserting user into DB");
		}
	}

	private function isEmailValid($email) {
		$regexp = "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/";
		return preg_match($regexp, $email	);
	}

	private function isPasswordValid($password) {
		if($password == "")
			return false;
		return true;
	}

}