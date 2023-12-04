<?php
/**
 * PartStream product related code.
 */



/**
 * Namespace and imports.
 */
namespace Wisewebs\Classes\HusqvarnaXepc;
use Wisewebs\Classes\REST;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WooCommerce;
use Wisewebs\Interfaces;
use Exception;



/**
 * Class for Husqvarna xEPC.
 */
class HusqvarnaXepc implements Interfaces\REST\Routes
{
	/**
	 * Class constants.
	 */
	const CSV_SEPARATOR                     = ';';
	const PRODUCT_PARENT_ID                 = 14943;
	const PRODUCT_SKU_PREFIX                = 'husqvarna';
	const REQUIRED_EXECUTION_TIME           = 3000;
	const REST_ROUTE__GET_PRODUCT_INFO      = 'husqvarnaxepcgetproductinfo';
	const REST_ROUTE__PRE_UPDATE_PARTS_LIST = 'husqvarnaxepcpreupdatepartslist';
	const REST_ROUTE__UPDATE_PARTS_LIST     = 'husqvarnaxepcupdatepartslist';
	const PRODUCT__PARENT_ID                = 14943;
	const PRODUCT__PARENT_SKU               = 'husqvarna-reservdel-bas';



	/**
	 * Register routes for the REST API.
	 */
	public static function registerRestRoutes()
	{
		add_action(
			'rest_api_init',
			function()
			{
				register_rest_route(
					REST\REST::ROUTE__BASE . '/' . REST\REST::ROUTE__CURRENT_VERSION,
					'/' . static::REST_ROUTE__GET_PRODUCT_INFO,
					[
						'methods'  => 'GET',
						'callback' => __CLASS__ . '::getProductInfo',
					]
				);
			}
		);

		add_action(
			'rest_api_init',
			function()
			{
				register_rest_route(
					REST\REST::ROUTE__BASE . '/' . REST\REST::ROUTE__CURRENT_VERSION,
					'/' . static::REST_ROUTE__PRE_UPDATE_PARTS_LIST,
					[
						'methods'  => 'POST',
						'callback' => __CLASS__ . '::preUpdatePartsList',
					]
				);
			}
		);

		add_action(
			'rest_api_init',
			function()
			{
				register_rest_route(
					REST\REST::ROUTE__BASE . '/' . REST\REST::ROUTE__CURRENT_VERSION,
					'/' . static::REST_ROUTE__UPDATE_PARTS_LIST,
					[
						'methods'  => 'POST',
						'callback' => __CLASS__ . '::updatePartsList',
					]
				);
			}
		);
	}



	/**
	 * Get info about the product.
	 */
	public static function getProductInfo()
	{
		try
		{
			global $wpdb;

			if ( empty( $_GET[ 'sku' ] ) )
			{
				throw new Exception( 'No SKU provided' );
			}

			if ( ! is_string( $_GET[ 'sku' ] ) && ! is_numeric( $_GET[ 'sku' ] ) )
			{
				throw new Exception( 'Invalid SKU provided' );
			}

			$result = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT `sku`, `description`, `price` FROM {$wpdb->prefix}husqvarna_xepc_parts WHERE `sku` = %s",
					$_GET[ 'sku' ]
				),
				ARRAY_A
			);

			if ( empty( $result[ 0 ] ) )
			{
				throw new Exception( 'SKU not registered in system' );
			};

			$productUpdate = static::createOrUpdateVariation(
				$result[ 0 ][ 'sku' ],
				$result[ 0 ][ 'description' ],
				$result[ 0 ][ 'price' ]
			);

			if ( true !== $productUpdate[ 'status' ] )
			{
				throw new Exception( 'Failed at setting spare part info in WooCommerce' );
			}

