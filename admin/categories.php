<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

	<div id="about">
		<h2>Categories</h2>
		<p>Welcome to the <b>categories</b> section of your administration panel.  You can manage your link categories from here.</p>
	</div>
<?php
	$action = $_GET['a'];
	if (isset($action) AND !empty($action)) {
		if ($action == 'edit') {
			require_once('categories_edit.php');
		} elseif ($action == 'add') {
			require_once('categories_add.php');
		} elseif ($action == 'delete') {
			require_once('categories_remove.php');
		}
	} else {
?>
		<p class="addcat"><a href="admin.php?p=categories&amp;a=add">Add new</a></p>
		<form action="admin.php?p=categories&a=delete" method="post">
			<table>
				<tr class="theading">
					<td>Check</td><td>ID</td><td>Parent</td><td>Name</td><td>Description</td><td>Links</td><td>Edit</td>
				</tr>
<?php 
				sbm_connect();
				$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' ORDER BY id';
				$result = mysql_query($sql);
				while($row = mysql_fetch_array($result)) {
					$id = $row['id'];
					$parent = $row['parent'];
					$name = $row['name'];
					$description = $row['description'];
					$sql2 = 'SELECT name FROM '. $SBM_SETTINGS['table_categories'] .' WHERE id='. $parent .' LIMIT 1'; //used to get the name of the parent category, for display only
					$result2 = mysql_query($sql2);
					while ($row2 = mysql_fetch_array($result2)) {
						$parentname = $row2['name'];
					}
?>
				<tr>
					<td><input type="checkbox" name="category[]" id="<?php echo $id; ?>" value="<?php echo $id; ?>" /></td><td><?php echo $id; ?></td><td><?php if ($parent != 0) { echo $parentname; } else { ?>None<?php } ?> (<?php echo $parent; ?>)</td><td><?php echo $name; ?></td><td><?php echo $description; ?></td><td><?php $links_count = links_count($id); echo $links_count; ?></td><td><a href="?p=categories&amp;a=edit&amp;id=<?php echo $id; ?>">Edit</a></td>
				</tr>
<?php
	}
?>
			</table>
			<input type="hidden" name="delete" value="delete" />
			<input type="submit" name="delete_category" id="delete_category" value="Delete checked" />
		</form>

		<p class="addcat"><a href="admin.php?p=categories&amp;a=add">Add new</a></p>
<?php
		mysql_close();
	}
?>