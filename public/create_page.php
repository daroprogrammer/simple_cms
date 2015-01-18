<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php find_selected_page(); ?>
<?php 
	if (!$current_subject['id']) {
		redirect_to("manage_content.php");
	}
?>
<?php 
	if(isset($_POST['submit'])) {

		$required_fields = array("menu_name", "position", "visible", "content");
		validate_presences($required_fields);
		$field_with_max_lengths = array("menu_name" => 30, "content" => 255);
		validate_max_lengths($field_with_max_lengths);
		if (!empty($errors)) {
			
		} else {
			$subject_id = $current_subject['id'];
			$menu_name = mysql_prep($_POST['menu_name']);
			$position = (int) $_POST['position'];
			$visible = (int) $_POST['visible'];
			$content = mysql_prep($_POST['content']);

			$query = "INSERT INTO pages (";
			$query .= " subject_id, menu_name, position, visible, content";
			$query .= " ) VALUES (";
			$query .= " {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
			$query .= " )";		
			$result = mysqli_query($connection, $query);
			if ($result) {
				$message = "Page created";
				redirect_to("manage_content.php?subject=" . $current_subject['id']);
			} else {
				$message = "Page creation failed";
			}

		} // no errors
	} else {

	} // url request
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject, $current_page); ?>
	</div><!--end navigation-->
	<div id="page">
		<?php if (isset($message)) {echo "<div class=\"error\" >" . $message. "</div>" ;} ?>
		<?php if (!empty($errors)) { echo form_errors(); } ?>
		<?php echo form_errors($errors);?>
		<h2>Create page</h2>
		<form method="post" action="create_page.php?subject=<?php echo $current_subject['id']; ?>">
			<p>Page name:
				<input type="text" name="menu_name" value="" />
			</p>
			<p>Position
				<select name="position">
					<?php
						$page_set = find_pages_for_subject($current_subject['id'], false);
						$page_count = mysqli_num_rows($page_set);
						for($count = 1; $count <= $page_count + 1; $count++) {
							echo "<option value=\"$count\">$count</option>";
						}
					?>
				</select>
			</p>
			<p>Visible
				<input type="radio" name="visible" value="0" /> No &nbsp;
				<input type="radio" name="visible" value="1" /> Yes
			</p>
			<p>Content</p>
			<textarea name="content" style="width: 479px; height: 168px">
			</textarea> <br />
			<input type="submit" name ="submit" value="Create page" />
			<br />
			<a href="manage_content.php?subject=<?php echo $current_subject['id']; ?>">Cancel</a>

		</form>
	</div><!--end page-->
</div> <!--end main-->
<?php include("../includes/layouts/footer.php"); ?>