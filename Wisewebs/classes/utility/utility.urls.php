<?php
/*
 * Utility functions concerning URLs.
 */


// Set namespace
Namespace Wisewebs\Classes\Utility;


/*
 * Utility functions concerning URLs.
 */
class URLs extends Utility {



	/**
	 * Get the URL to the frontpage/homepage of the site.
	 *
	 * @return     string  URL to the homepage
	 */
	public static function homeURL() {

		// Can we access WordPress' home_url()-function?
		if ( function_exists( 'home_url' ) ) {

			return home_url();

		// Nope, not using WordPress. You'll have to define you own!
		} else {

		}
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
		parent::preventClassOverload( __CLASS__ );
	}
}
