<?php
/**
     * @hooked - yolo_shop_page_content - 5
     **/

$yolo_options = yolo_get_options();

$load_more = isset($_POST['pagination']) ? isset($_POST['pagination']) : '';
$archive_product_style = $yolo_options['archive_product_style'] ? $yolo_options['archive_product_style'] : 'style_1';
?>

<?php if ( isset( $archive_product_style ) && $archive_product_style == 'style_1'  && $load_more != 'load_more' ): ?>
    <div class="sidebar woocommerce-sidebar hidden-sm hidden-xs">
        <?php dynamic_sidebar( 'woocommerce_filter' ); ?>
    </div>
    <div class="clearfix"></div>
    <div class="yolo-search-field">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="text" class="search-field" placeholder="Sök tillbehör&hellip;" value="<?php if ( isset($_REQUEST['s']) && $_REQUEST['s']) { echo $_REQUEST['s'];}?>" name="s" title="Sök:">
            <button type="submit"><i class="fa fa-search"></i></button>
            <input type="hidden" name="post_type" value="product">
        </form>
    </div>
    <div class="clearfix"></div>
<?php endif;?>

<?php if ( have_posts() ) : ?>

    <?php
    /**
     * woocommerce_before_shop_loop hook
     *
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
    do_action( 'woocommerce_before_shop_loop' );
    ?>


    <?php if ( $load_more != 'load_more') { woocommerce_product_loop_start(); } ?>

    <?php while ( have_posts() ) : the_post(); ?>

        <?php wc_get_template_part( 'content', 'product' ); ?>

    <?php endwhile; // end of the loop. ?>

    <?php if ( $load_more != 'load_more'){ woocommerce_product_loop_end(); } ?>

    <?php
    /**
     * woocommerce_after_shop_loop hook
     *
     * @hooked woocommerce_pagination - 10
     */
    do_action( 'woocommerce_after_shop_loop' );
    ?>
<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

    <?php wc_get_template( 'loop/no-products-found.php' ); ?>

<?php endif; ?>
