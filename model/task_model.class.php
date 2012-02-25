<?php

class TaskModel extends Model {

	public $id;
	public $title;
	public $description;
	public $start;
	public $end;
	public $duration;
	public $is_done;
	public $estimate_days;
	public $estimate_hours;
	public $estimate_minutes;

	public function __construct() {
		parent::setTemplate('task');
	}

	public function setAttributes($attr) {
		$this->id = $attr['ID'];
		$this->title = $attr['title'];
		$this->description = nl2br($attr['description']);
		$this->start = $attr['start'];
		$this->end = $attr['end'];
		$this->duration = $attr['duration'];
		$this->is_done = $attr['is_done'];
		$estimate_arr = $this->fromEstimateType($attr['estimate']);
		$this->estimate_days = $estimate_arr['days'];
		$this->estimate_hours = $estimate_arr['hours'];
		$this->estimate_minutes = $estimate_arr['minutes'];
	}

	public function insertNewTask($data) {
		$db = DB::getInstance();
		$sql = "INSERT INTO tasks (title, description, estimate) ";
		$sql .= "VALUES(:title, :description, :estimate)";
		$statement = $db->prepare($sql);
		$statement->bindParam(':title', $data['title']);
		$statement->bindParam(':description', $data['description']);
		$estimate = $this->toEstimateType(
			$data['estimate_days'],
			$data['estimate_hours'],
			$data['estimate_minutes']);
		$statement->bindParam(':estimate', $estimate, PDO::PARAM_INT);
		$statement->execute();
	}

	/**
	 *
	 * Updates task specified by data parameter
	 * @param Array $data
	 */
	public function update($data) {
		$db = DB::getInstance();
		$sql = "UPDATE tasks SET ";
		$sql .= "title=:title,";
		$sql .= "description=:description,";
		$sql .= "start=:start,";
		$sql .= "end=:end,";
		$sql .= "estimate=:estimate ";
		$sql .= "WHERE ID=:id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$stmt->bindParam(':title', $data['title']);
		$stmt->bindParam(':description', $data['description']);
		$stmt->bindParam(':start', $data['start']);
		$stmt->bindParam(':end', $data['end']);
		$estimate = $this->toEstimateType(
			$data['estimate_days'],
			$data['estimate_hours'],
			$data['estimate_minutes']);
		$stmt->bindParam(':estimate', $estimate, PDO::PARAM_INT);
		//echo $stmt->debugDumpParams();
		$stmt->execute();
	}

	/**
	 *
	 * Returns data from the task of a given id.
	 * @param integer $id
	 */
	public function get($id) {
		$db = DB::getInstance();
		$sql = "SELECT * FROM tasks WHERE ID=:id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->setAttributes($data);
	}

	/**
	 * PRIVATE
	 */
	private function toEstimateType($days, $hours, $minutes) {
		return $days * 86400 + $hours * 3600 + $minutes * 60;
	}

	private function fromEstimateType($seconds) {
		$days = floor($seconds / 86400);
		$seconds %= 86400;
		$hours = floor($seconds / 3600);
		$seconds %= 3600;
		$minutes = floor($seconds / 60);
		return array("days" => $days, "hours" => $hours, "minutes" => $minutes);
	}

}