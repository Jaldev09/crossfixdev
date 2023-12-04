<?php
/*
 * Tracking script functinoality from Google Analytics.
 */


// Set the namespace
Namespace Wisewebs\Classes\Tracking;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * Tracking scripts from Google Analytics.
 */
class GoogleAnalytics extends Tracking {

	// Class constants
	const UA_CODE = 'UA-89693622-1';





	/**
	 * The base Google Analytics script.
	 */
	public static function basicTracking() {

		// Are we in a situation where we want to include tracking?
		if ( parent::includeTracking() ) {
?>
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga( 'create', '<?php echo self::UA_CODE; ?>', 'auto' );
				ga( 'send', 'pageview' );
			</script>
<?php
		}
	}





	/**
	 * Send a custom event for more precise tracking and custom reports.
	 *
	 * @param      string  $category  Event category
	 * @param      string  $action    Event action
	 * @param      string  $label     Event label
	 */
	public static function customEvent( $category = '', $action = '', $label = '' ) {

		// Are we in a situation where we want to include tracking?
		if ( parent::includeTracking() ) {
?>
			<script>
				ga(
					'send',
					{
						hitType:       'event',
						eventCategory: '<?php echo $category; ?>',
						eventAction:   '<?php echo $action; ?>',
						eventLabel:    '<?php echo $label; ?>',
					}
				);
			</script>
<?php
		}
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
