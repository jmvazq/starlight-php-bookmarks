<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

	<div id="about">
		<p class="head">Welcome!</p>
		Welcome to the home of the control panel for your <b>Starlight Bookmarks</b> script installation.
	</div>
	<div id="statistics">
		<p class="head">Statistics</p>
		This web bookmarks directory contains <?php echo links_count(); ?> links in <?php echo categories_count(); ?> categories and sub-categories.<br />
		The last link was added on <?php date($SBM_SETTINGS['dateformat'], $lastadded); ?>.
	</div>
	<div id="credits">
		<p class="head">Credits</p>
		Credits to...
	</div>