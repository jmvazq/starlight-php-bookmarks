<?php
	if (isset($_GET['id']) AND !empty($_GET['id']) AND is_numeric($_GET['id'])) {
		sbm_connect();
		if (isset($_POST['edited_category'])) {
			if (empty($_POST['newname']) OR empty($_POST['newdescription'])) {
				echo '<p>Failed to edit category!<br />You need to at least specify a name for the category, in order to add it!</p>';
			} else {
				$id = $_GET['id'];
				$newparent = CleanData($_POST['newparent']);
				$newname = CleanData($_POST['newname']);
				$newdescription = CleanData($_POST['newdescription']);
				$updatesql = 'UPDATE '. $SBM_SETTINGS['table_categories'] .' SET parent=\''. $newparent .'\', name=\''. $newname .'\', description=\''. $newdescription .'\' WHERE id='. $id .' LIMIT 1';
				$updateresult = mysql_query($updatesql);
				if ($updateresult) {
					echo '<p>Category edited successfully!</p>';
				} else {
?>
					<p>Failed to edit category!<br />
						MySQL Error: <?php echo mysql_error(); ?>
					</p>
<?php
				}
			}
		}
		$id = $_GET['id'];
		$sql= 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' WHERE id='. $id .' LIMIT 1';
		$result = mysql_query($sql);
		while ($row = mysql_fetch_array($result)) {
			$id = $row['id'];
			$oldname = html_entity_decode($row['name']);
			$oldparent = html_entity_decode($row['parent']);
			$olddescription = html_entity_decode($row['description']);
?>
			<form action="admin.php?p=categories&amp;a=edit&amp;id=<?php echo $id; ?>" method="post">
				<p><label for="newparent">Parent Category:</label><br />
				<select id="newparent" name="newparent">
					<option value="0" name="newparent">None</option>		
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
					<option name="newparent" id="<?php echo $catid; ?>" value="<?php echo $catid; ?>" <?php if ($oldparent == $catid) { ?>selected="selected"<?php } ?>><?php echo $catname; ?> <?php if ($catparent != 0) { echo '['. $catparentname .']'; } ?> (<?php echo $catid; ?>)</option>
<?php
					} //*Sighs*  End of this mess!  But, at least it works!  :D
?>
				</select></p>
				<p><label for="newname">Name:</label><br /><input type="text" maxlength="150" id="newname" name="newname" value="<?php echo $oldname; ?>" /></p>
				<p><label for="newdescription">Description:</label><br /><textarea rows="5" cols="20" id="newdescription" name="newdescription"><?php echo $olddescription; ?></textarea></p>
				<p><input type="submit" name="edited_category" id="edited_category" value="Edit category" /></p>
			</form>
<?php
		}
	}