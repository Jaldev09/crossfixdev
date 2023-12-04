<?php
/*
 * REST functionality.
 */


// Set the namespace
Namespace Wisewebs\Classes\REST;


// Import relevant namespaces
Use Wisewebs\Interfaces;


/*
 * Class for REST functionality.
 */
class REST implements Interfaces\JS\JS {

	const ROUTE__BASE               = 'wisewebs';
	const ROUTE__CURRENT_VERSION    = 'v1';

	const ERROR_CODE__LOGGED_OUT    = 1;
	const ERROR_MESSAGE__LOGGED_OUT = 'You need to be logged in to use this function';





	/**
	 * Set up and inject the necessary JS structure.
	 */
	public static function injectJSVariables() {

		// Is this WP so we can add actions?
		if ( function_exists( 'add_action' ) ) {

			// Enqueue admin script
			add_action(
				'admin_enqueue_scripts',
				function() {

					// Prepend variables to admin.js
					wp_localize_script(
						'ww-admin-js',
						'wpApiSettings',
						array(
							'root' => esc_url_raw( rest_url() ),
							'nonce' => wp_create_nonce( 'wp_rest' )
						)
					);
				}
			);
		}
	}
}
