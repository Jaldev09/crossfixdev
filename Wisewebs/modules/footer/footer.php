<?php
/*
 * The main site footer.
 */


/**
 * Namespace and imports.
 */
use Wisewebs\Classes\ACF;
use Wisewebs\Classes\Content;
use Wisewebs\Classes\Utility;
use Wisewebs\Classes\WordPress;

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

// Name of the module
$moduleName = 'footer';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );
?>
<div class="<?php $BEMHelper(); ?>">

	<div class="<?php $BEMHelper( 'row', 'top' ); ?>">
		<div class="<?php $BEMHelper( 'row-wrap' ); ?>">

			<div class="<?php $BEMHelper( 'columns' ); ?>">
<?php
				// If we have any columns
				if ( have_rows( $moduleName . '__columns', 'option' ) )
				{
					// Loop coumns
					while ( have_rows( $moduleName . '__columns', 'option' ) )
					{
						// Setup row data
						the_row();
?>
						<div class="<?php $BEMHelper( 'column' ); ?>">
							<h2 class="<?php $BEMHelper( 'columns-title' ); ?>">
<?php
								the_sub_field( $moduleName . '__columns-title' );
?>
							</h2>
<?php
							// If we have any links
							if ( have_rows( $moduleName . '__columns-links' ) )
							{
?>
								<ul class="<?php $BEMHelper( 'columns-links' ); ?>">
<?php
									// Loop links
									while ( have_rows( $moduleName . '__columns-links' ) )
									{
										// Setup row data
										the_row();

										// Get link field once for DRY code
										$link = get_sub_field( $moduleName . '__columns-link' );
?>
										<li class="<?php $BEMHelper( 'columns-link-item' ); ?>">
											<a
												class="<?php $BEMHelper( 'columns-link' ); ?>"
												<?php ACF\FieldHelper::linkFieldHrefAttr( $link ); ?>
												<?php ACF\FieldHelper::linkFieldTargetAttr( $link ); ?>
											>
<?php
												ACF\FieldHelper::linkFieldTitle( $link );
?>
											</a>
										</li>
<?php
									}
?>
								</ul>
<?php
							}
?>
						</div>
<?php
					}
				}
?>
			</div>

			<div class="<?php $BEMHelper( 'payment-gateway-info' ); ?>">
				<img class="<?php $BEMHelper( 'payment-gateway-info-image' ); ?>" src="/wp-content/themes/Wisewebs/assets/img/klarna.png" alt="" />
			</div>
		</div>
	</div>

	<div class="<?php $BEMHelper( 'row', 'bottom' ); ?>">
		<div class="<?php $BEMHelper( 'row-wrap' ); ?>">

			<div class="<?php $BEMHelper( 'copyright-info' ); ?>">
				Copyright <?php echo date( 'Y' ); ?> Crossfix AB
			</div>
<?php
			$bottomLinksFieldName = $moduleName . '__bottom-links';

			// If we have any bottom links
			if ( have_rows( $bottomLinksFieldName, 'option' ) )
			{
?>
				<ul class="<?php $BEMHelper( 'bottom-links' ); ?>">
<?php
					// Loop bottom links
					while ( have_rows( $bottomLinksFieldName, 'option' ) )
					{
						// Setup row data
						the_row();

						// Get link field once for DRY code
						$link = get_sub_field( $moduleName . '__bottom-link' );
?>
						<li class="<?php $BEMHelper( 'bottom-link-item' ); ?>">
							<a
								class="<?php $BEMHelper( 'bottom-link' ); ?>"
								<?php ACF\FieldHelper::linkFieldHrefAttr( $link ); ?>
								<?php ACF\FieldHelper::linkFieldTargetAttr( $link ); ?>
							>
<?php
								ACF\FieldHelper::linkFieldTitle( $link );
?>
							</a>
						</li>
<?php
					}
?>
				</ul>
<?php
			}
?>
		</div>
	</div>
</div>
