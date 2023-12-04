<?php
/*
 * Class file for the main header.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Classes\WordPress;


/**
 * Class used for the main header.
 */
class Header extends Content {

	// Class constants
	const FIELD_NAME            = 'logo';

	const CSS_CLASS_SECTION     = 'header-logo';

	const IMAGE_SIZE_MIN_NAME   = 'site_logo_min_dimensions';
	const IMAGE_SIZE_MIN_WIDTH  = 50;
	const IMAGE_SIZE_MIN_HEIGHT = 50;
	const IMAGE_SIZE_MAX_NAME   = 'site_logo_print_dimensions';
	const IMAGE_SIZE_MAX_WIDTH  = 150;
	const IMAGE_SIZE_MAX_HEIGHT = 120;





	/**
	 * Compile and output section.
	 *
	 * @param      null  $data   The field contents.
	 */
	public static function output( $data = null ) {

		// No wrapper necessary, just push it as is
		echo static::content( $data );
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
?>
		<!-- START: Site logo -->
		<div class="<?php echo self::CSS_CLASS_SECTION; ?>">
			<a href="<?php echo home_url(); ?>">
<?php
				yolo_get_template( 'header/logo' );
?>
			</a>
		</div>
		<!-- END: Site logo -->
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
