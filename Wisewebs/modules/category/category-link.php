<?php
/**
 * Template for product category links.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;



/**
 * Runtime.
 */

// Access global variables
global $link;
global $title;
global $fieldModifier;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Name of the module
$moduleName = 'category-link';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

// If we specifically said we don't want the default title
if ( false === get_field( 'category-information__use-page-title', $fieldModifier ) )
{
	// Use the custom one
	$title = get_field( 'category-information__custom-page-title', $fieldModifier );
}

// Do we want an image for this?
$useImage = ( bool ) get_field( 'category-information__use-image', $fieldModifier );
?>
<a class="<?php $BEMHelper( '', [ 'has-image' => $useImage, ] ); ?>" href="<?php echo $link; ?>">
	<div class="<?php $BEMHelper( 'inner-wrap' ); ?>">
<?php
		// Do we want to use an image?
		if ( $useImage )
		{
?>
			<div class="<?php $BEMHelper( 'image-wrap' ); ?>">
<?php
				get_template_part( 'modules/category/category-image' );
?>
			</div>
<?php
		}
?>
		<h3 class="<?php $BEMHelper( 'title' ); ?>"><?php echo $title; ?></h3>
		<div class="<?php $BEMHelper( 'icon-wrap' ); ?>">
			<svg class="<?php $BEMHelper( 'icon' ); ?>" version="1.0" xmlns="http://www.w3.org/2000/svg" width="25" height="40" viewBox="0 0 24.956922 40.067788" preserveAspectRatio="xMidYMid meet">
				<g transform="translate(-0.518195,41.071761) scale(0.100000,-0.100000)"
				fill="#000000" stroke="none">
					<path d="M30 385 l-25 -26 78 -75 79 -74 -78 -76 -78 -75 25 -24 24 -25 100
				100 100 100 -101 100 -100 101 -24 -26z"/>
				</g>
			</svg>
		</div>
	</div>
</a>
