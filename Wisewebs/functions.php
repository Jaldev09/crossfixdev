<?php

// Get the functions from the theme
require_once "theme-functions.php";

// Get our functions
require_once "wisewebs-functions.php";

error_reporting( E_ALL ^ E_DEPRECATED );

function crossfix_enqueue_scripts() {
	/**
	 * frontend ajax requests.
	 */
	wp_enqueue_script( 'frontend-ajax', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), null, true );
	wp_localize_script( 'frontend-ajax', 'frontend_ajax_object',
		array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'mittfordon_url' => wc_get_account_endpoint_url('mitt-fordon')
		)
	);
}
add_action( 'wp_enqueue_scripts', 'crossfix_enqueue_scripts' );

/**
 * Revert Woo 3's HTML structure to the theme's variant. Doesn't seem to be a
 * filter for this so we'll need to do it outside of our namespaced files, i.e.
 * here...
 */
function woocommerce_template_loop_product_title()
{
	echo '<h3 class="woocommerce-loop-product__title" title="' . htmlspecialchars( get_the_title(), ENT_QUOTES ) . '">' . get_the_title() . '</h3>';
}




acf_add_local_field_group(
	[
		'key'    => 'group_5ce263fb0eeff',
		'title'  => 'Mobilmeny',
		'fields' =>
		[
			[
				'key'               => 'field_5ce264c31da82',
				'label'             => 'Text under mobilmeny',
				'name'              => 'text_below_mobile_menu',
				'type'              => 'wysiwyg',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           =>
				[
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value' => '',
				'tabs'          => 'all',
				'toolbar'       => 'full',
				'media_upload'  => 0,
				'delay'         => 0,
			],
		],
		'location' =>
		[
			[
				[
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'acf-options-mobilmeny',
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
	]
);

function get_acf_cf7_object()
{
    return true;
}

add_filter( 'get_acf_cf7_object', 'get_acf_cf7_object' );

remove_action('woocommerce_before_shop_loop_item_title','yolo_woocomerce_template_loop_link',20);

add_filter(
	'woocommerce_get_breadcrumb',
	function( $crumbs, $breadcrumb )
	{
		// Get ID of shop page
		$shopPageId = wc_get_page_id( 'shop' );

		// If a shop page is found, we aren't on it at the moment, but are on a WooCommerce page
		if ( $shopPageId > 0 && ! is_shop() && is_woocommerce() )
		{
			// Insert after home
			array_splice(
				$crumbs,
				1,
				0,
				[
					[
						'Tillbehör',
						get_permalink( $shopPageId )
					],
				]
			);
		}

		return $crumbs;
	},
	10,
	2
);



// TEMPORARY FIX for Woo not showing "All orders"
if ( version_compare( get_option( 'woocommerce_version' ),'3.5.2', '<=' ) && version_compare( get_bloginfo( 'version' ),'5.0.2', '>=' ) )
{
	function fix_request_query_args_for_woocommerce( $query_args )
	{
		if ( is_admin() && isset( $query_args[ 'post_status' ] ) && empty( $query_args[ 'post_status' ] ) )
		{
    		unset( $query_args[ 'post_status' ] );
		}

    	return $query_args;
	}

    add_filter( 'request', 'fix_request_query_args_for_woocommerce', 1, 1 );
}



// TEMPORARY FIX for Klarna checkout not translating coupon code text
add_filter(
	'woocommerce_cart_totals_coupon_label',
	function( $html )
	{
		$html = str_ireplace(
			'Coupon',
			'Rabattkod',
			$html
		);

		return $html;
	}
);



// TEMPORARY FIX for Klarna checkout not translating coupon code text
add_filter(
	'woocommerce_coupon_message',
	function( $html )
	{
		$html = str_ireplace(
			'Coupon code applied successfully',
			'Rabattkoden tillagd',
			$html
		);

		$html = str_ireplace(
			'Coupon code removed successfully',
			'Rabattkoden togs bort',
			$html
		);

		return $html;
	}
);



add_filter(
	'woocommerce_show_admin_notice',
	function( $bool, $notice )
	{
		if ( 'template_files' === $notice )
		{
			$bool = false;
		}

		return $bool;
	},
	10,
	2
);

add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );



add_action( 'wp_footer', 'wpcf7ReplacementForDeprecatedOnSubmitOk' );

function wpcf7ReplacementForDeprecatedOnSubmitOk() {
?>
	<script type="text/javascript">
		document.addEventListener( 'wpcf7mailsent', function( event ) {
			gtag('event', 'conversion', {'send_to': 'AW-784523663/cFrbCPOEp4sBEI_Di_YC'});
		}, false );
	</script>
<?php
}


add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'custom_order_item_get_formatted_meta_data', 10, 1 );

function custom_order_item_get_formatted_meta_data( $formatted_meta )
{
	$temp_metas = [];

	foreach( $formatted_meta as $key => $meta )
	{
		if ( isset( $meta->key ) && ! in_array( $meta->key, [ 'order_item_notation' ] ) )
		{
			$temp_metas[ $key ] = $meta;
		}
	}

	return $temp_metas;
}

/** New feature implementation start */

// Register Customer Vehicles Post Type
function register_customer_vehicle_post_type() {

	$labels = array(
		'name'                  => _x( 'Customer Vehicles', 'Customer Vehicles', 'crossfix' ),
		'singular_name'         => _x( 'Customer Vehicle', 'Customer Vehicle ', 'crossfix' ),
		'menu_name'             => __( 'Customer Vehicles', 'crossfix' ),
		'name_admin_bar'        => __( 'Customer Vehicles', 'crossfix' ),
		'archives'              => __( 'Item Archives', 'crossfix' ),
		'attributes'            => __( 'Item Attributes', 'crossfix' ),
		'parent_item_colon'     => __( 'Parent Item:', 'crossfix' ),
		'all_items'             => __( 'Customer Vehicles', 'crossfix' ),
		'add_new_item'          => __( 'Add New Vehicle', 'crossfix' ),
		'add_new'               => __( 'Add New Vehicle', 'crossfix' ),
		'new_item'              => __( 'New Item', 'crossfix' ),
		'edit_item'             => __( 'Edit Item', 'crossfix' ),
		'update_item'           => __( 'Update Item', 'crossfix' ),
		'view_item'             => __( 'View Item', 'crossfix' ),
		'view_items'            => __( 'View Items', 'crossfix' ),
		'search_items'          => __( 'Search Item', 'crossfix' ),
		'not_found'             => __( 'Not found', 'crossfix' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'crossfix' ),
		'featured_image'        => __( 'Featured Image', 'crossfix' ),
		'set_featured_image'    => __( 'Set featured image', 'crossfix' ),
		'remove_featured_image' => __( 'Remove featured image', 'crossfix' ),
		'use_featured_image'    => __( 'Use as featured image', 'crossfix' ),
		'insert_into_item'      => __( 'Insert into item', 'crossfix' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'crossfix' ),
		'items_list'            => __( 'Items list', 'crossfix' ),
		'items_list_navigation' => __( 'Items list navigation', 'crossfix' ),
		'filter_items_list'     => __( 'Filter items list', 'crossfix' ),
	);
	$args = array(
		'label'                 => __( 'Customer Vehicles', 'crossfix' ),
		'description'           => __( 'Post Type Description', 'crossfix' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'thumbnail'),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'show_in_rest' 			=> true,
		'capability_type'       => 'page',
		'menu_icon'           	=> 'dashicons-groups',
	);
	register_post_type( 'customer-vehicle', $args );

}
add_action( 'init', 'register_customer_vehicle_post_type', 0 );

// Register Crossfix Maskins Post Type
function register_corssfix_machine_post_type() {

	$labels = array(
		'name'                  => _x( 'Crossfix Maskin', 'Crossfix Maskins', 'crossfix' ),
		'singular_name'         => _x( 'Crossfix Maskin', 'Crossfix Maskin ', 'crossfix' ),
		'menu_name'             => __( 'Crossfix Maskins', 'crossfix' ),
		'name_admin_bar'        => __( 'Crossfix Maskins', 'crossfix' ),
		'archives'              => __( 'Item Archives', 'crossfix' ),
		'attributes'            => __( 'Item Attributes', 'crossfix' ),
		'parent_item_colon'     => __( 'Parent Item:', 'crossfix' ),
		'all_items'             => __( 'Crossfix Maskins', 'crossfix' ),
		'add_new_item'          => __( 'Add New Maskin', 'crossfix' ),
		'add_new'               => __( 'Add New Maskin', 'crossfix' ),
		'new_item'              => __( 'New Item', 'crossfix' ),
		'edit_item'             => __( 'Edit Item', 'crossfix' ),
		'update_item'           => __( 'Update Item', 'crossfix' ),
		'view_item'             => __( 'View Item', 'crossfix' ),
		'view_items'            => __( 'View Items', 'crossfix' ),
		'search_items'          => __( 'Search Item', 'crossfix' ),
		'not_found'             => __( 'Not found', 'crossfix' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'crossfix' ),
		'featured_image'        => __( 'Featured Image', 'crossfix' ),
		'set_featured_image'    => __( 'Set featured image', 'crossfix' ),
		'remove_featured_image' => __( 'Remove featured image', 'crossfix' ),
		'use_featured_image'    => __( 'Use as featured image', 'crossfix' ),
		'insert_into_item'      => __( 'Insert into item', 'crossfix' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'crossfix' ),
		'items_list'            => __( 'Items list', 'crossfix' ),
		'items_list_navigation' => __( 'Items list navigation', 'crossfix' ),
		'filter_items_list'     => __( 'Filter items list', 'crossfix' ),
	);
	$args = array(
		'label'                 => __( 'Crossfix Maskins', 'crossfix' ),
		'description'           => __( 'Post Type Description', 'crossfix' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'thumbnail'),
		'taxonomies'            => array( 'maskin-brand','maskin-modell','maskin-arsmodell' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'show_in_rest' 			=> true,
		'capability_type'       => 'page',
		'menu_icon'           	=> 'dashicons-performance',
	);
	register_post_type( 'crossfix-maskin', $args );

}
add_action( 'init', 'register_corssfix_machine_post_type', 0 );

// Register Custom Taxonomy
function maskin_brand() {

	$labels = array(
		'name'                       => _x( 'Märke', 'Märke General Name', 'poka' ),
		'singular_name'              => _x( 'Märke', 'Märke Singular Name', 'poka' ),
		'menu_name'                  => __( 'Märke', 'poka' ),
		'all_items'                  => __( 'Casinos', 'poka' ),
		'parent_item'                => __( 'Parent Item', 'poka' ),
		'parent_item_colon'          => __( 'Parent Item:', 'poka' ),
		'new_item_name'              => __( 'New Item Name', 'poka' ),
		'add_new_item'               => __( 'Add New Item', 'poka' ),
		'edit_item'                  => __( 'Edit Item', 'poka' ),
		'update_item'                => __( 'Update Item', 'poka' ),
		'view_item'                  => __( 'View Item', 'poka' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'poka' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'poka' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'poka' ),
		'popular_items'              => __( 'Popular Items', 'poka' ),
		'search_items'               => __( 'Search Items', 'poka' ),
		'not_found'                  => __( 'Not Found', 'poka' ),
		'no_terms'                   => __( 'No items', 'poka' ),
		'items_list'                 => __( 'Items list', 'poka' ),
		'items_list_navigation'      => __( 'Items list navigation', 'poka' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'maskin-brand', array( 'crossfix-maskin' ), $args );

}
add_action( 'init', 'maskin_brand', 0 );

// Register Custom Taxonomy
function maskin_modell() {

	$labels = array(
		'name'                       => _x( 'Modell', 'Modell General Name', 'poka' ),
		'singular_name'              => _x( 'Modell', 'Modell Singular Name', 'poka' ),
		'menu_name'                  => __( 'Modell', 'poka' ),
		'all_items'                  => __( 'Casinos', 'poka' ),
		'parent_item'                => __( 'Parent Item', 'poka' ),
		'parent_item_colon'          => __( 'Parent Item:', 'poka' ),
		'new_item_name'              => __( 'New Item Name', 'poka' ),
		'add_new_item'               => __( 'Add New Item', 'poka' ),
		'edit_item'                  => __( 'Edit Item', 'poka' ),
		'update_item'                => __( 'Update Item', 'poka' ),
		'view_item'                  => __( 'View Item', 'poka' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'poka' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'poka' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'poka' ),
		'popular_items'              => __( 'Popular Items', 'poka' ),
		'search_items'               => __( 'Search Items', 'poka' ),
		'not_found'                  => __( 'Not Found', 'poka' ),
		'no_terms'                   => __( 'No items', 'poka' ),
		'items_list'                 => __( 'Items list', 'poka' ),
		'items_list_navigation'      => __( 'Items list navigation', 'poka' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'maskin-modell', array( 'crossfix-maskin' ), $args );

}
add_action( 'init', 'maskin_modell', 0 );

// Register Custom Taxonomy
function maskin_arsmodell() {

	$labels = array(
		'name'                       => _x( 'Årsmodell', 'Årsmodell General Name', 'poka' ),
		'singular_name'              => _x( 'Årsmodell', 'Årsmodell Singular Name', 'poka' ),
		'menu_name'                  => __( 'Årsmodell', 'poka' ),
		'all_items'                  => __( 'Casinos', 'poka' ),
		'parent_item'                => __( 'Parent Item', 'poka' ),
		'parent_item_colon'          => __( 'Parent Item:', 'poka' ),
		'new_item_name'              => __( 'New Item Name', 'poka' ),
		'add_new_item'               => __( 'Add New Item', 'poka' ),
		'edit_item'                  => __( 'Edit Item', 'poka' ),
		'update_item'                => __( 'Update Item', 'poka' ),
		'view_item'                  => __( 'View Item', 'poka' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'poka' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'poka' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'poka' ),
		'popular_items'              => __( 'Popular Items', 'poka' ),
		'search_items'               => __( 'Search Items', 'poka' ),
		'not_found'                  => __( 'Not Found', 'poka' ),
		'no_terms'                   => __( 'No items', 'poka' ),
		'items_list'                 => __( 'Items list', 'poka' ),
		'items_list_navigation'      => __( 'Items list navigation', 'poka' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'maskin-arsmodell', array( 'crossfix-maskin' ), $args );

}
add_action( 'init', 'maskin_arsmodell', 0 );

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Woocommerce Custom Settings',
        'menu_title'    => 'Woocommerce Custom Settings',
        'menu_slug'     => 'woo-custom-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));    

}

add_filter( 'woocommerce_get_price_html', 'change_displayed_sale_price_html', 10, 2 );
function change_displayed_sale_price_html( $price, $product ) {
    // Only on sale products on frontend and excluding min/max price on variable products
    if( $product->is_on_sale() && ! is_admin() && ! $product->is_type('variable')){
        // Get product prices
        $regular_price = (float) $product->get_regular_price(); // Regular price
        $sale_price = (float) $product->get_price(); // Active price (the "Sale price" when on-sale)

        // "Saving price" calculation and formatting
        $saving_price = wc_price( $regular_price - $sale_price );

        // "Saving Percentage" calculation and formatting
        $precision = 1; // Max number of decimals
        $saving_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';

        // Append to the formated html price
        $price .= sprintf( __('<p class="saved-amount">Spara: %s </p>', 'woocommerce' ), $saving_price);
    }
    return $price;
}

// Remove the "Description" tab
add_filter('woocommerce_product_tabs', 'remove_product_description_tab', 98);

function remove_product_description_tab($tabs) {
    unset($tabs['description']);
    return $tabs;
}

// Customize the display of related products
add_filter('woocommerce_output_related_products', 'custom_related_products_output', 20);

function custom_related_products_output() {
    $related_products = wc_get_related_products(get_the_ID(), 4); // Adjust the number as needed

    if (count($related_products) > 0) {
        echo '<div class="related-products">';
        echo '<h2>Related Products</h2>';
        echo '<ul class="products">';
        
        foreach ($related_products as $related_product_id) {
            $related_product = wc_get_product($related_product_id);
            echo '<li class="product">';
            echo '<a href="' . esc_url(get_permalink($related_product_id)) . '">';
            echo $related_product->get_image();
            echo '<h3>' . esc_html($related_product->get_title()) . '</h3>';
            echo '</a>';
            echo '</li>';
        }
        
        echo '</ul>';
        echo '</div>';
    }
}

/**
 * @snippet       WooCommerce Add New Tab @ My Account
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 5.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
  
// ------------------
// 1. Register new endpoint (URL) for My Account page
// Note: Re-save Permalinks or it will give 404 error
function bbloomer_add_premium_support_endpoint() {
    add_rewrite_endpoint( 'mitt-fordon', EP_ROOT | EP_PAGES );
} 
add_action( 'init', 'bbloomer_add_premium_support_endpoint' );

function bbloomer_add_vehicle_support_endpoint() {
    add_rewrite_endpoint( 'lagg-till-fordon', EP_ROOT | EP_PAGES );
} 
add_action( 'init', 'bbloomer_add_vehicle_support_endpoint' );

function bbloomer_update_vehicle_support_endpoint() {
    add_rewrite_endpoint( 'uppdatera-fordonet', EP_ROOT | EP_PAGES );
} 
add_action( 'init', 'bbloomer_update_vehicle_support_endpoint' );

function bbloomer_crosssell_accessories_support_endpoint() {
    add_rewrite_endpoint( 'relaterade-tillbehör', EP_ROOT | EP_PAGES );
} 
add_action( 'init', 'bbloomer_crosssell_accessories_support_endpoint' );
  
// ------------------
// 2. Add new query var
  
function bbloomer_premium_support_query_vars( $vars ) {
    $vars[] = 'mitt-fordon';
    return $vars;
} 
add_filter( 'query_vars', 'bbloomer_premium_support_query_vars', 0 );

function bbloomer_add_vehicle_query_vars( $vars ) {
    $vars[] = 'lagg-till-fordon';
    return $vars;
} 
add_filter( 'query_vars', 'bbloomer_add_vehicle_query_vars', 0 );

function bbloomer_update_vehicle_query_vars( $vars ) {
    $vars[] = 'uppdatera-fordonet';
    return $vars;
} 
add_filter( 'query_vars', 'bbloomer_update_vehicle_query_vars', 0 );


function bbloomer_crosssell_accessories_query_vars( $vars ) {
    $vars[] = 'relaterade-tillbehör';
    return $vars;
} 
add_filter( 'query_vars', 'bbloomer_crosssell_accessories_query_vars', 0 );
  
// ------------------
// 3. Insert the new endpoint into the My Account menu
function bbloomer_add_premium_support_link_my_account( $items ) {

	$logout_link = $items ['customer-logout'];
	$orders_link = $items['orders'];
	$downloads_link = $items['downloads'];
	$edit_address_link = $items['edit-address'];
	$edit_acc_link = $items['edit-account'];
	
	unset( $items ['dashboard'] );
	unset( $items ['customer-logout'] );
    unset( $items['orders'] );
	unset( $items['downloads'] );
	unset( $items['edit-address'] );
	unset( $items['edit-account'] );

    $items['mitt-fordon'] = 'Mitt fordon';
	$items['orders'] = $orders_link;
	$items['downloads'] = $downloads_link;
	$items['edit-address'] = $edit_address_link;
	$items['edit-account'] = $edit_acc_link;

	// Insert back the logout item.
	$items ['customer-logout'] = $logout_link;
	
    return $items;
} 
add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_premium_support_link_my_account' );
  
// ------------------
// 4. Add content to the new tab
function bbloomer_premium_support_content() {
   echo '<h3>Mitt fordon</h3>';
   $args = array(
		'post_type'      => 'customer-vehicle',
		'post_status'    => 'publish',
		'posts_per_page' => -1, // Ensure the value is an integer
		'author' => get_current_user_id()
	);
	$customer_vehicles_list = new WP_Query( $args );
?>
<div class="table-wrapper">
    <div class="table-title">
        <div class="row">
            <!-- <div class="col-sm-6">
				<h2>Manage <b>Employees</b></h2>
			</div> -->
            <div class="col-sm-6 add-more-machines">
                <a href="<?php echo wc_get_account_endpoint_url('lagg-till-fordon'); ?>" class="add-more-btn btn btn-success">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> <span>Lägg till fordon</span>
                </a>
                <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal">
                    <i class="fa fa-minus-circle" aria-hidden="true"></i> <span>Delete</span>
                </a> -->
            </div>
        </div>
    </div>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<?php if($customer_vehicles_list->have_posts()): ?>
			<thead>
				<tr>
					<th>Name</th>
					<th>Make</th>
					<th>Modell</th>
					<th>Year</th>
					<th>Machine</th>
				</tr>
			</thead>
			<?php endif; ?>
			<tbody>
				<?php 
				if($customer_vehicles_list->have_posts()): 
					while($customer_vehicles_list->have_posts()): $customer_vehicles_list->the_post();
					$customer_machine_id = get_the_ID();
					$make_id = get_field('vehicle_make',get_the_ID());
					$modell_id = get_field('vehicle_model',get_the_ID()); 
					$year_id = get_field('vehicle_modell_year',get_the_ID());
					$crossfix_machine_obj = get_field('vehicle_machine',get_the_ID());

					$make_name = !empty($make_id) ? (!empty(get_term( $make_id )) ? get_term( $make_id )->name : ' ' ) : '-';
					$modell_name = !empty($modell_id) ? (!empty(get_term( $modell_id )) ? get_term( $modell_id )->name : '') : '-';
					$year_name = !empty($year_id) ? (!empty(get_term( $year_id )) ? get_term( $year_id )->name : '') : '-';
					$crossfix_machine_name = !empty($crossfix_machine_obj) ? $crossfix_machine_obj->post_title : '';

					?>
				<tr class="">
					<td><?php echo get_the_title(); ?></td>
					<td><?php echo  $make_name; ?></td>
					<td><?php echo 	$modell_name; ?></td>
					<td><?php echo  $year_name; ?></td>
					<td><?php echo  $crossfix_machine_name; ?></td>
					<td><a href="<?php echo wc_get_account_endpoint_url('uppdatera-fordonet').'?edit='.$customer_machine_id; ?>">Edit</a></td>
					<td><a href="javaScript:void(0);" data-del_customerid="<?php echo $customer_machine_id; ?>" class="delete-customer-vehicle" id="delete_customer_vehicle">Delete</a></td>
				</tr>
				<?php endwhile; wp_reset_query(); 
					else: ?>
				<tr class="no-vehicles">
					<td>There is no vehicle added yet.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
<?php 
$accessories_card_title = get_field('accessories_card_title','options');
$book_service_title = get_field('book_service_title','options');
$book_storage_title = get_field('book_storage_title','options');
$sell_machine_title = get_field('sell_machine_title','options');	

$accessories_shortcode = get_field('accessories_shortcode','options');
$service_form_shortcode = get_field('service_form_shortcode','options');
$storage_form_shortcode = get_field('storage_form_shortcode','options');
$selling_machine_shortcode = get_field('selling_machine_shortcode','options');
?>
<div class="how-can-help-wrapper">
	<h2 class="section-heading">Hur kan vi hjälpa dig idag?</h2>
	<div class="help-options-wrapper">
		<?php if(!empty($accessories_shortcode)): ?>
		<div class="help-option help-option-card" data-target="machine_accessories_form">
			<div class="option-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/plus-sign.svg" alt="plus-sign">
			</div>
			<p class="option-title"><?php echo $accessories_card_title; ?></p>
		</div>
		<?php endif; ?>
		<?php if(!empty($service_form_shortcode)): ?>
		<div class="help-option help-option-card" data-target="book_service_form">
			<div class="option-icon">
				<img src="<?php echo get_template_directory_uri().'/assets/img/setting-service.svg'; ?>"
					alt="setting-service">
			</div>
			<p class="option-title"><?php echo $book_service_title; ?></p>
		</div>
		<?php endif; ?>
		<?php if(!empty($storage_form_shortcode)): ?>
		<div class="help-option help-option-card" data-target="book_storage_form">
			<div class="option-icon">
				<img src="<?php echo get_template_directory_uri().'/assets/img/storage.svg'; ?>" alt="storage">
			</div>
			<p class="option-title"><?php echo $book_storage_title; ?></p>
		</div>
		<?php endif; ?>
		<?php if(!empty($selling_machine_shortcode)): ?>
		<div class="help-option help-option-card" data-target="sell_machine_form">
			<div class="option-icon">
				<img src="<?php echo get_template_directory_uri().'/assets/img/sell-machine.svg'; ?>"
					alt="sell-machine">
			</div>
			<p class="option-title"><?php echo $sell_machine_title; ?></p>
		</div>
		<?php endif; ?>
	</div>
	<div class="add-more-machines">
		<a href="<?php echo wc_get_account_endpoint_url('lagg-till-fordon'); ?>" class="add-more-btn">Lägg till fler maskiner</a>
	</div>
</div>
<?php
} 
add_action( 'woocommerce_account_mitt-fordon_endpoint', 'bbloomer_premium_support_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format

function bbloomer_add_vehicle_content() {
	ob_start();
	?>
	<div class="your-machines-wrapper">
		<h3 class="mb-2 common-title">Din maskin</h3>
		<p class="common-description">För att ge dig BÄSTA service och matchning av tillbehör kan du lägga till din maskin.
		</p>
		<form class='add-vehicle-form' id='add_vehicle_form' enctype="multipart/form-data">
			<div class="form-group">
				<label for="vehicle_name">Vehicle Name</label>
				<input type='text' name='vehiclename' class='vehicle-form-input' id='vehicle_name'
					placeholder='Vehicle Name'>
			</div>
			<div class="form-group">
				<label for="vehicle_description">Vehicle Description</label>
				<textarea name='vehicledesc' class='vehicle-form-textarea' id='vehicle_description' rows='4' cols='50'
					placeholder='Vehicle description'></textarea>
			</div>
			<div class="form-group">
				<label for="upload_image">Vehicle Image</label>
				<span class="upload-image-input"><input type='file' name='upload_image' id='upload_image'></span>
			</div>
			<?php 
				echo do_shortcode('[crossfix-machine-accessories-form display_heading="false"]'); //crossfix-machine-accessories-form 
				wp_nonce_field( 'custom-add-vehicle-nonce', 'security' );
				?>
			<div class="form-group vehicle-form-btngrp">
				<input type='submit' class='submitformbtn button button-primary button-large' id='add_cus_vehicle_form'
					value='Spara fordon'>
				<span class="form-ajax-loader" style="display:none;"></span>
			</div>
		</form>
		<span class="addvehicle-form-response"></span>
	</div>
<?php 
	
	$accessories_card_title = get_field('accessories_card_title','options');
	$book_service_title = get_field('book_service_title','options');
	$book_storage_title = get_field('book_storage_title','options');
	$sell_machine_title = get_field('sell_machine_title','options');	

	$accessories_shortcode = get_field('accessories_shortcode','options');
	$service_form_shortcode = get_field('service_form_shortcode','options');
	$storage_form_shortcode = get_field('storage_form_shortcode','options');
	$selling_machine_shortcode = get_field('selling_machine_shortcode','options');
	?>
	<div class="how-can-help-wrapper">
		<h2 class="section-heading">Hur kan vi hjälpa dig idag?</h2>
		<div class="help-options-wrapper">
			<?php if(!empty($accessories_shortcode)): ?>
			<div class="help-option help-option-card" data-target="machine_accessories_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/plus-sign.svg" alt="plus-sign">
				</div>
				<p class="option-title"><?php echo $accessories_card_title; ?></p>
			</div>
			<?php endif; ?>
			<?php if(!empty($service_form_shortcode)): ?>
			<div class="help-option help-option-card" data-target="book_service_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri().'/assets/img/setting-service.svg'; ?>"
						alt="setting-service">
				</div>
				<p class="option-title"><?php echo $book_service_title; ?></p>
			</div>
			<?php endif; ?>
			<?php if(!empty($storage_form_shortcode)): ?>
			<div class="help-option help-option-card" data-target="book_storage_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri().'/assets/img/storage.svg'; ?>" alt="storage">
				</div>
				<p class="option-title"><?php echo $book_storage_title; ?></p>
			</div>
			<?php endif; ?>
			<?php if(!empty($selling_machine_shortcode)): ?>
			<div class="help-option help-option-card" data-target="sell_machine_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri().'/assets/img/sell-machine.svg'; ?>"
						alt="sell-machine">
				</div>
				<p class="option-title"><?php echo $sell_machine_title; ?></p>
			</div>
			<?php endif; ?>
		</div>
		<div class="add-more-machines">
			<a href="<?php echo wc_get_account_endpoint_url('lagg-till-fordon'); ?>" class="add-more-btn">Lägg till fler maskiner</a>
		</div>
	</div>
<?php
	echo ob_get_clean();
}
add_action( 'woocommerce_account_lagg-till-fordon_endpoint', 'bbloomer_add_vehicle_content' );

function bbloomer_update_vehicle_content() {
	$machine_id = $_GET['edit'];
	
	ob_start();
	?>
	<div class="your-machines-wrapper">
		<h3 class="mb-2 common-title">Din maskin</h3>
		<p class="common-description">För att ge dig BÄSTA service och matchning av tillbehör kan du lägga till din maskin.
		</p>
		<form class='add-vehicle-form' id='update_vehicle_form' enctype="multipart/form-data">
			<div class="form-group">
				<label for="vehicle_name">Vehicle Name</label>
				<input type='text' name='vehiclename' class='vehicle-form-input' id='vehicle_name'
					placeholder='Vehicle Name' value="<?php echo get_the_title($machine_id); ?>">
			</div>
			<div class="form-group">
				<label for="vehicle_description">Vehicle Description</label>
				<textarea name='vehicledesc' class='vehicle-form-textarea' id='vehicle_description' rows='4' cols='50'
					placeholder='Vehicle description'><?php echo get_field('about_vehicle',$machine_id); ?></textarea>
			</div>
			<div class="form-group">
				<label for="upload_image">Vehicle Image</label>
				<span class="upload-image-input"><input type='file' name='upload_image' id='upload_image'></span>
				<?php if ( has_post_thumbnail($machine_id) ):?>
				<div>
					<?php 
						the_post_thumbnail();
					?>
				</div>
				<?php endif; ?>
			</div>
			<?php 
				echo do_shortcode('[crossfix-machine-accessories-form edit_machine_id='.$machine_id.' display_heading="false"]'); //crossfix-machine-accessories-form 
				wp_nonce_field( 'custom-update-vehicle-nonce', 'security' );
				?>
			<div class="form-group vehicle-form-btngrp">
				<input type="hidden" name="customer-machineid" value="<?php echo $machine_id; ?>" id="update_customer_machineid"> 
				<input type='submit' class='submitformbtn button button-primary button-large' id='update_cus_vehicle_form'
					value='Uppdatera fordon'>
				<span class="form-ajax-loader" style="display:none;"></span>
			</div>
		</form>
		<span class="addvehicle-form-response"></span>
	</div>
<?php 
	
	$accessories_card_title = get_field('accessories_card_title','options');
	$book_service_title = get_field('book_service_title','options');
	$book_storage_title = get_field('book_storage_title','options');
	$sell_machine_title = get_field('sell_machine_title','options');	

	$accessories_shortcode = get_field('accessories_shortcode','options');
	$service_form_shortcode = get_field('service_form_shortcode','options');
	$storage_form_shortcode = get_field('storage_form_shortcode','options');
	$selling_machine_shortcode = get_field('selling_machine_shortcode','options');
	?>
	<div class="how-can-help-wrapper">
		<h2 class="section-heading">Hur kan vi hjälpa dig idag?</h2>
		<div class="help-options-wrapper">
			<?php if(!empty($accessories_shortcode)): ?>
			<div class="help-option help-option-card" data-target="machine_accessories_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/plus-sign.svg" alt="plus-sign">
				</div>
				<p class="option-title"><?php echo $accessories_card_title; ?></p>
			</div>
			<?php endif; ?>
			<?php if(!empty($service_form_shortcode)): ?>
			<div class="help-option help-option-card" data-target="book_service_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri().'/assets/img/setting-service.svg'; ?>"
						alt="setting-service">
				</div>
				<p class="option-title"><?php echo $book_service_title; ?></p>
			</div>
			<?php endif; ?>
			<?php if(!empty($storage_form_shortcode)): ?>
			<div class="help-option help-option-card" data-target="book_storage_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri().'/assets/img/storage.svg'; ?>" alt="storage">
				</div>
				<p class="option-title"><?php echo $book_storage_title; ?></p>
			</div>
			<?php endif; ?>
			<?php if(!empty($selling_machine_shortcode)): ?>
			<div class="help-option help-option-card" data-target="sell_machine_form">
				<div class="option-icon">
					<img src="<?php echo get_template_directory_uri().'/assets/img/sell-machine.svg'; ?>"
						alt="sell-machine">
				</div>
				<p class="option-title"><?php echo $sell_machine_title; ?></p>
			</div>
			<?php endif; ?>
		</div>
		<div class="add-more-machines">
			<a href="<?php echo wc_get_account_endpoint_url('lagg-till-fordon'); ?>" class="add-more-btn">Lägg till fler maskiner</a>
		</div>
	</div>
<?php
	echo ob_get_clean();
}
add_action( 'woocommerce_account_uppdatera-fordonet_endpoint', 'bbloomer_update_vehicle_content' );

function bbloomer_crosssell_accessories_content() {
	$customer_vehicle_id = $_GET['id'];
	$vehicle_make = get_field('vehicle_make',$customer_vehicle_id);
	$vehicle_modell = get_field('vehicle_model',$customer_vehicle_id);
	$vehicle_year = get_field('vehicle_modell_year',$customer_vehicle_id);
	$crossfix_machine_id = get_field('vehicle_machine',$customer_vehicle_id);

	$machine_manufacturing_details = get_field('manufacturing_details',$crossfix_machine_id);
	
	$unique_productids = array();

	if(!empty($machine_manufacturing_details)){
		foreach ($machine_manufacturing_details as $item) {
			if($item['machine_marke'] == $vehicle_make && $item['machine_modell'] == $vehicle_modell && $item['machine_arsmodell'] == $vehicle_year && !empty($item['cross_sell_product'])) {
				$unique_productids[] = array_values($item['cross_sell_product']);
			}
		}
		$unique_productids_data = array_unique($unique_productids, SORT_REGULAR);
		$unique_productids_data = array_values($unique_productids_data);
	}

	// Initialize an empty array to store extracted values
	$extractedValues = array();

	// Loop through each sub-array and extract values
	foreach ($unique_productids_data as $subArray) {
		foreach ($subArray as $value) {
			$extractedValues[] = $value;
		}
	}

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish'
	);

	if(!empty($extractedValues)) {
		$args['post__in'] = $extractedValues;
		$args['posts_per_page'] = -1;
	} else {
		$args['tax_query'] 	 =  array(
			array(
				'taxonomy' => 'product_cat',
				'field'	   => 'term_id',
				'terms'    => $vehicle_modell
			)
		);
		$args['posts_per_page'] = 10;
	}
	
	$related_products = new WP_Query( $args );
	
	ob_start();
	?>
	<div class="myvehicle-heading-wrap">
		<div class="myvehicle-span-round">
			<span class="tillbaka-text">Tillbaka</span>
		</div>
		<?php if ( has_post_thumbnail( $customer_vehicle_id ) ) { ?>
		<div class="myvehicle-img">
			<?php echo get_the_post_thumbnail( $customer_vehicle_id, 'thumbnail' ); ?>
		</div>
		<?php } ?>
		<div class="myvehicle-title">
			<h1><?php echo get_the_title($customer_vehicle_id); ?></h1>
		</div>
	</div>

	<div class="tillbaka-product-listing">
		<h3 class="mb-2 common-title">Tillbehör som passar din maskin</h3>
		<?php if($related_products->have_posts()): ?>
		<div class="row" >
			<?php while($related_products->have_posts()): $related_products->the_post(); 
			$pro_id = get_the_ID();
			$_product = wc_get_product( $pro_id );
			?>
			<div class="col-md-3 col-xs-6">
				<div class="tillbaka-product-item">
					<?php 
					if ( has_post_thumbnail( $pro_id ) ) { 
						?>
						<a href="<?php echo get_the_permalink($pro_id); ?>">
							<?php echo get_the_post_thumbnail( $pro_id, 'thumbnail' );  ?>
						</a>
						<?php
					} 
					?>
					<span class="tillbaka-product-price"><?php echo $_product->get_price().' '.get_woocommerce_currency_symbol(); ?></span>
					<a href="<?php echo get_the_permalink($pro_id); ?>">
						<h4 class="tillbaka-product-title"><?php echo get_the_title(); ?></h4>
					</a>
				</div>
			</div>
			<?php endwhile; wp_reset_query(); ?>
		</div>
		<?php else: ?>
			<div class="row"> 
				<p>Oops, no accessories found for this machine.</p>
			</div>
		<?php
		endif;
		?>
	</div>
	<?php
	echo ob_get_clean();
}
add_action( 'woocommerce_account_relaterade-tillbehör_endpoint', 'bbloomer_crosssell_accessories_content' );

add_filter( 'woocommerce_get_query_vars', function ( $query_vars ) {
    $query_vars['relaterade-tillbehör'] = 'relaterade-tillbehör/vehicle';
    return $query_vars;
} );

/**
 * Machine Accessories Form Shortcode
 */
if( ! function_exists( 'crossfix_machine_accessories_form_sc' ) ) {
	function crossfix_machine_accessories_form_sc($atts, $content = null) {
		extract(
			shortcode_atts(
				array(
					'display_heading' => 'true',
					'edit_machine_id' => ''
				),
				$atts
			)
		);

		$vehicle_make_id = $vehicle_modell_id = $vehicle_year_id = '';
		if($edit_machine_id != ''){
			$vehicle_make_id = get_field('vehicle_make',$edit_machine_id);
			$vehicle_modell_id = get_field('vehicle_model',$edit_machine_id);
			$vehicle_year_id = get_field('vehicle_modell_year',$edit_machine_id);
			$vehicle_machine_obj = get_field('vehicle_machine',$edit_machine_id);

			$crossfix_machine_args = array(
				'post_type' 	 => 'crossfix-maskin',
				'post_status' 	 => 'publish',
				'posts_per_page' => -1,
				'orderby'		 => 'date',
				'order'			 => 'ASC'
			);
		
			if(isset($vehicle_make_id) && !empty($vehicle_make_id)) {
				$crossfix_machine_args['tax_query'][] = array(
						'taxonomy' => 'maskin-brand',
						'field'			=> 'term_id',
						'terms' => array($vehicle_make_id),
						'operator' => 'IN',
				);
			}
		
			if(isset($vehicle_modell_id) && !empty($vehicle_modell_id)) {
				$crossfix_machine_args['tax_query'][] = array(
						'taxonomy' => 'maskin-modell',
						'field'			=> 'term_id',
						'terms' => array($vehicle_modell_id),
						'operator' => 'IN',
				);
			}
		
			if(isset($vehicle_year_id) && !empty($vehicle_year_id)) {
				$crossfix_machine_args['tax_query'][] = array(	
						'taxonomy' => 'maskin-arsmodell',
						'field'		=> 'term_id',
						'terms' => array($vehicle_year_id),
						'operator' => 'IN',
				);
			}
		
			if(!empty($crossfix_machine_args['tax_query'])) {
				$crossfix_machine_args['tax_query']['relation'] = 'AND';
			}		
			
			$crossfix_machine_query = new WP_Query($crossfix_machine_args);
			
		}
		$make_listing = get_terms(array('taxonomy'   => 'maskin-brand'));
		$modell_listing = get_terms(array('taxonomy'   => 'maskin-modell'));
		$year_listing = get_terms(array('taxonomy'   => 'maskin-arsmodell'));
		
		$select_dropdwon_html = '';
		$options = '';
		$select_dropdwon_html .= '<div class="col-xs-12">';
		$select_dropdwon_html .= '<div class="mmy-select-wrap">';
		
		if(!empty($make_listing)){
			$select_dropdwon_html .= '<label>Märke:</label>';
			$select_dropdwon_html .='<div class="select-option-item">';		
			$options = '<option value="">Select an option</option>';
			
			foreach($make_listing as $make){
				// Output the column heading as a label
				$selected = ($vehicle_make_id == $make->term_id) ? 'selected' : '';
				$options .= '<option value="' . $make->term_id . '" '.$selected.'>' . $make->name . '</option>';
			}
			// Output the dropdown
			$select_dropdwon_html .= '<select class="sheet-colunms make_dropdown" id="sheet_colunm_1" data-colunm="Make">' . $options . '</select>';
			
			$select_dropdwon_html .= '</div></div></div>';
		}
		ob_start();
		?>
		<?php if($display_heading == "true" ): ?>
		<h3 class="mb-2 common-title">Din maskin</h3>
		<p class="common-description">För att ge dig BÄSTA service och matchning av tillbehör kan du lägga till din maskin.
		</p>
		<?php endif; ?>
		<div class="select-options-wrapper">
			<div class="row">
				<?php echo $select_dropdwon_html; ?>
				<div class="col-xs-12">
					<div class="mmy-select-wrap">
						<label>Modell:</label>
						<div class="select-option-item">
							<select class="sheet-colunms modell_dropdown" id="sheet_colunm_2" data-colunm="Modell" disable>
								<option value="">Select an option</option>
								<?php 
								if(!empty($modell_listing)): 
									foreach($modell_listing as $modell_item): 
										$selected = ($vehicle_modell_id == $modell_item->term_id) ? "selected" : '';
									?>
									<option value="<?php echo $modell_item->term_id;?>" <?php echo $selected; ?>><?php echo $modell_item->name; ?></option>
									<?php 
									endforeach;
								endif; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="mmy-select-wrap">
						<label>Årsmodell:</label>
						<div class="select-option-item">
							<select class="sheet-colunms year_dropdown" id="sheet_colunm_3" data-colunm="Year" disable>
								<option value="">Select an option</option>
								<?php 
								if(!empty($year_listing)): 
									foreach($year_listing as $year_item): 
										$selected = ($vehicle_year_id == $year_item->term_id) ? "selected" : '';
									?>
									<option value="<?php echo $year_item->term_id;?>" <?php echo $selected; ?>><?php echo $year_item->name; ?></option>
									<?php 
									endforeach;
								endif; ?>
							</select>
						</div>
					</div>
				</div>
				<div class="col-xs-12">
					<div class="mmy-select-wrap">
						<label>Maskin:</label>
						<div class="select-option-item">
							<select class="sheet-colunms maskin_dropdown" id="sheet_colunm_4" data-colunm="Maskin" disable>
								<option value="">Select an option</option>
								<?php 
								if(isset($crossfix_machine_query) && $crossfix_machine_query->have_posts()): 
									$masking_options = '';
									while($crossfix_machine_query->have_posts()):
										$crossfix_machine_query->the_post();
										$machine_id = get_the_ID();
										$machine_title = get_the_title();
										// Output the column heading as a label
										$selected = ($vehicle_machine_obj->ID == $machine_id) ? 'selected' : '';
										$masking_options .= '<option value="' . $machine_id . '" '.$selected.'>' . $machine_title . '</option>';
									endwhile;
									echo $masking_options;
									wp_reset_query();
								endif; 
								?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		echo ob_get_clean();
	}
}
add_shortcode( 'crossfix-machine-accessories-form', 'crossfix_machine_accessories_form_sc' );

/**
 * Display Vehicles dropdown of Current logged in User  Shortcode
 */
if( ! function_exists( 'current_customer_vehicles_dropdown_sc' ) ) {
	function current_customer_vehicles_dropdown_sc( $atts, $content = null ) {
		$shortcode_attr = array(
			'id' => ''
		);
		extract(
			shortcode_atts(
				$shortcode_attr,
				$atts
			)
		);
		// Get current user info
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		$args = array(
			'post_type'      => 'customer-vehicle',
			'post_status'    => 'publish',
			'posts_per_page' => -1, // Ensure the value is an integer
			'author' => $user_id
		);
		$customer_vehicles_options = new WP_Query( $args );

		ob_start();
		if($customer_vehicles_options->have_posts()){
			echo '<div class="mmy-select-wrap cf7-mmy-select-wrap"><label>Select Vehicle:</label><div class="select-option-item">';
			echo "<select class='cf7-vehicle-list' id='".$id."'>";
			while($customer_vehicles_options->have_posts()){ $customer_vehicles_options->the_post();
				if(!empty(get_the_title())){
					echo "<option value='".get_the_ID()."|".get_the_title()."'>".get_the_title()."</option>";
				}
			}
			wp_reset_query(); 
			echo "</select></div></div>";
		}
		echo ob_get_clean();
	}
}
add_shortcode( 'customer-vehicles-dropdown', 'current_customer_vehicles_dropdown_sc' );

/**
 *  Manage crosssell accessories listing shortcode
 */
if( ! function_exists( 'show_cross_sell_product' ) ) {
	function show_cross_sell_product( $atts, $content = null ) {
		// Get current user info
		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;
		$args = array(
			'post_type'      => 'customer-vehicle',
			'post_status'    => 'publish',
			'posts_per_page' => -1, // Ensure the value is an integer
			'author' => $user_id
		);
		$customer_vehicles_options = new WP_Query( $args );

		ob_start();
		if($customer_vehicles_options->have_posts()){
			// echo '<form class="add-vehicle-form" id="cross_sell_product_form" enctype="multipart/form-data">';
			echo '<div class="mmy-select-wrap"><label>Select Vehicle:</label><div class="select-option-item">';
			echo "<select class='cf7-vehicle-list' id='show_accessories'>";
			while($customer_vehicles_options->have_posts()){ $customer_vehicles_options->the_post();
				if(!empty(get_the_title())){
					echo "<option value='".get_the_ID()."'>".get_the_title()."</option>";
				}
			} wp_reset_query(); 
			echo "</select></div></div>";
			echo '<div class="form-group">';
			// echo "<input type='submit' class='submitformbtn button button-primary button-large' id='cross_sell_product_submit'
			// 		value='Visa tillbehör'>";
			echo "<a href='".wc_get_account_endpoint_url('relaterade-tillbehör')."' class='show_accessories button button-primary button-large' id='show_accessories_link'>Visa tillbehor</a>";
			echo '</div>';
			// echo "</form>";
		}
		echo ob_get_clean();
	}
}
add_shortcode( 'show-cross-sell-product', 'show_cross_sell_product' );

add_action('wp_ajax_submit_add_vehicle', 'submit_add_vehicle');
add_action('wp_ajax_nopriv_submit_add_vehicle', 'submit_add_vehicle');

function submit_add_vehicle() {
    check_ajax_referer('custom-add-vehicle-nonce', 'security');

	$make = "";
	$model = "";
	$year = "";
	$machine = "";

	foreach($_POST as $post_key => $post_val){
		
		if("Make" == substr($post_key,14)){
			$make = $post_val;
		}  else if("Maskin" == substr($post_key,14)) {
			$machine = $post_val;
		} else if ("Year" == substr($post_key,14)) {
			$year = $post_val;
		} else if ("Modell" == substr($post_key,14)) {
			$model = $post_val;
		}
	}
	
    // Get current user info
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    // Gather form data
    $post_title = sanitize_text_field($_POST['post_title']);
    $post_description = wp_kses_post($_POST['post_description']);
    // $category = sanitize_text_field($_POST['category']);

    $file = $_FILES['upload_image'];

	// Check if file was uploaded
    if (!empty($file['name'])) {
        $file_return = wp_handle_upload($file, array('test_form' => false));

        if (isset($file_return['file'])) {
            $upload_file = $file_return['file'];
            $filename = basename($upload_file);
            $filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $upload_file);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
        }
    }
	
    // Prepare post data
    $post_data = array(
        'post_title' => $post_title,
        'post_status' => 'publish',
        'post_author' => $user_id,
        'post_type' => 'customer-vehicle' // Change the post type if needed
    );
	global $wpdb;
	$exist_machine_count = $wpdb->get_var("SELECT count(post_title) FROM $wpdb->posts WHERE post_title like '$post_title' AND post_type like 'customer-vehicle' AND post_author = '$user_id'");
	
	if($exist_machine_count > 0){
		$response = array(
            'message' => 'This machine is already exists in your account!',
			'status'  => false
        );
		wp_send_json($response);
		wp_die();
	}

    // Insert the post
    $post_id = wp_insert_post($post_data);

    if (!is_wp_error($post_id)) {
         // Set featured image
		 if (!empty($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
        }

		if(!empty($post_description)) {
			update_field('about_vehicle', $post_description, $post_id);
		}

		if(!empty($make)) {
			$select_make = sanitize_text_field($make);
			update_field('vehicle_make', $select_make, $post_id);
		}

		if(!empty($model)) {
			$selecte_model = sanitize_text_field($model);
			update_field('vehicle_model', $selecte_model, $post_id);
		}
		if(!empty($year)) {
			$select_year = sanitize_text_field($year);
			update_field('vehicle_modell_year', $select_year, $post_id);
		}
		if(!empty($machine)) {
			$selected_machine = sanitize_text_field($machine);
			update_field('vehicle_machine', $selected_machine, $post_id);
		}

		// Prepare response data
        $response = array(
            'message' => 'Vehicle added successfully!',
			'status'  => true
        );
		// Return success response as JSON
		wp_send_json($response);
    } else {
        // Return error response as JSON
        wp_send_json_error('Error in saving your data.');
    }
    wp_die();
}

add_action('wp_ajax_submit_update_vehicle', 'submit_update_vehicle');
add_action('wp_ajax_nopriv_submit_update_vehicle', 'submit_update_vehicle');

function submit_update_vehicle() {
    check_ajax_referer('custom-update-vehicle-nonce', 'security');

	$customer_vehicleid = $_POST['customer_vehicleid'];
	$make = "";
	$model = "";
	$year = "";
	$machine = "";

	foreach($_POST as $post_key => $post_val){
		
		if("Make" == substr($post_key,14)){
			$make = $post_val;
		}  else if("Maskin" == substr($post_key,14)) {
			$machine = $post_val;
		} else if ("Year" == substr($post_key,14)) {
			$year = $post_val;
		} else if ("Modell" == substr($post_key,14)) {
			$model = $post_val;
		}
	}
	
    // Get current user info
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    // Gather form data
    $post_title = sanitize_text_field($_POST['post_title']);
    $post_description = wp_kses_post($_POST['post_description']);
    // $category = sanitize_text_field($_POST['category']);

    $file = $_FILES['upload_image'];

	// Check if file was uploaded
    if (!empty($file['name'])) {
        $file_return = wp_handle_upload($file, array('test_form' => false));

        if (isset($file_return['file'])) {
            $upload_file = $file_return['file'];
            $filename = basename($upload_file);
            $filetype = wp_check_filetype($filename, null);
            $attachment = array(
                'post_mime_type' => $filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            $attachment_id = wp_insert_attachment($attachment, $upload_file);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attachment_data = wp_generate_attachment_metadata($attachment_id, $upload_file);
            wp_update_attachment_metadata($attachment_id, $attachment_data);
        }
    }
	
    // Prepare post data
    $post_data = array(
		'ID'         => $customer_vehicleid,
        'post_title' => $post_title,
        'post_status' => 'publish',
        'post_author' => $user_id,
        'post_type' => 'customer-vehicle' // Change the post type if needed
    );
	// global $wpdb;
	// $exist_machine_count = $wpdb->get_var("SELECT count(post_title) FROM $wpdb->posts WHERE post_title like '$post_title' AND post_type like 'customer-vehicle' AND post_author = '$user_id'");
	
	// if($exist_machine_count > 0){
	// 	$response = array(
    //         'message' => 'This machine is already exists in your account!',
	// 		'status'  => false
    //     );
	// 	wp_send_json($response);
	// 	wp_die();
	// }

    // Insert the post
    $post_id = wp_update_post($post_data);

    if (!is_wp_error($post_id)) {
         // Set featured image
		 if (!empty($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
        }

		if(!empty($post_description)) {
			update_field('about_vehicle', $post_description, $post_id);
		}

		if(!empty($make)) {
			$select_make = sanitize_text_field($make);
			update_field('vehicle_make', $select_make, $post_id);
		}

		if(!empty($model)) {
			$selecte_model = sanitize_text_field($model);
			update_field('vehicle_model', $selecte_model, $post_id);
		}
		if(!empty($year)) {
			$select_year = sanitize_text_field($year);
			update_field('vehicle_modell_year', $select_year, $post_id);
		}
		if(!empty($machine)) {
			$selected_machine = sanitize_text_field($machine);
			update_field('vehicle_machine', $selected_machine, $post_id);
		}

		// Prepare response data
        $response = array(
            'message' => 'Vehicle updated successfully!',
			'status'  => true
        );
		// Return success response as JSON
		wp_send_json($response);
    } else {
        // Return error response as JSON
        wp_send_json_error('Error in saving your data.');
    }
    wp_die();
}

add_action('wp_ajax_get_machine_make', 'get_machine_make');
add_action('wp_ajax_nopriv_get_machine_make', 'get_machine_make');
function get_machine_make() {
	$machine_id = wp_kses_post($_POST['machine_id']);
	$manufacturing_details = get_field('manufacturing_details',$machine_id);

	if(!empty($manufacturing_details)) {
		$unique_make = [];
		foreach ($manufacturing_details as $item) {
			$unique_make[] = [
				'make' => $item['machine_marke']
			];
		}
		$unique_make_data = array_unique($unique_make, SORT_REGULAR);
		$unique_make_data = array_values($unique_make_data);

		$make_select_dropdown = '<option value="">Select an option</option>';
		foreach($unique_make_data as $make_key => $make_val){
			$make_name = get_term( $make_val['make'] )->name;
			$make_select_dropdown .= '<option value='.$make_val['make'].'>'.$make_name.'</option>';
		}
	}

	if(!empty($make_select_dropdown)) {
		$response = array(
            'make_dropdown_html' => $make_select_dropdown,
			'status'  => true
        );
	} else {
		$response = array(
            'message' => 'There is no make available for this machine, try different',
			'status'  => false
        );
	}
	wp_send_json($response);

	wp_die();
}

add_action('wp_ajax_get_machine_modell', 'get_machine_modell');
add_action('wp_ajax_nopriv_get_machine_modell', 'get_machine_modell');
function get_machine_modell() {
	$machine_id = wp_kses_post($_POST['machine_id']);
	$make_id = wp_kses_post($_POST['make_id']);
	$manufacturing_details = get_field('manufacturing_details',$machine_id);

	if(!empty($manufacturing_details)) {
		$unique_modell = [];
		foreach ($manufacturing_details as $item) {
			$unique_modell[] = [
				'modell' => $item['machine_modell']
			];
		}
		$unique_modell_data = array_unique($unique_modell, SORT_REGULAR);
		$unique_modell_data = array_values($unique_modell_data);

		$modell_select_dropdown = '<option value="">Select an option</option>';
		foreach($unique_modell_data as $modell_key => $modell_val){
			$modell_name = get_term( $modell_val['modell'] )->name;
			$modell_select_dropdown .= '<option value='.$modell_val['modell'].'>'.$modell_name.'</option>';
		}
	}

	if(!empty($modell_select_dropdown)) {
		$response = array(
            'modell_dropdown_html' => $modell_select_dropdown,
			'status'  => true
        );
	} else {
		$response = array(
            'message' => 'There is no make available for this machine, try different',
			'status'  => false
        );
	}
	wp_send_json($response);

	wp_die();
}

add_action('wp_ajax_get_machine_year', 'get_machine_year');
add_action('wp_ajax_nopriv_get_machine_year', 'get_machine_year');
function get_machine_year() {
	$machine_id = wp_kses_post($_POST['machine_id']);
	$make_id = wp_kses_post($_POST['make_id']);
	$modell_id = wp_kses_post($_POST['modell_id']);
	$manufacturing_details = get_field('manufacturing_details',$machine_id);

	if(!empty($manufacturing_details)) {
		$unique_year = [];
		foreach ($manufacturing_details as $item) {
			$unique_year[] = [
				'year' => $item['machine_arsmodell']
			];
		}
		$unique_year_data = array_unique($unique_year, SORT_REGULAR);
		$unique_year_data = array_values($unique_year_data);

		$year_select_dropdown = '<option value="">Select an option</option>';
		foreach($unique_year_data as $year_key => $year_val){
			$year_name = get_term( $year_val['year'] )->name;
			$year_select_dropdown .= '<option value='.$year_val['year'].'>'.$year_name.'</option>';
		}
	}

	if(!empty($year_select_dropdown)) {
		$response = array(
            'year_dropdown_html' => $year_select_dropdown,
			'status'  => true
        );
	} else {
		$response = array(
            'message' => 'There is no year data available for this machine, try different machine',
			'status'  => false
        );
	}
	wp_send_json($response);

	wp_die();
}

add_action('wp_ajax_get_machine_from_make_model_year', 'get_machine_from_make_model_year');
add_action('wp_ajax_nopriv_get_machine_from_make_model_year', 'get_machine_from_make_model_year');
function get_machine_from_make_model_year() {
	$make_id = wp_kses_post($_POST['make_id']);
	$modell_id = wp_kses_post($_POST['modell_id']);
	$year_id = wp_kses_post($_POST['year_id']);

	$crossfix_mac_args = array(
		'post_type' 	 => 'crossfix-maskin',
		'post_status' 	 => 'publish',
		'posts_per_page' => -1,
		'orderby'		 => 'date',
		'order'			 => 'ASC'
	);

	if(isset($make_id) && !empty($make_id)) {
		$crossfix_mac_args['tax_query'][] = array(
				'taxonomy' => 'maskin-brand',
				'field'			=> 'term_id',
				'terms' => array($make_id),
				'operator' => 'IN',
		);
	}

	if(isset($modell_id) && !empty($modell_id)) {
		$crossfix_mac_args['tax_query'][] = array(
				'taxonomy' => 'maskin-modell',
				'field'			=> 'term_id',
				'terms' => array($modell_id),
				'operator' => 'IN',
		);
	}

	if(isset($year_id) && !empty($year_id)) {
		$crossfix_mac_args['tax_query'][] = array(	
				'taxonomy' => 'maskin-arsmodell',
				'field'		=> 'term_id',
				'terms' => array($year_id),
				'operator' => 'IN',
		);
	}

	if(!empty($crossfix_mac_args['tax_query'])) {
		$crossfix_mac_args['tax_query']['relation'] = 'AND';
	}

	
	$crossfix_mac_query = new WP_Query($crossfix_mac_args);

	$options = '';
	if($crossfix_mac_query->have_posts()){
		
		$options = '<option value="">Select an option</option>';
		$count = 0;
		while($crossfix_mac_query->have_posts()){
			$crossfix_mac_query->the_post();
			$machine_id = get_the_ID();
			$machine_title = get_the_title();
			// Output the column heading as a label
			$selected = ($count == 0) ? 'selected' : '';
			$options .= '<option value="' . $machine_id . '">' . $machine_title . '</option>';
			$count++;
		} 
		
		wp_reset_query();
		
	}
	if(!empty($options) && $crossfix_mac_query->have_posts() != 0) {
		$response = array(
			'machine_dropdown_html' => $options,
			'status'  => true
		);
	} else {
		$response = array(
			'message' => 'There is no machine available for this combination, try different',
			'status'  => false
		);
	}
	wp_send_json($response);

	wp_die();

	// $manufacturing_details = get_field('manufacturing_details',$machine_id);
}

add_action('wp_ajax_delete_customer_vehicle', 'delete_customer_vehicle');
add_action('wp_ajax_nopriv_delete_customer_vehicle', 'delete_customer_vehicle');
function delete_customer_vehicle() {
	$customer_vehicleid = $_POST['customer_vehicle_id'];
	$delete_response = wp_delete_post($customer_vehicleid,true);
	$response = '';

	if($delete_response){
		$response = array(
			'message' => 'Vehicle deleted successfully!',
			'status'  => true
		);
	} else {
		$response = array(
			'message' => 'There is some error, please try again later.',
			'status'  => true
		);
	}
	wp_send_json($response);
	wp_die();
}

function mycustom_wpcf7_form_elements( $form ) {
	$form = do_shortcode( $form );
	return $form;
}
add_filter( 'wpcf7_form_elements', 'mycustom_wpcf7_form_elements' );


add_filter('woocommerce_before_account_content', 'remove_account_panel_text');
function remove_account_panel_text() {
    remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 10);
}

add_filter('woocommerce_login_redirect', 'wc_login_redirect'); 
function wc_login_redirect( $redirect_to ) {
    if ( ! is_checkout()){
        $redirect_to = wc_get_account_endpoint_url('mitt-fordon');
        return $redirect_to;
    }
}

function get_product_by_sku( $sku ) {

    global $wpdb;

    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );
	
    if ( $product_id ) return $product_id;

    return null;
}

/** New feature implementation end */