<?php
/*
 * PartStream product related code.
 */


// Set the namespace
Namespace Wisewebs\Classes\PartStream;


// Import relevant namespaces
Use Wisewebs\Classes\REST;
Use Wisewebs\Classes\Utility;
Use Wisewebs\Classes\WooCommerce;
Use Wisewebs\Interfaces;
Use Exception;


/*
 * Class for PartStream products.
 */
class PartStreamProduct extends PartStream implements Interfaces\REST\Routes {

	const REST_ROUTE__ADD_TO_CART = "addtocart";

	const PRODUCT__PARENT_ID      = "1361";

	const PRODUCT__SKU            = "arisku";
	const PRODUCT__QUANTITY       = "ariqty";
	const PRODUCT__PRICE          = "ariprice";
	const PRODUCT__BRAND          = "aribrand";
	const PRODUCT__DESCRIPTION    = "aridescription";
	const RETURN_URL              = "arireturnurl";

	const WC_HOOK__ADD_TO_CART_MESSAGE = 'wc_add_to_cart_message_html';
	const WC_FILTER__ORDER_ITEM_NAME   = "woocommerce_order_item_name";

	/**
	 * Register routes for the REST API.
	 */
	public static function registerRESTRoutes()
	{
		\add_action(
			'rest_api_init',
			function ()
			{
				\register_rest_route(
					REST\REST::ROUTE__BASE . '/' . REST\REST::ROUTE__CURRENT_VERSION,
					'/' . static::REST_ROUTE__ADD_TO_CART,
					[
						'methods'  => 'POST',
						'callback' =>
						[
							__CLASS__,
							'createOrUpdateVariation'
						],
						'permission_callback' => '__return_true',
					]
				);
			}
		);
	}

	/**
	 * Create a variant for this part or, if it exists, update it.
	 * @param WP_REST_Request $request The request as passed on by the REST API
	 * @return mixed
	 */
	public static function createOrUpdateVariation( \WP_REST_Request $request )
	{
		try
		{
			// We need a SKU to proceed
			if ( true === empty( $request->get_param( static::PRODUCT__SKU ) ) )
			{
				throw new Exception();
			}

			// We also need to know the brand to proceed (since PartStream handles pricing on a per brand basis meaning we would possibly overwrite brand specific prices if we don't use this)
			if ( true === empty( $request->get_param( static::PRODUCT__BRAND ) ) )
			{
				throw new Exception();
			}

			// Without price this function should never be allowed to run, so that's an exception
			if ( true === empty( $request->get_param( static::PRODUCT__PRICE ) ) )
			{
				throw new Exception();
			}
			// Format the SKU to the way we store it in WordPress
			$variationSKU =
				static::PRODUCT__SKU . '-' .
				$request->get_param( static::PRODUCT__BRAND ) . '-' .
				$request->get_param( static::PRODUCT__SKU );

			// Make sure we at least get the SKU if the description is empty
			$variationDescription =
			(
				true !== empty( $request->get_param( static::PRODUCT__DESCRIPTION ) )
					? urldecode(
						$request->get_param(
							static::PRODUCT__DESCRIPTION
						)
					)
					: $variationSKU
			);

			// If no quantity is set: Assume we only want 1
			$quantity =
			(
				true !== empty( $request->get_param( static::PRODUCT__QUANTITY ) )
					? $request->get_param( static::PRODUCT__QUANTITY )
					: '1'
			);

			// Price is formatted as string with lots of random stuff, so let's get the integer value of that rounding up
			$price = Utility\Numbers::integer(
				$request->get_param(
					static::PRODUCT__PRICE
				),
				'ceil'
			);

			// Try to get the variation ID using the SKU
			$variationID = wc_get_product_id_by_sku( $variationSKU );

			// Part exists since earlier, update it
			if ( true !== empty( $variationID ) )
			{
				// Set the metadata for the variation
				static::setVariationMetaData(
					$variationID,
					[
						'_price' => $price,
						'_regular_price' => $price,
						'_variation_description' => $variationDescription,
					]
				);
			}
			// Part doesn't exist, create it
			else
			{
				// Insert variation into database
				$variationID = wp_insert_post(
					[
						'post_title' => $variationDescription,
						'post_name' => $variationSKU,
						'post_status' => 'publish',
						'post_parent' => static::PRODUCT__PARENT_ID,
						'post_type' => 'product_variation',
						'guid' => Utility\URLs::homeURL() . '/?product_variation=' . $variationSKU,
					]
				);

				// Set the metadata for the variation
				static::setVariationMetaData(
					$variationID,
					[
						'_sku' => $variationSKU,
						'_price' => $price,
						'_regular_price' => $price,
						'_variation_description' => $variationDescription,
					]
				);
			}

			// Decode the URL so we can perform operations on it in plaintext
			$decodedReturnURL = urldecode(
				urldecode(
					$request->get_param( static::RETURN_URL )
				)
			);

			// Get the hash used for getting back to the right PartStream product list
			$partStreamHash = substr(
				$decodedReturnURL,
				strpos(
					$decodedReturnURL,
					"#"
				)
			);

			// Get the base return URL with no hash and no GET parameters
			$baseReturnURL = strtok(
				strtok(
					$decodedReturnURL,
					'#'
				),
				'?'
			);

			// Merge the base URL, add to cart parameters, and PatrStream hash
			$addToCartURL =
				$baseReturnURL .
				'?add-to-cart=' . static::PRODUCT__PARENT_ID . '&variation_id=' . $variationID . '&attribute_reservdel=&quantity=' . $quantity .
				$partStreamHash;

			return new \WP_REST_Response(
				[
					'url' => $addToCartURL,
					'status' => true,
				],
				200
			);
		}
		catch ( Exception $e )
		{
			return new \WP_REST_Response(
				[
					'status' => false,
				],
				400
			);
		}
	}

