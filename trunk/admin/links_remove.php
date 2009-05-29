<?php
if (isset($_POST['delete'])) {
	if (isset($_POST['link'])) {
		sbm_connect();
		$link = $_POST['link'];
		foreach ($link as $key => $id) {
			$sql = 'DELETE from '. $SBM_SETTINGS['table_links'] .' WHERE id='. $id .' LIMIT 1';
			$result = mysql_query($sql);
			if ($result == true) {
				echo '<p>Links deleted successfully!</p>';
				mysql_close();
			} else {
?>
				<p>Failed to delete links!<br />
					MySQL Error: <?php echo mysql_error(); ?>
				</p>
<?php
			}
		}	
	} else {
?>
		<p>You didn't select any links to delete!</p>
<?php
	}
}