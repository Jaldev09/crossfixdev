<?php
/*
 * Utility functions concerning strings. Extends the main utility class.
 */


// Set the namespace
Namespace Wisewebs\Classes\Utility;
use Wisewebs\Classes\Utility\Arrays;


/*
 * Utility functions concerning strings.
 */
class Strings extends Utility
{
	/**
	 * Class constants.
	 */
	const ENCODING = 'utf-8';



	/**
	 * Creates an anonymous helper function to create BEM classes.
	 *
	 * @param string $BEMBase Base selector for the module.
	 * @param bool   $echo    Whether to also echo the values (to keep code shorter when using the function).
	 *
	 * @return callable Anonymous function to generate the classes.
	 */
	public static function BEMHelper( string $BEMBase, bool $echo = true ) : callable
	{
		// Return a new anonymous function
		return function( string $element = '', $modifiers = [], $extras = [] ) use ( $BEMBase, $echo )
		{
			// Always use BEM base
			$BEMElement = $BEMBase;

			// If element isn't an empty string (i.e. actually a sub-element)
			if ( '' !== $element )
			{
				$BEMElement .= '__' . $element;
			}

			// Instantiate an array to hold our class names
			$classnameArray =
			[
				$BEMElement,
			];

			// If modifiers is string
			if ( is_string( $modifiers ) )
			{
				$classnameArray[] = $BEMElement . '--' . $modifiers;
			}
			// If we got multiple modifiers
			else if ( is_array( $modifiers ) )
			{
				// Is it assosciative?
				if ( Arrays::arrayIsAssociative( $modifiers ) )
				{
					// Loop modifiers
					foreach ( $modifiers as $modifier => $condition )
					{
						// Check if their condition matches
						if ( true === $condition )
						{
							$classnameArray[] = $BEMElement . '--' . $modifier;
						}
					}
				}
				else
				{
					// Loop modifiers
					foreach ( $modifiers as $modifier )
					{
						$classnameArray[] = $BEMElement . '--' . $modifier;
					}
				}
			}

			// If extras is string
			if ( is_string( $extras ) )
			{
				$classnameArray[] = $extras;
			}
			// If we got multiple extras
			else if ( is_array( $extras ) )
			{
				// Loop extras
				foreach ( $extras as $extra )
				{
					$classnameArray[] = $extra;
				}
			}

			// Run it through classnames
			return \Wisewebs\Classes\Utility\Strings::classnames( $classnameArray, $echo );
		};
	}



	/**
	 * Super-basic imitation of the NPM package with the same name.
	 *
	 * @param array $classnameArray Array of values to turn into classnames.
	 * @param bool  $echo           Whether to also echo the values (to keep code shorter when using the function).
	 *
	 * @return string String ready to use in class attribute.
	 */
	public static function classnames( array $classnameArray = [], bool $echo = true ) : string
	{
		// Only keep unique value
		$uniqueClassnameArray = array_unique( $classnameArray );

		// Implode array adding a space between each
		$classnameString = implode(
			' ',
			$uniqueClassnameArray
		);

		// Do we want to echo it directly?
		if ( true === $echo )
		{
			echo $classnameString;
		}

		// Always return to honor type declaration
		return $classnameString;
	}



	/**
	 * Check whether a given string starts with another string. Adapted from:
	 * http://stackoverflow.com/a/2790919
	 *
	 * @param      string   $haystack  Full string
	 * @param      string   $needle    What we want to know if it starts with
	 *
	 * @return     boolean  True if it does start with that with, False otherwise.
	 */
	public static function startsWith( $haystack = '', $needle = '' ) {

		return mb_substr(
				$haystack,
				0,
				mb_strlen(
					$needle,
					static::ENCODING
				),
				static::ENCODING
			) === $needle;
	}





	/**
	 * Check whether a given string ends with another string. Adapted from a
	 * comment on: http://stackoverflow.com/a/834355
	 *
	 * @param      string   $haystack  Full string
	 * @param      string   $needle    What we want to know if it ends with
	 *
	 * @return     boolean  True if it does end with that with, False otherwise.
	 */
	public static function endsWith( $haystack = '', $needle = '' ) {

		// How long is the full string?
		$haystackLength = mb_strlen(
			$haystack,
			static::ENCODING
		);

		// How long is the substring?
		$needleLength = mb_strlen(
			$needle,
			static::ENCODING
		);

		// What is the last part that's as long as the substring?
		$match = mb_substr(
			$haystack,
			( $haystackLength - $needleLength ),
			$haystackLength,
			static::ENCODING
		);

		// Are the last characters the same as the substring?
		return $match === $needle;
	}





