<?php
/*
 * PartStream related code.
 */


// Set the namespace
Namespace Wisewebs\Classes\PartStream;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * Class for PartStream related code.
 */
class PartStream {

	// Class constants
	const APP_KEY                    = 'SZXHemMIy3Jq0PLojtEU';
	const SHORTCODE_NAME__SCRIPT_TAG = 'partstream';





	/**
	 * The base script tag.
	 */
	public static function scriptTag() {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<script type="text/javascript" id="aripartstream" src="//services.arinet.com/PartStream/?appKey=<?php echo static::APP_KEY; ?>"></script>
<?php
		// Get the buffered data and clean it out.
		return ob_get_clean();
	}





	/**
	 * Register the shortcodes we can use with this class.
	 */
	public static function registerShortcodes() {

		// Script tag
		add_shortcode(
			static::SHORTCODE_NAME__SCRIPT_TAG,
			'Wisewebs\\Classes\\PartStream\\PartStream::scriptTag'
		);
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
