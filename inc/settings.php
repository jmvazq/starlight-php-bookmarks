<?php
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//  Starlight Bookmarks - Version 1.0 Beta
//  Copyright 2007, 2008, 2009 Jessica M. Vázquez  at http://www.arwym.com, unless otherwise stated.
//  This is linkware software.  You are required to leave a link to http://www.arwym.com/scripts, along with the software's name and version, in the footer. 
//  You can re-distribute this code under the terms of the GNU license.
*//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//MAIN SETTINGS

//Your website's name.
$SBM_SETTINGS['sitename'] = 'My Web Bookmarks';

//The root address of your installation. No trailing slash at the end!
$SBM_SETTINGS['siteurl'] = 'http://arwym.com/links';

//Your website's path to the root directory of your installation.  No trailing slash at the end!
$SBM_SETTINGS['sitepath'] = 'home/projectf/public_html/links';

//Your admin panel's root address.  No trailing slash at the end!
$SBM_SETTINGS['adminurl'] = $SBM_SETTINGS['siteurl'] . '/sbmadmin';

//Your admin panel's path.  No trailing slash at the end!
$SBM_SETTINGS['adminpath'] = $SBM_SETTINGS['sitepath'] . 'sbmadmin';

//Your admin panel's access username.
$SBM_SETTINGS['username'] = 'sbmadmin';

//Your admin panel's access password.
$SBM_SETTINGS['password'] = 'ilurvlinks';

//The random string that will be combined with your password in order to make it much harder for strangers to guess it
//and access your admin panel.  Make sure that it is very, very random.
$SBM_SETTINGS['randomstring'] = '6lollgdhhilovelinksduhwhyelseamiwritingthisscriptanyway4';


//OPTIONS

//Defines the format in which every date will be displayed.  Used for the dates in which every link was added.
$SBM_SETTINGS['dateformat'] = 'm/d/y';

//Specify the default category by its ID.  Default value is '1'.
//Every time a category is deleted, all its links will be automatically moved to the default category.
//And if no category is specified during link creation, then it'll be automatically sorted under the default one.
$SBM_SETTINGS['defaultcat'] = '1';


//DATABASE INFO

//Your website's host.  Usually 'localhost'.  If you don't know what this is, leave it as it is now.
$SBM_SETTINGS['db_host'] = 'localhost';

//Your database's name.
$SBM_SETTINGS['db_database'] = 'projectf_links';

//Your database's username.
$SBM_SETTINGS['db_user'] = 'projectf_links';

//Your database's password.
$SBM_SETTINGS['db_password'] = '1gatito01';


//DATA TABLE NAMES
//You may leave them as they are now, or change if your database has existing tables with these names already.

//Settings table.  Not used in this version, so you may just ignore it.
$SBM_SETTINGS['table_settings'] = 'sbm_settings';

//Categories table.
$SBM_SETTINGS['table_categories'] = 'sbm_categories';

//Links table.
$SBM_SETTINGS['table_links'] = 'sbm_links';

?>