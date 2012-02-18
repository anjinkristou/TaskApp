<?php

class TaskModel extends Model {

	public $id;
	public $title;
	public $description;
	public $start;
	public $end;
	public $is_done;

	public $is_form = false;

	public function __construct() {
		parent::setTemplate('task');
	}

	public function insertNewTask() {
		$db = DB::getInstance();
		$sql = "INSERT INTO tasks (title, description) ";
		$sql .= "VALUES(:title, :description)";

		$statement = $db->prepare($sql);
		$statement->bindParam(':title', $this->title);
		$statement->bindParam(':description', $this->description);

		$statement->execute();
	}

}