<?php
/**
 * Template for the sidescrolling cards.
 */



// Import relevant namespaces
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;



// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

global $flexibleContentSectionNumber;

// Name of the module
$moduleName = 'sidescrolling-cards';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

// Get link field once for DRY code
$showAllLink = get_sub_field( $moduleName . '__show-all-link' );
?>
<div class="<?php $BEMHelper(); ?>">
	<div class="<?php $BEMHelper( 'android-width-fixer' ); ?>">
		<div class="<?php $BEMHelper( 'top-row' ); ?>">
			<h2 class="<?php $BEMHelper( 'title' ); ?>"><?php the_sub_field( $moduleName . '__title' ); ?></h2>
<?php
			// Did we get a "Show all" link?
			if ( ACF\FieldHelper::linkFieldHasValue( $showAllLink ) )
			{
?>
				<a
					class="<?php $BEMHelper( 'show-all-link' ); ?>"
					<?php ACF\FieldHelper::linkFieldHrefAttr( $showAllLink );?>
					<?php ACF\FieldHelper::linkFieldTargetAttr( $showAllLink );?>
				>
<?php
					ACF\FieldHelper::linkFieldTitle( $showAllLink );
?>
				</a>
<?php
			}
?>
		</div>

		<div class="<?php $BEMHelper( 'shadow-wrapper', 'at-beginning' ); ?>">
			<div class="<?php $BEMHelper( 'scroll-shadow', 'left' ); ?>">
			</div>
			<div class="<?php $BEMHelper( 'scroll-wrapper' ); ?>">
				<div class="<?php $BEMHelper( 'scroll-wrapper-mobile-spacer' ); ?>">
				</div>
