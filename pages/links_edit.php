<?php
if (isset($_GET['id']) AND !empty($_GET['id']) AND is_numeric($_GET['id'])) {
	sbm_connect();
	if (isset($_POST['edited_link'])) {
		$id = $_GET['id'];
		$newcategory = CleanData($_POST['newcategory']);
		$newtitle = CleanData($_POST['newtitle']);
		$newurl = CleanData($_POST['newurl']);
		$newfeed = CleanData($_POST['newfeed']);
		$newowner = CleanData($_POST['newowner']);
		$newdescription = CleanData($_POST['newdescription']);
		$newrating = CleanData($_POST['newrating']);
		$updatesql = 'UPDATE '. $SBM_SETTINGS['table_links'] .' SET category=\''. $newcategory .'\', title=\''. $newtitle .'\', url=\''. $newurl .'\', feed=\''. $newfeed .'\', owner=\''. $newowner .'\', description=\''. $newdescription .'\', rating=\''. $newrating .'\' WHERE id='. $id .' LIMIT 1';
		$updateresult = mysql_query($updatesql);
		if ($updateresult) {
?>
			<p>Link edited successfully!</p>
<?php
		} else {
?>
			<p>Failed to edit link!<br />
				MySQL Error: <?php echo mysql_error(); ?>
			</p>
<?php
		}
	}
	$id = $_GET['id'];
	$sql= 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' WHERE id='. $id .' LIMIT 1';
	$result = mysql_query($sql);
	while ($row = mysql_fetch_array($result)) {
		$id = $row['id'];
		$oldcategory = html_entity_decode($row['category']);
		$oldtitle = html_entity_decode($row['title']);
		$oldurl = html_entity_decode($row['URL']);
		$oldfeed = html_entity_decode($row['feed']);
		$oldowner = html_entity_decode($row['owner']);
		$olddescription = html_entity_decode($row['description']);
		$oldrating = html_entity_decode($row['rating']);
?>
		<form action="admin.php?p=links&amp;a=edit&amp;id=<?php echo $id; ?>" method="post">
			<p><label for="newcategory">Category:</label><br />
			<select id="newcategory" name="newcategory">
				<option value="0" name="newcategory">- choose a category -</option>
<?php
					/*  NOTE:  The following three queries are used in order to neatly display the list of categories in a drop-down box, and allow the category's current "parent" category to be selected by default.  
					It's a confusing part, and I need to rewrite it later.  The dropdown_catlist() function doesn't work for this.  :(   Know of a more efficient way that requires less lines of code and that can be re-used?  Please let me know!  */
					$sql2 = 'SELECT id, parent, name FROM '. $SBM_SETTINGS['table_categories'] .' ORDER BY name, parent'; //used to select  id, parent and name of all the categories in the table
					$result2 = mysql_query($sql2);
					while($row2 = mysql_fetch_array($result2)) {
						$catid = $row2['id'];
						$catparent = $row2['parent'];
						$catname = $row2['name'];
						$sql3 = 'SELECT name FROM '. $SBM_SETTINGS['table_categories'] .' WHERE id ='. $catparent .' LIMIT 1'; //used to get the name of the parent category for each category that is in the list (a drop-down box in this case).
						$result3 = mysql_query($sql3);
						while ($row3 = mysql_fetch_array($result3)) {
							$catparentname = $row3['name'];
						}
?>
				<option name="newcategory" id="<?php echo $catid; ?>" value="<?php echo $catid; ?>" <?php if ($oldcategory == $catid) { ?>selected="selected"<?php } ?>><?php echo $catname; ?> <?php if ($catparent != 0) { echo '['. $catparentname .']'; } ?> (<?php echo $catid; ?>)</option>
<?php
					} //*Sighs*  End of this mess!  But, at least it works!  :D
?>
			</select></p>
			<p><label for="newtitle">Title:</label><br /><input type="text" maxlength="150" id="newtitle" name="newtitle" value="<?php echo $oldtitle; ?>" /></p>
			<p><label for="newurl">URL</label><br /><input type="text" maxlength="150" id="newurl" name="newurl" value="<?php echo $oldurl; ?>" /></p>
			<p><label for="newfeed">Feed</label><br /><input type="text" maxlength="150" id="newfeed" name="newfeed" value="<?php echo $oldfeed; ?>" /></p>
			<p><label for="newowner">Owner:</label><br /><input type="text" maxlength="150" id="newowner" name="newowner" value="<?php echo $oldowner; ?>" /></p>
			<p><label for="newdescription">Description:</label><br /><textarea rows="5" cols="20" id="newdescription" name="newdescription"><?php echo $olddescription; ?></textarea></p>
			<p><label for="newrating">Rating:</label><br />
			<select id="newrating" name="newrating">
				<option name="newrating" id="0" value="0" <?php if($oldrating == 0) { ?>selected="selected"<?php } ?>>- no rating -</option>
				<option name="newrating" id="1" value="1" <?php if($oldrating == 1) { ?>selected="selected"<?php } ?>>1</option>
				<option name="newrating" id="2" value="2" <?php if($oldrating == 2) { ?>selected="selected"<?php } ?>>2</option>
				<option name="newrating" id="3" value="3" <?php if($oldrating == 3) { ?>selected="selected"<?php } ?>>3</option>
				<option name="newrating" id="4" value="4" <?php if($oldrating == 4) { ?>selected="selected"<?php } ?>>4</option>
				<option name="newrating" id="5" value="5" <?php if($oldrating == 5) { ?>selected="selected"<?php } ?>>5</option>
			</select></p>
			<p><input type="submit" name="edited_link" id="edited_link" value="Edit link" /></p>
		</form>
<?php
	}
} else {
	echo '<p>You didn\' select a link to edit.</p>';
}