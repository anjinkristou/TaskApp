<?php

class TaskTableModel extends Model {

	public $rows = array();
	private $count = 0;

	public function addTask($task) {
		$this->rows[$this->count] = $task;
		$this->count++;
	}

}