<?php
/*
 * Class file for cards.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Interfaces;
Use Wisewebs\Classes\Utility;
Use Wisewebs\Classes\WordPress;


/**
 * Class used for displaying cards.
 */
class Cards extends Content implements Interfaces\JS\JS {

	// The main layout name
	const FIELD_NAME                         = 'cards';

	// Field names
	const FIELD_FORM                         = 'form';
	const FIELD_IMAGE                        = 'image';
	const FIELD_HEADING                      = 'heading';
	const FIELD_SUBHEADING                   = 'subheading';
	const FIELD_INGRESS                      = 'ingress';
	const FIELD_POPUP_OR_LINK                = 'popup_or_page_link';
	const FIELD_LINK                         = 'link';
	const FIELD_PRODUCT_CATEGORY_LINK        = 'cat_link';
	const FIELD_LINK_TEXT                    = 'link_text';

	// Field values (from fields with presets)
	const FIELD_VALUE__POPUP_OR_LINK__POPUP  = 'popup';
	const FIELD_VALUE__POPUP_OR_LINK__LINK   = 'page_link';
	const FIELD_VALUE__PRODUCT_CATEGORY_LINK = 'product_category_link';
	const FIELD_VALUE__POPUP__TECH_ADVISE    = 'tech_advise';
	const FIELD_VALUE__POPUP__BOOK_SERVICE   = 'book_service';

	// CSS classes & IDs
	const CSS_CLASS_SECTION                  = self::FIELD_NAME;
	const CSS_CLASS_CARD                     = 'card';
	const CSS_CLASS_POPUP_CARD               = 'popup-form--old';
	const CSS_CLASS_POPUP_ACTIVE             = 'active';
	const CSS_CLASS_TEXT_WRAP                = 'text';
	const CSS_CLASS_HEADING                  = 'heading';
	const CSS_CLASS_SUBHEADING               = 'sub' . self::CSS_CLASS_HEADING;
	const CSS_CLASS_INGRESS                  = 'ingress';
	const CSS_CLASS__POPUP_WRAP              = 'popup-wrap';
	const CSS_CLASS__POPUP_CLOSE             = 'popup-close';
	const CSS_CLASS__POPUP_OVERLAY           = 'popup-overlay';
	const CSS_CLASS__POPUP_FORM_WRAP         = 'popup-form-wrap';
	const CSS_CLASS__POPUP_FORM_HEADING      = 'heading';

	const CSS_ID__BOOK_SERVICE_POPUP         = 'book-service-popup';
	const CSS_ID__TECH_ADVISE_POPUP          = 'tech-advise-popup';

	// Image sizes
	const IMAGE_SIZE_NAME                    = self::FIELD_NAME;
	const IMAGE_SIZE_WIDTH                   = 300;
	const IMAGE_SIZE_HEIGHT                  = 300;





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

