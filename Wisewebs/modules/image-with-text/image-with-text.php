<?php
/**
 * Template for the image with text module.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

$moduleName = 'image-with-text';

$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

$imageId     = get_sub_field( $moduleName . '__image' );
$limitHeight = ( bool ) get_sub_field( $moduleName . '__limit-height' );
$maxHeight   = 'none';

if ( true === $limitHeight )
{
	$maxHeight = get_sub_field( $moduleName . '__max-height' );

	$addPx = true;

	if ( is_string( $maxHeight ) )
	{
		if ( Utility\Strings::endsWith( $maxHeight, 'px' ) || Utility\Strings::endsWith( $maxHeight, 'em' ) || Utility\Strings::endsWith( $maxHeight, 'rem' ) || Utility\Strings::endsWith( $maxHeight, '%' ) )
		{
			$addPx = false;
		}
	}

	if ( true === $addPx )
	{
		$maxHeight = $maxHeight . 'px';
	}
}

// $height = 0;
// $src    = '';
// $width  = 0;

// if ( ! empty( $imageId ) && is_numeric( $imageId ) )
// {
// 	$attachment = wp_get_attachment_image_src( $imageId, 'full_hd' );


// 	if ( ! empty( $attachment ) && ! empty( $attachment[ 0 ] ) )
// 	{
// 		$height = $attachment[ 2 ];
// 		$src    = $attachment[ 0 ];
// 		$width  = $attachment[ 1 ];
// 	}
// }

?>
<div class="<?php $BEMHelper(); ?>" style="max-height: <?php echo $maxHeight; ?>;">
	<img
		class="<?php $BEMHelper( 'image' ); ?>"
		<?php WordPress\Images::getSRCAttr( $imageId ); ?>
		<?php WordPress\Images::getSRCSetAttr( $imageId );?>
	>
	<div class="<?php $BEMHelper( 'text-wrapper' ); ?>">
		<h2 class="<?php $BEMHelper( 'text' ); ?>">
<?php
			the_sub_field( $moduleName . '__text' );
?>
		</h2>
	</div>
</div>
