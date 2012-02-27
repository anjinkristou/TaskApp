<?php

class TaskAjaxController extends AjaxController {

	public function index() {

	}

	public function done() {
		$data = $_POST;
		$db = DB::getInstance();
		$stmt = $db->prepare("SELECT UNIX_TIMESTAMP(end) FROM tasks WHERE ID=:id");
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		if($data['is_done'] == '1' && $result[0] == 0)
			$sql = "UPDATE tasks SET is_done=:is_done, end=now() WHERE ID=:id";
		else
			$sql = "UPDATE tasks SET is_done=:is_done WHERE ID=:id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':is_done', $data['is_done'], PDO::PARAM_INT);
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$count = $stmt->execute();
		if($count != 1)
			throw new Exception("Incorrect task ID sent!");
		else {
			$task = new TaskModel();
			$task->get($data['id']);
			$arr = get_object_vars($task);
			$response = "<data>";
			$response .= "<done>" . $arr['is_done'] . "</done>";
			$response .= "<end>" . $arr['end'] . "</end>";
			$response .= "<id>" . $arr['id'] . "</id>";
			$response .= "</data>";
			echo $response;
		}
	}

	public function started() {
		$data = $_POST;
		$db = DB::getInstance();
		// Check if the task has been already started
		$stmt = $db->prepare("SELECT UNIX_TIMESTAMP(start) FROM tasks WHERE ID=:id");
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$sql = "";
		if($result[0] != 0) {
			$sql = "UPDATE tasks SET started=FROM_UNIXTIME(:started) WHERE ID=:id";
		} else {
			$sql = "UPDATE tasks SET start=now(), started=FROM_UNIXTIME(:started) WHERE ID=:id";
		}
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':started', $data['started'], PDO::PARAM_INT);
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$count = $stmt->execute();
		if($count != 1)
			throw new Exception("Error while updating task with id ".$data['id']
			." and started time of ".$data['started']);
		else {
			$task = new TaskModel();
			$task->get($data['id']);
			$arr = get_object_vars($task);
			$response = "<data>";
			$response .= "<id>" . $arr['id'] . "</id>";
			$response .= "<start>" . $arr['start'] . "</end>";
			$response .= "</data>";
			echo $response;
		}
	}

	public function stopped() {
		$data = $_POST;
		$db = DB::getInstance();
		$stmt = $db->prepare("UPDATE tasks SET duration=:duration, started=NULL WHERE ID=:id");
		$stmt->bindParam(':duration', $data['duration'], PDO::PARAM_INT);
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$count = $stmt->execute();
		if($count != 1)
			throw new Exception("Error while updating time spent on task with id ".$data['id']
				." and duration of ".$data['duration']);
	}

	/* DEPRECATED
	public function edit() {
		$data = $_POST;
		$db = DB::getInstance();
		$attr = $data['attribute'];
		switch($attr) {
			case "title": break;
			case "description": break;
			case "end": break;
			default:
				throw new Exception("Incorrect attribute name");
		}
		$stmt = $db->prepare("UPDATE tasks SET $attr=:value WHERE ID=:id");
		$stmt->bindParam(':value', $data['value']);
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$count = $stmt->execute();
		if($count != 1)
			throw new Exception("Error while updating time spent on task with id ".$data['id']
				." and duration of ".$data['duration']);

		$stmt = $db->prepare("SELECT id, $attr FROM tasks WHERE ID=:id");
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!is_array($result)) {
			throw new Exception("Something's wrong with data retrieval");
		} else {
			$data = "<data>";
			$data .= "<id>" . $result['id'] . "</id>";
			$data .= "<attribute>" . $attr . "</attribute>";
			$data .= "<value>" . nl2br($result[$attr]) . "</value>";
			$data .= "</data>";
			echo $data;
		}
	}*/

	public function edit() {
		$data = $_POST;
		$task = new TaskModel();
		$task->update($data);
		$task->get($data['id']);
		$arr = get_object_vars($task);
		$output = "<data>";
		foreach($arr as $key => $value) {
			$output .= "<$key>" . $value . "</$key>";
		}
		$output .= "</data>";
		echo $output;
	}

	public function delete() {
		$data = $_POST;
		$db = DB::getInstance();
		$stmt = $db->prepare("DELETE FROM tasks WHERE ID=:id");
		$stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
		if(!$stmt->execute())
			throw new Exception("Error while deleting task item from DB!");
		else {
			$result = "<data>";
			$result .= "<id>" . $data['id'] . "</id>";
			$result .= "</data>";
			echo $result;
		}
	}
}
