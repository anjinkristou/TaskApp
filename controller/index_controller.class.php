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
		$table = $this->fetchGlobalTasksTable();
		$this->view->show($table);
	}

	private function fetchGlobalTasksTable() {
		$table = new TaskTableModel();
		$table->setTemplate('task_table');
		//
		$db = db::getInstance();
		$stmt = $db->query("SELECT * FROM tasks");
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$task = new TaskModel();
			$task->setAttributes($row);
			$table->addTask($task);
		}
		return $table;
	}
}