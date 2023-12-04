<?php
/*
 * Class file for selected products.
 */


// Set namespace
Namespace Wisewebs\Classes\Content;


// Import relevant namespaces
Use Wisewebs\Classes\WooCommerce;


/**
 * Class used for displaying selected products.
 */
class SelectedProducts extends Content {

	// Class constants
	const FIELD_PRODUCT_LISTS        = 'product_lists';
	const FIELD_PRODUCT_LIST         = 'product_list';
	const FIELD_PRODUCT              = 'product';
	const FIELD_HEADING              = 'heading_selected_products';
	const FIELD_CATEGORY_HEADING     = 'heading';

	const CSS_CLASS_HEADING          = 'heading';
	const CSS_CLASS_SECTION          = 'selected-products';
	const CSS_CLASS_CATEGORY_HEADING = 'category-' . self::FIELD_CATEGORY_HEADING;






	/**
	 * Create the actual section content.
	 *
	 * @param      string  $data   The field contents.
	 *
	 * @return     string  Formatted content.
	 */
	protected static function content( $data = Array() ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();

		// Instantiate variables as empty
		$headings = '';
		$products = '';

		// Index-counter as we don't want ugly 'For' loops
		$index = 0;

		// Loop categories
		foreach ( $data[ self::FIELD_PRODUCT_LISTS ] as $category ) {

			// Get the list of headings
			$headings .= self::getCategoryHeading( $category, $index );

			// Get the list of products
			$products .= self::getProductList( $category, $index );

			// Increment index
			$index++;
		}
?>
		<h2 class="<?php echo self::CSS_CLASS_HEADING; ?>"><?php echo $data[ self::FIELD_HEADING ]; ?></h2>
		<div class="shortcode-product-wrap masonry">

			<div class="product-filters">
				<ul data-option-key="filter" class="filter-center style_2">
<?php
					echo $headings;
?>
				</ul>
			</div>

			<div class="product-wrap masonry">
				<div class="product-inner clearfix product-style-masonry product-paging-default product-col-4">
					<div class="woocommerce product-listing clearfix columns-4">
<?php
						echo $products;
?>
					</div>
				</div>
			</div>
		</div>
<?php
		// Get the buffered data and clean it out.
		return ob_get_clean();
	}






	/**
	 * Gets the heading for the current category.
	 *
	 * @param      Array    $category  Category array with all category data
	 * @param      integer  $index     Current index
	 *
	 * @return     String   HTML-code for the heading of the current category.
	 */
	private static function getCategoryHeading( $category = Array(), $index = 0 ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();
?>
		<li>
			<a
			 href="#"
			 data-option-value=".product_cat-<?php echo $index; ?>"
			 class="<?php echo self::CSS_CLASS_CATEGORY_HEADING; ?>">
<?php
				echo $category[ self::FIELD_CATEGORY_HEADING ];
?>
			</a>
			</li>
<?php
		// Get the buffered data and clean it out.
		return ob_get_clean();
	}






	/**
	 * Gets a list of products from the current category.
	 *
	 * @param      Array    $category  Category array with all category data
	 * @param      integer  $index     Current index
	 *
	 * @return     String   HTML-code for the products in the current category.
	 */
	private static function getProductList( $category = Array(), $index = 0 ) {

		// Start an output buffer so we can write code in the right scope and syntax without printing it directly.
		ob_start();

		// Loop products in category
		foreach ( $category[ self::FIELD_PRODUCT_LIST ] as $product ) {

			// ACF returns WP_Post object but we want a WC_Product_Simple
			// object, so instead we simply get the ID and tell Woo to fetch
			// the right object
			$product = wc_get_product( $product[ self::FIELD_PRODUCT ] );

			// Make sure this product ID exists (I.e.: product hasn't been deleted)
			if ( !empty( $product->get_id() ) )  {
?>
				<div class="product-item-wrap button-has-tooltip product_style_1 product type-product product_cat-<?php echo $index; ?>">
					<div class="product-item-inner">
						<div class="product-thumb"><?php

							$product_new = get_post_meta(
								$product->get_id(),
								'yolo_product_new',
								true
							);

							$product_hot = get_post_meta(
								$product->get_id(),
								'yolo_product_hot',
								true
							);

?>
							<div class="product-flash-wrap"><?php

								if ( $product->is_on_sale() ) {

									if ( $product->is_on_sale() ) {

										echo apply_filters(
											'woocommerce_sale_flash',
											'<span class="on-sale product-flash">' . esc_html__( 'Sale', 'woocommerce' ) . '!</span>',
											$product,
											$product
										);
									}
								}


								if ( $product_new == 'yes' ) {
?>
								    <span class="on-new product-flash">Ny</span>
<?php
								}


								if ( $product_hot == 'yes' ) {
?>
									<span class="on-hot product-flash">Populär</span>
<?php
								}


								if ( !$product->is_in_stock() ) {
?>
								    <span class="on-sold product-flash">Slutsåld</span>
<?php
								}

							?></div>

							<div class="product-thumb-primary">
<?php
								echo $product->get_image( 'shop_catalog' );
?>
							</div>
							<a class="product-link" href="<?php echo get_permalink( $product->get_id() ); ?>">
								<div class="product-hover-sign">
									<hr>
									<hr>
								</div>
							</a>
						</div>
						<div class="product-info">
							<div class="product-actions">
								<div class="add-to-cart-wrap" data-toggle="tooltip" data-placement="top" title="" data-original-title="Lägg i varukorg">

									<a
									 rel="nofollow"
									 href="?add-to-cart=<?php echo $product->get_id(); ?>"
									 data-quantity="1"
									 data-product_id="<?php echo $product->get_id(); ?>"
									 data-product_sku="<?php echo $product->get_sku(); ?>"
									 class="add_to_cart_button product_type_simple button product_type_simple add_to_cart_button ajax_add_to_cart">

										<i class="fa fa-cart-plus"></i>
										Lägg i varukorg
									</a>
								</div>
								<a data-toggle="" data-placement="top" title="Snabbtitt" class="product-quick-view" data-product_id="<?php echo $product->get_id(); ?>" href="<?php echo get_permalink( $product->get_id() ); ?>"><i class="fa fa-search"></i>Snabbtitt</a>
							</div>
							<span class="price">
								<span class="woocommerce-Price-amount amount">
<?php
										echo $product->get_price_html();
?>
								</span>
							</span>
							<h3>
<?php

								echo $product->get_title();
?>
							</h3>
						</div>
					</div>
				</div>
<?php
			}
		}

		// Get the buffered data and clean it out.
		return ob_get_clean();
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
