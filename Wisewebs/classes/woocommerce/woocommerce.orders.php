<?php

// Set the namespace
namespace Wisewebs\Classes\WooCommerce;


// Import relevant namespaces
use Wisewebs\Classes\Utility;


class Orders
{
	/*----------  Functionality  ----------*/

	const ORDER_ITEM_NOTATION_SANITY_CHECK_VARIABLE_NAME  = 'order_item_notation_sanity_check';
	const ORDER_ITEM_NOTATION_SANITY_CHECK_VARIABLE_VALUE = 'present';

	const ORDER_ITEM_NOTATION_META_KEY                    = 'order_item_notation';





	/**
	 * Shows the notations for the current order item.
	 *
	 * @param      integer  $itemID   The item ID
	 * @param      object   $item     The order item
	 * @param      object   $product  The product
	 */
	public static function showOrderItemNotations( $itemID, $item, $product )
	{
		$metaData = get_metadata(
			'order_item',
			$itemID,
			'',
			''
		);

?>
		<div class="order-item-notation">
			<h4 style="margin-bottom: 0;">Anteckningar</h4>
			<textarea
			 name="<?php echo static::ORDER_ITEM_NOTATION_META_KEY; ?>[<?php echo $itemID; ?>]"
			><?php
				if ( ! empty( $metaData[ static::ORDER_ITEM_NOTATION_META_KEY ] ) && ! empty( $metaData[ static::ORDER_ITEM_NOTATION_META_KEY ][ ( count( $metaData[ static::ORDER_ITEM_NOTATION_META_KEY ] ) - 1 ) ] ) )
				{
					echo trim( $metaData[ static::ORDER_ITEM_NOTATION_META_KEY ][ ( count( $metaData[ static::ORDER_ITEM_NOTATION_META_KEY ] ) - 1 ) ] );
				}
			?></textarea>
			<input type="hidden" name="order_item_notation_sanity_check" value="present">
		</div>
<?php
	}





	/**
	 * Saves order item notations when saving an order.
	 *
	 * @param      integer  $orderID      The order ID
	 * @param      object   $orderObject  The order object
	 */
	public static function saveOrderItemNotations( $orderID, $orderObject )
	{
		// Make sure our sanity check variable is present in case the hook somehow gets invoked from elsewhere
		if ( ! empty( $_POST[ static::ORDER_ITEM_NOTATION_SANITY_CHECK_VARIABLE_NAME ] ) && static::ORDER_ITEM_NOTATION_SANITY_CHECK_VARIABLE_VALUE === $_POST[ static::ORDER_ITEM_NOTATION_SANITY_CHECK_VARIABLE_NAME ] )
		{
			// Make sure we got any of that posted
			if ( ! empty( $_POST[ static::ORDER_ITEM_NOTATION_META_KEY ] ) && is_array( $_POST[ static::ORDER_ITEM_NOTATION_META_KEY ] ) )
			{
				// Loop items
				foreach ( $_POST[ static::ORDER_ITEM_NOTATION_META_KEY ] as $key => $value )
				{
					// Add the metadata
					woocommerce_add_order_item_meta(
						$key,
						static::ORDER_ITEM_NOTATION_META_KEY,
						$value
					);
				}
			}
		}
	}





	/**
	 * Register function to use with filters.
	 */
	public static function addFilters()
	{
		if ( function_exists( 'add_filter' ) )
		{
			// Show custom order item metadata when saving order
			add_filter(
				'woocommerce_after_order_itemmeta',
				__CLASS__ . "::showOrderItemNotations",
				10,
				3
			);

			// When updating a product
			add_filter(
				'woocommerce_process_shop_order_meta',
				__CLASS__ . "::saveOrderItemNotations",
				10,
				2
			);
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
	public function __set( $name, $val )
	{
		// Hey, this is overloading! This class doesn't allow that!
		Utility\Utility::preventClassOverload();
	}
}
