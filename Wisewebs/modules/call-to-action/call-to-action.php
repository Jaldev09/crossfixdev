<?php
/**
 * Template for call to action.
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

// Name of the module
$moduleName = 'call-to-action';

// BEM helper for DRY code
$BEMHelper = Utility\Strings::BEMHelper( $moduleName );

// Get background
$background = get_sub_field( $moduleName . '__background-color' );

// Get variant
$variant = get_sub_field( 'call-to-action__variant' );
?>
<div
	class="<?php $BEMHelper(
		'',
		[
			$background => true,
			$variant    => true,
		]
	); ?>"
>
	<div class="<?php $BEMHelper( 'wrap' ); ?>">
		<h2 class="<?php $BEMHelper( 'title' ); ?>"><?php the_sub_field( $moduleName . '__title' ); ?></h2>
<?php
		$textField = get_sub_field( $moduleName . '__text' );

		// Did we get any text
		if ( ! empty( $textField ) )
		{
?>
			<p class="<?php $BEMHelper( 'text' ); ?>"><?php echo $textField; ?></p>
<?php
		}

		// Link button
		if ( 'link' === $variant )
		{
			$link = get_sub_field( $moduleName . '__button' );

			// Did we get a "Show all" link?
			if ( ACF\FieldHelper::linkFieldHasValue( $link ) )
			{
?>
				<a
					class="<?php $BEMHelper( 'button', 'link' ); ?>"
					<?php ACF\FieldHelper::linkFieldHrefAttr( $link ); ?>
					<?php ACF\FieldHelper::linkFieldTargetAttr( $link ); ?>
				>
<?php
					ACF\FieldHelper::linkFieldTitle( $link );
?>
				</a>
<?php
			}
		}
		// Form button
		else if ( 'form' === $variant )
		{
			// Create a new array for matches (superfluous but helps code readability)
			$matches =
			[
			];

			// Search for an ID
			preg_match(
				'/.+[\s]+id="([\d]+)".+/',
				get_sub_field( $moduleName . '__form' ),
				$matches
			);

			// If we found an ID
			if ( ! empty( $matches[ 1 ] ) )
			{
?>
				<button
					class="<?php $BEMHelper( 'button', 'form' ); ?>"
					data-form-id="<?php echo $matches[ 1 ]; ?>"
					type="button"
				>
<?php
					the_sub_field( $moduleName . '__button-text' );
?>
				</button>
<?php
				// If we don't yet have an array for forms to load as popups
				if ( empty( $GLOBALS[ 'popup-forms' ] ) )
				{
					// Create an array for that
					$GLOBALS[ 'popup-forms' ] =
					[
					];
				}

				// If we don't have it already
				if ( ! in_array( $matches[ 1 ], $GLOBALS[ 'popup-forms' ] ) )
				{
					// Add it
					$GLOBALS[ 'popup-forms' ][] = $matches[ 1 ];
				}
			}
		}
?>
	</div>
</div>
