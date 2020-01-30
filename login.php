<?php
//login.php

include 'database_connection.php';

if (isset($_SESSION['type'])) {
    header("location:index.php");
}

$message = '';

if (isset($_POST["login"])) {
    $query = "
	SELECT * FROM user_details
		WHERE user_email = :user_email
	";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            'user_email' => $_POST["user_email"],
        )
    );
    $count = $statement->rowCount();
    if ($count > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if ($row['user_status'] == 'Active') {
                if (password_verify($_POST["user_password"], $row["user_password"])) {
                    $_SESSION['type'] = $row['user_type'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];

                    if ($_SESSION['type'] == 'employee') {
                        $_SESSION['employee_id'] = $row['employee_id'];
                    }

                    if ($_SESSION['type'] == 'master') {
                        header("location:index.php");
                    } else {
                        header("location:complain.php");
                    }
                } else {
                    $message = "<label>Wrong Password</label>";
                }
            } else {
                $message = "<label>Your account is disabled, Contact Master</label>";
            }
        }
    } else {
        $message = "<label>Wrong Email Address</labe>";
    }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Complain Management System</title>
		<script src="js/jquery-1.10.2.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="center">Complain Management System</h2>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					<form method="post">
						<?php echo $message; ?>
						<div class="form-group">
							<label>User Email</label>
							<input type="text" name="user_email" class="form-control" required />
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="user_password" class="form-control" required />
						</div>
						<div class="form-group">
							<input type="submit" name="login" value="Login" class="btn btn-info" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
