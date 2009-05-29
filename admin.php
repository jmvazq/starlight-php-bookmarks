<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//ADMIN CONTROL PANEL

//Include the required files.
require('inc/system.php');
require('inc/settings.php');

//Set important variables.
$password = $SBM_SETTINGS['password'];
$randomstring = $SBM_SETTINGS['randomstring'];

$sitename = $SBM_SETTINGS['sitename'];
$adminurl = $SBM_SETTINGS['adminurl'];

$section = $_GET['p'];

//If the yummy cookie is set...

if (isset($_COOKIE['SBMadmin'])) {	
	//... And then, if the cookie is same as the specified password...
   if ($_COOKIE['SBMadmin'] == md5($password.$randomstring)) {
		//ADMIN PANEL GOES HERE
	?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $sitename; ?> | Starlight Bookmarks Script - Administration Panel</title>
	<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id="wrapper">
		<div id="header">
			Starlight Bookmarks
		</div>
		<div id="content">
			<div id="menu">
				<p>
					<a href="?p=home">Home</a> - <a href="?p=links">Links</a> - <a href="?p=categories">Categories</a> - <a href="?p=faq">FAQ</a>
				</p>
			</div>
			<div id="section">
				<?php admin_section($section); ?>
			</div>	
		</div>
		<div id="footer">
			Powered by <strong>Starlight Bookmarks</strong>
		</div>
	</div>
</body>
</html>
<?php
	exit;
    //... Else, if the cookie's value is NOT the same as the specified password...
    } else {
   		//We go back to the login screen.
    	header('Location: ' . $adminurl);  
      	exit;
	}
}

//Else, if the cookie is NOT set at all...

header('Location: ' . $adminurl);
exit;
?>