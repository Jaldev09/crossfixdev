<?php
/*
 * Generic functionality for Wordpress-related things.
 */


// Set the namespace
Namespace Wisewebs\Classes\WordPress;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * The main class for Woocommerce-related things.
 */
class WordPress {





	/**
	 * Utilize the magic function __set to make sure we can't overload this
	 * class.
	 *
	 * @param      string  $name   Unused, we only care to receive it for
	 *                             compatibility
	 * @param      string  $val    Unused, we only care to receive it for
	 *                             compatibility
	 */
	public function __set( $name, $val ) {

		// Hey, this is overloading! This class doesn't allow that!
		Utility\Utility::preventClassOverload();
	}
}
