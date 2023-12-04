<?php

// Get the functions from the theme
require_once "theme-functions.php";

// Get our functions
require_once "wisewebs-functions.php";

error_reporting( E_ALL ^ E_DEPRECATED );

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