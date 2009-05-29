<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////  NOTES ABOUT THIS DOCUMENT
/*
I'm planning to separate functions in individual files, or restrict the system.php include to user functions only, keeping administrative ones somewhere else, so that they cannot be used in the user's 'front' by default.
*/

require_once('settings.php');

//MAIN FUNCTIONS

//--COMMON ACTIONS

//SBM CONNECT:  This function connects to the corresponding database.
function sbm_connect() {
	GLOBAL $SBM_SETTINGS;
	mysql_connect ($SETTINGS['db_host'], $SBM_SETTINGS['db_user'], $SBM_SETTINGS['db_password']) or die('<b>Error!</b>  Failed to connect! :(');
	mysql_select_db ($SBM_SETTINGS['db_database']) or die('<b>Error!</b>  Failed to select database! :(');
} //end of SBM CONNECT function.

function sbm_pagination() {
}

//--SECTIONS

//---ADMIN PANEL

//ADMIN SECTION:  This function checks which section is being requested by the browser, and returns the correct information for each section.
function admin_section($section) {
	GLOBAL $SBM_SETTINGS;
	$adminpath = $SBM_SETTINGS['adminpath'];
	if ($section == 'help') {
		require_once($adminpath .'/admin/help.php');
	}
	elseif ($section == 'links') {
		require_once($adminpath .'/admin/links.php');
	}
	elseif ($section == 'categories') {
		require_once($adminpath .'/admin/categories.php');
	}
	else {
		require_once($adminpath .'/admin/main.php');
	}
} //END of ADMIN SECTION function.


//-- SECURITY

/* This function helps validate data in a more organized way.  Even though most forms are in the admin panel, it may be 
used sometime just to add that extra security, which is always necessary.
Credits to Jem from Jemjabella.co.uk! */

function CleanData($data) {
	if (!get_magic_quotes_gpc()) $data = addslashes($data);
		$data = trim(htmlentities(strip_tags($data)));
		return $data;
}


//--USER FUNCTIONS
/* The following functions are the heart of this script, so to say.  Without them, the users wouldn't be able to easily read and display their bookmarks in their websites.
So, in other words, these functions are meant to handle the link and category data stored in the user's database.  'Nuff said. */


// CATEGORIES() - Select a group of categories from the database.
function categories($beforecat, $aftercat, $order, $display, $linked) {
	GLOBAL $SBM_SETTINGS;
	sbm_connect();
	if ($beforecat == '' AND $aftercat == '') {
		$aftercat = '<br />';
	}
	if ($order != 'name' OR $order != 'id') {
		$order = 'name';
	}
	if ($display == 'parents') {
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' WHERE parent<>\'0\' ORDER BY '. $order .'';
	} else if ($display == 'all' OR $display == '' OR $display == 'noparents') {
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' WHERE parent=\'0\' ORDER BY '. $order .'';
	} else {
		if (!is_numeric($display)) {
			echo '<p>Error in request: invalid parent category ID specified in the \'display\' parameter.</p>';
		} else {
			$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' WHERE parent='. $display .' ORDER BY '. $order .'';
		}
	}
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) { 
		$id = $row['id'];
		$parent = $row['parent'];
		$name = $row['name'];
		$description = $row['description'];
		if ($linked == 'linked') {
			echo ''. $beforecat .'<a href="?catid='. $id .'" title="'. $description .'">'. $name .'</a>'. $aftercat .'';
			if ($display == 'all' OR $display == '') { 
				$sql2 = 'SELECT id, name, description FROM '. $SBM_SETTINGS['table_categories'] .' WHERE parent='. $id .' ORDER BY '. $order .''; 
				$result2 = mysql_query($sql2);
				while($row2 = mysql_fetch_array($result2)) {
					$parentid = $row2['id'];
					$parentname = $row2['name'];
					$parentdescription = $row2['description'];	
					echo ''. $beforecat .'--<a href="?catid='. $parentid .'" title="'. $parentdescription .'">'. $parentname .'</a>'. $aftercat .'';
				}
			}
		} else {
			echo ''. $beforecat .''. $name .''. $aftercat .'';
			if ($display == 'all' OR $display == '') { 
				$sql2 = 'SELECT id, name, description FROM '. $SBM_SETTINGS['table_categories'] .' WHERE parent='. $id .' ORDER BY '. $order .''; 
				$result2 = mysql_query($sql2);
				while($row2 = mysql_fetch_array($result2)) {
					$parentid = $row2['id'];
					$parentname = $row2['name'];
					$parentdescription = $row2['description'];
					echo '--'. $beforecat .''. $parentname .''. $aftercat .'';
				}
			}
		}
	}
	mysql_close();
} //END of function.


// GET_CATEGORY() - Get a chosen category's information.
function get_category($id) {
	GLOBAL $SBM_SETTINGS;
	if ($id) {
		sbm_connect();
		global $cat_id;
		global $cat_parent;
		global $cat_name;
		global $cat_description;
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' WHERE id='. $id .' LIMIT 1';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$cat_id = $row['id'];
			$cat_parent = $row['parent'];
			$cat_name = $row['name'];
			$cat_description = $row['description'];
		}
	}
} //END of function.


