<div id="footer">
				Copyright <?php echo date("Y"); ?>, Widget Corp
			</div><!--end footer-->
	</body>
</html>
<?php
	if (isset($connection)) {
		mysqli_close($connection);
	}
?>