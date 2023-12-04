<?php
/*
 * Class file for slideshows.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Classes\WordPress;


/**
 * Class used for displaying slideshows.
 */
class Slideshow extends Content {

	// The main layout name
	const FIELD_NAME                   = 'slideshow';

	// Field names
	const FIELD_IMAGE                  = 'image';
	const FIELD_HEADING                = 'heading';
	const FIELD_SUBHEADING             = 'subheading';
	const FIELD__IS_LINK               = 'link_to_page';
	const FIELD__LINK                  = 'page_link';
	const FIELD__PRODUCT_CATEGORY_LINK = 'cat_link';
	const FIELD__NO_LINK               = 'nothing';

	// CSS classes
	const CSS_CLASS_SECTION            = self::FIELD_NAME;
	const CSS_CLASS_SLIDESHOW          = self::FIELD_NAME;
	const CSS_CLASS_SLIDE              = 'slide';
	const CSS_CLASS_IMAGE_HOLDER       = self::FIELD_NAME . '-image-holder';
	const CSS_CLASS_TEXT_WRAP          = 'text-wrap';
	const CSS_CLASS_ICONS              = 'icons';
	const CSS_CLASS_HEADING            = self::FIELD_HEADING;
	const CSS_CLASS_SUBHEADING         = self::FIELD_SUBHEADING;
	const CSS_CLASS_PAGER_BUTTONS      = 'pager-button';
	const CSS_CLASS_PAGER_BUTTON_NEXT  = 'next';
	const CSS_CLASS_PAGER_BUTTON_PREV  = 'prev';

	// Image sizes
	const IMAGE_SIZE_NAME              = self::FIELD_NAME;
	const IMAGE_SIZE_WIDTH             = 1400;
	const IMAGE_SIZE_HEIGHT            = 700;





	/**
	 * Compile and output section. As we expect to receive an array we define a
	 * function in this class calling parent instead of utilising direct
	 * inheritance.
	 *
	 * @param      array  $data   The field contents.
	 */
	public static function output( $data = Array() ) {

		// Classes to set for the slideshow
		parent::output( $data );
	}





	/**
	 * Create the actual section content.
	 *
	 * @param      array   $data   The field contents.
	 *
	 * @return     string  Formatted content.
	 */
	protected static function content( $data = Array() ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<!-- START: Slideshow -->
		<div class="<?php echo static::CSS_CLASS_SLIDESHOW; ?>">
<?php
			// Loop slideshow slides
			foreach ( $data as $slide ) {

				if ( static::FIELD__NO_LINK !== $slide[ static::FIELD__IS_LINK ] ) {

					$link = (
						static::FIELD__LINK === $slide[ static::FIELD__IS_LINK ]
							? $slide[ static::FIELD__LINK ]
							: get_category_link(
								$slide[ static::FIELD__PRODUCT_CATEGORY_LINK ]->term_id
							)
					);
?>
					<!-- START: Slide -->
					<a class="<?php echo static::CSS_CLASS_SLIDE; ?>" href="<?php echo $link; ?>">
<?php
				} else {
?>
					<!-- START: Slide -->
					<div class="<?php echo static::CSS_CLASS_SLIDE; ?>">
<?php
				}
?>

					<img src="<?php echo $slide[ static::FIELD_IMAGE ][ 'sizes' ][ static::IMAGE_SIZE_NAME ]; ?>" class="<?php echo static::CSS_CLASS_IMAGE_HOLDER; ?>" <?php WordPress\Images::getSRCSetAttr( $slide[ static::FIELD_IMAGE ][ 'id' ] ); ?>>

					<div class="<?php echo static::CSS_CLASS_TEXT_WRAP; ?>">

						<div class="<?php echo static::CSS_CLASS_ICONS; ?>">
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						</div>

						<h2 class="<?php echo static::CSS_CLASS_HEADING; ?>"><?php echo $slide[ static::FIELD_HEADING ]; ?></h2>

						<h3 class="<?php echo static::CSS_CLASS_SUBHEADING; ?>"><?php
							// Check if there's a subheading and echo that
							if ( !empty( $slide[ static::FIELD_SUBHEADING ] ) )
								echo $slide[ static::FIELD_SUBHEADING ];
						?></h3>

					</div>
<?php
				if ( static::FIELD__NO_LINK !== $slide[ static::FIELD__IS_LINK ] ) {
?>
					</a>
					<!-- END: Slide -->
<?php
				} else {
?>
					</div>
					<!-- END: Slide -->
<?php
				}
			}

			// If there's more than one image then we need next/previous buttons
			if ( count( $data ) > 1 ) {
?>
				<button type="button" class="<?php echo static::CSS_CLASS_PAGER_BUTTONS; ?> <?php echo static::CSS_CLASS_PAGER_BUTTON_PREV; ?>">
					<i class="fa fa-angle-left fa-fw"></i>
				</button>

				<button type="button" class="<?php echo static::CSS_CLASS_PAGER_BUTTONS; ?> <?php echo static::CSS_CLASS_PAGER_BUTTON_NEXT; ?>">
					<i class="fa fa-angle-right fa-fw"></i>
				</button>
<?php
			}
?>
		</div>
		<!-- END: Slideshow -->
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
