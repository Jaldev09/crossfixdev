<?php


// Set the namespace
Namespace Wisewebs\Classes\Content;
// Import relevant namespaces
Use Wisewebs\Theme\Functions;



/**
 * Class used when no ACF layout could be found.
 */
class GoogleMap extends Content {

	// The main layout name
	const FIELD_NAME              = 'google_map';

	// Field names
	const FIELD_NAME__GOOGLE_MAP  = self::FIELD_NAME;
	const FIELD_NAME__INFO_COLUMN = self::FIELD_NAME . '_info_column';

	// CSS classes
	const CSS_CLASS_SECTION       = 'google-map';
	const CSS_CLASS__INFO_WRAP    = self::CSS_CLASS__INFO . '-wrap';
	const CSS_CLASS__INFO         = 'info';

	// Settings
	const SETTING__LANGUAGE       = 'sv';
	const SETTING__REGION         = 'SE';
	const SETTING__API_KEY        = 'AIzaSyAkGGGgSrmdHLXz3Jh6N678tiMscI78SR0';

	const DEFAULT_ADDRESS         = 'Piteå, Sweden';





	/**
	 * Create the actual section content.
	 *
	 * @param      -----
	 *
	 * @return     string  Formatted content.
	 */
	protected static function content( $data = Array() ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<div
			 class="map map-render"
			 data-address="<?php echo ( !empty( $data[ self::FIELD_NAME__GOOGLE_MAP ][ 'address' ] ) ? $data[ self::FIELD_NAME__GOOGLE_MAP ][ 'address' ] : self::DEFAULT_ADDRESS ); ?>"
			 data-latitude="<?php echo $data[ self::FIELD_NAME__GOOGLE_MAP ][ 'lat' ]; ?>"
			 data-longitude="<?php echo $data[ self::FIELD_NAME__GOOGLE_MAP ][ 'lng' ]; ?>"
		></div>

		<div class="<?php echo self::CSS_CLASS__INFO_WRAP; ?>">
			<div class="<?php echo self::CSS_CLASS__INFO; ?>">
<?php
				if ( !empty( $data[ self::FIELD_NAME__INFO_COLUMN ] ) )
					echo $data[ self::FIELD_NAME__INFO_COLUMN ];
?>
			</div>
		</div>
<?php
		// Get the buffered data and clean it out.
		return ob_get_clean();
	}





	/**
	 * Updates the ACF settings with the Google Maps API key specified in the Google
	 * Maps flexible content class.
	 */
	public static function addAPIKeyToACF() {

		// Make sure the function we need to load this exists
		if ( function_exists( 'acf_update_setting' ) )
			acf_update_setting( 'google_api_key', self::SETTING__API_KEY );
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


