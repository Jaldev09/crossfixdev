<?php
/*
 * Utility functions concerning cacheing. Extends the main utility class.
 *
 * DEVELOPER'S NOTE: In the future we should optimize this to only use
 * get_file_contents() ONCE AND ONCE ONLY per request.
 */


// Set the namespace
Namespace Wisewebs\Classes\Utility;


// Import relevant namespaces
Use \Exception;


/*
 * Utility functions concerning cacheing.
 */
class Cache extends Utility {

	const CACHE_BUSTER__FILE_NAME      = 'cache-buster.json';

	const BUILD_FOLDERS_BELOW_WEB_ROOT =  ABSPATH;






	/**
	 * Gets the location of the cache buster file (We need this to be a function
	 * as constants do not accept function return values, which is necessary
	 * with WordPress).
	 *
	 * @return     string  The folder where the the cache buster file is located.
	 */
	public static function getCacheBusterFileLocation() {

		// Start by setting $location to an empty string so we can safely return it no matter what
		$location = '';

		// Can we access the WP function to get stylesheet directory?
		if ( function_exists( 'get_stylesheet_directory' ) ) {

			$location = get_stylesheet_directory() . '/assets/';

		// Nope, you'll have to handle it manually if it gets here
		} else {

		}

		return $location;
	}





	/**
	 * Bust the cache for a specific resource when it has been modified only.
	 *
	 * @param      string     $resource                The resource whose cache
	 *                                                 we need to bust
	 * @param      boolean    $concatHashWithResource  Do we want to concatenate
	 *                                                 the cache hash with
	 *                                                 resource URI so we can
	 *                                                 use it instantly?
	 *
	 * @throws     Exception  Throws an E_USER_NOTICE if no valid file was passed
	 *                        in the arguments
	 *
	 * @return     string     Returns the resource URI with a cache bust hash
	 *                        appended if True, cache bust hash only if False
	 */
	public static function cacheBustResource( $resource = null, $concatHashWithResource = true ) {

		try {

			// Check that we actually have a resource
			if ( empty( $resource ) )
				throw new Exception( 'You need to pass a resource to run ' . __FUNCTION__ . '.' );


			// Replace folders below web root as we don't utilize those when generating the cache buster
			$resource = str_replace(
				static::BUILD_FOLDERS_BELOW_WEB_ROOT,
				'',
				$resource
			);

			// Replace the site's URL as we don't utilize those when generating the cache buster
			$resource = str_replace(
				static::getSiteURL(),
				'',
				$resource
			);

			// Lowercase the string as we (currently) generate lowercase JSON in the cache buster
			$resource = strtolower(
				$resource
			);

			// Instantiate the cache busting string as an empty var so we can interact with it as we please
			$cacheBustString = '';

			// Check that the the file has actually been generated
			if ( file_exists( static::getCacheBusterFileLocation() . static::CACHE_BUSTER__FILE_NAME ) ) {

				// Get the contents
				$json = json_decode( file_get_contents( static::getCacheBusterFileLocation() . static::CACHE_BUSTER__FILE_NAME ) );

				// Loop it
				foreach ( $json as $key => $hash ) {

					// Check for a file match
					if ( substr( $key, -strlen( $resource ) ) === $resource ) {

						// Match! Let's add it to link
						$cacheBustString = 'cachehash_' . $hash;

						// We're done. Let's break the loop.
						break;
					}
				}
			}


			// If the cache buster didn't have that: Can we access the resource?
			if ( empty( $cacheBustString ) && file_exists( $resource ) ) {

				// Get the filemtime from the resource directly
				$cacheBustString = 'filemtime_' . filemtime( $resource );
			}


			// Are we looking for the entire thing or do we just want a hash?
			if ( true == $concatHashWithResource )
				$cacheBustString .= $resource . '?ver=' . $cacheBustString;


			// Return the generated string
			return $cacheBustString;

		// Handle any eventual exceptions
		} catch ( Exception $e ) {

			// Get backtrace info
			$backtrace = debug_backtrace();

			// Trigger a user-defined error
			trigger_error(
				$e->getMessage() . ' Correct usage is: <strong>' . __CLASS__ . '::' . __FUNCTION__ . '( string $resource [,  bool $concatHashWithResource ] );' . '</strong>.<br> Function was called from <strong>' . $backtrace[ 0 ][ 'file' ] . '</strong> on line <strong>' . $backtrace[ 0 ][ 'line' ] . '</strong><br> Exception was triggered ',
				E_USER_NOTICE
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