// LINKS() - Select a group of links from the database.
function links($beforelink = null, $afterlink = null, $order = null, $display = null, $target = null, $limit = null) {
	GLOBAL $SBM_SETTINGS;
	sbm_connect();
	if ($beforelink == '' AND $afterlink == '') {
		$afterlink = '<br />';
	}
	if ($order != 'title' AND $order != 'id' AND $order != 'category' AND $order != 'date_added ASC' AND $order != 'date_added DESC' OR !isset($order)) {
		$order = 'title';
	}
	if ($limit == '' OR !is_numeric($limit)) { 
		if ($display == 'all' OR $display == '') {
			$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' ORDER BY '. $order .'';
		} else {
			$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' WHERE category='. $display .' ORDER BY '. $order .'';
		}
	} else {
		if ($display == 'all' OR $display == '') {
			$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' ORDER BY '. $order .' LIMIT '. $limit .'';
		} else {
			$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' WHERE category='. $display .' ORDER BY '. $order .' LIMIT '. $limit .'';
		}
	}
	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)) { 
		$id = $row['id'];
		$category = $row['category'];
		$title = $row['title'];
		$url = $row['URL'];
		$feed = $row['feed'];
		$owner = $row['owner'];
		$description = $row['description'];
		if($row['rating'] == 0) { $rating = 'N/A'; } else { $rating = $row['rating']; }
		$date = $row['date_added'];
		if ($order == 'category') {
			$catsql = 'SELECT name FROM '. $SBM_SETTINGS['table_categories'] .' WHERE id='. $category .' LIMIT 1';
			$catresult = mysql_query($catsql);
			while($catrow = mysql_fetch_array($catresult)) {
				$catname = $catrow['name'];
			}
			echo ''. $beforelink .'<strong>'. $catname .'</strong>: <a href="'. $url .'" target="'. $target .'" title="'. $description .'">'. $title .'</a>'. $afterlink .'';
		} else {
			echo ''. $beforelink .'<a href="'. $url .'" target="'. $target .'" title="'. $description .'">'. $title .'</a>'. $afterlink .'';
		}
	}
	mysql_close();
}


//GET_LINK() - Get a selected link's information.
function get_link($id) {
	GLOBAL $SBM_SETTINGS;
	if ($id) {
		sbm_connect();
		global $link_id;
		global $link_category;
		global $link_title;
		global $link_url;
		global $link_feed;
		global $link_owner;
		global $link_description;
		global $link_rating;
		global $link_date;
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' WHERE id='. $id .' LIMIT 1';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$link_id = $row['id'];
			$link_category = $row['category'];
			$link_title = $row['title'];
			$link_url = $row['URL'];
			$link_feed = $row['feed'];
			$link_owner = $row['owner'];
			$link_description = $row['description'];
			if($row['rating'] == 0) { $link_rating = 'N/A'; } else { $link_rating = $row['rating']; }
			$link_date = $row['date_added'];
		}
	}
}


// MUST REWRITE - LINKS_COUNT() - Count links in your database.
function links_count($category = null) {
	GLOBAL $SBM_SETTINGS;
	sbm_connect();
	if (!isset($category)) {
		$sql = 'SELECT id FROM '. $SBM_SETTINGS['table_links'] .'';
	} else {
		$sql = 'SELECT id FROM '. $SBM_SETTINGS['table_links'] .' WHERE category='. $category .'';
	}
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	return $count;
}


// LINKS_RANDOM() - Select a random link from the database.
function links_random($category = null) {
	GLOBAL $SBM_SETTINGS;
	sbm_connect();
	global $link_id;
	global $link_category;
	global $link_title;
	global $link_url;
	global $link_feed;
	global $link_owner;
	global $link_description;
	global $link_rating;
	global $link_date;
	if($parent) {
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' WHERE category= '. $category .' ORDER BY RAND() LIMIT 1';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$link_id = $row['id'];
			$link_category = $row['category'];
			$link_title = $row['title'];
			$link_url = $row['URL'];
			$link_feed = $row['feed'];
			$link_owner = $row['owner'];
			$link_description = $row['description'];
			if($row['rating'] == 0) { $link_rating = 'N/A'; } else { $link_rating = $row['rating']; }
			$link_date = $row['date_added'];
		}
	} else {
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_links'] .' ORDER BY RAND() LIMIT 1';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$link_id = $row['id'];
			$link_category = $row['category'];
			$link_title = $row['title'];
			$link_url = $row['URL'];
			$link_feed = $row['feed'];
			$link_owner = $row['owner'];
			$link_description = $row['description'];
			if($row['rating'] == 0) {
				$link_rating = 'N/A'; } else { $link_rating = $row['rating'];
			}
			$link_date = $row['date_added'];
		}
	}
}


// MUST REWRITE - CATEGORIES_COUNT() - Count categories in the database.
function categories_count($parent = null) {
	GLOBAL $SBM_SETTINGS;
	sbm_connect();
	if (!isset($parent)) {
		$sql = 'SELECT id FROM '. $SBM_SETTINGS['table_categories'] .'';
	} else {
		$sql = 'SELECT id FROM '. $SBM_SETTINGS['table_categories'] .' WHERE parent='. $parent .'';
	}
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	return $count;
}


// CATEGORIES_RANDOM() - Select a random category from the database.
function categories_random($parent = null) {
	GLOBAL $SBM_SETTINGS;
	sbm_connect();
	global $cat_id;
	global $cat_parent;
	global $cat_name;
	global $cat_description;
	if($parent) {
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' WHERE parent= '. $parent .' ORDER BY RAND() LIMIT 1';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$cat_id = $row['id'];
			$cat_parent = $row['parent'];
			$cat_name = $row['name'];
			$cat_description = $row['description'];
		}
	} else {
		$sql = 'SELECT * FROM '. $SBM_SETTINGS['table_categories'] .' ORDER BY RAND() LIMIT 1';
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)) {
			$cat_id = $row['id'];
			$cat_parent = $row['parent'];
			$cat_name = $row['name'];
			$cat_description = $row['description'];
		}
	}
}
?>