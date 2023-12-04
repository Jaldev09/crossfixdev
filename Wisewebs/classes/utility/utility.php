<?php
/*
 * The main utility class. This does nothing by itself but can be utilized in
 * other classes for it's generic utility-functions to avoid duplicate code.
 */


// Set the namespace
Namespace Wisewebs\Classes\Utility;


/*
 * The main class for utility-functions.
 */
class Utility {

	/**
	 * Prevent class overloading for stricter classes.
	 *
	 * Call this from within the magic method __set().
	 */
	public static function preventClassOverload() {

		// Get backtrace info
		$backtrace = debug_backtrace();

		// Get the classname if available
		$class = ( !empty( $backtrace[ 1 ][ 'class' ] ) ? '"' . $backtrace[ 1 ][ 'class' ] . '"' : 'unknown class' );

		// Trigger a user-defined error
		trigger_error(
			'Trying to overload class <strong>' . $class . '</strong> with undefined property <strong>"' . $backtrace[ 1 ][ 'args' ][ 0 ] . '"</strong> in <strong>' . $backtrace[ 1 ][ 'file' ] . '</strong> on line <strong>' . $backtrace[ 1 ][ 'line' ] . '</strong> <br>
			Triggered by <strong>' . __FUNCTION__ . '()</strong> ',
			E_USER_WARNING
		);
	}





	/**
	 * Get the site's URL (We need this as a function instead of as a constant
	 * as this may need a function to be accessible depending on setup).
	 *
	 * @return     string  The site's URL.
	 */
	public static function getSiteURL() {

		// Start by setting $siteURL to an empty string so we can safely return it no matter what
		$siteURL = '';

		// Can we access the WP function to get site url?
		if ( function_exists( 'site_url' ) ) {

			$siteURL = site_url();

		// Nope, you'll have to handle it manually if it gets here
		} else {

		}

		return $siteURL;
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
		self::preventClassOverload( __CLASS__ );
	}
}
