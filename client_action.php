<?php

//action.php

include 'database_connection.php';

if (isset($_POST['btn_action'])) {
	if ($_POST['btn_action'] == 'Add') {
		$query = "
		INSERT INTO client (name)
		VALUES (:name)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':name' => $_POST["name"],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'client Name Added';
		}
	}

	if ($_POST['btn_action'] == 'client_fetch_single') {
		$query = "SELECT * FROM client WHERE id = :id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':id' => $_POST["id"],
			)
		);
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			$output['name'] = $row['name'];
		}
		echo json_encode($output);
	}

	if ($_POST['btn_action'] == 'Edit') {
		$query = "
		UPDATE client set name = :name
		WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':name' => $_POST["name"],
				':id' => $_POST["id"],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'client Name Edited';
		}
	}
	if ($_POST['btn_action'] == 'delete') {
		$status = 'active';
		if ($_POST['status'] == 'active') {
			$status = 'inactive';
		}
		$query = "
		UPDATE client
		SET status = :status
		WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':status' => $status,
				':id' => $_POST["id"],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'client status change to ' . $status;
		}
	}
}

?>