	/**
	 * Sets variation metadata for a specific variation.
	 *
	 * @param      integer    $variationID  Variation ID
	 * @param      array      $metaData     Metadata to set
	 *
	 * @throws     Exception  (description)
	 *
	 * @return     boolean    True if no errors were encountered, False otherwise
	 */
	public static function setVariationMetaData( $variationID, $metaData = Array() ) {

		try {

			// Lopp all metadata
			foreach ( $metaData as $metaKey => $metaValue ) {

				// Make sure we have a valid meta key set
				if ( empty( $metaKey) )
					throw new Exception();


				// Set or update meta value
				update_post_meta(
					$variationID,
					$metaKey,
					$metaValue
				);
			}

			return true;

		} catch ( Exception $e ) {

			return false;
		}
	}





	/**
	 * Register function to use with filters.
	 */
	public static function addFilters() {

		if ( function_exists( 'add_filter' ) ) {

			// When fetching the WC product title, run our filter to make sure PartStream products use description as name
			add_filter(
				'woocommerce_product_title',
				__CLASS__ . "::changeDisplayNameToVariationDescription",
				10,
				2
			);

			// When Woo sets the product message: Change the PartStream product to the correct one
			add_filter(
				static::WC_HOOK__ADD_TO_CART_MESSAGE,
				__CLASS__ . '::changeAddedToCartMessage',
				10,
				2
			);


			add_filter(
				'woocommerce_order_item_name',
				__CLASS__ . '::changeSparePartsNameToDescription',
				10,
				3
			);


			add_action(
				WooCommerce\WooCommerce::WC_HOOK__MODIFY_CART_ITEM_TITLE,
				__CLASS__ . '::changeSparePartsNameToDescriptionInCart',
				10,
				3
			);


			add_action(
				'woocommerce_before_order_itemmeta',
				__CLASS__ . '::changeSparePartsNameToDescriptionInOrderView',
				10,
				3
			);
		}
	}





	public static function changeSparePartsNameToDescriptionInOrderView( $item_id, $item, $product )
	{
		// Check if we can find parent ID and if that ID is our container product
		if
		(
			true !== empty( $product )
			&&
			true === is_object( $product )
			&&
			true === method_exists( $product, 'get_parent_id' )
			&&
			true !== empty( $product->get_parent_id() )
			&&
			( string ) static::PRODUCT__PARENT_ID === ( string ) $product->get_parent_id()
		)
		{
			echo '<span style="display: inline-block; margin-top: 7px;"><strong>Namn på reservdel: </strong>' . $product->get_description() . '</span>';
		}
	}





	public static function changeSparePartsNameToDescriptionInCart( $formattedName, $item, $key )
	{
		$Product = wc_get_product( $item[ 'variation_id' ] );

		// If parent product is our container product
		if
		(
			false !== $Product
			&&
			! empty( $Product )
			&&
			! empty( $Product->get_parent_id() )
			&&
			( string ) static::PRODUCT__PARENT_ID === ( string ) $Product->get_parent_id()
		)
		{
			$formattedName = $Product->get_description();
		}

		return $formattedName . ' ';
	}





	/**
	 * Change the name of spare parts to their description.
	 *
	 * @param      string       $formattedName     The formatted name
	 * @param      WcOrderItem  $OrderItemProduct  The order item product
	 */
	public static function changeSparePartsNameToDescription( $formattedName, $OrderItemProduct )
	{
		$Product = wc_get_product( $OrderItemProduct->get_variation_id() );

		// If parent product is our container product
		if
		(
			false !== $Product
			&&
			! empty( $Product )
			&&
			! empty( $Product->get_parent_id() )
			&&
			( string ) static::PRODUCT__PARENT_ID === ( string ) $Product->get_parent_id()
		)
		{
			$formattedName = $Product->get_description();
		}

		echo $formattedName;
	}





	/**
	 * Change the display name of the container product for PartStream parts to
	 * that of the selected variation's description.
	 *
	 * @param      string  $currentTitle  Product name
	 * @param      object  $instance      Product instance
	 *
	 * @return     string  New title
	 */
	public static function changeDisplayNameToVariationDescription( $currentTitle, $instance )
	{
		// If parent product is our container product
		if (
			! empty( $instance->get_parent_id() )
			&&
			( string ) static::PRODUCT__PARENT_ID === ( string ) $instance->get_parent_id()
		)
		{
			$currentTitle = $instance->get_description() ;
		}

		return $currentTitle;
	}





	/**
	 * Change WooCommerce's added to cart message so we cant get the PartStream
	 * description in there instead of the WooCommerce product name.
	 *
	 * @param      string          $message   Added to cart message
	 * @param      string/integer  $products  ?
	 *
	 * @return     string          Processed error message
	 */
	public static function changeAddedToCartMessage( $message, $product )
	{

		// If this product is the main PartStream product then use a custom message since Woo won't allow us to use variation name...
		if ( static::PRODUCT__PARENT_ID === ( string ) key( $product ) )
		{
			$message = "Reservdelen har lagts i din varukorg.";
		}


		// Return the message
		return $message;
	}
}