		// Loop cards
		foreach ( $data as $card )
		{
			// Popup style card
			if ( static::FIELD_VALUE__POPUP_OR_LINK__POPUP === $card[ static::FIELD_POPUP_OR_LINK ] )
			{
				// Create a new array for matches (superfluous but helps code readability)
				$matches =
				[
				];

				// Search for an ID
				preg_match(
					'/.+[\s]+id="([\d]+)".+/',
					$card[ static::FIELD_FORM ],
					$matches
				);

				// If we found an ID
				if ( ! empty( $matches[ 1 ] ) )
				{
?>
					<button
						class="<?php echo static::CSS_CLASS_CARD; ?> <?php echo static::CSS_CLASS_POPUP_CARD; ?>"
						data-form-id="<?php echo $matches[ 1 ]; ?>"
					>
<?php
					// If we don't yet have an array for forms to load as popups
					if ( empty( $GLOBALS[ 'popup-forms' ] ) )
					{
						// Create an array for that
						$GLOBALS[ 'popup-forms' ] =
						[
						];
					}

					// If we don't have it already
					if ( ! in_array( $matches[ 1 ], $GLOBALS[ 'popup-forms' ] ) )
					{
						// Add it
						$GLOBALS[ 'popup-forms' ][] = $matches[ 1 ];
					}
				}
			}
			// Link style card
			else if
			(
				static::FIELD_VALUE__POPUP_OR_LINK__LINK === $card[ static::FIELD_POPUP_OR_LINK ]
				||
				static::FIELD_VALUE__PRODUCT_CATEGORY_LINK === $card[ static::FIELD_POPUP_OR_LINK ]
			)
			{

				$link =
				(
					static::FIELD_VALUE__POPUP_OR_LINK__LINK === $card[ static::FIELD_POPUP_OR_LINK ]
					? $card[ static::FIELD_LINK ]
					: '/reservdelar/'
				);
?>
				<a
				 href="<?php echo $link; ?>"
				 class="<?php echo static::CSS_CLASS_CARD; ?>">
<?php
			}
?>
				<div class="<?php echo static::CSS_CLASS_TEXT_WRAP ?>">
					<h2 class="<?php echo static::CSS_CLASS_HEADING; ?>">
<?php
						echo $card[ static::FIELD_HEADING ];
?>
					</h2>

					<h3 class="<?php echo static::CSS_CLASS_SUBHEADING; ?>">
<?php
						echo $card[ static::FIELD_SUBHEADING ];
?>
					</h3>

					<div class="<?php echo static::CSS_CLASS_INGRESS; ?>">
<?php
						echo $card[ static::FIELD_INGRESS ];
?>
					</div>

					<div class="link">
<?php
						echo $card[ static::FIELD_LINK_TEXT ];
?>
					</div>
				</div>

				<img src="<?php echo $card[ static::FIELD_IMAGE ][ 'sizes' ][ 'slideshow' ]; ?>" alt="" <?php WordPress\Images::getSRCSetAttr( $card[ static::FIELD_IMAGE ][ 'id' ] ); ?>>
<?php
			// Popup style card
			if ( static::FIELD_VALUE__POPUP_OR_LINK__POPUP === $card[ static::FIELD_POPUP_OR_LINK ] )
			{
?>
				</button>
<?php
			// Link style card
			}
			else if
			(
				static::FIELD_VALUE__POPUP_OR_LINK__LINK === $card[ static::FIELD_POPUP_OR_LINK ]
				||
				static::FIELD_VALUE__PRODUCT_CATEGORY_LINK === $card[ static::FIELD_POPUP_OR_LINK ]
			)
			{
?>
				</a>
<?php
			}
		}

		// Get the buffered data and clean it out.
		return ob_get_clean();
	}





	/**
	 * Content that should go explicitly in the footer.
	 */
	public static function footerContent()
	{
		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<div id="<?php echo static::CSS_ID__BOOK_SERVICE_POPUP; ?>" class="<?php echo static::CSS_CLASS__POPUP_WRAP; ?>">
			<div class="<?php echo static::CSS_CLASS__POPUP_OVERLAY; ?>">
			</div>
			<div class="<?php echo static::CSS_CLASS__POPUP_FORM_WRAP; ?>">

				<div class="scroll-wrap">
					<h2 class="<?php echo static::CSS_CLASS__POPUP_FORM_HEADING; ?>">Boka <span>service</span></h2>
<?php
					echo do_shortcode( '[contact-form-7 id="286" title="Boka service"]' );
?>
				</div>
				<button type="button" class="<?php echo static::CSS_CLASS__POPUP_CLOSE; ?>">
					<i class="fa fa-close"></i>
				</button>
			</div>
		</div>

		<div id="<?php echo static::CSS_ID__TECH_ADVISE_POPUP; ?>" class="<?php echo static::CSS_CLASS__POPUP_WRAP; ?>">
			<div class="<?php echo static::CSS_CLASS__POPUP_OVERLAY; ?>">
			</div>
			<div class="<?php echo static::CSS_CLASS__POPUP_FORM_WRAP; ?>">

				<div class="scroll-wrap">
					<h2 class="<?php echo static::CSS_CLASS__POPUP_FORM_HEADING; ?>">Teknisk <span>rådgivning</span></h2>
<?php
					echo do_shortcode( '[contact-form-7 id="287" title="Teknisk rådgivning"]' );
?>
				</div>
				<button type="button" class="<?php echo static::CSS_CLASS__POPUP_CLOSE; ?>">
					<i class="fa fa-close"></i>
				</button>
			</div>
		</div>
<?php
		// Get the buffered data and clean it out.
		echo ob_get_clean();
	}





	/**
	 * Set up and inject the necessary JS structure.
	 */
	public static function injectJsVariables() {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();

		// Get the class constants and JSON encode so the JS can receive it
		$constants = json_encode(
			Utility\Classes::getClassConstants(
				__CLASS__
			)
		);
?>
		<script type="text/javascript">

			Wisewebs.phpVariables.Content.cards = <?php echo $constants; ?>;

		</script>
<?php
		// Get the buffered data and clean it out.
		echo ob_get_clean();

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
