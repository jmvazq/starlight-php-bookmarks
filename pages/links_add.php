<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['add_link'])) {
		if (!empty($_POST['category']) AND !empty($_POST['title']) AND !empty($_POST['url'])) {
			sbm_connect();
			$category = CleanData($_POST['category']);
			$title = CleanData($_POST['title']);
			$url = CleanData($_POST['url']);
			$feed = CleanData($_POST['feed']);
			$owner = CleanData($_POST['owner']);
			$description = CleanData($_POST['description']);
			$rating = CleanData($_POST['rating']);
			$sql = 'INSERT INTO '. $SBM_SETTINGS['table_links'] .' (category, title, URL, feed, owner, description, rating) VALUES (\''. $category .'\',\''. $title .'\',\''. $url .'\',\''.$feed .'\',\''. $owner .'\',\''. $description .'\',\''. $rating .'\')';
			$result = mysql_query($sql);
			if ($result) {
?>
				<p>Link added successfully!</p>
<?php
				mysql_close();
			} else {
?>
				<p>Failed to add link!<br />
					MySQL Error: <?php echo mysql_error(); ?>
				</p>
<?php
			}
		} else {
?>
				<p>Failed to add link!<br />
					You need to at least specify a category, title and URL for the link, in order to add it!
				</p>
<?php
		}
	}
?>
	<form action="admin.php?p=links&amp;a=add" method="post">
		<p><label for="category">Category:</label><br />
			<select id="category" name="category">
				<option value="0" name="category">- choose a category -</option>
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
?>
			</select>
		</p>
		<p><label for="title">Title:</label><br /><input type="text" maxlength="150" id="title" name="title" /></p>
		<p><label for="url">URL:</label><br /><input type="text" id="url" name="url" /></p>
		<p><label for="feed">Feed:</label><br /><input type="text" id="feed" name="feed" /></p>
		<p><label for="owner">Owner:</label><br /><input type="text" maxlength="150" id="owner" name="owner" /></p>
		<p><label for="description">Description:</label><br /><textarea rows="5" cols="20" id="description" name="description"></textarea></p>
		<p><label for="rating">Rating:</label><br />
			<select id="rating" name="rating">
				<option name="rating" id="0" value="0" selected="selected">- no rating -</option>
				<option name="rating" id="1" value="1">1</option>
				<option name="rating" id="2" value="2">2</option>
				<option name="rating" id="3" value="3">3</option>
				<option name="rating" id="4" value="4">4</option>
				<option name="rating" id="5" value="5">5</option>
			</select>
		</p>
		<p><input type="submit" name="add_link" id="add_link" value="Add link" /></p>
	</form>