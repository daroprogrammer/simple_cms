<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 
	$admin;
	if (!$_GET['id']) {
		redirect_to("manage_admins.php");
	} else {
		$admin = find_admin_by_id($_GET['id']);
	}
	if(isset($_POST['submit'])) {
		$required_fields = array("username", "password");
		validate_presences($required_fields);
		if (empty($errors)) {
			$id = $admin['id'];
			$username = mysql_prep($_POST['username']);
			$password = password_encrypt($_POST['password']);	
			$query = "UPDATE admins SET";
			$query .= " username = '{$username}',";
			$query .= " hashed_password = '{$password}'";
			$query .= " WHERE id = {$id}";
			$query .= " LIMIT 1";	
			$result = mysqli_query($connection, $query);
			if ($result && mysqli_affected_rows($connection) >= 0) {
				$_SESSION['message'] = "Admin updated";
				redirect_to("manage_admins.php");
			} else {
				$message = "Admin update failed";
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
		<h2>Edit Admin</h2>
		<form method="post" action="edit_admin.php?id=<?php echo $admin['id']; ?>">
			Username: <input type="text" name="username" value="<?php echo $admin['username']; ?>" />
			<br /><br />
			Password: <input type="password" name="password" value="<?php echo $admin['hashed_password']; ?>" />
			<br /><br />
			<input type="submit" name="submit" value="Edit admin" />
		</form>
		<br />
		<a href="manage_admins.php">Cancel</a>
		
	</div><!--end page-->
</div> <!--end main-->
<?php include("../includes/layouts/footer.php"); ?>