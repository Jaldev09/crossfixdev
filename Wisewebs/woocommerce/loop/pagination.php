<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.3.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $wp_query;
$yolo_options = yolo_get_options();

if ($wp_query->max_num_pages <= 1) {
	return;
}

$data_page = apply_filters('woocommerce_pagination_args', array(
	'base' => esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false)))),
	'format' => '',
	'add_args' => '',
	'current' => max(1, get_query_var('paged')),
	'total' => $wp_query->max_num_pages,
	'prev_text' => 'Föregående',
	'next_text' => 'Nästa',
	'type' => 'array',
	'end_size' => 3,
	'mid_size' => 3
));
$page_links = paginate_links($data_page);

$load_more = str_replace( '%#%', 2, $data_page['base'] );

if (count($page_links) == 0) return;
$links = "<ul class='pagination'>\n\t<li>";
$links .= join("</li>\n\t<li>", $page_links);
$links .= "</li>\n</ul>\n";
$load_more = isset($_POST['pagination']) ? isset($_POST['pagination']) : '';
if ( $load_more != 'load_more' ):

?>
<div class="woocommerce-pagination">
	<?php
	if ( $yolo_options['archive_product_style'] == 'style_2' || ( $yolo_options['archive_product_style'] == 'style_1' && !$yolo_options['yolo_ajax_filter'] ) ) {
		echo wp_kses_post($links);
	} else {
		echo '<a class="yolo-shop-loadmore" href="' . $load_more . '" data-page="2" data-link="' . $data_page['base'] . '" data-totalpage="' . $data_page['total'] . '">'. esc_html__( 'Load more', 'yolo-motor' ) .'</a>';
	}

	?>

</div>
<?php endif;?>



