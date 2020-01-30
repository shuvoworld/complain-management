<?php

//complain_action.php

include 'database_connection.php';
include 'function.php';

if (isset($_POST['btn_action'])) {
    if ($_POST['btn_action'] == 'Add') {
        if ($_SESSION['type'] == 'employee') {
            $employee_id = $_SESSION['employee_id'];
        } elseif ($_SESSION['type'] == 'user') {
            $employee_id = null;
        } else {
            $employee_id = $_POST['employee_id'];
        }
        $category_id = $_POST["category_id"];
        $category_name = getSingleValue($connect, 'category_name', 'category', 'category_id', $_POST["category_id"]);
        $subject = $_POST["subject"];
        $description = $_POST["description"];
        $contact_no = $_POST["contact_no"];
        $current_date = date('Y-m-d H:i:s');
        $status = 'Pending';
        $query = "
		INSERT INTO complain (category_id, category_name, subject, description, contact_no, user_id, employee_id, status, created_at, updated_at)
		VALUES (:category_id, :category_name, :subject, :description, :contact_no, :user_id, :employee_id, :status, :created_at, :updated_at)
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
                ':employee_id' => $employee_id,
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
		SELECT * FROM complain WHERE id = :id
		";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':id' => $_POST["id"],
            )
        );
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['category_id'] = $row['category_id'];
            $output['subject'] = $row['subject'];
            $output['description'] = $row['description'];
            $output['contact_no'] = $row['contact_no'];
            $output['employee_id'] = $row['employee_id'];
            $output['status'] = $row['status'];
        }
        echo json_encode($output);
    }

    if ($_POST['btn_action'] == 'Edit') {
        if (isset($_SESSION['employee_id'])) {
            $employee_id = $_SESSION['employee_id'];
        } else {
            $employee_id = $_POST['employee_id'];
        }
        $category_name = getSingleValue($connect, 'category_name', 'category', 'category_id', $_POST["category_id"]);
        $query = "
		UPDATE complain SET
		category_id = :category_id,
		category_name = :category_name,
		subject = :subject,
		description = :description,
		contact_no = :contact_no,
		status = :status,
		updated_at = :updated_at,
		employee_id = :employee_id
		WHERE id = :id
		";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':category_id' => $_POST["category_id"],
                ':category_name' => $category_name,
                ':subject' => $_POST["subject"],
                ':description' => $_POST["description"],
                ':contact_no' => $_POST["contact_no"],
                ':status' => $_POST["status"],
                ':employee_id' => $employee_id,
                ':updated_at' => date('Y-m-d H:i:s'),
                ':id' => $_POST["id"],
            )
        );
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo "Complain Information Updated"; // For debug Query: print_r($statement->debugDumpParams());
        }
    }

    if ($_POST['btn_action'] == 'delete') {
        $query = "
		DELETE FROM complain
		WHERE id = :id
		";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':id' => $_POST["complain_id"],
            )
        );
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'Complain Deleted!';
        }
    }
}
