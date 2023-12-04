<?php
/*
 * Functionality related to Wordpress images and image sizes.
 */


// Set the namespace
Namespace Wisewebs\Classes\WordPress;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * The main class for Wordpress images and image sizes.
 */
class Images extends WordPress {

	// Class constants
	const SETTING__MAX_SCRSET_WIDTH = 2000;

	const SETTING__DEFAULT_IMG_SIZE = 'full';



	/**
	 * Gets the SRC attribute for an image.
	 */
	public static function getSRCAttr( $imageID, $size = self::SETTING__DEFAULT_IMG_SIZE, $echo = true )
	{
		ob_start();

		// Get SRCs from WP
		$SRCs = wp_get_attachment_image_src( $imageID, 'full' );

		if ( ! empty( $SRCs[ 0 ] ) )
		{
?>
		 src="<?php echo $SRCs[ 0 ]; ?>"
<?php
		}

		// Get the buffered data and clean it out.
		if ( true === $echo )
		{
			echo ob_get_clean();
		}
		else
		{
			return ob_get_clean();
		}
	}



	/**
	 * 
	 */
	public static function getSRCSetAttr( $imageID, $size = self::SETTING__DEFAULT_IMG_SIZE, $echo = true ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();

		if ( function_exists( 'wp_get_attachment_image_srcset' ) )
		{
?>
			 srcset="<?php echo wp_get_attachment_image_srcset( $imageID, $size ); ?>"
<?php
		}

		// Get the buffered data and clean it out.
		if ( true === $echo )
		{
			echo ob_get_clean();
		}
		else
		{
			return ob_get_clean();
		}
	}



	/**
	 * 
	 */
	public static function getSizesAttr( $imageID, $size = self::SETTING__DEFAULT_IMG_SIZE, $echo = true ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();

		if ( function_exists( 'wp_get_attachment_image_sizes' ) )
		{
?>
			 sizes="<?php echo wp_get_attachment_image_sizes( $imageID ); ?>"
<?php
		}

		// Get the buffered data and clean it out.
		if ( true === $echo )
		{
			echo ob_get_clean();
		}
		else
		{
			return ob_get_clean();
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
	public function __set( $name, $val )
	{
		// Hey, this is overloading! This class doesn't allow that!
		Utility\Utility::preventClassOverload();
	}
}
