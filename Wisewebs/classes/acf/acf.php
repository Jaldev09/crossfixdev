<?php
/*
 * Generic functionality for Advanced Custom Fields content.
 */


// Set the namespace
Namespace Wisewebs\Classes\ACF;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * The main class for structuring generic content.
 */
class ACF {

	/**
	 * Get the ALT-text for an image as ACF doesn't magically add it.
	 *
	 * @param      Array  $img    The image
	 */
	protected static function altText( $img = Array() ) {

		// Does this image specifically have an alt text?
		if ( !empty( $img[ 'alt' ] ) )
			$altText = $img[ 'alt' ];

		else if ( !empty( $img[ 'original_image' ][ 'alt' ] ) )
			$altText = $img[ 'original_image' ][ 'alt' ];

		// No alts then. Default to empty string as that is more valid than a missing alt attribute.
		else
			$altText = '';

		// Echo the result
		echo 'alt="' . $altText . '"';
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
