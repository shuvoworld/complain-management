<?php

//user_action.php

include 'database_connection.php';
include 'function.php';

if (isset($_POST['btn_action'])) {
    if (isset($_POST['employee_id'])) {
        $employee_id = $_POST['employee_id'];
        $employee_name = getSingleValue($connect, 'name', 'employee', 'id', $employee_id);
        $client_id = null;
        $client_name = null;
    } else {
        $employee_id = null;
        $employee_name = null;
    }
    if (isset($_POST['client_id'])) {
        $client_id = $_POST['client_id'];
        $client_name = getSingleValue($connect, 'name', 'client', 'id', $_POST["client_id"]);
        $employee_id = null;
        $employee_name = null;
    } else {
        $client_id = null;
        $client_name = null;
    }
    if ($_POST['btn_action'] == 'Add') {
        $query = "
		INSERT INTO user_details (user_email, user_password, user_name, user_type_id, user_type, user_status, client_id, client_name, employee_id, employee_name)
		VALUES (:user_email, :user_password, :user_name, :user_type_id, :user_type, :user_status, :client_id, :client_name, :employee_id, :employee_name)
		";

        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':user_email' => $_POST["user_email"],
                ':user_password' => password_hash($_POST["user_password"], PASSWORD_DEFAULT),
                ':user_name' => $_POST["user_name"],
                ':user_type_id' => $_POST["user_type_id"],
                ':user_type' => getSingleValue($connect, 'name', 'user_types', 'id', $_POST["user_type_id"]),
                ':user_status' => 'active',
                ':client_id' => $client_id,
                ':client_name' => $client_name,
                ':employee_id' => $_POST['employee_id'],
                ':employee_name' => $employee_name,
            )
        );
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'New User Added';
        }
    }
    if ($_POST['btn_action'] == 'fetch_single') {
        $query = "
		SELECT * FROM user_details WHERE user_id = :user_id
		";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':user_id' => $_POST["user_id"],
            )
        );
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output['user_email'] = $row['user_email'];
            $output['user_name'] = $row['user_name'];
            $output['user_type_id'] = $row['user_type_id'];
            $output['client_id'] = $row['client_id'];
            $output['employee_id'] = $row['employee_id'];
        }
        echo json_encode($output);
    }
    if ($_POST['btn_action'] == 'Edit') {
        if ($_POST['user_password'] != '') {
            $query = "
			UPDATE user_details SET
				user_name = '" . $_POST["user_name"] . "',
				user_email = '" . $_POST["user_email"] . "',
                user_type_id = '" . $_POST["user_type_id"] . "',
                user_type = '" . getSingleValue($connect, 'name', 'user_types', 'id', $_POST["user_type_id"]) . "',
				client_id = '" . $client_id . "',
				client_name = '" . $client_name . "',
				employee_id = '" . $employee_id . "',
				employee_name = '" . $employee_name . "',
				user_password = '" . password_hash($_POST["user_password"], PASSWORD_DEFAULT) . "'
				WHERE user_id = '" . $_POST["user_id"] . "'
			";
        } else {
            $query = "
			UPDATE user_details SET
				user_name = '" . $_POST["user_name"] . "',
				user_email = '" . $_POST["user_email"] . "',
                user_type_id = '" . $_POST["user_type_id"] . "',
                user_type = '" . getSingleValue($connect, 'name', 'user_types', 'id', $_POST["user_type_id"]) . "',
				client_id = '" . $client_id . "',
				client_name = '" . $client_name . "',
				employee_id = '" . $employee_id . "',
				employee_name = '" . $employee_name . "'
				WHERE user_id = '" . $_POST["user_id"] . "'
			";
        }
        $statement = $connect->prepare($query);
        $statement->execute();
        print_r($statement->debugDumpParams());
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'User Details Edited';
        }
    }
    if ($_POST['btn_action'] == 'delete') {
        $status = 'Active';
        if ($_POST['status'] == 'Active') {
            $status = 'Inactive';
        }
        $query = "
		UPDATE user_details
		SET user_status = :user_status
		WHERE user_id = :user_id
		";
        $statement = $connect->prepare($query);
        $statement->execute(
            array(
                ':user_status' => $status,
                ':user_id' => $_POST["user_id"],
            )
        );
        $result = $statement->fetchAll();
        if (isset($result)) {
            echo 'User Status change to ' . $status;
        }
    }
}
