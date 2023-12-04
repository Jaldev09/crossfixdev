<?php
/**
 * Template for category information for WooCommerce categories.
 */



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Make variables global
global $title;
global $fieldModifier;

// Get category info
$category = get_queried_object();

// Default to using category name as title
$title = $category->name;

// Set field modifier
$fieldModifier = 'product_cat_' . $category->term_id;

// Category information
get_template_part( 'modules/category/category-information' );
