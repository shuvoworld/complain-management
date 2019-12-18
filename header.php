<?php
//header.php
?>
<!DOCTYPE html>
<html>
<head>
<title>Complain Management System</title>
<script src="js/jquery-1.10.2.min.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/bootstrap.min.js"></script>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

</head>
<body>
<br />
<div class="container">
	<h2 align="center">Complain Management System</h2>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a href="index.php" class="navbar-brand">Home</a>
			</div>
			<ul class="nav navbar-nav">
			<?php
if ($_SESSION['type'] == 'master') {
	?>
				<li><a href="user.php">User</a></li>
				<li><a href="category.php">Category</a></li>
				<li><a href="brand.php">Brand</a></li>
				<li><a href="product.php">Product</a></li>
				<li><a href="client.php">Client</a></li>
				<li><a href="employee.php">Employee</a></li>
			<?php
}
?>
				<li><a href="order.php">Order</a></li>
				<li><a href="complain.php">Complain</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count"></span> <?php echo $_SESSION["user_name"]; ?></a>
					<ul class="dropdown-menu">
						<li><a href="profile.php">Profile</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>

		</div>
	</nav>
