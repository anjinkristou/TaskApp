<?php

class IndexController extends Controller {

	public function index() {
		$table = $this->fetchGlobalTasksTable();
		$this->view->show($table);
	}

	public function newtask() {
		$data = $_POST;
		$task = new TaskModel();
		$task->insertNewTask($data);
		//header('Location: index.php');
		$table = $this->fetchGlobalTasksTable();
		$this->view->show($table);
	}

	private function fetchGlobalTasksTable() {
		$table = new TaskTableModel();
		$table->setTemplate('task_table');
		//
		$db = db::getInstance();
		$stmt = $db->prepare("SELECT * FROM tasks WHERE id_user=:id_user");
		$stmt->bindParam(':id_user', Session::$UserID, PDO::PARAM_INT);
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$task = new TaskModel();
			$task->setAttributes($row);
			$table->addTask($task);
		}
		return $table;
	}
}