	/**
	 * Convert a string to camelcase.
	 *
	 * @param      string   $string                    String to convert
	 * @param      boolean  $capitalizeFirstCharacter  Do we want to capitalize
	 *                                                 the first character?
	 *
	 * @return     string   Camelcased string
	 */
	public static function convertToCamelcase( $string = '', $capitalizeFirstCharacter = false ) {

		// Replace all whitespaces, dashes, and underscores with a single space
		$string = preg_replace(
			'/[\s-_]/',
			' ',
			$string
		);

		// Make all the words uppercase
		$string = ucwords(
			$string
		);

		// Now remove the spaces (As we needn't treat things like words now that they're capitalized)
		$string = str_replace(
			' ',
			'',
			$string
		);

		// Do we want the first character lowercase? And IS there in fact a first character?
		if ( $capitalizeFirstCharacter !== true && !empty( $string[ 0 ] ) )
			$string[ 0 ] = strtolower( $string[ 0 ] );

		// Return processed string
		return $string;
	}





	/**
	 * Makes phone numbers nice and readable. Use for display, not for
	 * functionality.
	 *
	 * @param      string   $number    Phone number to process
	 * @param      integer  $startPos  Where to start off with a dash (In case
	 *                                 we add support for +46 later)
	 *
	 * @return     string   Processed number
	 */
	public static function niceFormatPhoneNumber( $number = '', $startPos = 3 ) {

		// Insert a dash after 070
		$number = substr_replace(
			$number,
			'-',
			$startPos,
			0
		);

		// Insert a space 3 letters later (Compensating for the things we've added up until now)
		$number = substr_replace(
			$number,
			' ',
			( $startPos + 4 ),
			0
		);

		// Insert a space 2 letters later (Compensating for the things we've added up until now)
		$number = substr_replace(
			$number,
			' ',
			( $startPos + 7 ),
			0
		);

		// Return processed number
		return $number;
	}





	/**
	 * Remove all unnecessary whitespace. Single spaces are not considered unnecessary and are kept.
	 *
	 * @param      string  $text   The text to filter
	 *
	 * @return     string  Text with unnecessary whitespace removed
	 */
	public static function removeWhitespace( $text = '' ) {

		// Define what kind of things we want to remove
		$remove = array(
			"\n",
			"\r",
			"\t",
		);

		// Remove the things we defined
		$text = str_replace(
			$remove,
			"",
			$text
		);

		// If there are repeated spaces or other whitespace characters, replace them with a single space
		$text = mb_ereg_replace(
			"\s+",
			" ",
			$text
		);

		// Return processed value
		return $text;
	}





	/**
	 * Prefix a certain name with it's relevant namespace.
	 *
	 * @param      string  $name       The name
	 * @param      string  $namespace  The namespace
	 *
	 * @return     string  Name with namespace prepended
	 */
	public static function prefixWithNamespace( $name = '', $namespace = '' ) {

		// Prepend a backslash if we're in a namespace
		if ( !empty( $namespace ) )
			$name = '\\\\' . $name;

		// Make sure all backslashes are doubled
		$namespace = str_replace( '\\', '\\\\', $namespace );

		// Return the name prepended with the namespace
		return $namespace . $name;
	}






	/**
	 * Converts a given namespace to its equivalent path.
	 *
	 * @param      string   $namespace        The namespace to convert
	 * @param      boolean  $addLeadingSlash  Do we want to add a leading slash?
	 *
	 * @return     string   Namespace as path
	 */
	public static function convertNamespaceToPath( $namespace = '', $addLeadingSlash = true ) {

		// Replace backslashes
		$namespace = str_replace(
			"\\",
			"/",
			$namespace
		);

		// Replace double backslashes in case we've been passing it as string before this function
		$namespace = str_replace(
			"\\\\",
			"/",
			$namespace
		);


		// Add a leading slash if we want one and we don't already have one
		if ( true === $addLeadingSlash && ! static::startsWith( $namespace, "/" ) )
			$namespace = "/" . $namespace;


		// Return the processed namespace
		return $namespace;
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
