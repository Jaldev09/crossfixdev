<?php
/*
 * Handling of third party tracking scripts.
 */


// Set the namespace
Namespace Wisewebs\Classes\Tracking;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * The main class for handling third party tracking scripts.
 */
class Tracking {

	/**
	 * Check whether to include tracking scripts or not.
	 *
	 * @return     boolean  True if we're in production, false if we're in development.
	 */
	public static function includeTracking() {

		return true;
	}





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
