<?php

//complain_action.php

include 'database_connection.php';
include 'function.php';

if (isset($_POST['btn_action'])) {
	if ($_POST['btn_action'] == 'Add') {

		$category_id = $_POST["category_id"];
		$category_name = getSingleValue($connect, 'category_name', 'category', 'category_id', $_POST["category_id"]);
		$subject = $_POST["subject"];
		$description = $_POST["description"];
		$contact_no = $_POST["contact_no"];
		$current_date = date('Y-m-d H:i:s');
		$status = 'Pending';
		$query = "
		INSERT INTO complain (category_id, category_name, subject, description, contact_no, user_id, created_at, updated_at, status)
		VALUES (:category_id, :category_name, :subject, :description, :contact_no, :user_id, :created_at, :updated_at, :status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id' => $category_id,
				':category_name' => $category_name,
				':subject' => $subject,
				':description' => $description,
				':contact_no' => $contact_no,
				':user_id' => $_SESSION["user_id"],
				':status' => $status,
				':created_at' => $current_date,
				':updated_at' => $current_date,
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Complain Submitted Successfully!';
		}
	}

	if ($_POST['btn_action'] == 'fetch_single_complain') {
		$query = "
		SELECT * FROM complain WHERE id = :complain_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':complain_id' => $_POST["complain_id"],
			)
		);
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			$output['category_id'] = $row['category_id'];
			$output['subject'] = $row['subject'];
			$output['description'] = $row['description'];
			$output['contact_no'] = $row['contact_no'];
		}
		echo json_encode($output);
	}

	if ($_POST['btn_action'] == 'Edit') {
		$query = "
		UPDATE complain set
		category_id = :category_id,
		category_name = :category_name,
		subject = :subject,
		description = :description,
		contact_no = :contact_no,
		status = :status,
		updated_at = :updated_at,
		employee_id = :employee_id,
		WHERE id = :complain_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':complain_id' => $_POST["complain_id"],
				':category_id' => $_POST["category_id"],
				':category_name' => $category_name = getSingleValue($connect, 'category_name', 'category', 'category_id', $_POST["category_id"]),
				':subject' => $_POST["subject"],
				':description' => $_POST["description"],
				':contact_no' => $_POST["contact_no"],
				':status' => $_POST["status"],
				':employee_id' => $_POST["employee_id"],
				':updated_at' => date('Y-m-d H:i:s'),
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Complain Information Updated';
		}
	}

	if ($_POST['btn_action'] == 'delete') {
		$status = 'active';
		if ($_POST['status'] == 'active') {
			$status = 'inactive';
		}
		$query = "
		UPDATE complain
		SET complain_status = :complain_status
		WHERE complain_id = :complain_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':complain_status' => $status,
				':complain_id' => $_POST["complain_id"],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Complain status change to ' . $status;
		}
	}
}

?>