			return [
				'product' =>
				[
					'description' => $result[ 0 ][ 'description' ],
					'price'       => $result[ 0 ][ 'price' ],
					'variationId' => $productUpdate[ 'variationId' ],
				],
				'status' => true,
			];
		}
		catch ( Exception $e )
		{
			$returnData =
			[
				'status' => false
			];

			if ( false && true === WP_DEBUG )
			{
				$returnData[ 'exception' ] = print_r(
					$e,
					true
				);
			}

			return $returnData;
		}
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



	public static function preUpdatePartsList()
	{
		$minTime = 90;

		$returnData =
		[
			'message' => '',
			'status'  => true,
		];

		// Initial setting
		if ( ( int ) ini_get( 'max_execution_time' ) < $minTime )
		{
			ini_set(
				'max_execution_time',
				static::REQUIRED_EXECUTION_TIME
			);
		}

		// Verification that value updated
		if ( ( int ) ini_get( 'max_execution_time' ) < $minTime )
		{
			$returnData[ 'message' ] = 'VARNING: Ditt webbhotell tillåter inte att processer som tar lång tid körs (t.ex. denna import). Importen kommer försökas ändå, men det kan innebära att importen avbryts. Om det händer så prova dela upp filen i flera mindre delar.';

			$returnData[ 'status' ] = false;
		}

		return $returnData;
	}



	public static function updatePartsList()
	{
		$startTime = microtime( true );

		if ( ! is_user_logged_in() || ! current_user_can( 'edit_pages' ) )
		{
			$returnData[ 'message' ] = 'EJ TILLÅTET: Du har inte tillåtelse att göra detta.';
			$returnData[ 'status' ]  = false;
		}
		else
		{
			global $wpdb;

			$returnData =
			[
				'executionTime' => 0,
				'message'       => '-',
				'status'        => true,
			];

			ini_set(
				'max_execution_time',
				static::REQUIRED_EXECUTION_TIME
			);

			if ( empty( $_FILES[ 'xepc-csv-upload' ] ) )
			{
				$returnData[ 'message' ] = 'FIL SAKNAS: Du måste välja en fil att ladda upp.';
				$returnData[ 'status' ]  = false;
			}
			else
			{
				$fileData = $_FILES[ 'xepc-csv-upload' ];

				$file = fopen(
					$fileData[ 'tmp_name' ],
					'r'
				);

				$query = "INSERT INTO {$wpdb->prefix}husqvarna_xepc_parts ( `sku`, `description`, `price` ) VALUES ( %s, %s, %s ) ON DUPLICATE KEY UPDATE `description` = %s, `price` = %s";

				while ( false !== ( $csvData = fgetcsv( $file, 500, static::CSV_SEPARATOR ) ) )
				{
					// If SKU is empty then ignore it altogether
					if ( ! empty( $csvData[ 0 ] ) )
					{
						$result = $wpdb->query(
							$wpdb->prepare(
								$query,
								$csvData[ 0 ],
								$csvData[ 1 ],
								$csvData[ 2 ],
								$csvData[ 1 ],
								$csvData[ 2 ]
							)
						);
					}
				}

				fclose( $file );

				$returnData[ 'message' ] = 'Import klar.';
			}
		}

		$endTime = microtime( true );

		$returnData[ 'executionTime' ] = ( $endTime - $startTime ) . ' sec';

		return $returnData;
	}



	/**
	 * Create a variant for this part or, if it exists, update it.
	 */
	public static function createOrUpdateVariation( $sku, $description, $price )
	{
		try
		{
			global $wpdb;

			// We need a SKU to proceed
			if ( empty( $sku ) )
			{
				throw new Exception();
			}

			// No exception for missing price, but no operation either since this is now useless to us
			if ( ! empty( $price ) )
			{
				$variationSku = static::PRODUCT_SKU_PREFIX . '-' . $sku;

				// Make sure we at least get the SKU if the description is empty
				$variationDescription =
				(
					! empty( $description )
					? $description
					: ''
				);

				$variationId = wc_get_product_id_by_sku( $variationSku );

				if ( empty( $variationId ) )
				{
					$result = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT `post_id` FROM {$wpdb->prefix}postmeta WHERE `meta_key` = '_sku' AND `meta_value` = %s",
							$variationSku
						),
						ARRAY_A
					);

					if ( ! empty( $result[ 0 ][ 'post_id' ] ) )
					{
						$variationId = $result[ 0 ][ 'post_id' ];
					};
				}

				// Part exists since earlier, update it
				if ( ! empty( $variationId ) )
				{
					// Set the metadata for the variation
					static::setVariationMetaData(
						$variationId,
						array(
							'_price'                 => $price,
							'_regular_price'         => $price,
							'_variation_description' => $variationDescription,
						)
					);
				}
				// Part doesn't exist, create it
				else
				{
					// Insert variation into database
					$variationId = wp_insert_post(
						array(
							'post_title'  => $variationDescription,
							'post_name'   => $variationSku,
							'post_status' => 'publish',
							'post_parent' => static::PRODUCT_PARENT_ID,
							'post_type'   => 'product_variation',
							'guid'        => Utility\URLs::homeURL() . '/?product_variation=' . $variationSku,
						)
					);

					// Set the metadata for the variation
					static::setVariationMetaData(
						$variationId,
						array(
							'_sku'                   => $variationSku,
							'_price'                 => $price,
							'_regular_price'         => $price,
							'_variation_description' => $variationDescription,
						)
					);
				}
			}

			return array(
				'variationId' => $variationId,
				'status'      => true,
			);

		} catch ( Exception $e ) {

			return array(
				'status' => false
			);
		}
	}



	/**
	 * Sets variation metadata for a specific variation.
	 *
	 * @param integer $variationId Variation ID.
	 * @param array   $metaData    Metadata to set.
	 *
	 * @throws Exception (description).
	 *
	 * @return boolean True if no errors were encountered, False otherwise.
	 */
	public static function setVariationMetaData( $variationId, $metaData = array() )
	{
		try
		{
			foreach ( $metaData as $metaKey => $metaValue )
			{
				if ( empty( $metaKey ) )
				{
					throw new Exception();
				}

				// Set or update meta value
				update_post_meta(
					$variationId,
					$metaKey,
					$metaValue
				);
			}

			return true;
		}
		catch ( Exception $e )
		{
			return false;
		}
	}
}
