<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//Include the required files.
require('../inc/system.php');

$table_categories = $SBM_SETTINGS['table_categories'];
$table_links = $SBM_SETTINGS['table_links'];
?>

<html>
<head>
<title>Starlight Bookmarks Installation - Installing...</title>
</head>
<body>

<h2>Starlight Bookmarks Installation - Installing...</h2>

<p>Attempting to connect to database...
<br />
<br />
<?php 
sbm_connect();
?>
Connection successful!</p>

<p>Installing database table, <b>Categories</b>...
<br />
<br />
<?php
$sql = 'CREATE TABLE '. $table_categories .'(
  id int(20) NOT NULL AUTO_INCREMENT, 
  parent int(20) NOT NULL, 
  name tinytext NOT NULL, 
  description longtext NOT NULL,  
  PRIMARY KEY (id)
)';

$result = mysql_query($sql) or
die('<strong>Error!</strong>  Can\'t create the table \''. $table_categories .'\' in the database... :( <p>'. $sql .'</p>'. mysql_error());

if ($result != false) {
    echo 'Table \''. $table_categories .'\' was successfully created!';
}
?>
</p>

<p>Installing database table, <b>Links</b>...
<br />
<br />
<?php
$sql = 'CREATE TABLE '. $table_links .'(
  id int(20) NOT NULL AUTO_INCREMENT, 
  category int(20) NOT NULL, 
  title tinytext NOT NULL, 
  URL tinytext NOT NULL,
  feed tinytext NOT NULL,
  owner tinytext NOT NULL,
  description longtext NOT NULL,
  rating int(2) NOT NULL,
  date_added DATETIME NOT NULL,
  PRIMARY KEY (id)
)';

$result = mysql_query($sql) or
die('<strong>Error!</strong>  Can\'t create the table \''. $table_links .'\' in the database... :( <p>'. $sql .'</p>'. mysql_error());

if ($result != false) {
    echo 'Table \''. $SBM_SETTINGS['table_links'] .'\' was successfully created!';
}
?>
</p>
<?php

$sql = "INSERT INTO " . $table_categories . " (name, description) VALUES ('Sample Category','This is your sample category.  You may add links to it.')";
$result = mysql_query($sql) or
die("<strong>Error!</strong>  Tried to insert sample category, but failed... :( <p><em>" . $sql . "</em></p>" . mysql_error());

$sql = "INSERT INTO " . $table_links . " (category, title, URL, feed, owner, description, rating, date_added) VALUES (0,'Starlight Bookmarks at Google Code', 'http://code.google.com/p/starlight-php-bookmarks', '', 'Jessica M. Vazquez','SBM\'s project site at Google Code, where you can browse the subversion repository for the very latest revision of the source, read the documentation, among other things.', 5, NOW())";
$result = mysql_query($sql) or
die("<strong>Error!</strong>  Tried to insert sample link, but failed... :( <p><em>" . $sql . "</em></p>" . mysql_error());

mysql_close();
?>
<p><a href="end.php">Finish installation...</a></p>

</body>
</html>