<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */


// Prevent direct access to the file
if ( ! defined( 'ABSPATH' ) )
{
	die;
}

// Import relevant namespaces
use Wisewebs\Classes\Content;

// Header
get_header( 'shop' );

// Shop banner
get_template_part( 'modules/shop-banner/shop-banner' );

// If it isn't a category
if ( ! is_product_category() && ! is_search() )
{
	get_template_part( 'modules/breadcrumbs/breadcrumbs--woocommerce' );

	// Print the hero image
	Content\LargeHeroImage::output(
		[
			Content\LargeHeroImage::FIELD_HEADING         => get_field( 'spare_parts_title', wc_get_page_id( 'shop' ) ),
			'ingress'                                     => get_field( 'spare_parts_ingress', wc_get_page_id( 'shop' ) ),
			Content\LargeHeroImage::FIELD_IMAGE           => get_field( Content\LargeHeroImage::FIELD_IMAGE, wc_get_page_id( 'shop' ) ),
			Content\LargeHeroImage::FIELD_TONE_DOWN_IMAGE => ( bool ) get_field( Content\LargeHeroImage::FIELD_TONE_DOWN_IMAGE, wc_get_page_id( 'shop' ) ),
		]
	);
}

// Woocommerce message
get_template_part( 'modules/woocommerce-messages/woocommerce-messages' );

// If it's a category (and not shop root)
if ( is_product_category() )
{
	// Category information
	get_template_part( 'modules/category/category-information--woocommerce' );
}

// Don't show categories for search or page 2 and forwards
if ( ! is_search() && ! is_paged() )
{
	// Subcategory links
	get_template_part( 'modules/category/category-links--woocommerce' );
}

// Add a heading for search
if ( is_search() )
{
	get_template_part( 'modules/search/title' );
}

// Product links
get_template_part( 'modules/product/product-listing-links' );

// Footer
get_footer( 'shop' );
