<?php
/*
 * Class file for hero images.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


/**
 * Class used for displaying hero images.
 */
class HeroImage extends Content {

	// Class constants
	const FIELD_HEADING       = 'heading';
	const FIELD_IMAGE         = 'hero_image';

	// Image sizes
	const IMAGE_SIZE_NAME      = self::FIELD_IMAGE;
	const IMAGE_SIZE_WIDTH     = 1400;
	const IMAGE_SIZE_HEIGHT    = 230;

	// CSS classes
	const CSS_CLASS_SECTION    = 'hero-image';






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

		// We're receiving args as an array, so to have nested defaults we need to define them like this and merge the two arrays
		$defaults = Array(
			self::FIELD_IMAGE => Array(
				'sizes' => Array(
					self::IMAGE_SIZE_NAME => '',
				),
			),
			self::FIELD_HEADING => '',
		);

		// Combine args and defaults to make sure all variables are defined
		$data = array_replace_recursive( $defaults, $data );
?>
		<div class="yolo-page-title-section page-title-margin">
			<section class="yolo-page-title-wrap page-title-height page-title-wrap-bg page-title-center" style="background-image: url(<?php echo $data[ self::FIELD_IMAGE ][ 'sizes' ][ self::IMAGE_SIZE_NAME ]; ?>);">
				<div class="yolo-page-title-overlay"></div>
				<div class="container">
					<div class="page-title-inner block-center">
						<div class="block-center-inner">
							<h1><?php echo $data[ self::FIELD_HEADING ]; ?></h1>
						</div>
					</div>
				</div>
			</section>
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