<?php
				// Get the field type
				$fieldType = get_sub_field( $moduleName . '__type' );

				// Concatenate field name for repeater for DRY code
				$repeaterFieldName = $moduleName . '__' . $fieldType;

				// Start a new counter
				$i = 1;

				// Get the repeater field data
				$repeater = get_sub_field( $repeaterFieldName );

				// In case we got unexpected data
				if ( empty( $repeater ) || ! is_array( $repeater ) )
				{
					// Set it to empty array
					$repeater =
					[
					];
				}

				$total = count( $repeater );

				// Check that we have at least one link
				if ( have_rows( $repeaterFieldName ) )
				{
					// Loop links
					while ( have_rows( $repeaterFieldName ) )
					{
						// Setup row data
						the_row();

						$type = '';

						// Is it a product link page
						if ( 'product-links' === $fieldType )
						{
							// Set product object to a variable
							$page = get_sub_field( $moduleName . '__product' );

							// Check for missing page ID's
							if ( empty( $page->ID ) )
							{
								// Abort mission, this isn't supposed to happen
								continue;
							}

							// Set type
							$type = 'product';

							// Get link from the product itself
							$link   = get_the_permalink( $page->ID );
							$href   = 'href="' . $link . '"';
							$target = '';

							// Get product object so we can access more data
							$Product = wc_get_product( $page->ID );

							// Get product title and price
							$title    = $page->post_title;
							$subtitle = $Product->get_price_html();

							// Get WP's pre-defined image
							$imageID = get_post_thumbnail_id( $page->ID );
						}
						else
						{
							// Set type
							$type = 'product';

							// Get link field once for DRY code
							$link   = get_sub_field( $moduleName . '__page-link-link' );
							$href   = ACF\FieldHelper::linkFieldHrefAttr( $link, false );
							$target = ACF\FieldHelper::linkFieldTargetAttr( $link, false );

							// Get text fields
							$title    = get_sub_field( $moduleName . '__page-link-title' );
							$subtitle = get_sub_field( $moduleName . '__page-link-subtitle' );

							// Get image ID
							$imageID = get_sub_field( $moduleName . '__page-link-image' );
						}

						// Start off by assuming it's wider than or equal to our target aspect ratio
						$matchHeight = false;
						$matchWidth  = true;

						// Get uploads directory
						$uploadsDir = wp_upload_dir();

						// Get file path of image
						$filePath = str_replace(
							$uploadsDir[ 'baseurl' ],
							$uploadsDir[ 'basedir' ],
							wp_get_attachment_url( $imageID )
						);

						// Double-check that it actually exists...
						if ( file_exists( $filePath ) )
						{
							// Get image size
							$size = getimagesize( $filePath );

							// If it's taller than out target aspect ratio
							if ( true !== empty( $size ) && ( $size[ 0 ] / $size[ 1 ] ) > ( 207 / 250 ) )
							{
								$matchHeight = true;
								$matchWidth  = false;
							}
						}

						// Check if we want a bottom shadow to enhance text on the image
						$bottomShadow = get_sub_field( $moduleName . '__bottom-shadow' );

						// Check if we want an overlay to avoid background blending in with image
						$overlay = get_sub_field( $moduleName . '__overlay' );

						$lazy =
						(
							( 3 < $i || 2 < $flexibleContentSectionNumber )
							? true
							: false
						);

						$additionalImgClasses =
						[
						];

						if ( $lazy )
						{
							$additionalImgClasses[] = 'lazyload lazyload-fade-in';
						}
?>
						<a
							class="<?php
								$BEMHelper(
									'link',
									[
										$type   => true,
										'first' => ( 1 === $i ),
										'last'  => ( $total === $i ),
									]
								);
							?>"
							<?php echo $href;?>
							<?php echo $target;?>
						>
							<div class="<?php $BEMHelper( 'link-inner-wrap' ); ?>">
								<img
									class="<?php
										$BEMHelper(
											'image',
											[
												'match-height' => $matchHeight,
												'match-width'  => $matchWidth,
											],
											$additionalImgClasses
										);
									?>"
									<?php if ( $lazy ) { ?>data-<?php } ?><?php echo ltrim( WordPress\Images::getSRCAttr( $imageID, WordPress\Images::SETTING__DEFAULT_IMG_SIZE, false ) ); ?>
									<?php if ( $lazy ) { ?>data-<?php } ?><?php echo ltrim( WordPress\Images::getSRCSetAttr( $imageID, WordPress\Images::SETTING__DEFAULT_IMG_SIZE, false ) ); ?>
								>
								<div
									class="<?php
										$BEMHelper(
											'text-outer-wrap',
											[
												'overlay' => $overlay,
											]
										);
									?>"
								>
									<div
										class="<?php
											$BEMHelper(
												'text-inner-wrap',
												[
													'bottom-shadow' => $bottomShadow,
												]
											);
										?>"
									>
										<div class="<?php $BEMHelper( 'icon-wrapper' ); ?>">
											<svg
												version="1.0"
												xmlns="http://www.w3.org/2000/svg"
												class="<?php $BEMHelper( 'icon' ); ?>"
												width="48.479252px"
												height="48.500000pt"
												viewBox="0 0 48.479252 48.500000"
												preserveAspectRatio="xMidYMid meet"
											>
												<g
													fill="#000000"
													stroke="none"
													transform="translate(-48.000000,96.000000) scale(0.100000,-0.100000)"
												>
													<path d="M695 940 c-19 -20 -18 -22 65 -105 l85 -85 -183 0 -182 0 0 -30 0 -30 182 0 183 0 -83 -83 -83 -83 20 -25 20 -24 123 122 123 123 -120 120 c-66 66 -122 120 -126 120 -3 0 -14 -9 -24 -20z"/>
												</g>
											</svg>
										</div>
										<h2 class="<?php $BEMHelper( 'card-title' ); ?>"><?php echo $title; ?></h2>
										<h3 class="<?php $BEMHelper( 'card-subtitle' ); ?>"><?php echo $subtitle; ?></h3>
									</div>
								</div>
							</div>
						</a>
<?php
						// Increment counter
						$i++;
					}
				}
?>
				<div class="<?php $BEMHelper( 'scroll-wrapper-mobile-spacer' ); ?>">
				</div>
			</div>
			<div class="<?php $BEMHelper( 'scroll-shadow', 'right' ); ?>">
			</div>
		</div>
	</div>
</div>
