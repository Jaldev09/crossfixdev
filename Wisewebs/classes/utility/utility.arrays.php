<?php
/*
 * Utility functions concerning arrays. Extends the main utility class.
 */


// Set the namespace
Namespace Wisewebs\Classes\Utility;


/*
 * Utility functions concerning cacheing.
 */
class Arrays extends Utility
{
	/**
	 * Checks if an array is associative.
	 *
	 * @param      array  $array  The array to check
	 *
	 * @return     bool   True if array is associative, false otherwise
	 *
	 * @see        arrayIsIndexed
	 */
	public static function arrayIsAssociative( array $array ) : bool
	{
		return ! static::arrayIsIndexed( $array );
	}



	/**
	 * Checks if an array is indexed.
	 *
	 * Adapted from:
	 * http://thinkofdev.com/check-if-an-array-is-associative-or-sequentialindexed-in-php/
	 *
	 * @param      array  $array  The array to check
	 *
	 * @return     bool   True if array is indexed, false otherwise
	 */
	public static function arrayIsIndexed( array $array ) : bool
	{
		return ( bool ) (
			array_keys( $array )
			===
			range(
				0,
				count( $array ) - 1
			)
		);
	}



	/**
	 * Utilize the magic function __set to make sure we can't overload this class.
	 *
	 * @param string $name Unused, we only care to receive it for compatibility
	 * @param string $val  Unused, we only care to receive it for compatibility
	 */
	public function __set( $name, $val )
	{
		// Hey, this is overloading! This class doesn't allow that!
		parent::preventClassOverload( __CLASS__ );
	}
}
