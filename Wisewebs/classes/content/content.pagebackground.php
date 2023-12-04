<?php
/*
 * Page background settings.
 */


// Set the namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Classes\Utility;
Use Wisewebs\Classes\WordPress;


/*
 * The main class for structuring generic content.
 */
class PageBackground extends Content {

	// Class constants
	const FIELD_NAME        = 'page_background';

	const IMAGE_SIZE_NAME   = self::FIELD_NAME;
	const IMAGE_SIZE_WIDTH  = 1920;
	const IMAGE_SIZE_HEIGHT = 1080;

	const CSS_ID_IMAGE      = 'background-image';





	/**
	 * Compile and output section. Overwrites parent class to echo without a
	 * section.
	 *
	 * @param      null  $data   The field contents.
	 */
	public static function output( $data = null ) {

		// Just echo the data
		echo self::content( $data );
	}





	/**
	 * Create the actual section content.
	 *
	 * @param      string  $data   The field contents.
	 *
	 * @return     string  Formatted content.
	 */
	protected static function content( $data = null ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();

		// Get the background
		$background = get_field( self::FIELD_NAME, 'option' );
?>
		<div id="<?php echo self::CSS_ID_IMAGE; ?>">
			<img src="<?php echo $background[ 'sizes' ][ self::IMAGE_SIZE_NAME ]; ?>" alt="" <?php WordPress\Images::getSRCSetAttr( $background[ 'id' ] ); ?>>
		</div>
<?php
		// Get the buffered data and clean it out.
		return ob_get_clean();
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
