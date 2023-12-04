<?php
/**
 * Template for category information.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



/**
 * Runtime.
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

global $title;
global $fieldModifier;

// Name of the module
$moduleName = 'category-information';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

// If we specifically said we don't want the default title
if ( false === get_field( 'category-information__use-page-title', $fieldModifier ) )
{
	// Use the custom one
	$title = get_field( 'category-information__custom-page-title', $fieldModifier );
}

// Do we want an image?
$useImage = ( bool ) get_field( 'category-information__use-image', $fieldModifier );

// Get description
$description = get_field( 'category-information__category-description', $fieldModifier );
?>
<div class="<?php $BEMHelper(); ?>">
<?php
	get_template_part( 'modules/breadcrumbs/breadcrumbs--woocommerce' );
?>
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
		<div class="<?php $BEMHelper( 'text-wrap' ); ?>">
			<h2 class="<?php $BEMHelper( 'title', [ 'bottom-margin' => ! empty( $description ) ] ); ?>"><?php echo $title; ?></h2>
<?php
			// Check if we have a description
			if ( ! empty( $description ) )
			{
?>
				<div class="<?php $BEMHelper( 'description' ); ?>">
<?php
					echo $description;
?>
				</div>
<?php
			}
?>
		</div>
	</div>
</div>
