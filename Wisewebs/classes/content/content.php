<?php
/*
 * Generic functionality for structuring content.
 */


// Set the namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Interfaces;
Use Wisewebs\Classes\Utility;


/*
 * The main class for structuring generic content.
 */
class Content implements Interfaces\JS\JS {

	// Class constants
	const CSS_SELECTOR_SECTION_PREFIX   = 's-';
	const CSS_SELECTOR_SECTION_SELECTOR = '.';

	const CSS_SELECTOR_WRAPPER_PREFIX   = 'w-';
	const CSS_SELECTOR_WRAPPER_SELECTOR = '.';


	const CSS_CLASS_SECTION             = 'section';





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
	 * Prefix a section name and add selector if necessary.
	 *
	 * @param      string  $sectionName  The name of the section
	 *
	 * @return     string  Formatted section with prefix and, if chosen, selector
	 */
	public static function prefixSection( $sectionName = '', $addSelector = false ) {

		// Start off with section as an empty string so we can freely append whatever to it conditionally
		$section = '';

		// Do we want a selector or just the name of it?
		if ( ( bool )$addSelector === true )
			$section .= self::CSS_SELECTOR_SECTION_SELECTOR;

		// Add the prefix, end with the filename
		$section .= self::CSS_SELECTOR_SECTION_PREFIX . $sectionName;

		// Aaaand return it, obviously.
		return $section;
	}





	/**
	 * Prefix a wrapper name and add selector if necessary.
	 *
	 * @param      string  $wrapperName  The name of the section
	 *
	 * @return     string  Formatted section with prefix and, if chosen, selector
	 */
	public static function prefixWrapper( $wrapperName = '', $addSelector = false ) {

		// Start off with section as an empty string so we can freely append whatever to it conditionally
		$section = '';

		// Do we want a selector or just the name of it?
		if ( ( bool )$addSelector === true )
			$section .= self::CSS_SELECTOR_WRAPPER_SELECTOR;

		// Add the prefix, end with the filename
		$section .= self::CSS_SELECTOR_WRAPPER_PREFIX . $wrapperName;

		// Aaaand return it, obviously.
		return $section;
	}





	/**
	 * Create wrapper elements for flexible content sections.
	 *
	 * @param      string  $data        The section content
	 * @param      array   $classNames  The class names to set for the section
	 *
	 * @return     string  Wrapped section content
	 */
	protected static function wrapSection( $data = null, $classNames = Array(), $background = null ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<section
		 class="<?php echo join( ' ', $classNames ); ?>"
		 style="<?php if ( !empty( $background ) ) echo 'background-image: url(' . $background . ');'; ?>">
<?php
			echo $data;
?>
		</section>
<?php
		// Get the buffered data and clean it out.
		return ob_get_clean();
	}





	/**
	 * Set up and inject the necessary JS structure.
	 */
	public static function injectJsVariables() {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<script type="text/javascript">

			// Verify that Wisewebs is instantiated: Otherwise instatiate it
			if ( typeof Wisewebs !== 'object' )
				Wisewebs = {};

			// Verify that phpVariables is instantiated: Otherwise instatiate it
			if ( typeof Wisewebs.phpVariables !== 'object' )
				Wisewebs.phpVariables = {};

			// Verify that Content is instantiated: Otherwise instatiate it
			if ( typeof Wisewebs.phpVariables.Content !== 'object' )
				Wisewebs.phpVariables.Content = {};

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
