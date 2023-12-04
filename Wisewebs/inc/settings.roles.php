<?php
/*
 * Settings related to WordPress roles.
 */

// Set namespace
Namespace Wisewebs\Settings\WordPress;




/**
 * Adds the current role to the list of body classes.
 *
 * @param      string  $classes  Other classes
 *
 * @return     string  Classes including role class
 */
function addRoleToBodyClass( $classes ) {

	// Access user in a global scope
	global $current_user;

	// Check that there is an array of roles
	if ( is_array( $current_user->roles ) )
		// Loop roles
		foreach ( $current_user->roles as $role )
			// Append the role class
			$classes .= ' user-role-' . $role . ' ';

	// Return classes
	return $classes;
}

add_filter( 'admin_body_class', 'Wisewebs\\Settings\\WordPress\\addRoleToBodyClass' );
