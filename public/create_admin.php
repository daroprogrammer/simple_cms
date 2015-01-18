<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 
	if(isset($_POST['submit'])) {
		$required_fields = array("username", "password");
		validate_presences($required_fields);
		if (empty($errors)) {
			$username = mysql_prep($_POST['username']);
			$password = password_encrypt($_POST['password']);	
			$query = "INSERT INTO admins (";
			$query .= " username, hashed_password";
			$query .= " ) VALUES (";
			$query .= " '{$username}', '{$password}'";
			$query .= " )";		
			$result = mysqli_query($connection, $query);
			if ($result) {
				$_SESSION['message'] = "Admin created";
				redirect_to("manage_admins.php");
			} else {
				$message = "Admin creation failed";
			}
		}
		
	} else {
		// redirect_to("manage_admins.php");
	}
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
	<div id="navigation">
	</div><!--end navigation-->
	<div id="page">
		<?php if (isset($message)) {echo "<div class=\"error\" >" . $message. "</div>";} ?>
		<?php if (!empty($errors)) {echo form_errors($errors) ;}?>
		<h2>Create Admin</h2>
		<form method="post" action="create_admin.php">
			Username: <input type="text" name="username" value="" />
			<br /><br />
			Password: <input type="password" name="password" value"" />
			<br /><br />
			<input type="submit" name="submit" value="Create admin" />
		</form>
		<br />
		<a href="manage_admins.php">Cancel</a>
		
	</div><!--end page-->
</div> <!--end main-->
<?php include("../includes/layouts/footer.php"); ?>