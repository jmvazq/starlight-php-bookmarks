<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

	<div id="about">
		<h2>Links</h2>
		<p>Welcome to the <b>links</b> section of your administration panel.  You can manage your links from here.</p>
	</div>
<?php
	$action = $_GET['a'];
	if (isset($action) AND !empty($action)) {
		if ($action == 'edit') {
			require_once('links_edit.php');
		} elseif ($action == 'add') {
			require_once('links_add.php');
		} elseif ($action == 'delete') {
			require_once('links_remove.php');
		}
	} else {
?>
	<p class="addlink"><a href="admin.php?p=links&amp;a=add">Add new</a></p>
	<form action="admin.php?p=links&a=delete" method="post">
		<table>
		<tr class="theading">
			<td>Check</td><td>ID</td><td>Category</td><td>Title</td><td>URL</td><td>Feed</td><td>Owner</td><td>Description</td><td>Rating</td><td>Edit</td>
		</tr>
<?php
		sbm_connect();
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' ORDER BY id';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$id = $row['id'];
			$category = $row['category'];
			$title = $row['title'];
			$url = $row['URL'];
			$feed = $row['feed'];
			$owner = $row['owner'];
			$description = substr($row['description'], 0, 150);
			if($row['rating'] == 0) { $rating = 'N/A'; } else { $rating = $row['rating']; }
				$sql2 = 'SELECT name FROM '. $SBM_SETTINGS['table_categories'] .' WHERE id='. $category .' LIMIT 1'; //used to get the name of the parent category, for display only
				$result2 = mysql_query($sql2);
				while ($row2 = mysql_fetch_array($result2)) {
					$categoryname = $row2['name'];
				}
?>
				<tr>
					<td><input type="checkbox" name="link[]" id="<?php echo $id; ?>" value="<?php echo $id; ?>" /></td><td><?php echo $id; ?></td><td><?php if ($category != 0) { echo $categoryname; } else { ?>None<?php } ?> (<?php echo $category; ?>)</td><td><?php echo $title; ?></td><td><?php echo $url; ?></td><td><?php echo $feed; ?></td><td><?php echo $owner; ?></td><td><?php echo $description; ?></td><td><?php echo $rating; ?></td><td><a href="?p=links&amp;a=edit&amp;id=<?php echo $id; ?>">Edit</a></td>
				</tr>
<?php
	}
?>
		</table>
		<input type="hidden" name="delete" value="delete" />
		<input type="submit" name="delete_link" id="delete_link" value="Delete checked" />
	</form>
	<p class="addlink"><a href="admin.php?p=links&amp;a=add">Add new</a></p>
<?php
		mysql_close();
	}