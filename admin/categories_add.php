<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['add_category'])) {
		if (!empty($_POST['name'])) {
			sbm_connect();
			$parent = CleanData($_POST['parent']);
			$name = CleanData($_POST['name']);
			$description = CleanData($_POST['description']);
			$sql = 'INSERT INTO '. $SBM_SETTINGS['table_categories'] .' (parent, name, description) VALUES (\''. $parent .'\',\''. $name .'\',\''. $description .'\')';
			$result = mysql_query($sql);
			if ($result) {
?>
				<p>Category added successfully!</p>
<?php
			mysql_close();
			} else {
?>
				<p>Failed to add category!<br />
					MySQL Error: <?php echo mysql_error(); ?>
				</p>
<?php
			}
		} else {
?>
			<p>Failed to add category!
			<br />You need to at least specify a name for the category, in order to add it!</p>
<?php
		}
	}
			<form action="admin.php?p=categories&amp;a=add" method="post">
				<p><label for="parent">Parent Category:</label><br />
				<select id="parent" name="parent">
					<option value="0" name="parent" selected="selected">None</option>
<?php
						sbm_connect();
						$sql = 'SELECT id, parent, name FROM '. $SBM_SETTINGS['table_categories'] .' ORDER BY name, parent';
						$result = mysql_query($sql);
						while($row = mysql_fetch_array($result)) {
							$id = $row['id'];
							$parent = $row['parent'];
							$name = $row['name'];
							$sql2 = 'SELECT name FROM '. $SBM_SETTINGS['table_categories'] .' WHERE id='. $parent .' LIMIT 1'; //used to get the name of the parent category, for display only
							$result2 = mysql_query($sql2);
							while ($row2 = mysql_fetch_array($result2)) {
								$parentname = $row2['name'];
							}
?>
					<option name="parent" id="<?php echo $id; ?>" value="<?php echo $id; ?>"><?php echo $name; ?> <?php if ($parent != 0) { echo '['. $parentname .']'; } ?> (<?php echo $id; ?>)</option>
<?php
	}
				</select></p>
				<p><label for="name">Name:</label><br /><input type="text" maxlength="150" id="name" name="name" /></p>
				<p><label for="description">Description:</label><br /><textarea rows="5" cols="20" id="description" name="description"></textarea></p>
				<p><input type="submit" name="add_category" id="add_category" value="Add category" /></p>
			</form>
?>