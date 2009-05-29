<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer.
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/* ADMIN LOGIN
Credits to Jem from Tutorialtastic.co.uk for the secure login tutorial, in which I based this login form. */

//Include the required files.

require('inc/settings.php');

//Set important variables.
$username = $SBM_SETTINGS['username'];
$password = $SBM_SETTINGS['password'];
$randomstring = $SBM_SETTINGS['randomstring'];

$adminurl = $SBM_SETTINGS['adminurl'];

//If the yummy cookie is set...
if (isset($_COOKIE['SBMadmin'])) {
	//... And then, if the cookie is same as the specified password...
   if ($_COOKIE['SBMadmin'] == md5($password.$randomstring)) {
	//LOAD ADMINISTRATION PANEL!   
		header('Location: '. $adminurl .'/admin.php');
		exit;
    //else...
    } else {
		echo '<p>Bad cookie. :(  Please clear it out and try to login again.</p>';
		exit;
	}
}

//Now, if the cookie isn't set, the user is not logged in.  This is where the fun comes in!  SO...

//If the form has been sent, AND username and password have already been submitted in the login form...
if (isset($_GET['a']) && $_GET['a'] == 'login') {
	if (isset($_POST['name']) && isset($_POST['pass'])) {
		//... Then let's check if those values are correct.  And if they're not...
		if (!empty($_POST['name']) && !empty($_POST['pass'])) {
			if ($_POST['name'] != $username || $_POST['pass'] != $password) {
				echo '<p>Sorry, wrong username or password.  Please try again.</p>';
			//BUT, if they are...
			} else if ($_POST['name'] == $username && $_POST['pass'] == $password) {
				setcookie('SBMadmin', md5($_POST['pass'].$randomstring));
				header('Location: '. $_SERVER[PHP_SELF] .'');
			//Otherwise, something went wrong with the form.
			} else {
				echo '<p>Sorry, you could not be logged in at this time.  Please try again.</p>';
			}
		} else {
			echo '<p>Please enter both your username and password, and try again.</p>';
		}
   //Or perhaps the form wasn't filled in correctly.  Something may have been missing.
	} else {
		echo '<p>You have to fill in the form!  Please try again.</p>';
	}
}

//And finally!  Here is the super famous login form!
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?a=login" method="post">
	<fieldset>
		<label><input type="text" name="name" id="name" /> Username</label><br />
		<label><input type="password" name="pass" id="pass" /> Password</label><br />
		<input type="submit" id="submit" value="Login" />
	</fieldset>
</form>