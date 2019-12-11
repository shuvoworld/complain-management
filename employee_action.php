<?php

//action.php

include 'database_connection.php';

if (isset($_POST['btn_action'])) {
	if ($_POST['btn_action'] == 'Add') {
		$query = "
		INSERT INTO employee (name, contact_no, email)
		VALUES (:name, :contact_no, :email)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':name' => $_POST["name"],
				':contact_no' => $_POST["contact_no"],
				':email' => $_POST["email"],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Employee Information Added';
		}
	}

	if ($_POST['btn_action'] == 'employee_fetch_single') {
		$query = "SELECT * FROM employee WHERE id = :id";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':id' => $_POST["id"],
			)
		);
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			$output['name'] = $row['name'];
			$output['contact_no'] = $row['contact_no'];
			$output['email'] = $row['email'];
		}
		echo json_encode($output);
	}

	if ($_POST['btn_action'] == 'Edit') {
		$query = "
		UPDATE employee set name = :name, contact_no = :contact_no, email = :email
		WHERE id = :id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':name' => $_POST["name"],
				':contact_no' => $_POST["contact_no"],
				':email' => $_POST["email"],
				':id' => $_POST["id"],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Employee Information Edited';
		}
	}
	if ($_POST['btn_action'] == 'delete') {
		$status = 'active';
		if ($_POST['status'] == 'engaged' || $_POST['status'] == 'free') {
			$status = 'inactive';
		}
		$query = "
		UPDATE employee
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
			echo 'employee status change to ' . $status;
		}
	}
}

?>