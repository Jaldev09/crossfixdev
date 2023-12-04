<?php
/*
 * Class file for welcome text blocks.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


/**
 * Class used for displaying the welcome text blocks.
 */
class WelcomeText extends Content {

	// Class constants
	const FIELD_HEADING       = 'heading';
	const FIELD_SUBHEADING    = 'subheading';
	const FIELD_INGRESS       = 'ingress';
	const FIELD_IMAGE         = 'image';

	const CSS_CLASS_SECTION    = 'welcome-text';
	const CSS_CLASS_HEADING    = 'heading';
	const CSS_CLASS_SUBHEADING = 'sub' . self::CSS_CLASS_HEADING;
	const CSS_CLASS_INGRESS    = 'ingress';
	const CSS_CLASS_BG_IMAGE   = 'background-img';
	const CSS_CLASS_FG_IMAGE   = 'foreground-img';

	// Image sizes
	const IMAGE_SIZE_NAME      = 'welcome_text_image';
	const IMAGE_SIZE_WIDTH     = 335;
	const IMAGE_SIZE_HEIGHT    = 655;






	/**
	 * Create the actual section content.
	 *
	 * @param      string  $data   The field contents.
	 *
	 * @return     string  Formatted content.
	 */
	protected static function content( $data = Array() ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<div class="wrapper">
			<h2 class="<?php echo self::CSS_CLASS_HEADING; ?>">
<?php
				echo $data[ self::FIELD_HEADING ];
?>
			</h2>

			<h3 class="<?php echo self::CSS_CLASS_SUBHEADING; ?>">
<?php
				echo $data[ self::FIELD_SUBHEADING ];
?>
			</h3>

			<div class="<?php echo self::CSS_CLASS_INGRESS; ?>">
<?php
				echo $data[ self::FIELD_INGRESS ];
?>
			</div>

			<img src="<?php echo get_template_directory_uri(); ?>/assets/img/crossfix-logo-grayscale.png" alt="" class="<?php echo self::CSS_CLASS_BG_IMAGE; ?>">

			<img src="<?php echo $data[ self::FIELD_IMAGE ][ 'sizes' ][ self::IMAGE_SIZE_NAME ]; ?>" alt="" class="<?php echo self::CSS_CLASS_FG_IMAGE; ?>">
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
