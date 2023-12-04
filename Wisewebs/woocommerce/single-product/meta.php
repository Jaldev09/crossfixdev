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
    <?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>

        <span class="sku_wrapper"><label><?php esc_html_e( 'SKU:', 'woocommerce' ); ?></label> <span class="sku" itemprop="sku"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'yolo-motor' ); ?></span>.</span>

    <?php endif; ?>

    <?php if (!empty($weight)) : ?>
        <span><label><?php esc_html_e("Fraktvikt:",'yolo-motor'); ?></label><span> <?php echo esc_html($weight) . ' ' .get_option( 'woocommerce_weight_unit' ) ?></span></span>
    <?php endif; ?>
<?php
    echo wc_get_product_category_list(
        $product->get_id(),
        '/',
        '<span class="posted_in">' . _n(
            '<label>Kategori:</label>',
            '<label>Kategorier:</label>',
            $cat_count,
            'yolo-motor'
        ) . ' '
        , '.</span>'
    );



    do_action( 'woocommerce_product_meta_end' );
?>
</div>
