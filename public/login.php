<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php 
	$username = "";
	if(isset($_POST['submit'])) {
		$required_fields = array("username", "password");
		validate_presences($required_fields);
		if (empty($errors)) {
			// Attempt to login

			$username = $_POST['username'];
			$password = $_POST['password'];
			$found_admin = attempt_login($username, $password);

			if ($found_admin) {
				// Mark user as login
				$_SESSION['admin_id'] = $found_admin['id'];
				$_SESSION['username'] = $found_admin['username'];
				redirect_to("admin.php");
			} else {
				$message = "Username/password not found.";
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
		<h2>Login</h2>
		<form method="post" action="login.php">
			Username: <input type="text" name="username" value="<?php echo htmlentities($username); ?>" />
			<br /><br />
			Password: <input type="password" name="password" value"" />
			<br /><br />
			<input type="submit" name="submit" value="Submit" />
		</form>
		
	</div><!--end page-->
</div> <!--end main-->
<?php include("../includes/layouts/footer.php"); ?>