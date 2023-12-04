<?php
/**
 * Template for the Hero image.
 */



/**
 * Namespace and imports.
 */
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Name of the module
$moduleName = 'hero';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

$variant = get_sub_field( 'hero_variant' );

if ( 'tall' === $variant )
{
	if ( have_rows( $moduleName . '__images' ) )
	{
?>
		<div class="<?php $BEMHelper( '', [ $variant => true, ] ); ?>">
<?php
			while ( have_rows( $moduleName . '__images' ) )
			{
				the_row();

				$imageId = get_sub_field( $moduleName . '__image' );
				$link    = get_sub_field( $moduleName . '__button' );

				if ( ! empty( $link[ 'url' ] ) )
				{
					$hrefAttr   = 'href="' . $link[ 'url' ] . '"';
					$showButton = true;
					$wrapperTag = 'a';
				}
				else
				{
					$hrefAttr   = '';
					$showButton = false;
					$wrapperTag = 'div';
				}
?>
				<<?php echo $wrapperTag; ?>
					<?php echo $hrefAttr; ?>
					class="<?php
						$BEMHelper(
							'wrapper',
							[
								$variant       => true,
								'has-button' => $showButton,
								'darken'     => get_sub_field( $moduleName . '__darken-image' ),
							]
						);
					?>"
				>
					<img
						class="<?php $BEMHelper( 'image', [ $variant => true, ] ); ?>"
						<?php WordPress\Images::getSRCAttr( $imageId ); ?>
						<?php WordPress\Images::getSRCSetAttr( $imageId );?>
					>
					<div class="<?php $BEMHelper( 'contents', [ $variant => true, ] ); ?>">
						<h1 class="<?php $BEMHelper( 'title', [ $variant => true, ] ); ?>"><?php the_sub_field( $moduleName . '__title' ); ?></h1>
						<h2 class="<?php $BEMHelper( 'text', [ $variant => true, ] ); ?>"><?php the_sub_field( $moduleName . '__text' ); ?></h2>
<?php
						if ( true === $showButton )
						{
?>
							<div class="<?php $BEMHelper( 'button', [ $variant => true, ] ); ?>">
<?php
								echo $link[ 'title' ];
?>
							</div>
<?php
						}
?>
					</div>
				</<?php echo $wrapperTag; ?>>
<?php
			}
?>
		</div>
<?php
	}
}
else if ( 'medium' === $variant || 'low' === $variant )
{
	$heading   = get_sub_field( 'hero__title' );
	$imageId   = get_sub_field( 'hero__medium-image' );
	$tonedDown = ( bool ) get_sub_field( 'hero__tone-down-image' );
?>
	<div class="<?php $BEMHelper( '', [ $variant => true, ] ); ?>">
		<div
			class="<?php
				$BEMHelper(
					'wrapper',
					[
						$variant => true,
						'darken' => $tonedDown,
					]
				);
			?>"
		>
			<img
				class="<?php $BEMHelper( 'image', [ $variant => true, ] ); ?>"
				<?php WordPress\Images::getSRCAttr( $imageId ); ?>
				<?php WordPress\Images::getSRCSetAttr( $imageId );?>
			>
			<div class="<?php $BEMHelper( 'contents', [ $variant => true, ] ); ?>">
				<h1 class="<?php $BEMHelper( 'title', [ $variant => true, ] ); ?>"><?php echo $heading; ?></h1>
			</div>
		</div>
	</div>
<?php
}
else if ( 'low' === $variant )
{
	$heading   = get_sub_field( 'hero__title' );
	$imageId   = get_sub_field( 'hero__medium-image' );
	$preamble  = get_sub_field( 'hero__text' );
	$tonedDown = ( bool ) get_sub_field( 'hero__tone-down-image' );

	$src = '';

	if ( ! empty( $imageId ) && is_numeric( $imageId ) )
	{
		$attachment = wp_get_attachment_image_src( $imageId, 'full_hd' );

		if ( ! empty( $attachment[ 0 ] ) )
		{

			$src = $attachment[ 0 ];
		}
	}
?>
	<div class="<?php $BEMHelper( '', [ $variant => true, ] ); ?>" style="background-image: url(<?php echo $src; ?>);">
		<div
			class="<?php
				$BEMHelper(
					'wrapper',
					[
						$variant => true,
						'darken' => $tonedDown,
					]
				);
			?>"
		>
			<div class="<?php $BEMHelper( 'contents', [ $variant => true, ] ); ?>">
				<h1 class="<?php $BEMHelper( 'title', [ $variant => true, ] ); ?>"><?php echo $heading; ?></h1>
<?php
				if ( ! empty( $preamble ) )
				{
?>
					<h2 class="<?php $BEMHelper( 'text', [ $variant => true, ] ); ?>"><?php echo $preamble; ?></h2>
<?php
				}
?>
			</div>
		</div>
	</div>
<?php
}
