<?php
/**
 * Template for product category images.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;



/**
 * Runtime.
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Access global variables
global $fieldModifier;

// Name of the module
$moduleName = 'category-image';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

// Image variables
$backgroundImage = get_field( 'category-information__background-image', $fieldModifier );
$foregroundImage = get_field( 'category-information__foreground-image', $fieldModifier );
$toneDownBgImage = get_field( 'category-information__tone-down-background-image', $fieldModifier );
?>
<div class="<?php $BEMHelper(); ?>">
<?php
	// Add a div for background image if available
	if ( ! empty( $backgroundImage ) )
	{
?>
		<div class="<?php $BEMHelper( 'background', [ 'toned-down' => ( bool ) $toneDownBgImage, ] ); ?>" style="background-image: url(<?php echo wp_get_attachment_image_src( $backgroundImage, 'medium' )[ 0 ]; ?>);">
		</div>
<?php
	}

	// Add a div for foreground image if available
	if ( ! empty( $foregroundImage ) )
	{
?>
		<div class="<?php $BEMHelper( 'foreground' ); ?>" style="background-image: url(<?php echo wp_get_attachment_image_src( $foregroundImage, 'medium' )[ 0 ]; ?>);">
		</div>
<?php
	}
?>
</div>
