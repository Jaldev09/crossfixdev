<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

$cat_count = sizeof( get_the_terms( $post->ID, 'product_cat' ) );

$weight = $product->get_weight();

$availability      = $product->get_availability();
if (empty($availability['availability'])) {
    $availability['availability'] = esc_html__( 'In stock', 'woocommerce' );
    $availability['class'] = 'in-stock';
}
$availability_html = '<span class="product-stock-status ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</span>';

?>
<div class="product_meta">

    <?php do_action( 'woocommerce_product_meta_start' ); ?>
    <?php //if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
    <!-- <span class="sku_wrapper"><label><?php //esc_html_e( 'SKU:', 'woocommerce' ); ?></label> <span class="sku"
            itemprop="sku"><?php //echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'yolo-motor' ); ?></span>.</span> -->
    <?php //endif; ?>

    <?php //if (!empty($weight)) : ?>
    <!-- <span><label><?php //esc_html_e("Fraktvikt:",'yolo-motor'); ?></label><span>
            <?php //echo esc_html($weight) . ' ' .get_option( 'woocommerce_weight_unit' ) ?></span></span> -->
    <?php //endif; ?>
    <?php
    // echo wc_get_product_category_list(
    //     $product->get_id(),
    //     '/',
    //     '<span class="posted_in">' . _n(
    //         '<label>Kategori:</label>',
    //         '<label>Kategorier:</label>',
    //         $cat_count,
    //         'yolo-motor'
    //     ) . ' '
    //     , '.</span>'
    // );
    do_action( 'woocommerce_product_meta_end' );
?>
    <?php
    $enable_delivery_option = get_field('enable_delivery_option','options');
    if($enable_delivery_option){
    global $product;

    // Check if the product is in stock
    if ($product->is_in_stock()) {
        echo '<p class="stock-availability"><strong>Finns:</strong> i Lager </p>';
    } else {
        echo '<p class="stock-availability out-of-stock">Out of Stock</p>';
    }

        $woo_delivery_information = get_field('woo_delivery_information','options');
        // Display delivery information
        echo '<p class="delivery-info">'.$woo_delivery_information.'</p>';
    }
?>
</div>
<?php
$klarna_url = !empty(get_field('klarna_url','options')) ? get_field('klarna_url','options') : "javaScript:void(0);";
$shop_now_offer_text = get_field('shop_now_offer_text','options');
$offer_page_url = !empty(get_field('offer_page_url','options')) ? get_field('offer_page_url','options') : "javaScript:void(0);";

?>
<div class="klarna-wrap">
    <a href="<?php echo $klarna_url; ?>" class="klarna-url">Klarna.</a>
    <?php if(!empty($shop_now_offer_text)): ?>
    <p><?php echo $shop_now_offer_text; ?><a href="<?php echo $offer_page_url; ?>"> Las mer </a></p>
    <?php endif; ?>
</div>