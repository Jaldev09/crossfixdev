<?php
/*
 * Class file for integrating Facebook feeds.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Interfaces;
Use Wisewebs\Classes\Utility;


/**
 * Class used for displaying integrating Facebook feeds.
 */
class FacebookFeed extends Content implements Interfaces\JS\JS {

	// Class constants
	const FB_APP_ACCESS_TOKEN                = '1825787934325118|GA8HKuOdoyi-ZPdVv0Tpdh0piRg';
	const FB_API_VERSION                     = 'v2.8';
	const FB_FEED_PAGE_ID                    = '218929471480331';
	const FB_FEED_FIELDS                     = '&fields=full_picture,id,message,attachments,link,name,description,type,status_type,created_time';

	const CSS_CLASS_SECTION                  = 'facebook-feed';
	const CSS_CLASS_FEED                     = self::CSS_CLASS_SECTION;
	const CSS_CLASS_FEED_ITEM                = 'item';
	const CSS_CLASS_FEED_ITEM_LOADED         = 'loaded';
	const CSS_CLASS_FEED_ITEM_IMG            = 'img';
	const CSS_CLASS_FEED_ITEM_MSG            = 'message';
	const CSS_CLASS_FEED_ITEM_SHARED_LINK    = 'shared-link';
	const CSS_CLASS_FEED_ITEM_POST_LINK      = 'post-link';
	const CSS_CLASS_FEED_ITEM_PUBLISHED_DATE = 'published-date';





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
		<div class="<?php echo self::CSS_CLASS_FEED; ?>"></div>
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

		// Get the class constants and JSON encode so the JS can receive it
		$constants = json_encode(
			Utility\Classes::getClassConstants(
				__CLASS__
			)
		);
?>
		<script type="text/javascript">

			Wisewebs.phpVariables.Content.facebookFeed = <?php echo $constants; ?>;

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
