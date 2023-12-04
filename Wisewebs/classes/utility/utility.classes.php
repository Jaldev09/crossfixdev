<?php
/*
 * Utility functions concerning classes. Extends the main utility class.
 */


// Set the namespace
Namespace Wisewebs\Classes\Utility;


// Import relevant namespaces
Use \ReflectionClass;


/*
 * Utility functions concerning classes.
 */
class Classes extends Utility {


	public static function getClassConstants( $class ) {

		// Is this a valid class?
		if ( class_exists( $class ) ) {

			// Get a reflection of the given class
			$reflection = new ReflectionClass( $class );

			// Return an array with all constants
			return $reflection->getConstants();

		} else {

			return Array(
				'Class not found' => $class . 'was not found',
			);
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
