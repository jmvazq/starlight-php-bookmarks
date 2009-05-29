<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST['delete'])) {
	if (isset($_POST['category']) AND !empty($_POST['category'])) {
		sbm_connect();
		$category = $_POST['category'];
		$defaultcat = $SBM_SETTINGS['defaultcat'];
		foreach ($category as $key => $id) {
			if ($id == $defaultcat) { 
				exit('<p>You cannot delete the default category!  :(</p>');
			}
			$sql = 'DELETE from '. $SBM_SETTINGS['table_categories'] .' WHERE id='. $id .' LIMIT 1';
			mysql_query($sql) OR exit('<p>Failed to delete categories!<br />MySQL Error: '. mysql_error() .'</p>');
		}
		echo '<p>Categories deleted successfully!</p>';
		foreach ($category as $key => $id) {
			$sql2 = 'UPDATE '. $SBM_SETTINGS['table_links'] .' SET category = '. $defaultcat .' WHERE category = '. $id .'';
			mysql_query($sql2) OR exit('<p>Categories deleted successfully.<br />However, an unexpected error caused that links in those categories couldn\'t be moved to the default category ('. $SBM_SETTINGS['defaultcat'] .').</p>');
		}
		echo 'All the links in the deleted categories have been preserved under the default category ('. $defaultcat .').';
		mysql_close();
	} else {
		echo '<p>You didn\'t select any categories to delete!</p>';
	}
}
?>