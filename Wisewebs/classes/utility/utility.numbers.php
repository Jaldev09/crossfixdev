<?php
/*
 * Utility functions concerning numbers/numeric values. Extends the main utility class.
 */


// Set the namespace
Namespace Wisewebs\Classes\Utility;


/*
 * Utility functions concerning numbers/numeric values.
 */
class Numbers extends Utility {

	const DECIMAL_MARK = '.';





	/**
	 * Convert/format a number as an integer.
	 *
	 * NOTE: This utilizes call_user_func(), so never run this with user input
	 * as that may present a security risk.
	 *
	 * @param      integer   $number    Number to format
	 * @param      function  $rounding  Function to use for rounding the value
	 *
	 * @return     integer   Integer value of the provided number
	 */
	public static function integer( $number = 0, $rounding = null ) {

		// Format the number so we won't get bad results
		$number = static::setStandardFormatting( $number );

		// If a rounding function was passed and that function exists
		if ( function_exists( $rounding ) )
			$number = call_user_func( $rounding, $number );

		// Return the integer value, just to be on the safe side
		return intval( $number );
	}





	/**
	 * Sets the standard formatting for numbers so we can process them without
	 * losing data. Remember to process the number afterwards as it returns
	 * string to allow for converting to both float and integer etc.
	 *
	 * @param      integer/string  $number  Number to format
	 *
	 * @return     string          Formatted number
	 */
	public static function setStandardFormatting( $number = 0 ) {

		// Start by removing all types of whitespace (digit grouping)
		$number = preg_replace(
			'/[\s]/',
			'',
			$number
		);

		// Remove all commas and dots but the last match (more digit grouping)
		$number = preg_replace(
			'/[\.,](?=.*[\.,])/',
			'',
			$number
		);

		// Not a digit, comma, or dot? Remove it!
		$number = preg_replace(
			'/[^\.,\d]/',
			'',
			$number
		);

		// Replace the remaining comma or dot, if there is one, with what we've defined as decimal mark
		$number = str_replace(
			Array(
				',',
				'.',
			),
			Array(
				static::DECIMAL_MARK,
				static::DECIMAL_MARK,
			),
			$number
		);

		// Is the last comma or dot not followed by a digit? Then remove it.
		$number = preg_replace(
			'/[\.,](?!\d)/',
			'',
			$number
		);

		// Return processed value
		return $number;
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
