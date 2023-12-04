<?php
/*
 * Settings related to menus.
 */


// Set namespace
Namespace Wisewebs\Settings\WordPress;



// Limit menu depth when editing menus
add_action(
	'admin_enqueue_scripts',
	'Wisewebs\\Classes\\WordPress\\Menus::limitMenuDepth'
);



// Allow us to filter by specific parent in wp_nav_menu()
add_filter(
	'wp_nav_menu_objects',
	'Wisewebs\\Classes\\WordPress\\Menus::allowFilteringByMenuItem',
	10,
	2
);
