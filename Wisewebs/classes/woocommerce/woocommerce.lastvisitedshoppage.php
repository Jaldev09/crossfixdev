<?php
/*
 * 
 */


// Set the namespace
Namespace Wisewebs\Classes\WooCommerce;


// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * 
 */
class LastVisitedShopPage {

	const COOKIE__NAME = 'lastvisitedshoppage';





	/**
	 * 
	 */
	public static function backToLastPageButton() {

		// If there's something in our cookie: Show the link
		if ( ! empty( $_COOKIE[ static::COOKIE__NAME ] ) ) {
?>
			<a href="<?php echo $_COOKIE[ static::COOKIE__NAME ]; ?>" class="button keep-shopping">Fortsätt handla</a>
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
