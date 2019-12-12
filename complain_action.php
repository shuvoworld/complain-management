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
		INSERT INTO complain (category_id, category_name, subject, description, contact_no, created_at, :updated_at, status)
		VALUES (:category_id, :category_name, :subject, :description, :contact_no, :created_at, :updated_at :status)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id' => $category_id,
				':category_name' => $category_name,
				':subject' => $subject,
				':description' => $description,
				':contact_no' => $contact_no,
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

	if ($_POST['btn_action'] == 'fetch_single') {
		$query = "
		SELECT * FROM complain WHERE complain_id = :complain_id
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
			$output['complain_name'] = $row['complain_name'];
		}
		echo json_encode($output);
	}

	if ($_POST['btn_action'] == 'Edit') {
		$query = "
		UPDATE complain set
		category_id = :category_id,
		complain_name = :complain_name
		WHERE complain_id = :complain_id
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':category_id' => $_POST["category_id"],
				':complain_name' => $_POST["complain_name"],
				':complain_id' => $_POST["complain_id"],
			)
		);
		$result = $statement->fetchAll();
		if (isset($result)) {
			echo 'Complain Name Edited';
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