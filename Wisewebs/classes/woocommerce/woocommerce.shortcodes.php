<?php
/*
 * Generic functionality for Woocommerce-related things.
 */


// Set the namespace
namespace Wisewebs\Classes\WooCommerce;


// Import relevant namespaces
use Wisewebs\Classes\Utility;


/*
 * The main class for Woocommerce-related things.
 */
class Shortcodes
{
	/**
	 * Adds shortcodes for billing form actions to use on non-standard checkout
	 * pages.
	 */
	public static function addShortcodesForBillingFormActions()
	{
		add_shortcode(
			'do_action_woocommerce_before_checkout_billing_form',
			function()
			{
				do_action( 'woocommerce_before_checkout_billing_form' );
			}
		);

		add_shortcode(
			'do_action_woocommerce_after_checkout_billing_form',
			function()
			{
				do_action( 'woocommerce_after_checkout_billing_form' );
			}
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
	public function __set( $name, $val )
	{
		// Hey, this is overloading! This class doesn't allow that!
		Utility\Utility::preventClassOverload();
	}
}
