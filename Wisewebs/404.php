<?php
	get_header();


	$yolo_options = yolo_get_options();
?>
	<div id="yolo-wrapper">
		<div class="page404">
			<div class="content-wrap">
				<div class="page404-title">
					<h2 class="p-title">Ojdå!</h2>
					<h4  class="p-description p-font">sidan du sökte kunde inte hittas</h4>
					<div class="p-title-hr">
						<div class="hr-icon"><i class="fa fa-square-o"></i></div>
					</div>
				</div>
				<div class="page404-content">
					<p class="404-content">404</p>
				</div>
				<div class="return">
					<a href="<?php echo home_url(); ?>" class="button">Gå tillbaka till startsidan</a>
				</div>
			</div>
		</div>
	</div>
<?php
	get_footer();
?>


