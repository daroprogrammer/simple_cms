<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>
<div id="main">
	<div id="navigation">
		<br />
		<a href="admin.php">&laquo; Main menu</a><br />
		<?php echo navigation($current_subject, $current_page); ?>
		<br />
		<a href="new_subject.php">+ Add a subject</a>
	</div><!--end navigation-->
	<div id="page">
		<?php echo message(); ?>
		<?php if ($current_subject) { ?>
		<h2>Manage Subject</h2>
			Menu name: <?php echo htmlentities($current_subject['menu_name']); ?> <br />
			Position: <?php echo $current_subject['position']; ?> <br />
			Visible: <?php echo $current_subject['visible'] == 1 ?  'Yes' : 'No'; ?> <br />
			<a href="edit_subject.php?subject=<?php echo urlencode($current_subject['id']); ?>">Edit subject</a>
			<hr />
			<h3>Pages in subject</h3>
			<ul>
				<?php $page_set = find_pages_for_subject($current_subject['id'], false); ?>
				<?php while ($page = mysqli_fetch_assoc($page_set)) {
				?>
				<li><?php echo htmlentities($page['menu_name']); ?></li>
				<?php }  ?>
			</ul>
			+ <a href="create_page.php?subject=<?php echo urlencode($current_subject['id']); ?>">Add a new page to this subject</a>
		<?php } elseif ($current_page) { ?>
		<h2>Manage Page</h2>
			Menu name: <?php echo htmlentities($current_page['menu_name']); ?> <br />
			Position: <?php echo $current_page['position']; ?> <br />
			Visible: <?php echo $current_page['visible'] == 1 ? 'Yes' : 'No'; ?> <br />
			Content: <br />
			<div class="view-content">
				<?php echo htmlentities($current_page['content']); ?>
			</div>
			<a href="edit_page.php?page=<?php echo $current_page['id']; ?>">Edit page</a>
			<a href="delete_page.php?page=<?php echo $current_page['id']; ?>" onclick = "return confirm('Are you sure?');">Delete page</a>
		<?php } else { ?>
			Please select a subject or a page.
		<?php } ?>
	</div><!--end page-->
</div> <!--end main-->
<?php include("../includes/layouts/footer.php"); ?>