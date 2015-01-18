<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
		<a href="admin.php">&laquo; Main menu</a><br />
	</div><!--end navigation-->
	<div id="page">
		<?php echo message(); ?>
		<h2>Manage Admins</h2>
		<?php $admin_set = find_all_admins(); ?>
		<table>
			<tr>
				<th>Username</th>
				<th>Actions</th>
			</tr>
			<?php 
				while ($admin = mysqli_fetch_assoc($admin_set)) {
			?>
					<tr>
					<td><?php echo $admin['username']; ?></td>
					<td><a href="edit_admin.php?id=<?php echo $admin['id']; ?>">Edit</a> <a href="delete_admin.php?id=<?php echo $admin['id']; ?>" onclick = "return confirm('Are you sure?'); ">Delete</a></td>
					</tr>
			<?php 
				}
			?>
		</table>
		<a href="create_admin.php">Add new admin</a>
	</div><!--end page-->
</div> <!--end main-->
<?php include("../includes/layouts/footer.php"); ?>