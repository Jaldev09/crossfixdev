<?php
/*
 * Class file for logotype lists.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Classes\WordPress;


/**
 * Class used for displaying logotype lists.
 */
class LogotypeList extends Content {

	// Class constants
	const FIELD_NAME           = 'logotype_list';
	const FIELD_IMAGE          = 'image';
	const FIELD_NAME__LINK     = 'link';

	const CSS_CLASS_SECTION    = 'logotype-list';
	const CSS_CLASS_COLUMN     = 'logotype-item';

	// Image sizes
	const IMAGE_SIZE_NAME      = 'logotype_list';
	const IMAGE_SIZE_WIDTH     = 320;
	const IMAGE_SIZE_HEIGHT    = 225;






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

		// Loop logotypes
		foreach ( $data as $logo ) {

			// Do we have somewhere to link this to? Then wrap it in a link.
			if ( !empty( $logo[ self::FIELD_NAME__LINK ] ) ) {
?>
				<a href="<?php echo $logo[ self::FIELD_NAME__LINK ]; ?>"  class="<?php echo self::CSS_CLASS_COLUMN; ?>" target="_blank">
<?php
					echo self::formatImg( $logo );
?>
				</a>
<?php
			// Nowhere. Wrap it in a div instead.
			} else {
?>
				<div class="<?php echo self::CSS_CLASS_COLUMN; ?>">
<?php
					echo self::formatImg( $logo );
?>
				</div>
<?php
			}
		}

		// Get the buffered data and clean it out.
		return ob_get_clean();
	}






	/**
	 * Format up the image for the logotype.
	 *
	 * @param      Array  $logo   The data for the logotype
	 *
	 * @return     string  Image data formatted as HTML
	 */
	protected static function formatImg( $logo = Array() ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<img src="<?php echo $logo[ self::FIELD_IMAGE ][ 'url' ]; ?>" alt="" <?php WordPress\Images::getSRCSetAttr( $logo[ static::FIELD_IMAGE ][ 'id' ] ); ?>>
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
