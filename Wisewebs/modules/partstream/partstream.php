<?php
// Prevent direct file access
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
?>
<div class="partstream-wrap">
	<div class="partstream-wrap__content">
<?php
		echo do_shortcode( '[partstream]' );
?>
	</div>
</div>
