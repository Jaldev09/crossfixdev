<?php
/*
 * Generic functionality for Woocommerce-related things.
 */


// Set the namespace
Namespace Wisewebs\Classes\WooCommerce;
// Import relevant namespaces
Use Wisewebs\Classes\Utility;


/*
 * The main class for Woocommerce-related things.
 */
class WooCommerce {

	// Class constants
	const FIELD_PRODUCT_TITLE               = 'post_title';

	const WC_HOOK__TRIM_DECIMALS_FROM_PRICE = "woocommerce_price_trim_zeros";
	const WC_HOOK__MODIFY_CART_ITEM_TITLE   = "woocommerce_cart_item_name";





	/**
	 * Register function to use with filters.
	 */
	public static function addFilters() {


		if ( function_exists( 'add_filter' ) ) {

			add_filter(
				static::WC_HOOK__TRIM_DECIMALS_FROM_PRICE,
				'__return_true'
			);


			add_filter(
				static::WC_HOOK__MODIFY_CART_ITEM_TITLE,
				__CLASS__ . '::addSkuToCart',
				20,
				3
			);
		}
	}






	/**
	 * Display the SKU in the cart.
	 *
	 * @param      string  $title        Product title
	 * @param      Array   $values       Product data
	 * @param      string  $cartItemKey  The key for this product in the cart
	 *
	 * @return     string  Processed title
	 */
	public static function addSkuToCart( $title, $values, $cartItemKey ) {

		// Can we fetch the SKU?
		$sku = $values[ 'data' ]->get_sku();

		// Did we find a SKU for this? Then add it after the title
		if ( ! empty( $sku ) )
			$title = $title . sprintf( "<span class=\"cart-sku\">(#%s)</span>", $sku );

		// Return the title
	    return $title;
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
