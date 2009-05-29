<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

	<div id="about">
		<h2>Welcome!</h2>
		<p>
		Welcome to the home of the control panel for your <b>Starlight Bookmarks</b> script installation.
		</p>
	</div>
	<div id="statistics">
		<h2>Statistics</h2>
		<p>
		This web bookmarks directory contains <?php echo links_count(); ?> links in <?php echo categories_count(); ?> categories and sub-categories.<br />
			<p><strong>5 Most recent links:</strong>
			<ul>
				<?php
				//5 most recent links:
				links('<li>', '</li>', 'date_added DESC', 'all', '_blank', 5);
				?>
			</ul>
			</p>
		</p>
	</div>
	<div id="credits">
		<h2>Credits</h2>
		<p>
		Credits to...
		</p>
	</div>