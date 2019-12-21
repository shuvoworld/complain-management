<?php

//brand_fetch.php

include 'database_connection.php';

$query = '';

$output = array();
$query .= "
	SELECT complain.id as complain_id, complain.subject as complain_subject,
	complain.description as complain_description, complain.contact_no as complain_contact_no,
	complain.status as complain_status, complain.updated_at as complain_updated_at,
	user_details.user_name as user_name FROM complain
	LEFT JOIN user_details
	ON complain.user_id = user_details.user_id
";

if(($_SESSION["type"] == 'employee')){
	$query .= 'WHERE complain.employee_id = ' . $_SESSION["user_id"]; 
	}
elseif(($_SESSION["type"] == 'user')){
	$query .= 'WHERE complain.user_id = ' . $_SESSION["user_id"]; 
	}

if (isset($_POST["search"]["value"])) {
	$query .= ' AND (user_details.user_name LIKE "%' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR complain.subject LIKE "%' . $_POST["search"]["value"] . '%" ';
	$query .= 'OR complain.contact_no LIKE "%' . $_POST["search"]["value"] . '%" )';
}



if (isset($_POST["order"])) {
	$query .= ' ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
	$query .= ' ORDER BY complain.updated_at DESC ';
}

if ($_POST["length"] != -1) {
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

//echo $query; die();
$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

$data = array();

$filtered_rows = $statement->rowCount();

foreach ($result as $row) {
	$status = '';
	if ($row['complain_status'] == 'Solved') {
		$status = '<span class="label label-success">Solved</span>';
	} else {
		$status = '<span class="label label-danger">Pending</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['complain_id'];
	$sub_array[] = $row['complain_subject'];
	$sub_array[] = $row['user_name'];
	$sub_array[] = $row['complain_contact_no'];
	$sub_array[] = $row['complain_updated_at'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="' . $row['complain_id'] . '" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="' . $row['complain_id'] . '" class="btn btn-danger btn-xs delete" data-status="' . $row["complain_status"] . '">Delete</button>';
	$data[] = $sub_array;
}

function get_total_all_records($connect) {
	$statement = $connect->prepare('SELECT * FROM complain');
	$statement->execute();
	return $statement->rowCount();
}

$output = array(
	"draw" => intval($_POST["draw"]),
	"recordsTotal" => $filtered_rows,
	"recordsFiltered" => get_total_all_records($connect),
	"data" => $data,
);

echo json_encode($output);

?>
