<?php
/*
 * Class file for the main footer.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Classes\WordPress;


/**
 * Class used for the main footer.
 */
class Footer extends Content {

	// Class constants
	const FIELD_BACKGROUND          = 'footer_bg_lower';
	const FIELD_COLUMN_1            = 'footer_col_1';
	const FIELD_ADDRESS             = 'footer_address';
	const FIELD_PHONE               = 'footer_phone';
	const FIELD_EMAIL               = 'footer_email';
	const FIELD_COLUMN_2            = 'footer_col_2';
	const FIELD_ABOUT               = 'footer_about_text';
	const FIELD_COLUMN_3            = 'footer_col_3';
	const FIELD_CONDITIONS_LINKS    = 'footer_conditions_links';
	const FIELD_COLUMN_4            = 'footer_col_4';
	const FIELD_CATEGORY_LINKS      = 'footer_category_links';
	const FIELD_LINK                = 'link';
	const FIELD_LINK_TITLE          = 'title';

	const CSS_CLASS_SECTION         = 'footer';
	const CSS_CLASS_COLUMN_WRAP     = 'columns';
	const CSS_CLASS_COLUMN          = 'column';
	const CSS_CLASS_HEADING         = 'heading';
	const CSS_CLASS_PAYMENT_METHODS = 'payment-methods';
	const CSS_ID__WISEWBES_LINKS    = 'wiseweb-links';

	const IMAGE_SIZE_NAME           = 'footer_background';
	const IMAGE_SIZE_WIDTH          = 1400;
	const IMAGE_SIZE_HEIGHT         = 600;





	/**
	 * Compile and output section.
	 *
	 * @param      null  $data   The field contents.
	 */
	public static function output( $data = null ) {

		// Classes to set for the section
		$classes = Array(
			self::prefixSection(
				static::CSS_CLASS_SECTION
			),
		);

		// Use the parent class to wrap the contents into a section and echo it out
		echo static::wrapSection(
			// Format the data
			static::content( $data ),
			$classes
		);
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
		$background = get_field( self::FIELD_BACKGROUND, 'option' );
?>
		<img src="<?php echo $background[ 'sizes' ][ self::IMAGE_SIZE_NAME ]; ?>" class="background" alt="" <?php WordPress\Images::getSRCSetAttr( $background[ 'id' ] ); ?>>
		<!-- START: Columns wrapper -->
		<div class="<?php echo self::CSS_CLASS_COLUMN_WRAP; ?>">
			<!-- START: Column 1 -->
			<div class="<?php echo self::CSS_CLASS_COLUMN; ?>">
<?php
				// Get the first column
				$contactCol = get_field( self::FIELD_COLUMN_1, 'option' );
?>
				<h2 class="<?php echo self::CSS_CLASS_HEADING; ?>">Kontakt</h2>

				<div>
					<i class="fa fa-map-marker"></i>
					<p>
<?php
						echo $contactCol[ self::FIELD_ADDRESS ];
?>
					</p>
				</div>

				<div>
					<i class="fa fa-mobile"></i>
					<p>
						<a href="tel:<?php echo str_replace( ' ', '', $contactCol[ self::FIELD_PHONE ] ); ?>">
<?php
							echo $contactCol[ self::FIELD_PHONE ];
?>
						</a>
					</p>
				</div>

				<div>
					<i class="fa fa-envelope-o"></i>
					<p>
						<a href="mailto:<?php echo $contactCol[ self::FIELD_EMAIL ]; ?>">
<?php
							echo $contactCol[ self::FIELD_EMAIL ];
?>
						</a>
					</p>
				</div>
			</div>
			<!-- END: Column 1 -->

			<!-- START: Column 2 -->
			<div class="<?php echo self::CSS_CLASS_COLUMN; ?>">
				<h2 class="heading">Om oss</h2>
<?php
				// Get the second column
				$aboutCol = get_field( self::FIELD_COLUMN_2, 'option' );

				echo $aboutCol[ self::FIELD_ABOUT ];
?>
			</div>
			<!-- END: Column 2 -->

			<!-- START: Column 3 -->
			<div class="<?php echo self::CSS_CLASS_COLUMN; ?>">
				<h2 class="heading">Villkor</h2>
				<ul>
	<?php
					// Get the second column
					$conditionsCol = get_field( self::FIELD_COLUMN_3, 'option' );

					foreach ( $conditionsCol[ self::FIELD_CONDITIONS_LINKS ] as $link ) {
?>
						<li>
							<a href="<?php echo $link[ self::FIELD_LINK ]; ?>">
<?php
								echo $link[ self::FIELD_LINK_TITLE ];
?>
							</a>
						</li>
<?php
					}
?>
				</ul>
			</div>
			<!-- END: Column 3 -->

			<!-- START: Column 4 -->
			<div class="<?php echo self::CSS_CLASS_COLUMN; ?>">
				<h2 class="heading">Kategorier</h2>
				<ul>
<?php
					// List all subpages of shop in the menu
					echo wp_nav_menu(
						Array(
							'parent' => get_option( 'woocommerce_shop_page_id' )
						)
					);
?>
				</ul>
			</div>
			<!-- END: Column 4 -->
		</div>
		<!-- END: Columns wrapper -->

		<!-- START: Created by links -->
		<div id="<?php echo self::CSS_ID__WISEWBES_LINKS; ?>">
			<a href="http://www.wiseweb.se/responsiv-hemsida" title="Hemsidor responsiv" target="_blank">Responsiv hemsida</a><wbr> levererad av <wbr><a href="http://www.wiseweb.se" title="Wiseweb" target="_blank">Wiseweb</a>
		</div>
		<!-- END: Created by links -->
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
