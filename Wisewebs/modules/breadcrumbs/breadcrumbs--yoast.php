<?php
// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( function_exists( 'yoast_breadcrumb' ) )
{
	yoast_breadcrumb( '<div class="breadcrumbs">','</div>' );
}