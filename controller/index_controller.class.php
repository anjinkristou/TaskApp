<?php

class IndexController extends Controller {

	public function index() {
		$table = $this->fetchGlobalTasksTable();
		$this->view->show($table);
	}

	public function newtask() {
		$data = $_POST;
		//
		$task = new TaskModel();
		$task->title = $data['title'];
		$task->description = $data['description'];
		//
		$task->insertNewTask();
		//
		$table = $this->fetchGlobalTasksTable();
		//
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
			$task->id = $row['ID'];
			$task->title = $row['title'];
			$task->description = $row['description'];
			$task->start = $row['start'];
			$task->end = $row['end'];
			$task->is_done = $row['is_done'];
			$table->addTask($task);
		}
		return $table;
	}
}